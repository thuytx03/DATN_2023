<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetailFood;
use App\Models\OrderFood;
use Illuminate\Http\Request;

class OrderFoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order_food.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $order_date = $request->input('order_date');
        $total_amount = $request->input('total_amount');
        $payment_method = $request->input('payment_method');
        $order_id = $request->input('order_id');
        $food_items = $request->input('food_items');

        // Lưu vào bảng order
        $order = OrderFood::create([
            'user_id' => $user_id,
            'order_date' => $order_date,
            'total_amount' => $total_amount,
            'payment_method' => $payment_method,
            'order_id' => $order_id,
        ]);

        // Lưu các food items vào bảng order_detail
        foreach ($food_items as $food_item) {
            $order->orderDetail()->create([
                'order_id' => $order->id,
                'food_id' => $food_item['food_id'],
                'quantity' => $food_item['quantity'],
            ]);
        }

        return response()->json(['message' => 'Đặt đồ ăn thành công!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
