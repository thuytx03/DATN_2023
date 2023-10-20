<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieGenre extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'movie_genres';
    public $timestamps = true;
    public $fillable = ['movie_id','genre_id'];
}
