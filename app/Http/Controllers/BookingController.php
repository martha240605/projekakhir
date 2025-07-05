<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Lapangan;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())->get();
        return view('user.booking.index', compact('bookings'));
    }

    public function create()
    {
        $lapangan = Lapangan::all();
        return view('user.booking.create', compact('lapangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'durasi_jam' => 'required|integer',
        ]);

        $lapangan = Lapangan::findOrFail($request->lapangan_id);
        $total = $lapangan->harga_per_jam * $request->durasi_jam;

        Booking::create([
            'user_id' => auth()->id(),
            'lapangan_id' => $request->lapangan_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'durasi_jam' => $request->durasi_jam,
            'total_harga' => $total,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.index')->with('success', 'Booking berhasil dibuat');
    }

    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();
        return redirect()->route('booking.index')->with('success', 'Booking dibatalkan');
    }
}


