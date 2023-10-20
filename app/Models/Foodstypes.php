<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MovieFood;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Foodstypes extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'foods_types';
    public $fillable = ['name', 'slug', 'image', 'price', 'description','parent_id','status'];
    public function filterStatus($status){
        $foods = DB::table('foods_types')
                ->where('status', $status)
                ->get();
                return $foods;
    }
    public function MovieFood()
    {
        return $this->belongsToMany(MovieFood::class, 'movie_foods_types', 'food_id', 'food_type_id');
    }


}
