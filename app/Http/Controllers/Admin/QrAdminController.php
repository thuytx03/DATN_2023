<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\ShowTime;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode;
class QrAdminController extends Controller
{
    public function index() {
        $bookings = Booking::orderBy('updated_at', 'desc')->get();
        $showTime = ShowTime::all();
        return view('admin.qr.qrscanner',compact('bookings','showTime'));
    }
    public function store(Request $request){

        $bookings = Booking::orderBy('updated_at', 'desc')->get();


        $dataFromQR = $request->input('param');
$parts = explode('/', $dataFromQR);
$numberAfterSlash = end($parts);

// Remove curly braces
$numberAfterSlash = str_replace(['{', '}'], '', $numberAfterSlash);

// Output the result

        $booking1 = Booking::where('id',$numberAfterSlash)->first();
if(isset($booking1)) {
        if($booking1->status == 2 && $booking1->status != 3 && $booking1->status != 4) {
            if($booking1) {
                $showTime1 = ShowTime::find($booking1->showtime_id);
                $status = 3;
                $booking1->status = $status;
                $booking1->save();
                $thongbao = 'Thành Công';
                return view('admin.qr.qrscanner',compact('booking1','thongbao','showTime1'));
            }
        }elseif($booking1->status == 3) {
            $thongbao = 'Vé này đã checkin';
            return redirect()->route('qr.scanner');
        }elseif($booking1->status == 4) {
            $thongbao = 'Vé này đã hủy, vui Lòng bảo khách đặt vé mới';
            return redirect()->route('qr.scanner');
        }
    }else {
        $bookings = Booking::orderBy('updated_at', 'desc')->get();
        $showTime = ShowTime::all();
        $thongbao = 'Thất Bại, không tìm thấy vé đặt';
        return view('admin.qr.qrscanner',compact('bookings','thongbao','showTime'));
    }



        return redirect()->route('qr.scanner');
    }
    public function checkQr($id){
        $booking = Booking::find($id)->first();
        Redirect()->route('qr.scanner',compact('booking'));
    }
}
