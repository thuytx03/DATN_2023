<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class QrcodeController extends Controller
{
    public function index($id) {

      if(Auth::check()){
        $booking = Booking::where('id',$id)->first();
        return Redirect()->route('qr.scanner',compact('booking'));
      }
        return view('client.qrcode.index');
    }
    


    public function redirect($param)
    {

        return redirect()->to($param);
    }

}
