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
