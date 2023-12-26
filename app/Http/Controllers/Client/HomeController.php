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
use App\Models\Cinema;
use App\Models\Country;
use App\Models\Province;
use Carbon\Carbon;
use App\Models\Post;




class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $userID = auth()->user()->id;
            $user = User::with('favoriteMovies')->find($userID); // Assuming you have defined the relationship in the User model.
            $movies = Movie::all();
            $cinemas = Cinema::all();
            $provinces = Province::all();
            $post = Post::orderBy('created_at', 'desc')->get();
            $countries=Country::all();
            $currentDate = Carbon::now()->format('d/m/Y'); // Lấy ngày hiện tại
            $sevenDaysLater = Carbon::now()->addDays(7)->format('d/m/Y'); // Lấy ngày 7 ngày sau


            return view('client.index', compact('movies', 'cinemas', 'currentDate', 'sevenDaysLater', 'provinces','user','post','countries'));
        }
        $movies = Movie::all();
        $cinemas = Cinema::all();
        $provinces = Province::all();
        $post = Post::orderBy('created_at', 'desc')->get();
        $countries=Country::all();
        $currentDate = Carbon::now()->format('d/m/Y'); // Lấy ngày hiện tại
        $sevenDaysLater = Carbon::now()->addDays(7)->format('d/m/Y'); // Lấy ngày 7 ngày sau


        return view('client.index', compact('movies', 'cinemas', 'currentDate', 'sevenDaysLater', 'provinces','post','countries'));
    }
}
