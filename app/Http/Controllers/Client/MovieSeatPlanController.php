<?php

namespace App\Http\Controllers\Client;

use App\Events\SeatCancelled;
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
use App\Models\SelectedSeat;
use App\Models\ShowTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class MovieSeatPlanController extends Controller
{

    public function index(Request $request, $room_id, $slug, $showtime_id)
    {
        $numberOfUsers = 30;

        for ($i = 1; $i <= $numberOfUsers; $i++) {
            $cacheKey = 'selected_seats_' . $i . '_showtime_' . $showtime_id;
            $selectedSeatsJson = Redis::get($cacheKey);

            if ($selectedSeatsJson !== null) {
                $selectedSeats = json_decode($selectedSeatsJson, true);
                // dd($selectedSeats);
                // event(new SeatSelected($i, $selectedSeats, $showtime_id, 'selected'));
                broadcast(new SeatSelected($i, $selectedSeats, $showtime_id, 'selected'))->toOthers();
            }
        }

        // dd($selectedSeats);

        session()->forget('selectedSeats');
        session()->forget('selectedProducts');
        session()->forget('totalPriceFood');
        session()->forget('voucher');

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
        $bookings = Booking::where('showtime_id', $showtime_id)
        ->where('status','!=',4)
        ->get();
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
        $selectedSeats1 = $this->getSelectedSeats($showTime->id);

        return view('client.movies.movie-seat-plan', compact('seatsVip', 'seatsThuong', 'seatsDoi', 'room', 'showTime', 'bookedSeats', 'province', 'food', 'selectedSeats1'));
    }



    public function seatPrice($showtime_id)
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
                    // Lưu giá của từng ghế vào mảng $prices.
                    $prices[] = $seatInfo->seatType->seatPrice->where('showtime_id',$showtime_id)->first()->price;
            }
        }

        // Tính tổng giá của tất cả các ghế.
        $totalPriceTicket = array_sum($prices);
        // Trả về giá của ghế
        return $totalPriceTicket;
    }

    // public function testRedis(){
    //     Redis::set('user:1:first_name',"trinh");
    //     Redis::set('user:2:first_name',"xuan");
    //     Redis::set('user:3:first_name',"thuy");
    //     for($i=1; $i<3; $i++){
    //         echo Redis::get('user:'. $i .':first_name');
    //     }
    //     Redis::set('name',"thuycoi2003");
    //     echo Redis::get('name');
    // }

    public function saveSelectedSeats(Request $request)
{
    $showtime_id = $request->input('showtime_id');
    $selectedSeats = $request->input('selectedSeats');

    // Lấy danh sách ghế trước khi lưu để so sánh với danh sách mới
    $previousSelectedSeats = json_decode(Redis::get('selected_seats_' . auth()->id() . '_showtime_' . $showtime_id), true) ?? [];

    try {
        // Lưu danh sách ghế mới với thời gian sống là 10 phút (600 giây)
        $cacheKey = 'selected_seats_' . auth()->id() . '_showtime_' . $showtime_id;
        $redisResult = Redis::setex($cacheKey, 600, json_encode($selectedSeats));

        // Broadcast sự kiện SeatSelected
        broadcast(new SeatSelected(auth()->id(), $selectedSeats, $showtime_id, 'selected'))->toOthers();

        // Xác định danh sách ghế bị huỷ
        $cancelledSeats = array_values(array_diff($previousSelectedSeats, $selectedSeats));

        // Broadcast sự kiện SeatCancelled nếu có ghế bị huỷ
        if (!empty($cancelledSeats)) {
            broadcast(new SeatCancelled(auth()->id(), $cancelledSeats, $showtime_id, 'cancelled'))->toOthers();
        }

        Session::put('selectedSeats', $selectedSeats);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Redis error: ' . $e->getMessage()], 500);
    }

    $totalPrice = $this->seatPrice($showtime_id);
    return response()->json(['message' => 'Selected seats saved successfully', 'totalPrice' => $totalPrice]);
}





    public function getSelectedSeats($showtime_id)
    {
        $cacheKey = 'selected_seats_' . auth()->id() . '_showtime_' . $showtime_id;
        $selectedSeatsJson = Redis::get($cacheKey);

        if ($selectedSeatsJson) {
            $selectedSeats = json_decode($selectedSeatsJson);
            // broadcast(new SeatSelected(auth()->id(), $selectedSeats, $showtime_id,'selected'))->toOthers();
        } else {
            $selectedSeats = session()->get('selectedSeats', []); // Lấy từ session trên client side
        }
        return $selectedSeats;
    }


    public function clearSeatsCache(Request $request)
    {
        $showtime_id = $request->showtime_id;
        try {
            $cacheKey = 'selected_seats_' . auth()->id() . '_showtime_' . $showtime_id;
            $previousSelectedSeats = Redis::get($cacheKey);
            $cancelledSeats = json_decode($previousSelectedSeats);

            if ($previousSelectedSeats) {
                Redis::del($cacheKey);
                broadcast(new SeatCancelled(auth()->id(), $cancelledSeats, $showtime_id, 'cancelled'))->toOthers();
            }
            session()->forget('selectedSeats');
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
