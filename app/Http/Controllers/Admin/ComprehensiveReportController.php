<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking; // Pastikan model Booking sudah ada
use App\Models\Field;   // Pastikan model Field sudah ada
use App\Models\User;    // Pastikan model User sudah ada
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ComprehensiveReportController extends Controller
{
    public function generate()
    {
        // Ambil data yang dibutuhkan
        $totalBookings = Booking::count();
        $totalFields = Field::count();
        $totalUsers = User::count();

        // Ambil beberapa booking terbaru (misal 10 booking terakhir)
        $latestBookings = Booking::with(['user', 'field'])
                                 ->latest()
                                 ->limit(10)
                                 ->get();

        // Ambil semua data lapangan
        $fields = Field::all();

        // Ambil semua data pengguna (kecuali admin, jika ada role_id)
        $users = User::where('id', '!=', auth()->id()) // Contoh: tidak include user yang sedang login
                     ->when(config('your_app.admin_role_id'), function ($query) {
                         // Asumsi ada kolom 'role_id' di tabel users
                         // dan ada config 'your_app.admin_role_id'
                         return $query->where('role_id', '!=', config('your_app.admin_role_id'));
                     })
                     ->get();

        // Siapkan data untuk view PDF
        $data = [
            'reportTitle' => 'Laporan Komprehensif Sport Center',
            'generatedAt' => Carbon::now()->format('d M Y H:i:s'),
            'totalBookings' => $totalBookings,
            'totalFields' => $totalFields,
            'totalUsers' => $totalUsers,
            'latestBookings' => $latestBookings,
            'fields' => $fields,
            'users' => $users,
        ];

        // Load view PDF dan passing data
        $pdf = Pdf::loadView('admin.reports.comprehensive', $data);

        // Unduh PDF
        return $pdf->download('laporan_komprehensif_' . Carbon::now()->format('Ymd_His') . '.pdf');
    }
}
