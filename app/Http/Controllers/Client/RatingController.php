<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FeedBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Diff\Exception;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function submitRatingAndMessage(Request $request)
    {
        try {
            $user_id = auth()->user()->id;
            $movie_id = $request->movie_id;
            $rating = $request->rating;
            $message = $request->message; // Nếu cần lưu cả nội dung bình luận
            $numberOfBookings = Booking::join('show_times', 'bookings.showtime_id', '=', 'show_times.id')
                ->where(['bookings.user_id' => $user_id, 'show_times.movie_id' => $movie_id])
                ->count();

            $numberOfReviews = Feedback::where(['user_id' => $user_id, 'movie_id' => $movie_id])->count();

            // Kiểm tra số lần đánh giá đã vượt quá số lần đặt vé
            if ($numberOfReviews >= $numberOfBookings) {
                return response()->json(['messageError' => 'Bạn không còn lượt đánh giá nào nữa.']);
            }
            // Lưu đánh giá vào bảng feedbacks
            $feedback = new Feedback([
                'user_id' => $user_id,
                'movie_id' => $movie_id,
                'rating' => $rating,
                'message' => $message,
            ]);
            $feedback->save();

            // Sau khi xử lý, trả về một response (ví dụ: JSON response)
            return response()->json(['message' => 'Đánh giá và bình luận thành công.']);

        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);

        }
    }

}
