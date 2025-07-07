<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TimeSlotController; // <--- PASTIKAN INI BENAR
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rute untuk mendapatkan slot waktu yang tersedia
Route::get('/time-slots', [TimeSlotController::class, 'getAvailableTimeSlots']); // <--- PASTIKAN INI JUGA BENAR