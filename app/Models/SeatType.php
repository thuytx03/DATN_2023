<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SeatType extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="seat_types";
    protected $fillable=['name','price','slug','image','description','status'];
    public function seats() {
        return $this->hasMany(Seat::class);
    }
}
