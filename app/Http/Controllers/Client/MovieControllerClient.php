<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Cinema;
use Illuminate\Support\Facades\Log;
use App\Models\Province;
use Carbon\Carbon;
use App\Models\User;



class MovieControllerClient extends Controller
{
    //
    public function list()
    {
        $movies = Movie::all();
        $genres = Genre::all();
        $cinemas = Cinema::all();
        $provinces = Province::all();

        $currentDate = Carbon::now()->format('d/m/Y'); // Lấy ngày hiện tại
        $sevenDaysLater = Carbon::now()->addDays(7)->format('d/m/Y'); // Lấy ngày 7 ngày sau

        return view('client.movies.movie-list', compact('movies', 'genres', 'cinemas', 'currentDate', 'sevenDaysLater', 'provinces'));
    }



    public function detail($slug, $id)
    {
        $movie = Movie::find($id);
        if (auth()->check()) {
            $userID = auth()->user()->id;
            $user = User::with('favoriteMovies')->find($userID); // Assuming you have defined the relationship in the User model.
            $genres = $movie->genres;
            $genresName = $genres->pluck('name')->toArray();
            $nameGenres = implode(',', $genresName);
            $images = $movie->images;

            return view('client.movies.movie-detail', compact('user', 'movie', 'images', 'nameGenres'));
        }
        if ($movie) {
            $genres = $movie->genres;
            $genresName = $genres->pluck('name')->toArray();
            $nameGenres = implode(',', $genresName);
            $images = $movie->images;
            return view('client.movies.movie-detail', compact('movie', 'nameGenres', 'images'));
        }
    }

    public function search(Request $request)
    {
        try {
            $query = Movie::query();

            if ($request->filled('start_date')) {
                $startDate = $request->input('start_date');
                $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
                $query->whereDate('start_date', $startDate);
            }

            if ($request->filled('search_query')) {
                $searchQuery = $request->input('search_query');
                $query->where('name', 'like', "%$searchQuery%");
            }

            $movies = $query->get();

            return view('client.movies.partial-movies', compact('movies'));
        } catch (\Exception $e) {
            Log::error('Error during search: ' . $e->getMessage());
            // Xử lý exception ở đây nếu cần
        }
    }


    public function filter(Request $request)
    {
        try {
            $selectedGenres = $request->input('genres');

            $movies = Movie::whereHas('genres', function ($query) use ($selectedGenres) {
                $query->whereIn('genre_id', $selectedGenres);
            })->select('id', 'name', 'poster')->get();

            return view('client.movies.partial-movies', compact('movies'));
        } catch (\Exception $e) {
            Log::error('Lỗi trong quá trình lọc: ' . $e->getMessage());
            // Xử lý exception ở đây
        }
    }
}
