<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login'); // Arahkan ke halaman login jika belum login
        }

        // Pastikan user yang login memiliki role 'admin'
        if (Auth::user()->role !== 'admin') {
            // Jika bukan admin, kita bisa mengarahkan ke halaman home biasa
            // atau menampilkan pesan error 403 (Forbidden)
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin Admin.'); // Tampilkan error 403
            // Atau redirect ke halaman lain:
            // return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Admin.');
        }

        // Jika semua syarat terpenuhi (sudah login dan role-nya admin),
        // lanjutkan request ke rute atau controller selanjutnya
        return $next($request);
    }
}