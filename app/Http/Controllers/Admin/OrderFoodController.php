<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderFoodRequest;
use App\Models\MovieFood;
use App\Models\OrderDetailFood;
use App\Models\OrderFood;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;

class OrderFoodController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin', ['only' => $methods]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = OrderFood::query();

        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('user_id', 'like', '%' . $search . '%');
        }
        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }
        $orders = $query->orderBy('id', 'desc')->get(); // Sắp xếp theo ID mới nhất
        return view('admin.order_food.index', compact('orders'));
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
    public function store(OrderFoodRequest $request)
    {
        $order_date = now();
        $total_amount = $request->input('total_amount');
        $totalPrice = $request->input('total_price');
        $payment_method = $request->input('payment_method');
        $email = $request->input('email');
        $order_end = $request->input('order_end');
        $note = $request->input('note');
        $cinema = $request->input('cinema');
        $userVoucher = $request->input('voucher');
        $food_items = json_decode($request->input('food_items'), true);

        if (empty($food_items)) {
            toastr()->error('Bạn chưa chọn món!');
            return redirect()->route('food');
        }

        $can_place_order = true;

        foreach ($food_items as $item) {
            $food = MovieFood::find($item['food_id']);
            $food_quantity = $food->quantity;
            if ($item['quantity'] > $food_quantity) {
                toastr()->error('Số lượng món ăn vượt quá số lượng có sẵn!');
                $can_place_order = false;
                break;
            }
        }

        if ($can_place_order) {
            $voucher = Voucher::where('code', $userVoucher)->first();

            if ($voucher && $voucher->quantity > 0 && $order_date >= $voucher->start_date && $order_date <= $voucher->end_date && $totalPrice >= $voucher->min_order_amount && $totalPrice <= $voucher->max_order_amount) {
                // Decrease the voucher quantity by 1
                $voucher->quantity -= 1;
                $voucher->save();
            }
            $order = OrderFood::create([
                'user_id' => auth()->user()->id,
                'cinema_id' => $cinema,
                'email' => $email,
                'order_date' => $order_date,
                'order_end' => $order_end,
                'total_amount' => $total_amount,
                'payment_method' => $payment_method,
                'note' => $note,
                'reason' => null,
                'status' => 1,
            ]);

            foreach ($food_items as $item) {
                $food = MovieFood::find($item['food_id']);
                $food_quantity = $food->quantity;
                $food->quantity = $food_quantity - $item['quantity'];
                $food->save();
                OrderDetailFood::create([
                    'order_id' => $order->id,
                    'food_id' => $item['food_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
            toastr()->success('Đặt hàng thành công!');
            return redirect()->route('food');
        } else {
            return redirect()->route('food');
        }
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
        $item = OrderFood::find($id);
        $newReason = $request->input('reason');
        $item->reason =  $newReason;
        $item->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderFood = OrderFood::find($id);

        if ($orderFood) {
            // Xóa các OrderDetailFood có order_id tương ứng
            OrderDetailFood::where('order_id', $orderFood->id)->delete();

            // Xóa OrderFood
            $orderFood->delete();

            toastr()->success('Thành công xoá đơn hàng');
        }

        return redirect()->back();
    }

    public function user(Request $request, $id)
    {
        $orderFood = OrderFood::find($id);

        if ($orderFood) {
            // Lấy user_id của người mua đơn hàng
            $userId = $orderFood->user_id;

            // Lấy thông tin người mua
            $user = User::find($userId);

            if ($user) {
                // Hiển thị thông tin người mua
                return view('admin.order_food.user', compact('user'));
            }
            // ...
        }
    }
    public function food(Request $request, $id)
    {

        $orderDetails = OrderDetailFood::join('movie_foods', 'order_detail_foods.food_id', '=', 'movie_foods.id')
            ->join('order_foods', 'order_detail_foods.order_id', '=', 'order_foods.id')
            ->select('movie_foods.name', 'movie_foods.image', 'movie_foods.price', 'order_detail_foods.quantity')
            ->where('order_foods.id', $id)
            ->get();
        return view('admin.order_food.food', compact('orderDetails'));
    }
    public function updateStatus(Request $request, $id)
    {
        $item = OrderFood::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }

        $newStatus = $request->input('status');

        // Kiểm tra xem nếu trạng thái đã hoàn thành hoặc đã hủy bỏ, thì không cho phép thay đổi
        if ($item->status == 3 || $item->status == 4) {
            toastr()->error('Không thể thay đổi trạng thái đã hoàn thành hoặc đã hủy bỏ!');
            return response()->json(['success' => false, 'message' => 'Không thể thay đổi trạng thái đã hoàn thành hoặc đã hủy bỏ']);
        }

        $newReason = $request->input('reason');

        if (empty($newReason)) {
            $item->reason = null;
        }
        $item->status = $newStatus;
        $item->save();

        toastr()->success('Cập nhật trạng thái thành công!');
        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            // Delete orders
            OrderFood::whereIn('id', $ids)->delete();

            // Delete related order details
            OrderDetailFood::whereIn('order_id', $ids)->delete();

            toastr()->success('Thành công xoá các đơn đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các đơn đã chọn');
        }
    }
}
