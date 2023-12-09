<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Foodstypes;
use App\Models\MovieFoodsTypes;
use App\Models\MovieFood;
use App\Models\Voucher;
use Carbon\Carbon;
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

        $foodType = Foodstypes::orderBy('id', 'DESC')->where('status', 1)->get();
        $food = $query->orderBy('id', 'DESC')->paginate(6);
        $cinema = Cinema::all();
        return view('client.foods.food', compact('foodType', 'food','cinema'));
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
    public function checkVoucher(Request $request)
    {
        $userVoucher = $request->input('voucher');
        $totalPrice = $request->input('totalPrice');

        $voucher = Voucher::where('code', $userVoucher)->first();

        if ($voucher && $voucher->quantity > 0) {
            $now = Carbon::now();

            if ($now >= $voucher->start_date && $now <= $voucher->end_date) {
                // Additional check for total price
                if ($totalPrice >= $voucher->min_order_amount && $totalPrice <= $voucher->max_order_amount) {
                    return response()->json(['discount' => $voucher->value]);
                } else {
                    return response()->json(['error' => 'Tổng tiền không đáp ứng yêu cầu.'], 422);
                }
            } else {
                return response()->json(['error' => 'Mã giảm giá đã hết hạn hoặc chưa đến ngày áp dụng.'], 422);
            }
        } elseif ($voucher && $voucher->quantity == 0) {
            return response()->json(['error' => 'Mã giảm giá đã hết.'], 422);
        } else {
            return response()->json(['error' => 'Mã giảm giá không hợp lệ.'], 422);
        }
    }
}
