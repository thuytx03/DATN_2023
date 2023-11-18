<?php

namespace App\Http\Controllers\Client;

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
    public function saveSelectedSeats(Request $request)
    {
        $selectedSeats = $request->input('selectedSeats');
        Session::put('selectedSeats', $selectedSeats);

        // Gọi hàm seatPrice để tính toán tổng giá ghế và trả về giá trị đó
        $totalPrice = $this->seatPrice();

        // Trả về giá trị JSON chứa tổng giá ghế
        return response()->json(['message' => 'Selected seats saved successfully', 'totalPrice' => $totalPrice]);
    }


    public function luuThongTinSanPham(Request $request)
    {
        $selectedProducts = $request->input('selectedProducts');
        $totalPriceFood = $request->input('totalPriceFood');
        // Lưu dữ liệu vào session
        session(['selectedProducts' => $selectedProducts, 'totalPriceFood' => $totalPriceFood]);
        return response()->json(['success' => true]);
    }
}
