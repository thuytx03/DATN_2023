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
use App\Models\SeatPrice;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use App\Models\Seat;
use pdf;
use Dompdf\Options;
use Dompdf\Dompdf;
use App\Models\SeatType;
use App\Models\BookingDetail;
use App\Models\MovieFood;

class QrAdminController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh|Staff-Qr-Hanoi|Staff-Qr-HaiPhong|Staff-Qr-ThaiBinh|Staff-Qr-NamDinh|Staff-Qr-NinhBinh', ['only' => $methods]);
    }
    public function index()
    {
        $bookings = Booking::orderBy('updated_at', 'desc')->get();
        $showTime = ShowTime::all();
        $movie = Movie::all();
        $rooms = Room::all();
        return view('admin.qr.index', compact('bookings', 'showTime', 'movie', 'rooms'));
    }
    public function store(Request $request)
    {

        $bookings = Booking::orderBy('updated_at', 'desc')->get();
        $dataFromQR = $request->input('param');
        $parts = explode('/', $dataFromQR);
        $numberAfterSlash = end($parts);

        // Remove curly braces
        $numberAfterSlash = str_replace(['{', '}'], '', $numberAfterSlash);

        // Output the result


        $booking1 = Booking::where('id', $numberAfterSlash)->first();
        if (isset($booking1)) {
            if ($booking1->status == 2 && $booking1->status != 3 && $booking1->status != 4 || $booking1->status == 5) {
                if ($booking1) {
                    $showTime1 = ShowTime::where('id', $booking1->showtime_id)->first();
                    $movieName = Movie::where('id', $showTime1->movie_id)->first();
                    $room = Room::where('id', $showTime1->room_id)->first();
                    $status = 3;
                    $booking1->status = $status;
                    $booking1->save();
                    $thongbao = 'Thành Công';
                    $bookingdetail = BookingDetail::where('booking_id', $booking1->id)->get();



                    if (isset($bookingdetail)) {

                        // Extracting food_ids from booking details
                        $foodIds = $bookingdetail->pluck('food_id');

                        // Retrieving food items using the extracted food_ids
                        $foods = MovieFood::whereIn('id', $foodIds)->get();
                    }
                    return view('admin.qr.qrscanner', compact('booking1', 'thongbao', 'showTime1', 'room', 'movieName', 'foods'));
                }
            } elseif ($booking1->status == 3) {
                $showTime1 = ShowTime::where('id', $booking1->showtime_id)->first();
                if ($showTime1) {

                    $movieName = Movie::where('id', $showTime1->movie_id)->first();
                    $room = Room::where('id', $showTime1->room_id)->first();
                    $thongbao = 'Vé này Đã được quét';
                    $bookingdetail = BookingDetail::where('booking_id', $booking1->id)->get();



                    if (isset($bookingdetail)) {

                        // Extracting food_ids from booking details
                        $foodIds = $bookingdetail->pluck('food_id');

                        // Retrieving food items using the extracted food_ids
                        $foods = MovieFood::whereIn('id', $foodIds)->get();
                    }
                    return view('admin.qr.qrscanner', compact('booking1', 'thongbao', 'showTime1', 'room', 'movieName', 'foods'));
                } else {
                    $bookings = Booking::orderBy('updated_at', 'desc')->get();
                    $showTime = ShowTime::all();
                    $movie = Movie::all();
                    $rooms = Room::all();
                    $thongbao = 'Vé này Đã được quét';
                    $bookingdetail = BookingDetail::where('booking_id', $booking1->id)->get();



                    if (isset($bookingdetail)) {

                        // Extracting food_ids from booking details
                        $foodIds = $bookingdetail->pluck('food_id');

                        // Retrieving food items using the extracted food_ids
                        $foods = MovieFood::whereIn('id', $foodIds)->get();
                    }
                    return view('admin.qr.qrscanner', compact('bookings', 'showTime', 'movie', 'rooms', 'thongbao', 'foods'));
                }
                // $thongbao = 'Vé này Đã được quét';
                // return view('admin.qr.qrscanner',compact('booking1','thongbao','showTime1'));

            } elseif ($booking1->status == 4) {
                $bookings = Booking::orderBy('updated_at', 'desc')->get();
                $showTime = ShowTime::all();
                $movie = Movie::all();
                $rooms = Room::all();
                $thongbao = 'Vé này Đã bị hủy';
                $bookingdetail = BookingDetail::where('booking_id', $booking1->id)->get();



                if (isset($bookingdetail)) {

                    // Extracting food_ids from booking details
                    $foodIds = $bookingdetail->pluck('food_id');

                    // Retrieving food items using the extracted food_ids
                    $foods = MovieFood::whereIn('id', $foodIds)->get();
                }
                return view('admin.qr.index', compact('bookings', 'showTime', 'movie', 'rooms', 'thongbao', 'foods'));
            }
        } else {
            $bookings = Booking::orderBy('updated_at', 'desc')->get();
            $showTime = ShowTime::all();
            $thongbao = 'Thất Bại, không tìm thấy vé đặt';
            return view('admin.qr.qrscanner', compact('bookings', 'thongbao', 'showTime'));
        }



        return redirect()->route('qr.scanner');
    }
    public function checkQr($id)
    {
        $booking = Booking::find($id)->first();
        Redirect()->route('qr.scanner', compact('booking'));
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
    public function inPdf(Request $request)
    {
        $data = [
            'booking_id' => $request->input('booking_id'),
            'name' => $request->input('name'),
            'moviename' => $request->input('moviename'),
            'roomname' => $request->input('roomname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'list_seat' => $request->input('list_seat'),
            'created_at' => $request->input('created_at'),
            'start_date' => $request->input('start_date'),
            'payment' => $request->input('payment'),
            'total' => $request->input('total'),
        ];
        $bookingdetail = BookingDetail::where('booking_id', $data['booking_id'])->get();
        $booking_id =  $data['booking_id'];

        if (isset($bookingdetail)) {

            // Extracting food_ids from booking details
            $foodIds = $bookingdetail->pluck('food_id');

            // Retrieving food items using the extracted food_ids
            $foods = MovieFood::whereIn('id', $foodIds)->get();
        }

        $list_seat = explode(",", $data['list_seat']);
        $number_of_seats = count($list_seat);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->getOptions()->set('isHtml5ParserEnabled', true);


        // Nếu có nhiều ghế, tạo nhiều hóa đơn
        if ($number_of_seats > 1) {
            foreach ($list_seat as $seat) {
                $individual_data = $data; // Tạo một bản sao của dữ liệu để không ảnh hưởng đến các hóa đơn khác nhau
                $seat1 = Seat::all();
                $seat_type = SeatPrice::all();
                // Remove brackets and keep alphanumeric characters only
                $individual_data['list_seat'] = trim($seat, '[]');
                $startDate = date('d/m/Y', strtotime($individual_data['start_date']));
                $screeningTime = date('H:i', strtotime($individual_data['start_date']));

                $pdf->loadHTML(view('admin.qr.bills', compact('seat_type', 'individual_data', 'startDate', 'screeningTime', 'list_seat', 'seat1', 'foods', 'booking_id', 'bookingdetail'))->render());

                // Xuất hóa đơn cho từng ghế
                return   $pdf->stream('bill_seat_' . $individual_data['list_seat'] . '.pdf');
            }
        } else {
            // Nếu chỉ có một ghế, thì xử lý như bình thường
            $startDate = date('d/m/Y', strtotime($data['start_date']));
            $screeningTime = date('H:i', strtotime($data['start_date']));
            $seat1 = Seat::all();
            $seat_type = SeatPrice::all();
            $pdf->loadHTML(view('admin.qr.bill', compact('data', 'startDate', 'screeningTime', 'foods', 'booking_id', 'bookingdetail','seat1','seat_type'))->render());


            // Xuất hóa đơn

            return $pdf->stream();
        }
    }
}
