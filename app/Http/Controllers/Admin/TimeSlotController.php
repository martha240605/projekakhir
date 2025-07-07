<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimeSlot; // Import model TimeSlot
use Carbon\Carbon; // Untuk parsing waktu

class TimeSlotController extends Controller
{
    public function index()
    {
        $timeSlots = TimeSlot::orderBy('start_time')->paginate(10);
        return view('admin.time_slots.index', compact('timeSlots'));
    }

    public function create()
    {
        return view('admin.time_slots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'price' => 'nullable|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        TimeSlot::create([
            'start_time' => Carbon::parse($request->start_time)->format('H:i:s'),
            'end_time' => Carbon::parse($request->end_time)->format('H:i:s'),
            'price' => $request->price,
            'is_available' => $request->is_available,
        ]);

        return redirect()->route('admin.time-slots.index')->with('success', 'Slot waktu berhasil ditambahkan.');
    }

    public function edit(TimeSlot $timeSlot)
    {
        return view('admin.time_slots.edit', compact('timeSlot'));
    }

    public function update(Request $request, TimeSlot $timeSlot)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'price' => 'nullable|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        $timeSlot->update([
            'start_time' => Carbon::parse($request->start_time)->format('H:i:s'),
            'end_time' => Carbon::parse($request->end_time)->format('H:i:s'),
            'price' => $request->price,
            'is_available' => $request->is_available,
        ]);

        return redirect()->route('admin.time-slots.index')->with('success', 'Slot waktu berhasil diperbarui.');
    }

    public function destroy(TimeSlot $timeSlot)
    {
        // Perhatian: Jika ada booking yang menggunakan slot ini,
        // ini bisa menyebabkan masalah integrity data.
        // Pertimbangkan validasi atau soft delete.
        $timeSlot->delete();
        return redirect()->route('admin.time-slots.index')->with('success', 'Slot waktu berhasil dihapus.');
    }
}