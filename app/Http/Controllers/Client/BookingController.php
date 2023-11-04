<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\MovieFood;
use App\Models\Room;
use App\Models\Seat;
use App\Models\SeatType;
use App\Models\ShowTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function index(BookingRequest $request, $room_id, $slug, $showtime_id)
    {
        $room = Room::where('id', $room_id)->first();
        $showTime = ShowTime::find($showtime_id);

        // dd(Session::get('selectedSeats', []));

        $totalPrice = 0;
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
        $totalPrice = array_sum($prices);

        // dd($totalPrice);

        if ($request->isMethod('POST')) {
            $booking = new Booking();
            $booking->user_id = auth()->user()->id;
            $booking->showtime_id = $showTime->id;
            $booking->name = $request->name;
            $booking->email = $request->email;
            $booking->phone = $request->phone;
            $booking->address = $request->address;
            $booking->total = $request->total;
            $booking->payment = $request->payment;
            $booking->status = 1;
            $booking->note = $request->note;
            if (Session::has('selectedSeats')) {
                $listSeat = Session::get('selectedSeats', []);
                // dd($listSeat);
                $selectedSeatsJson = json_encode($listSeat);
                // dd($selectedSeatsJson);
                $booking->list_seat = $selectedSeatsJson;
            }
            $booking->total = $totalPrice;
            $booking->save();
            session()->forget('selectedSeats');
            toastr()->success('Đặt vé thành công');
            return redirect()->route('index');
        }
        return view('client.movies.movie-checkout', compact('showTime', 'room', 'totalPrice'));
    }


}
