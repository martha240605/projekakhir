<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking; // Import model Booking
use App\Models\Field;   // Import model Field (jika perlu cek ketersediaan)
use App\Models\TimeSlot; // Import model TimeSlot
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang sedang login
use Carbon\Carbon; // Untuk manipulasi tanggal dan waktu

class BookingController extends Controller
{
    /**
     * Menyimpan booking baru yang diajukan oleh user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time_slot_id' => 'required|exists:time_slots,id',
            'end_time_slot_id' => 'required|exists:time_slots,id',
            'notes' => 'nullable|string|max:500',
        ]);

        // Pastikan waktu mulai tidak lebih dari atau sama dengan waktu selesai (untuk booking multi-slot)
        if ($request->start_time_slot_id >= $request->end_time_slot_id) {
            return redirect()->back()->withErrors(['time_slot_range' => 'Waktu selesai harus setelah waktu mulai.'])->withInput();
        }

        $field = Field::findOrFail($request->field_id);
        $startTimeSlot = TimeSlot::findOrFail($request->start_time_slot_id);
        $endTimeSlot = TimeSlot::findOrFail($request->end_time_slot_id);

        // --- Logika Cek Ketersediaan Slot Waktu (PENTING) ---
        // Ini adalah logika dasar, Anda perlu mengembangkannya lebih lanjut
        // untuk menangani skenario tumpang tindih yang kompleks.
        $isBooked = Booking::where('field_id', $field->id)
                            ->where('booking_date', $request->booking_date)
                            ->where(function($query) use ($request) {
                                // Cek apakah ada booking yang tumpang tindih
                                $query->whereBetween('start_time_slot_id', [$request->start_time_slot_id, $request->end_time_slot_id -1])
                                      ->orWhereBetween('end_time_slot_id', [$request->start_time_slot_id +1, $request->end_time_slot_id])
                                      ->orWhere(function($query2) use ($request) {
                                          $query2->where('start_time_slot_id', '<=', $request->start_time_slot_id)
                                                 ->where('end_time_slot_id', '>=', $request->end_time_slot_id);
                                      });
                            })
                            ->whereIn('status', ['confirmed', 'pending']) // Hanya cek booking yang sudah dikonfirmasi/pending
                            ->exists();

        if ($isBooked) {
            return redirect()->back()->withErrors(['availability' => 'Slot waktu yang Anda pilih sudah dibooking atau tidak tersedia.'])->withInput();
        }

        // Hitung total jam booking
        // Asumsi: TimeSlot ID berurutan per jam. Jika tidak, perlu logika perhitungan yang lebih kompleks
        $totalHours = $endTimeSlot->id - $startTimeSlot->id;
        if ($totalHours <= 0) { // Jika cuma satu slot, anggap 1 jam. Jika pakai ID, harusnya > 0
            $totalHours = 1; // Minimal 1 jam booking jika memilih start dan end slot yang sama
        }

        $totalPrice = $field->price_per_hour * $totalHours;

        // Buat booking baru
        Booking::create([
            'user_id' => Auth::id(), // ID user yang sedang login
            'field_id' => $field->id,
            'booking_date' => $request->booking_date,
            'start_time_slot_id' => $startTimeSlot->id,
            'end_time_slot_id' => $endTimeSlot->id,
            'total_price' => $totalPrice,
            'notes' => $request->notes,
            'status' => 'pending', // Status awal booking biasanya 'pending' atau 'menunggu_pembayaran'
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking lapangan berhasil diajukan! Menunggu konfirmasi.');
        // Atau redirect ke halaman riwayat booking user
        // return redirect()->route('user.bookings.index')->with('success', 'Booking lapangan berhasil diajukan!');
    }

    // Anda mungkin akan menambahkan method 'index' (riwayat booking user)
    // public function index() { ... }
}