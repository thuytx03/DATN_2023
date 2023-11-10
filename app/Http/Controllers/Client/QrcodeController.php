<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class QrcodeController extends Controller
{
    public function index() {
        return view('client.qrcode.index');
    }
    public function redirect($param)
    {
      
        return redirect()->to($param);
    }

}
