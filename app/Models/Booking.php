<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table="bookings";
    protected $fillable=["name",'user_id','showtime_id','list_seat',
    'email', 'phone', 'address', 'total','payment','status','note','cancel_reason'
];
}
