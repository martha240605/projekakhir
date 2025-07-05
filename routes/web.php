<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facads\Auth;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LapanganController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::middleware('auth')->group(function () {


    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        });

   
        Route::resource('/lapangan', LapanganController::class);
    });


    Route::middleware('user')->prefix('user')->group(function () {
        Route::get('/dashboard', function () {
            return view('user.dashboard');
        });


        Route::resource('/booking', BookingController::class);
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
