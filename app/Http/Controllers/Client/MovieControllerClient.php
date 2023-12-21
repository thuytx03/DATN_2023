<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FeedBack;
use App\Models\ShowTime;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Cinema;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Province;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MovieControllerClient extends Controller
{
    //
    public function list()
    {
        $movies = Movie::all();
        $genres = Genre::all();
        $cinemas = Cinema::all();
        $provinces = Province::all();
        $countries = Country::all();
        $currentDate = Carbon::now()->format('d/m/Y'); // Lấy ngày hiện tại
        $sevenDaysLater = Carbon::now()->addDays(7)->format('d/m/Y'); // Lấy ngày 7 ngày sau

        return view('client.movies.movie-list', compact('movies', 'genres', 'cinemas', 'currentDate', 'sevenDaysLater', 'provinces', 'countries'));
    }

    // Trong controller của bạn
    public function nowShowingMovies(Request $request)
    {
        $sortBy = $request->input('sortBy', 'default');
        $currentTime = Carbon::now();
        $user = Auth::user(); // Đảm bảo biến $user được gán giá trị từ Auth::user() hoặc từ nguồn dữ liệu khác
        // Nếu $sortBy là 'now-showing', lấy danh sách các bộ phim đang chiếu
        if ($sortBy === 'now-showing') {
            $movies = Movie::whereHas('showtimes', function ($query) use ($currentTime) {
                $query->where('start_date', '<=', $currentTime)
                    ->where('end_date', '>=', $currentTime);
            })->get();
        } else {
            // Nếu $sortBy là 'coming-soon', lấy danh sách các bộ phim sắp chiếu trong khoảng từ ngày hiện tại đến 7 ngày kể từ ngày hiện tại
            $movies = Movie::where('start_date', '>=', $currentTime)
                ->where('start_date', '<=', $currentTime->copy()->addDays(7))
                ->get();
        }
        // Trả về HTML thay vì view
        return view('client.movies.movie', compact('movies','user'));
    }



    public function searchByName(Request $request)
    {
        try {
            $query = Movie::query();
            $user = Auth::user(); // Đảm bảo biến $user được gán giá trị từ Auth::user() hoặc từ nguồn dữ liệu khác
            if ($request->filled('start_date')) {
                $startDate = $request->input('start_date');
                $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
                $query->whereDate('start_date', $startDate);
            }

            if ($request->filled('search_query')) {
                $searchQuery = $request->input('search_query');
                $query->where('name', 'like', "%$searchQuery%");
            }

            // Kiểm tra nếu country_id được chọn
            if ($request->filled('country_id')) {
                $countryId = $request->input('country_id');
                $query->where('country_id', $countryId);
            }

            $movies = $query->get();
            return view('client.movies.movie', compact('movies', 'user'));
        } catch (\Exception $e) {
            Log::error('Error during search: ' . $e->getMessage());
            // Xử lý exception ở đây nếu cần
        }
    }


    public function detail($slug, $id)
    {
        $movie = Movie::find($id);
        $averageRating = FeedBack::where('movie_id', $id)->avg('rating');
        $reviews = DB::table('feed_backs')
            ->join('users', 'feed_backs.user_id', '=', 'users.id')
            ->join('movies', 'feed_backs.movie_id', '=', 'movies.id')
            ->select('feed_backs.created_at as feed_back_created_at', 'users.name as user_name', 'users.avatar as avatar', 'feed_backs.message', 'feed_backs.rating')
            ->where('feed_backs.movie_id', $id)
            ->get();
        //        dd($reviews);
        // Làm tròn điểm trung bình nếu cần
        $averageRating = round($averageRating, 1);

        if (auth()->check()) {
            $userID = auth()->user()->id;
            $user = User::with('favoriteMovies')->find($userID); // Assuming you have defined the relationship in the User model.
            $genres = $movie->genres;
            $genresName = $genres->pluck('name')->toArray();
            $nameGenres = implode(',', $genresName);
            $images = $movie->images;
            $canUserReviewMovie = $this->canUserReviewMovie($userID, $id);
            $canUserReviewMovieBooking = $this->isBookingScheduleEnded($userID, $id);
            //            dd($canUserReviewMovieBooking);
            return view('client.movies.movie-detail', compact('user', 'movie', 'images', 'nameGenres', 'averageRating', 'canUserReviewMovie', 'reviews'));
        }
        if ($movie) {
            $genres = $movie->genres;
            $genresName = $genres->pluck('name')->toArray();
            $nameGenres = implode(',', $genresName);
            $images = $movie->images;
            return view('client.movies.movie-detail', compact('movie', 'nameGenres', 'images', 'averageRating', 'reviews'));
        }
    }

    public function search(Request $request)
    {
        try {
            $query = Movie::query();
            $user = Auth::user();
            if ($request->filled('start_date')) {
                $startDate = $request->input('start_date');
                $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
                $query->whereDate('start_date', $startDate);
            }

            if ($request->filled('search_query')) {
                $searchQuery = $request->input('search_query');
                $query->where('name', 'like', "%$searchQuery%");
            }

            if ($request->filled('country_id')) {
                $countryId = $request->input('country_id');
                $query->where('country_id', $countryId);
            }

            $movies = $query->get();

            return view('client.movies.partial-movies', compact('movies', 'user'));
        } catch (\Exception $e) {
            Log::error('Error during search: ' . $e->getMessage());
            // Xử lý exception ở đây nếu cần
        }
    }


    public function filter(Request $request)
    {
        try {
            $selectedCountry = $request->input('country');
            $selectedGenres = $request->input('genres');

            $query = Movie::query();

            if (!empty($selectedCountry)) {
                // Sử dụng whereHas để lọc theo country_id trong bảng movies
                $query->whereHas('country', function ($query) use ($selectedCountry) {
                    $query->whereIn('country_id', $selectedCountry);
                });
            }

            if (!empty($selectedGenres)) {
                $query->whereHas('genres', function ($query) use ($selectedGenres) {
                    $query->whereIn('genre_id', $selectedGenres);
                });
            }

            $movies = $query->get();

            return view('client.movies.partial-movies', compact('movies'));
        } catch (\Exception $e) {
            Log::error('Lỗi trong quá trình lọc: ' . $e->getMessage());
            // Xử lý exception ở đây
        }
    }
    function canUserReviewMovie($user_id, $movie_id)
    {
        // Lấy số lần đặt vé
        $numberOfBookings = Booking::join('show_times', 'bookings.showtime_id', '=', 'show_times.id')
            ->where(['bookings.user_id' => $user_id, 'show_times.movie_id' => $movie_id])
            ->count();

        // Lấy số lần đánh giá
        $numberOfReviews = Feedback::where(['user_id' => $user_id, 'movie_id' => $movie_id])->count();

        // Kiểm tra số lần đánh giá đã vượt quá số lần đặt vé
        return $numberOfReviews < $numberOfBookings;
    }
    function isBookingScheduleEnded($user_id, $movie_id)
    {
        // Lấy danh sách tất cả các lịch chiếu của phim
        $allShowtimes = ShowTime::where('movie_id', $movie_id)->get();

        foreach ($allShowtimes as $showtime) {
            // Kiểm tra xem lịch chiếu đã kết thúc chưa
            $endTime = Carbon::parse($showtime->end_time);
            $now = Carbon::now();

            if ($endTime->gt($now)) {
                // Nếu có ít nhất một lịch chiếu chưa kết thúc, người dùng không thể đánh giá
                return false;
            }
        }

        // Nếu tất cả các lịch chiếu của phim đã kết thúc, kiểm tra số lần đánh giá đã vượt quá số lần đặt vé
        $numberOfBookings = Booking::join('show_times', 'bookings.showtime_id', '=', 'show_times.id')
            ->where(['bookings.user_id' => $user_id, 'show_times.movie_id' => $movie_id])
            ->count();

        $numberOfReviews = Feedback::where(['user_id' => $user_id, 'movie_id' => $movie_id])->count();

        return $numberOfReviews < $numberOfBookings;
    }
}
