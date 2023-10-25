<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;

class HomeController extends Controller
{
    //
    public function index()
    {
        $movies = Movie::all();
        return view('client.index', compact('movies'));
    }

    public function list()
    {
        $movies = Movie::all();
        return view('client.movies.movie-list', compact('movies'));
    }

    public function detail($id)
    {
        $movie = Movie::find($id);
        if ($movie) {
            $genres = $movie->genres;
            $genresName = $genres->pluck('name')->toArray();
            $nameGenres = implode(',', $genresName);
            $images = $movie->images;
            return view('client.movies.movie-detail', compact('movie', 'nameGenres', 'images'));
        }
    }
}
