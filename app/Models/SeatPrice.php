<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatPrice extends Model
{
    use HasFactory;
    protected $table="seat_prices";

    protected $fillable = ['seat_type_id', 'showtime_id', 'price'];

    public function seatType()
    {
        return $this->belongsTo(SeatType::class);
    }

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }
}
