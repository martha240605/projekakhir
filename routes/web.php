<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Import Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController; // Ini untuk dashboard user
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController; // Ini untuk dashboard admin
use App\Http\Controllers\Admin\FieldController as AdminFieldController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\TimeSlotController as AdminTimeSlotController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\ComprehensiveReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Halaman Depan Umum: Redirect ke login jika belum login, atau ke dashboard yang sesuai
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard'); // Mengarahkan ke user.dashboard
    }
    return redirect()->route('login');
});

// Rute Dashboard Default Laravel Breeze:
// Ini adalah rute yang akan diakses setelah login berhasil secara default.
// Kita akan memanfaatkannya untuk mengarahkan ke dashboard yang benar.
Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard'); // Mengarahkan ke user.dashboard
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');


// --- Rute Khusus untuk User Biasa (Role 'user') ---
// Menggunakan prefix 'user' agar URL menjadi /user/dashboard, /user/profile, dll.
// Menggunakan name('user.') agar nama rute menjadi user.dashboard, user.profile, dll.
Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {

    // Rute Dashboard User: URL /user/dashboard
    // INI YANG AKAN MEMANGGIL CONTROLLER DAN MENGIRIM $fields
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Rute Profil (Breeze default): URL /user/profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Home User (Daftar Lapangan): URL /user/home (jika Anda ingin home terpisah dari dashboard)
    // Jika dashboard dan home sama, Anda bisa hapus rute ini atau arahkan ke dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');


    // Rute Booking untuk User
    Route::get('/bookings/create/{field}', [UserBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [UserBookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [UserBookingController::class, 'index'])->name('bookings.history');
    Route::get('/my-bookings/{booking}', [UserBookingController::class, 'show'])->name('bookings.show');
    Route::put('/my-bookings/{booking}/upload-proof', [UserBookingController::class, 'uploadProof'])->name('bookings.uploadProof');
});


// --- Rute Khusus untuk Admin ---
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin: URL akan menjadi /admin/dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Lapangan
    Route::resource('fields', AdminFieldController::class);

    // Manajemen Booking Admin
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::put('bookings/{booking}/update-status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update_status');
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

    // Manajemen Slot Waktu
    Route::resource('time-slots', AdminTimeSlotController::class)->except(['show']);

    // Manajemen Pengguna
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

// Auth Routes (Breeze default)
require __DIR__.'/auth.php';


Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    // ... rute yang sudah ada seperti dashboard, fields, bookings, users

    // Rute untuk Laporan Komprehensif
    Route::get('/reports/comprehensive', [ComprehensiveReportController::class, 'generate'])->name('reports.comprehensive');
});