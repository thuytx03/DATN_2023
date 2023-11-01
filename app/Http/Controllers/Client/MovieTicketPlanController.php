<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Province;
use App\Models\Room;
use App\Models\ShowTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovieTicketPlanController extends Controller
{
    public function index(Request $request, $id, $slug)
    {
        $movie = Movie::where('id', $id)->where('slug', $slug)->first();

        if ($movie) {
            $currentDateTime = Carbon::now(); // Lấy ngày và giờ hiện tại

            $ticketShowTime = ShowTime::where('movie_id', $movie->id)
                ->where('start_date', '>', $currentDateTime)
                ->where('status', 1)
                ->get();

            $province = Province::all();

            return view('client.movies.movie-ticket-plan', compact('ticketShowTime', 'movie', 'province'));
        }
    }

    public function getCinemasByProvince($provinceId)
    {
        $cinemas = Cinema::where('province_id', $provinceId)->pluck('name', 'id');
        return response()->json($cinemas);
    }
}
