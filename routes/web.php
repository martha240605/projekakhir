<?php

use Illuminate\Support\Facades\Auth; // Pastikan ini ada
use Illuminate\Support\Facades\Route; // Pastikan ini ada

// Import Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FieldController as AdminFieldController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\TimeSlotController as AdminTimeSlotController; // Tambahkan ini
use App\Http\Controllers\Admin\UserController as AdminUserController;       // Tambahkan ini
use App\Http\Middleware\AdminMiddleware;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute untuk Halaman Depan Umum (Tidak perlu login)
Route::get('/', function () {
    // Redirect langsung ke halaman home user jika sudah login, atau ke welcome jika belum.
    // Atau bisa juga langsung menampilkan daftar lapangan tanpa login.
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.home');
    }
   return redirect()->route('login'); // Halaman welcome default Laravel
});

// Rute untuk Dashboard User (Setelah Login)
// Ini akan mengarahkan user biasa ke halaman beranda user kita
Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.home');
    }
    // Jika belum login, redirect ke halaman login
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');


// Rute Khusus untuk User Biasa (Role 'user')
Route::middleware(['auth', 'verified'])->name('user.')->group(function () {
    // Rute Profil (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Home User (Daftar Lapangan)
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/fields/{field}', [HomeController::class, 'show'])->name('fields.show'); // Detail Lapangan

    // Rute Booking untuk User
    Route::get('/bookings/create/{field}', [UserBookingController::class, 'create'])->name('bookings.create'); // Form booking
    Route::post('/bookings', [UserBookingController::class, 'store'])->name('bookings.store'); // Simpan booking
    Route::get('/my-bookings', [UserBookingController::class, 'index'])->name('bookings.history'); // Riwayat booking
    Route::get('/my-bookings/{booking}', [UserBookingController::class, 'show'])->name('bookings.show'); // Detail booking
    Route::put('/my-bookings/{booking}/upload-proof', [UserBookingController::class, 'uploadProof'])->name('bookings.uploadProof'); // Upload bukti pembayaran
    // Route::put('/my-bookings/{booking}/cancel', [UserBookingController::class, 'cancel'])->name('bookings.cancel'); // Opsional: Batalkan booking
});


// Rute Khusus untuk Admin
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Lapangan
    Route::resource('fields', AdminFieldController::class);

    // Manajemen Booking Admin
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::put('bookings/{booking}/update-status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update_status'); // Update status booking
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy'); // Hapus booking

    // Manajemen Slot Waktu
    Route::resource('time-slots', AdminTimeSlotController::class)->except(['show']); // Tidak perlu method show untuk individual time slot

    // Manajemen Pengguna
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

// Auth Routes (Breeze default)
require __DIR__.'/auth.php';