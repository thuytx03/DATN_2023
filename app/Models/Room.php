<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'rooms';
    public $fillable = ['cinema_id', 'room_type_id', 'name', 'description', 'status', 'image'];

    public function typeRoom()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
    public function showTimes()
    {
        return $this->hasMany(ShowTime::class);
    }
}
