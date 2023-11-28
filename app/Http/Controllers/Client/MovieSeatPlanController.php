<?php

namespace App\Http\Controllers\Client;


use App\Events\SeatSelected;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\MovieFood;
use App\Models\Province;
use App\Models\Room;
use App\Models\Seat;
use App\Models\SeatType;
use App\Models\ShowTime;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class MovieSeatPlanController extends Controller
{
    public function index(Request $request, $room_id, $slug, $showtime_id)
    {
        session()->forget('selectedSeats');
        session()->forget('selectedProducts');
        session()->forget('totalPriceFood');
        $room = Room::where('id', $room_id)->first();
        // Lấy danh sách ghế của phòng chiếu $room, lọc theo loại ghế
        $seatsThuong = $room
            ->seats()
            ->where('seat_type_id', 1)
            ->get();
        $seatsVip = $room
            ->seats()
            ->where('seat_type_id', 2)
            ->get();
        $seatsDoi = $room
            ->seats()
            ->where('seat_type_id', 3)
            ->get();

        // Sắp xếp danh sách ghế theo hàng và cột
        $seatsThuong = $seatsThuong->sortBy('row');

        $seatsVip = $seatsVip->sortBy('row');
        $seatsDoi = $seatsDoi->sortBy('row');

        if (!$request->session()->has('selectedSeats')) {
            $request->session()->put('selectedSeats', []);
        }
        $showTime = ShowTime::find($showtime_id);

        //đây là code kiểm tra danh sách ghế đã được đặt dựa trên showtime_id
        $bookings = Booking::where('showtime_id', $showtime_id)->get();
        $bookedSeats = [];
        foreach ($bookings as $booking) {
            $bookedSeats = array_merge($bookedSeats, json_decode($booking->list_seat));
        }
        // Loại bỏ các giá trị trùng lặp
        $bookedSeats = array_unique($bookedSeats);
        $province = Province::all();

        //Danh sách đồ ăn
        $food = MovieFood::paginate(6);

        // session()->forget('selectedProducts');
        // session()->forget('totalPriceFood');
       $this->getSelectedSeats($showTime->id);





        // dd(event(new SeatSelected(auth()->id(), $selectedSeats, $showTime->id)));

        return view('client.movies.movie-seat-plan', compact('seatsVip', 'seatsThuong', 'seatsDoi', 'room', 'showTime', 'bookedSeats', 'province', 'food'));
    }

    public function seatPrice()
    {
        // Tạo một mảng để lưu giá của từng ghế.
        $prices = [];
        foreach (Session::get('selectedSeats', []) as $seat) {
            // Tách hàng và cột từ chuỗi ghế (ví dụ: "J6" -> hàng "J", cột "6").
            $row = substr($seat, 0, 1); // Lấy ký tự đầu tiên
            $column = substr($seat, 1);

            // Lấy thông tin của ghế từ bảng 'seats'.
            $seatInfo = Seat::where('row', $row)
                ->where('column', $column)
                ->first();

            if ($seatInfo) {
                // Lấy giá dựa trên 'seat_type_id' từ bảng 'seat_types'.
                $seatType = SeatType::find($seatInfo->seat_type_id);
                if ($seatType) {
                    // Lưu giá của từng ghế vào mảng $prices.
                    $prices[] = $seatType->price;
                }
            }
        }

        // Tính tổng giá của tất cả các ghế.
        $totalPriceTicket = array_sum($prices);

        // Trả về giá của ghế
        return $totalPriceTicket;
    }


    public function saveSelectedSeats(Request $request)
    {
        $showtime_id = $request->input('showtime_id');
        $selectedSeats = $request->input('selectedSeats');
        try {
            $cacheKey = 'selected_seats_' . auth()->id() . '_showtime_' . $showtime_id;
            $redisResult = Redis::set($cacheKey, json_encode($selectedSeats));
            broadcast(new SeatSelected(auth()->id(), $selectedSeats, $showtime_id))->toOthers();
            Session::put('selectedSeats', $selectedSeats);
            // Gửi thông báo đến channel để cập nhật trạng thái ghế cho tất cả người dùng
        } catch (\Exception $e) {
            return response()->json(['error' => 'Redis error: ' . $e->getMessage()], 500);
        }

        $totalPrice = $this->seatPrice();
        return response()->json(['message' => 'Selected seats saved successfully', 'totalPrice' => $totalPrice]);
    }

    public function getSelectedSeats($showtime_id)
    {
        $cacheKey = 'selected_seats_' . auth()->id() . '_showtime_' . $showtime_id;
        $selectedSeatsJson = Redis::get($cacheKey);

        if ($selectedSeatsJson) {
            $selectedSeats = json_decode($selectedSeatsJson, true);
            // dd($selectedSeats);
        } else {
            $selectedSeats = session()->get('selectedSeats', []); // Lấy từ session trên client side
        }

        // event(new SeatSelected(auth()->id(), $selectedSeats, $showtime_id));
        broadcast(new SeatSelected(auth()->id(), $selectedSeats, $showtime_id))->toOthers();

        return $selectedSeats;
    }


    public function clearSeatsCache(Request $request)
    {
        $showtime_id=$request->showtime_id;
        try {
            $cacheKey = 'selected_seats_' . auth()->id() . '_showtime_' . $showtime_id;
            Redis::del($cacheKey);
            Session::forget('selectedSeats');
            Session::forget('selectedSeatsCreatedAt');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error clearing cache and session: ' . $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Cache and session cleared successfully']);
    }




    public function luuThongTinSanPham(Request $request)
    {
        $selectedProducts = $request->input('selectedProducts');
        $totalPriceFood = $request->input('totalPriceFood');
        // Lưu dữ liệu vào session
        session(['selectedProducts' => $selectedProducts, 'totalPriceFood' => $totalPriceFood]);
        return response()->json(['success' => true]);
    }


    public function foodPlan(Request $request, $room_id, $slug, $showtime_id)
    {
        $showTime = ShowTime::find($showtime_id);
        $room = Room::where('id', $room_id)->first();
        $food = MovieFood::where('status', 1)->get();
        // $sesion=session('selectedProducts');
        // dd($sesion);
        // session()->forget('selectedProducts');
        // session()->forget('totalPriceFood');
        return view('client.movies.movie-food', compact('room', 'showTime', 'food'));
    }
}
