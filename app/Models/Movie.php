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
    protected $fillable = ['name', 'slug', 'language', 'poster', 'trailer', 'director', 'actor', 'manufacturer', 'duration', 'start_date', 'view', 'description', 'country_id', 'status'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function favoriteMovies1()
    {
        return $this->belongsToMany(Movie::class, 'movie_favorite', 'movie_id', 'user_id');
    }

    public function images()
    {
        return $this->hasMany(MovieImage::class, 'movie_id', 'id');
    }

    public function showtimes()
    {
        return $this->hasMany(ShowTime::class, 'movie_id');
    }

    public function userRating()
    {
        $user_id = auth()->user()->id;
        $rating = Feedback::where(['user_id' => $user_id, 'movie_id' => $this->id])->latest()->value('rating');
        return $rating ?? 0;
    }

    public function views()
    {
        return $this->hasMany(MovieView::class);
    }
}

