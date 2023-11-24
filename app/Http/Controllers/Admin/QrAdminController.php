<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Booking;
use App\Models\ShowTime;
use Illuminate\Support\Facades\Redirect;

use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
class QrAdminController extends Controller
{
    public function index() {
        $bookings = Booking::orderBy('updated_at', 'desc')->get();
        $showTime = ShowTime::all();
        $movie = Movie::all();
        $rooms = Room::all();
        return view('admin.qr.qrscanner',compact('bookings','showTime','movie','rooms'));
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
        if($booking1->status == 2 && $booking1->status != 3 && $booking1->status != 4 || $booking1->status == 5 ) {
            if($booking1) {
                $showTime1 = ShowTime::where('id',$booking1->showtime_id)->first();
                $movieName = Movie::where('id',$showTime1->movie_id)->first();

                $room = Room::where('id',$showTime1->room_id)->first();
                $status = 3;
                $booking1->status = $status;
                $booking1->save();
                $thongbao = 'Thành Công';
                return view('admin.qr.qrscanner',compact('booking1','thongbao','showTime1','room','movieName'));
            }
        }elseif($booking1->status == 3) {
            $bookings = Booking::orderBy('updated_at', 'desc')->get();
            $showTime = ShowTime::all();
            $movie = Movie::all();
            $rooms = Room::all();
            $thongbao = 'Vé này Đã được quét';
            return view('admin.qr.qrscanner',compact('bookings','showTime','movie','rooms','thongbao'));

        }elseif($booking1->status == 4) {
            $bookings = Booking::orderBy('updated_at', 'desc')->get();
            $showTime = ShowTime::all();
            $movie = Movie::all();
            $rooms = Room::all();
            $thongbao = 'Vé này Đã bị hủy';
            return view('admin.qr.qrscanner',compact('bookings','showTime','movie','rooms','thongbao'));
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




    public function processForm(Request $request)
    {
        // Lấy giá trị từ request
        $name = $request->input('name');
        $moivename = $request->input('moviename');
        $roomname = $request->input('roomname');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $list_seat = $request->input('list_seat');
        $created_at = $request->input('created_at');
        $start_date = $request->input('start_date');
        $payment = $request->input('payment');
        $total = $request->input('total');

        // Convert payment to payment method
        if ($payment == 1) {
            $payment = 'VNPAY';
        } elseif ($payment == 2) {
            $payment = 'PayPal';
        }

        // Tạo đối tượng PhpWord
        $phpWord = new \PhpOffice\PhpWord\PhpWord;

        // Thêm một phần vào tài liệu Word
        $section = $phpWord->addSection();

        // Thêm thông tin vào phần vừa tạo
        $section->addText('Name: ' . $name);
        $section->addText('Tên Phim: ' . $moivename);
        $section->addText('Phòng: ' . $roomname);
        $section->addText('Email: ' . $email);
        $section->addText('Phone: ' . $phone);
        $section->addText('List Seat: ' . $list_seat);
        $section->addText('Created At: ' . $created_at);
        $section->addText('Start Date: ' . $start_date);
        $section->addText('Payment: ' . $payment);
        $section->addText('Total: ' . $total);

        // Kiểm tra xem thư mục có tồn tại không
        if (!is_dir(public_path('2023'))) {
            // Nếu không, tạo thư mục
            mkdir(public_path('2023'), 0777, true);
        }

        // Tạo một đối tượng ghi PhpWord
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(public_path('2023/phpflow.docx'));
        return response()->download(public_path('2023/phpflow.docx'));

        // Trả về tệp để tải xuống
    }




}
