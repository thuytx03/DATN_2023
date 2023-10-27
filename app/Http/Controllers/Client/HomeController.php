<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use App\Models\moviefavorite;
use App\Models\User;
use App\Models\Genre;

class HomeController extends Controller
{
    public function vouchers(Request $request)
    {
        $vouchers = Voucher::query();
        if ($request->has('trangthai')) {
            if ($request->input('trangthai') == 'saphethan') {
                $vouchers = Voucher::where('end_date', '>=', now())
                    ->orderBy('end_date', 'asc')
                    ->orderByRaw('end_date - NOW() ASC')
                    ->paginate(5);
                $vouchers1 = $vouchers;
            } elseif ($request->input('trangthai') == 'moi') {
               
        
                $vouchers1 = $vouchers->latest()->paginate(5);
            }
        }else {
            $vouchers1 = $vouchers->latest()->paginate(5);
        }
        if ($request->has('giamgia')) {
            if ($request->input('giamgia') == 'theophantram') {
                $vouchers = Voucher::where('type', '=', 2)
                    ->paginate(5);
                $vouchers1 = $vouchers;
            } elseif ($request->input('giamgia') == 'theogia') {
                $vouchers = Voucher::where('type', '=', 1)
                ->paginate(5);
            $vouchers1 = $vouchers;
            }
        }
       
       
        return view('client.vouchers.vouchers-list', compact('vouchers1'));
    }

    public function detailVouchers($id)
    {
        $vouchers = Voucher::query();
        $vouchers1 =    $vouchers->find($id);

        return view('client.vouchers.vouchers-detail', compact('vouchers1'));
    }
    //
    public function index()
{
    if (auth()->check()) {
        $userID = auth()->user()->id;
        $user = User::with('favoriteMovies')->find($userID); // Assuming you have defined the relationship in the User model.
        $movies = Movie::all();
        return view('client.index', compact('user','movies'));
    }

    $movies = Movie::all();
    return view('client.index', compact('movies'));
}
    public function list()
    {
       
        $movies = Movie::all();
        
        return view('client.movies.movie-list', compact('movies'));
    }

    public function detail($id)
    {    $movie = Movie::find($id);
        if (auth()->check()) {
            $userID = auth()->user()->id;
            $user = User::with('favoriteMovies')->find($userID); // Assuming you have defined the relationship in the User model.
            $genres = $movie->genres;
            $genresName = $genres->pluck('name')->toArray();
            $nameGenres = implode(',', $genresName);
            $images = $movie->images;
           
            return view('client.movies.movie-detail', compact('user','movie','images','nameGenres'));
        }
       
        if ($movie) {
            $genres = $movie->genres;
            $genresName = $genres->pluck('name')->toArray();
            $nameGenres = implode(',', $genresName);
            $images = $movie->images;
            return view('client.movies.movie-detail', compact('movie', 'nameGenres', 'images'));
        }
    }
}
