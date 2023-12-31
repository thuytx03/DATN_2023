<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieImage extends Model
{
    use HasFactory;
    protected $table = 'movie_images';
    public $timestamps = true;
    public $fillable = ['movie_id','movie_image'];
}
