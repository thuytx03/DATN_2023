<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
class Seat extends Model
{
    use HasFactory;
    protected $table="seats";
    protected $fillable=['room_id','row','column','seat_type_id'];
    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function seatType() {
        return $this->belongsTo(SeatType::class);
    }
    public function bookings()
{
    return $this->hasMany(Booking::class);
}

}
