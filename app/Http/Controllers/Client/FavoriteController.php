<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\MovieGenre;
use App\Models\Movie;
use Illuminate\Pagination\Paginator;
use App\Models\MovieFavourite;


use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function addFavorite($movieID, Request $request)
    {
        // Lấy ID của người dùng đang đăng nhập
        $userID = auth()->user()->id;
        // Kiểm tra xem phim đã tồn tại trong danh sách yêu thích của người dùng hay chưa
        $favoriteExists = MovieFavourite::where('movie_id', $movieID)
            ->where('user_id', $userID)
            ->first();
        if ($favoriteExists) {
            $favoriteExists->delete();
        }
        if (!$favoriteExists) {
            // Nếu phim chưa tồn tại trong danh sách yêu thích, thêm nó vào danh sách
            $favorite = new MovieFavourite();
            $favorite->movie_id = $movieID;
            $favorite->user_id = $userID;
            $favorite->save();

            if ($favorite->id) {

                toastr()->success('Phim yêu thích thêm thành công!');
                return redirect()->back();
            } else {
                toastr()->error('Có lỗi xảy ra khi thêm phim yêu thích.');
            }
        } else {
            toastr()->warning('Đã xóa phim khỏi mục yêu thích');
        }
        return redirect()->back();
    }
    public function listFavorite(Request $request)
    {
        if (auth()->check()) {
            $userID = auth()->user()->id;
            $user = User::with('favoriteMovies')->find($userID);
            $movies = Movie::all();
            $genres = Genre::all();
            $favoriteMovies = $user->favoriteMovies();

            if (!empty($request['search'])) {
                $timkiem = $request->input('search');
                $favoriteMovies = $favoriteMovies->where('name', 'like', '%' . $timkiem . '%');
            }

            if (!empty($request['danhmuc'])) {
                $categoryId = $request->input('danhmuc');
                $favoriteMovies = $favoriteMovies->whereHas('genres', function ($query) use ($categoryId) {
                    $query->where('genre_id', $categoryId);
                });
            }

            if ($request->has('trangthai')) {
                $trangThai = $request->input('trangthai');
                if ($trangThai == 'sapchieu') {
                    $favoriteMovies = $favoriteMovies->where('start_date', '>', now());
                } elseif ($trangThai == 'dangchieu') {
                    $favoriteMovies = $favoriteMovies->where('start_date', '<=', now());
                }
            }

            // $perPage = 5; // Số phần tử trên mỗi trang
            // $page = $request->input('page', 1); // Trang hiện tại
            $favoriteMovies = $favoriteMovies->paginate(5);

            return view('client.favorite.favorite-list', [
                'genres' => $genres,
                'movies' => $movies,
                'user' => $user,
                'favoriteMovies' => $favoriteMovies,
                // 'currentPage' => $page, // Trang hiện tại
            ]);
        }
    }
}
