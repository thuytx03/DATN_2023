<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Movie;
use App\Models\ShowTime;
use App\Models\Room;

class QrcodeController extends Controller
{





    public function qrtiketinfo($id) {
        $booking = Booking::where('id',$id)->first();
        $showtime = ShowTime::where('id',$booking->showtime_id)->first();
        $movie = Movie::where('id',$showtime->movie_id)->first();
        $room = Room::where('id',$showtime->room_id)->first();
        return view('client.qrcode.index',compact('booking','movie','room','showtime'));
    }

}
