<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimeSlot; // Tambahkan ini
use Carbon\Carbon; // Tambahkan ini kalau mau pakai Carbon untuk jam

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama jika ada, agar tidak duplikat saat di-seed ulang
        TimeSlot::truncate();

        // Buat slot waktu dari jam 08:00 sampai 22:00
        for ($i = 8; $i <= 22; $i++) {
            $startTime = Carbon::createFromTime($i, 0, 0); // Jam mulai
            $endTime = Carbon::createFromTime($i + 1, 0, 0); // Jam selesai (1 jam setelahnya)

            TimeSlot::create([
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $endTime->format('H:i:s'),
                'is_available' => true,
            ]);
        }
    }
}