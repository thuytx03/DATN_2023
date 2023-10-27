<?php

namespace App\Http\Controllers\Client;
use App\Models\MovieFavorite;
use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\MovieGenre;
use App\Models\Movie;



use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function addFavorite($movieID, Request $request) {
        // Lấy ID của người dùng đang đăng nhập
        $userID = auth()->user()->id;
        // Kiểm tra xem phim đã tồn tại trong danh sách yêu thích của người dùng hay chưa
        $favoriteExists = MovieFavorite::where('movie_id', $movieID)
            ->where('user_id', $userID)
            ->first();
            if($favoriteExists) {
                $favoriteExists->delete();
            }
        if (!$favoriteExists) {
            // Nếu phim chưa tồn tại trong danh sách yêu thích, thêm nó vào danh sách
            $favorite = new MovieFavorite();
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
    public function listFavorite(Request $request) {
        if (auth()->check()) {
            $userID = auth()->user()->id;
            $user = User::with('favoriteMovies')->find($userID);
            // Lấy danh sách các phim yêu thích của người dùng
            $movies = Movie::all();
            $genres = Genre::all();
            $favoriteMovies = $user->favoriteMovies;
       
            if (!empty($request['search'])) {
                $timkiem = $request->input('search');
                $favoriteMovies = $favoriteMovies->where('name', 'LIKE', "$timkiem");
            }
            if (!empty($request['danhmuc'])) {
                $categoryId = $request->input('danhmuc');
                // Lọc danh sách phim yêu thích dựa trên danh mục được chọn
                $favoriteMovies = $favoriteMovies->filter(function ($movie) use ($categoryId) {
                    return $movie->genres->contains('id', $categoryId);
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
           
            // $filteredFavoriteMovies = $favoriteMovies->get();
            // dd( $filteredFavoriteMovies);
            // $favoriteMovies = $favoriteMovies->paginate(3); // Phân trang dữ liệu
            $favoriteMovies = $favoriteMovies;
         
            return view('client.favorite.favorite-list', compact('genres', 'movies', 'user', 'favoriteMovies'));
        }
    }
}
