<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Foodstypes;
use App\Models\MovieFoodsTypes;
use App\Models\MovieFood;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function food(Request $request)
    {
        $query = MovieFood::where('status', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($request->has('foodstypes')) {
            $foodstypes = $request->input('foodstypes');

            if ($foodstypes != 0) {
                $foodIds = MovieFoodsTypes::where('food_type_id', $foodstypes)->pluck('food_id')->all();
                $query->whereIn('id', $foodIds);
            }
        }

        $foodType = Foodstypes::orderBy('id', 'DESC')->where('status',1)->get();
        $food = $query->orderBy('id', 'DESC')->paginate(6);

        return view('client.foods.food', compact('foodType', 'food'));
    }

    public function getFoodByType($foodTypeId)
    {
        $foods = DB::table('movie_foods_types')
            ->join('movie_foods', 'movie_foods_types.food_id', '=', 'movie_foods.id')
            ->where('movie_foods_types.food_type_id', $foodTypeId)
            ->where('movie_foods.status', 1)
            ->select('movie_foods.*')
            ->get();

        return response()->json($foods);
    }
}
