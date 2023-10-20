<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Foodstypes;
use App\Models\MovieFood;

class MovieFoodsTypes extends Model
{
    use HasFactory;
    protected $table = 'movie_foods_types';
   protected $fillable = [
    'food_id','food_type_id'
   ];
   
   
}
