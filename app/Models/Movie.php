<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'movies';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'slug',
        'language',
        'poster',
        'trailer',
        'director',
        'actor',
        'manufacturer',
        'duration',
        'start_date',
        'view',
        'description',
        'country_id',
        'status'
    ];
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id');
    }

    public function images()
    {
        return $this->hasMany(MovieImage::class, 'movie_id', 'id');
    }
}
