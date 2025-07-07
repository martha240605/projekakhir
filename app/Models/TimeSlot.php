<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    // Kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'start_time',
        'end_time',
        'is_available',
    ];

    // Secara default, Eloquent akan mencari tabel 'time_slots'
    // dan kolom 'id', 'created_at', 'updated_at'.
    // Jadi kita tidak perlu mendefinisikannya secara eksplisit kecuali ada perubahan.
}
