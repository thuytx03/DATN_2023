<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FeedBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function submitRating(Request $request)
    {
        $userId = auth()->id(); // Lấy ID của người dùng hiện tại
        // Reset biến đếm trên session
        session()->forget('ratings_performed');
        $rating = $request->input('rating');
        $movieId = $request->input('movie_id'); // Chắc chắn rằng bạn đã truyền movie_id từ JavaScript

        // Kiểm tra xem người dùng đã đặt vé cho phim này bao nhiêu lần
        $bookingCount = DB::table('bookings')
            ->join('show_times', 'bookings.showtime_id', '=', 'show_times.id')
            ->where('bookings.user_id', $userId)
            ->where('show_times.movie_id', $movieId)
            ->count();
        $feedback = Feedback::where('user_id', $userId)
            ->where('movie_id', $movieId)
//            ->whereNull('message')
            ->first();
        // Kiểm tra xem người dùng đã đánh giá bao nhiêu lần
        $existingRatings = Feedback::where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->count();
        if ($feedback && $feedback->rating == null) {
            $feedback->update(['rating' => $rating]);
            return response()->json(['messageSuccess' => 'Đánh giá đã được gửi thành công', 'rating' => $rating]);
        }
        // Kiểm tra số lượt đánh giá đã thực hiện
        $ratingsPerformed = session()->get('ratings_performed', 0);
        if ($bookingCount > 0 && $existingRatings < $bookingCount && $ratingsPerformed < $bookingCount) {
            // Lưu đánh giá vào cơ sở dữ liệu
            $newRating = new FeedBack([
                'movie_id' => $movieId,
                'user_id' => auth()->id(), // Lấy user_id của người đăng nhập
                'rating' => $rating,
            ]);
            $newRating->save();

            // Tăng biến đếm số lượt đánh giá đã thực hiện
            $ratingsPerformed++;
            session(['ratings_performed' => $ratingsPerformed]);
            // Trả về thông điệp nếu cần
            return response()->json(['messageSuccess' => 'Đánh giá đã được gửi thành công', 'rating' => $rating]);
        } elseif ($bookingCount == 0) {
            return response()->json(['messageBookingMovie' => 'Bạn cần đặt vé ít nhất 1 lần trước khi đánh giá.'], 422);
        } elseif ($existingRatings >= $bookingCount) {
            return response()->json(['messageOver' => 'Bạn đã vượt quá số lần đánh giá cho phép.'], 422);
        } elseif ($ratingsPerformed >= $bookingCount) {
            return response()->json(['messageEnough' => 'Bạn đã đánh giá đủ số lần vé đã đặt.'], 422);
        } else {
            return response()->json(['message' => 'Có lỗi xảy ra.'], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function submitMessage(Request $request)
    {
        $userId = auth()->user()->id;
        $movieId = $request->input('movie_id');
        $rating = ($request->input('rating') == 0) ? null : $request->input('rating');
        $message = $request->input('message');
        $feedback = Feedback::where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->first();
        if ($message == null) {
            return response()->json(['messageNotNull' => 'Vui lòng không bỏ trống.'], 422);
        }
        if ($rating != 0) {
            if ($feedback) {
                // Nếu đã có đánh giá, chỉ cập nhật trường message
                $feedback->update(['message' => $message]);
            }
            return response()->json(['message' => 'Bình luận thành công']);
        } else if($feedback) {
            $feedback->update(['message' => $message]);
            return response()->json(['message' => 'Bình luận thành công']);
        }
        else {
            // Nếu chưa có đánh giá, tạo mới bản ghi
            Feedback::create([
                'user_id' => $userId,
                'movie_id' => $movieId,
                'rating' => $rating,
                'message' => $message,
            ]);
            return response()->json(['message' => 'Bình luận thành công']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}
