<?php

namespace App\Http\Controllers\Api; // <--- NAMESPACE INI BENAR UNTUK API

use App\Http\Controllers\Controller;
use App\Models\TimeSlot; // Import model TimeSlot
use App\Models\Booking; // Import model Booking
use Illuminate\Http\Request;
use Carbon\Carbon; // Untuk bekerja dengan tanggal dan waktu

class TimeSlotController extends Controller
{
    /**
     * Mengembalikan daftar slot waktu yang tersedia untuk tanggal dan lapangan tertentu.
     */
    public function getAvailableTimeSlots(Request $request)
    {
        $date = $request->query('date');
        $fieldId = $request->query('field_id');

        if (!$date || !$fieldId) {
            return response()->json(['error' => 'Date and field_id are required.'], 400);
        }

        try {
            $bookingDate = Carbon::parse($date)->toDateString();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date format.'], 400);
        }

        // Ambil semua time slots yang ada di sistem (dari tabel time_slots)
        $allTimeSlots = TimeSlot::orderBy('start_time')->get();

        // Ambil booking yang sudah dikonfirmasi atau pending untuk lapangan dan tanggal ini
        $bookedSlots = Booking::where('field_id', $fieldId)
                                ->where('booking_date', $bookingDate)
                                ->whereIn('status', ['confirmed', 'pending'])
                                ->get();

        $availableTimeSlots = [];

        foreach ($allTimeSlots as $slot) {
            $isBooked = false;
            foreach ($bookedSlots as $booked) {
                // Logika ini untuk mendeteksi tumpang tindih slot waktu
                // Jika slot yang sedang dicek berada di antara start dan end slot dari booking yang sudah ada
                if (($slot->id >= $booked->start_time_slot_id && $slot->id < $booked->end_time_slot_id)) {
                    $isBooked = true;
                    break;
                }
                 // Khusus untuk booking 1 slot (dimana start_id == end_id)
                if ($slot->id == $booked->start_time_slot_id && $booked->start_time_slot_id == $booked->end_time_slot_id) {
                    $isBooked = true;
                    break;
                }
            }

            // Tambahkan slot hanya jika tidak dibooking
            if (!$isBooked) {
                // Tambahkan atribut custom untuk tampilan di frontend
                $slot->formatted_time = Carbon::parse($slot->start_time)->format('H:i') . ' - ' . Carbon::parse($slot->end_time)->format('H:i');
                $availableTimeSlots[] = $slot;
            }
        }

        return response()->json($availableTimeSlots);
    }
}