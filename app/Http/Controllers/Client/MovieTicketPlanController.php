<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Province;
use App\Models\Room;
use App\Models\ShowTime;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\TestEvent;
use Illuminate\Support\Facades\Redis;

class MovieTicketPlanController extends Controller
{

    public function index(Request $request, $id, $slug)
    {
        // xoá session khi chuyển sang lịch chiếu khác
        session()->forget('selectedSeats');
        session()->forget('selectedProducts');
        session()->forget('totalPriceFood');
        $selectedDate = $request->input('selected_date'); // Lấy ngày đã chọn từ query parameter
        $selectedProvinceId = $request->input('province_id'); // Lấy province_id từ query parameter
        $selectedCinemaId = $request->input('cinema_id'); // Lấy cinema_id từ query parameter

        $movie = Movie::where('id', $id)
            ->where('slug', $slug)
            ->first();

        if ($movie) {
            // Lấy danh sách rạp chiếu phim
            $cinemas = Cinema::all();

            // Lấy danh sách tỉnh
            $province = Province::all();

            // Tạo một mảng để lưu thông tin về rạp, phòng và lịch chiếu
            $cinemaSchedules = [];

            if (!$selectedDate) {
                $selectedDate = Carbon::now()->format('Y-m-d'); // Nếu không có ngày được chọn, sử dụng ngày hiện tại
            }

            $currentDateTime = Carbon::now(); // Thời gian hiện tại

            foreach ($cinemas as $cinema) {
                $showTimeQuery = ShowTime::where('movie_id', $movie->id)
                    ->where('status', 1)
                    ->whereHas('room', function ($query) use ($cinema, $selectedCinemaId) {
                        $query->where('cinema_id', $cinema->id);
                        if ($selectedCinemaId) {
                            $query->where('id', $selectedCinemaId);
                        }
                    });

                if ($selectedDate) {
                    $showTimeQuery->whereDate('start_date', $selectedDate); // Lọc theo ngày bắt đầu
                }

                if ($selectedProvinceId) {
                    $showTimeQuery->whereHas('room.cinema', function ($query) use ($selectedProvinceId) {
                        $query->where('province_id', $selectedProvinceId);
                    });
                }

                $showTimes = $showTimeQuery->get();

                if ($showTimes->count() > 0) {
                    $cinemaSchedules[$cinema->name] = [];

                    // Nhóm các lịch chiếu theo phòng cho rạp này
                    $groupedShowtimes = $showTimes->groupBy('room_id');

                    foreach ($groupedShowtimes as $roomId => $roomShowtimes) {
                        $room = Room::find($roomId);

                        // Lọc các lịch chiếu mà thời gian bắt đầu vẫn chưa vượt qua thời gian hiện tại
                        $roomShowtimes = $roomShowtimes->filter(function ($showtime) use ($currentDateTime) {
                            return Carbon::parse($showtime->start_date) > $currentDateTime;
                        });

                        if ($roomShowtimes->count() > 0) {
                            // Khởi tạo một mảng để lưu trữ số lượng ghế trống cho mỗi lịch chiếu
                            $availableSeatCounts = [];

                            foreach ($roomShowtimes as $showtime) {
                                // Lấy danh sách ghế đã đặt cho lịch chiếu này
                                $bookings = Booking::where('showtime_id', $showtime->id)
                                    ->where('status', '!=', '4')
                                    ->get();
                                    $cacheKey = 'selected_seats_' . auth()->id() . '_showtime_' . $showtime->id;
                                    // dd($cacheKey);
                                    Redis::del($cacheKey);
                                $bookedSeats = [];
                                foreach ($bookings as $booking) {
                                    $bookedSeats = array_merge($bookedSeats, json_decode($booking->list_seat));

                                }
                                // Loại bỏ các giá trị trùng lặp
                                $bookedSeats = array_unique($bookedSeats);

                                // Tính toán số ghế trống cho lịch chiếu này
                                $availableSeats = $room->seats->count() - count($bookedSeats);

                                // Thêm số lượng ghế trống vào mảng
                                $availableSeatCounts[$showtime->id] = $availableSeats;
                            }

                            // Thêm thông tin về phòng, lịch chiếu và số ghế trống vào lịch chiếu của rạp
                            $cinemaSchedules[$cinema->name][$room->name] = [
                                'roomShowtimes' => $roomShowtimes,
                                'availableSeatCounts' => $availableSeatCounts,
                            ];
                        }
                    }
                }
            }
            $cinemasByProvince = Cinema::where('province_id', $selectedProvinceId)->get();

            return view('client.movies.movie-ticket-plan', compact('cinemaSchedules', 'movie', 'province', 'selectedCinemaId', 'cinemasByProvince'));
        }
    }


    public function getCinemasByProvince($provinceId)
    {
        $cinemas = Cinema::where('province_id', $provinceId)->pluck('name', 'id');
        return response()->json($cinemas);
    }
}
