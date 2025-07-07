<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking; // Pastikan model Booking sudah ada
use App\Models\Field;   // Pastikan model Field sudah ada
use App\Models\User;   // Pastikan model User sudah ada
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data untuk dashboard
        $totalFields = Field::count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalUsers = User::count(); // Hitung semua user, termasuk admin jika ada

        // Data booking terbaru (misalnya 5 booking terakhir)
        $latestBookings = Booking::with(['user', 'field'])
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();

        return view('admin.dashboard', compact('totalFields', 'totalBookings', 'pendingBookings', 'totalUsers', 'latestBookings'));
    }
}