<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking; // Pastikan model Booking sudah ada
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'field']);

        // Filter berdasarkan status jika ada parameter 'status' di URL
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10); // Ambil semua booking dengan paginasi
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'field']); // Load relasi user dan field
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,rejected,completed,canceled',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Status booking berhasil diperbarui!');
    }
}