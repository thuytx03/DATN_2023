<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="bookings";
    protected $fillable=["name",'user_id','showtime_id','list_seat',
    'email', 'phone', 'address', 'total','payment','status','note','cancel_reason'
];
public function showtime(){
    return $this->belongsTo(ShowTime::class);
}
}
