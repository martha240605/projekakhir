<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'field_id',
        'booking_date',
        'start_time_slot_id',
        'end_time_slot_id',
        'total_hours',
        'total_price',
        'status',
        'payment_proof',
    ];

    // Nanti kita akan tambahkan relasi di sini
    // public function user() { return $this->belongsTo(User::class); }
    // public function field() { return $this->belongsTo(Field::class); }
    // public function startTimeSlot() { return $this->belongsTo(TimeSlot::class, 'start_time_slot_id'); }
    // public function endTimeSlot() { return $this->belongsTo(TimeSlot::class, 'end_time_slot_id'); }
}