<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Cinema extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;
    public $table = 'cinemas';
    public $fillable = ['name', 'slug', 'address', 'phone', 'open_hours', 'close_hours', 'description', 'status', 'province_id'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
     public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_cinemas', 'cinema_id', 'role_id');
    }
    public function rooms() {
        return $this->hasMany(Room::class);
    }
}
