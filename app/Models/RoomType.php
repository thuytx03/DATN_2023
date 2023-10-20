<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'room_types';
    public $fillable = ['name', 'slug', 'image', 'description', 'status'];

    public function room()
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }
}
