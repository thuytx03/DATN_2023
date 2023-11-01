<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cinema;
use App\Models\Movie;
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
        //xoá session khi chuyển sang lịch chiếu khác
        session()->forget('selectedSeats');

        $room = Room::where('id', $room_id)->first();
        // Lấy danh sách ghế của phòng chiếu $room, lọc theo loại ghế
        $seatsThuong = $room->seats()->where('seat_type_id', 1)->get();
        $seatsVip = $room->seats()->where('seat_type_id', 2)->get();
        $seatsDoi = $room->seats()->where('seat_type_id', 3)->get();

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

        return view('client.movies.movie-seat-plan', compact('seatsVip', 'seatsThuong', 'seatsDoi', 'room', 'showTime', 'bookedSeats','province'));
    }

    public function saveSelectedSeats(Request $request)
    {
        $selectedSeats = $request->input('selectedSeats');
        Session::put('selectedSeats', $selectedSeats);
        // Trả về số ghế đã chọn cùng với phản hồi JSON
        return response()->json(['message' => 'Selected seats saved successfully']);
    }

}
