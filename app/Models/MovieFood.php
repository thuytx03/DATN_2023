<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MovieFoodsTypes;
use Illuminate\Support\Facades\DB;
use App\Models\Foodstypes;
use AWS\CRT\HTTP\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieFood extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'movie_foods';
    public $fillable = ['name', 'slug', 'image', 'price', 'description','quantity'];
    
    public function filterStatus($status){
        $foods = DB::table('foods_types')
                ->where('status', $status)
                ->get();
                return $foods;
    }

    public function filterTypes($id) {
        $movieFoods = MovieFood::whereHas('Foodstypes', function ($query) use ($id) {
            $query->where('food_type_id', $id);
        })->get();
    
      
        return $movieFoods;
    }
    public function search($name){
        $users = User::where('name', 'like', "%$name%")->get();
        return  $users;
    }

   

    public function Foodstypes()
    {
        return $this->belongsToMany(Foodstypes::class, 'movie_foods_types', 'food_id', 'food_type_id');
    }
    
    public function movieFoodstypes()
    {
        return $this->belongsToMany(MovieFoodsTypes::class,  'food_id', 'food_type_id');
    }
}
