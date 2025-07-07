<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Tambahkan ini
use Illuminate\Support\Facades\Hash; // Tambahkan ini untuk hashing password

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user admin
        User::create([
            'name' => 'Admin Futsal',
            'email' => 'admin@gmail.com', // Email untuk login admin
            'password' => Hash::make('password'), // Password untuk login admin (bisa diganti)
            'role' => 'admin', // Ini yang paling penting, set sebagai admin
            'email_verified_at' => now(), // Anggap sudah terverifikasi
        ]);

        // Buat contoh user biasa (opsional)
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@gmail.com', // Email untuk login user biasa
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}