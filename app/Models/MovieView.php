<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieView extends Model
{
    protected $fillable = ['movie_id', 'date', 'count'];

    public function movie()
    {
        return $this->belongsTo(Movie::class,'movie_id');
    }
}
