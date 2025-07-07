<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;  // Pastikan model Booking sudah ada
use App\Models\Field;    // Pastikan model Field sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Untuk manipulasi tanggal dan waktu

class BookingController extends Controller
{
    /**
     * Show the form for creating a new booking.
     */
    public function create(Field $field)
    {
        return view('user.book_field', compact('field'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'start_time' => 'required|date_format:Y-m-d H:i',
            'end_time' => 'required|date_format:Y-m-d H:i|after:start_time',
            'notes' => 'nullable|string|max:500',
        ]);

        $field = Field::findOrFail($request->field_id);
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);

        // Hitung durasi dalam jam
        $durationHours = $endTime->diffInMinutes($startTime) / 60;
        if ($durationHours <= 0) {
            return back()->withErrors(['end_time' => 'Waktu selesai harus setelah waktu mulai.']);
        }

        // Hitung total harga
        $totalPrice = $field->price_per_hour * $durationHours;

        // Cek ketersediaan lapangan (sederhana: tidak tumpang tindih)
        $isOverlap = Booking::where('field_id', $field->id)
                            ->whereIn('status', ['pending', 'confirmed']) // Hanya cek booking yang aktif
                            ->where(function ($query) use ($startTime, $endTime) {
                                $query->whereBetween('start_time', [$startTime, $endTime->subMinute()]) // -1 menit agar tidak konflik jika pas selesai
                                      ->orWhereBetween('end_time', [$startTime->addMinute(), $endTime]) // +1 menit agar tidak konflik jika pas mulai
                                      ->orWhere(function ($query) use ($startTime, $endTime) {
                                          $query->where('start_time', '<=', $startTime)
                                                ->where('end_time', '>=', $endTime);
                                      });
                            })
                            ->exists();

        if ($isOverlap) {
            return back()->withErrors(['availability' => 'Lapangan sudah dipesan pada waktu tersebut. Silakan pilih waktu lain.']);
        }


        Booking::create([
            'user_id' => Auth::id(),
            'field_id' => $request->field_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'total_price' => $totalPrice,
            'status' => 'pending', // Status awal saat booking dibuat
            'notes' => $request->notes,
        ]);

        return redirect()->route('user.bookings.history')->with('success', 'Booking berhasil dibuat! Silakan unggah bukti pembayaran.');
    }

    /**
     * Display a listing of user's bookings (history).
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('field')->orderBy('created_at', 'desc')->paginate(10);
        return view('user.booking_history', compact('bookings'));
    }

    /**
     * Display the specified user's booking.
     */
    public function show(Booking $booking)
    {
        // Pastikan user hanya bisa melihat booking miliknya sendiri
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $booking->load('field'); // Load relasi field
        return view('user.booking_detail', compact('booking'));
    }

    /**
     * Upload proof of payment for a booking.
     */
    public function uploadProof(Request $request, Booking $booking)
    {
        // Pastikan user hanya bisa mengunggah bukti pembayaran untuk booking miliknya sendiri
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maks 2MB
        ]);

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            // Hapus bukti pembayaran lama jika ada
            if ($booking->payment_proof_path && Storage::disk('public')->exists($booking->payment_proof_path)) {
                Storage::disk('public')->delete($booking->payment_proof_path);
            }
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $booking->update([
            'payment_proof_path' => $proofPath,
            'status' => 'pending_review', // Ubah status menjadi menunggu review admin
        ]);

        return redirect()->route('user.bookings.show', $booking)->with('success', 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi admin.');
    }

    /**
     * Optional: Cancel a booking
     * Uncomment this method if you want to allow users to cancel bookings.
     */
    // public function cancel(Booking $booking)
    // {
    //     if ($booking->user_id !== Auth::id()) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     // Hanya bisa dibatalkan jika statusnya masih 'pending' atau 'pending_review'
    //     if (in_array($booking->status, ['pending', 'pending_review'])) {
    //         $booking->update(['status' => 'canceled']);
    //         return redirect()->route('user.bookings.history')->with('success', 'Booking berhasil dibatalkan.');
    //     }

    //     return redirect()->back()->with('error', 'Booking tidak dapat dibatalkan pada status ini.');
    // }
}