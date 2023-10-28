<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class moviefavorite extends Model
{
    use HasFactory;
    protected $table = 'movie_favorite';
    public $fillable = ['movie_id', 'user_id'];
}
