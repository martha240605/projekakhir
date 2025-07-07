<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Pastikan ini ada

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Pastikan HasApiTokens ada di sini

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Pastikan ini ada
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the bookings for the user.
     */
    public function bookings() // <-- Tambahkan method ini jika belum ada
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin() // <-- Tambahkan method ini jika belum ada
    {
        return $this->role === 'admin';
    }

    public function testMethod()
{
    return "Metode testMethod berhasil dipanggil!";
}
}