<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShowTime extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps = true;
    protected $table = 'show_times';
    protected $fillable = ['room_id','movie_id','start_date','end_date','status'];
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function bookings()
{
    return $this->hasMany(Booking::class);
}
public function seatPrice()
    {
        return $this->hasMany(SeatPrice::class, 'showtime_id');
    }
}
