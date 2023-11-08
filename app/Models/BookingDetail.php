<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;
    protected $table="booking_details";
    protected $fillable=['booking_id','food_id','price','quantity'];
    public function food()
    {
        return $this->belongsTo(MovieFood::class, 'food_id');
    }
}
