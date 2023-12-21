<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use App\Models\Movie;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\MovieFood;
use App\Models\Cinema;
use App\Models\Room;
use App\Models\Seat;
use App\Models\SeatType;
use App\Models\ShowTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Payment_Vnpay;
use App\Models\PayMent_PayPal;
use App\Models\UserVoucher;
use App\Models\Voucher;
use App\Models\VoucherUnlocked;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class BookingController extends Controller
{
    public function index(BookingRequest $request, $room_id, $slug, $showtime_id)
    {
        // session()->forget('voucher');

        $listSeat = Session::get('selectedSeats', []);
        if (empty($listSeat)) {
            toastr()->error('Không thể vào trang thanh toán khi bạn chưa chọn ghế!');
            return redirect()->route('index');
        }

        $this->checkStatus();
        $room = Room::where('id', $room_id)->first();
        $showTime = ShowTime::find($showtime_id);
        // dd(Session::get('selectedSeats', []));

        $totalPrice = 0;
        // Tạo một mảng để lưu giá của từng ghế.
        $prices = [];
        foreach (Session::get('selectedSeats', []) as $seat) {

            // Tách hàng và cột từ chuỗi ghế (ví dụ: "J6" -> hàng "J", cột "6").
            $row = substr($seat, 0, 1); // Lấy ký tự đầu tiên
            $column = substr($seat, 1);

            // Lấy thông tin của ghế từ bảng 'seats'.
            $seatInfo = Seat::where('row', $row)
                ->where('column', $column)
                ->first();

            if ($seatInfo) {
                // Lưu giá của từng ghế vào mảng $prices.
                $prices[] = $seatInfo->seatType->seatPrice->where('showtime_id', $showtime_id)->first()->price;
            }
        }

        // Tính tổng giá của tất cả các ghế.
        $totalPriceTicket = array_sum($prices);

        // dd($totalPriceTicket);

        if ($request->isMethod('POST')) {

            $booking = new Booking();
            $booking->user_id = auth()->user()->id;
            $booking->showtime_id = $showTime->id;
            $booking->name = $request->name;
            $booking->email = $request->email;
            $booking->phone = $request->phone;
            $booking->address = $request->address;
            $booking->price_ticket = $totalPriceTicket;
            $booking->price_food = $request->totalPriceFood;
            // $booking->total = $request->total;
            $booking->payment = $request->payment;
            $booking->status = 1;
            $booking->note = $request->note;

            if (Session::has('selectedSeats')) {
                $listSeat = Session::get('selectedSeats', []);
                // dd($listSeat);
                $selectedSeatsJson = json_encode($listSeat);
                // dd($selectedSeatsJson);
                $existingSeats = Booking::where('showtime_id', $showtime_id)
                    ->where('list_seat', $selectedSeatsJson)
                    ->where('status', '!=', 4)
                    ->exists();
                if ($existingSeats) {
                    toastr()->error('Ghế đã được đặt bởi người khác!');
                    return redirect()->back();
                }
                $booking->list_seat = $selectedSeatsJson;
            }
            if (empty($listSeat)) {
                toastr()->error('Không thể trang thanh toán khi bạn chưa chọn ghế!');
                return redirect()->back();
            }
            $booking->total = $request->totalPrice;
            $booking->save();
            if ($showTime->movie) {
                $movie = $showTime->movie;
                $movie->view += 1;
                $movie->save();
                // Lấy ngày đặt vé
                $bookingDate = now()->format('Y-m-d');

                // Tăng số lượng lượt xem cho ngày đó hoặc tạo mới nếu chưa có
                $movie->views()->updateOrCreate(
                    ['date' => $bookingDate],
                    ['count' => DB::raw('count + 1')]
                );
            }
            if (session()->has('selectedProducts')) {
                foreach (session('selectedProducts') as $food) {
                    $bookingDetail = new BookingDetail();
                    $bookingDetail->booking_id = $booking->id;
                    $bookingDetail->food_id = $food['id'];
                    $bookingDetail->quantity = $food['quantity'];
                    $bookingDetail->price = $food['price'];
                    $bookingDetail->save();
                }
            }
            // Lấy thông tin mã voucher từ session
            $voucherInfo = Session::get('voucher');
            if ($voucherInfo) {
                $voucher = Voucher::where('code', $voucherInfo['code'])->first();
                $voucher->quantity--;
                $voucher->save();

                $userUnlocked=VoucherUnlocked::where('user_id',auth()->id())->where('voucher_id',$voucher->id)->first();
                if ($userUnlocked && $userUnlocked->status == 0) {
                    $userUnlocked->status = 1;
                    $userUnlocked->unlocked = false;
                    $userUnlocked->save();
                }

                UserVoucher::create([
                    'user_id' => auth()->id(),
                    'voucher_id' => $voucher->id,
                ]);
            }

            if ($booking->payment == 1) {
                // Thực hiện thanh toán VNPay
                $result = $this->paymentVNP($booking->id, $booking->total);
            } elseif ($booking->payment == 2) {

                return redirect()->route('paypal.payment', ['id' => $booking->id]);
            }

            session()->forget('voucher');
            session()->forget('selectedSeats');
            session()->forget('selectedProducts');
            session()->forget('totalPriceFood');

            toastr()->success('Đặt vé thành công');
        }

        return view('client.movies.movie-checkout', compact('showTime', 'room', 'totalPriceTicket'));
    }


    // thanh toán VNPAY
    public function paymentVNP($bookingId, $total)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/camon";
        $vnp_TmnCode = "KX6PXWV0"; // Mã website tại VNPAY
        $vnp_HashSecret = "LDTFIBSAGQRVLQLNQZCNZHMGVRCAKMOC"; // Chuỗi bí mật
        $vnp_TxnRef = $bookingId; // Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh Toán Đơn Hàng Test';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        // echo "111";
        // die("122");
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
        // die("222");
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }
    public function thanks(Request $request)
    {


        session()->forget('voucher');
        session()->forget('selectedSeats');
        session()->forget('selectedProducts');
        session()->forget('totalPriceFood');

        if ($request->query('vnp_Amount')) {

            $vnp_Amount = $request->query('vnp_Amount');
            $vnp_BankCode = $request->query('vnp_BankCode');
            $vnp_BankTranNo = $request->query('vnp_BankTranNo');
            $vnp_CardType = $request->query('vnp_CardType');
            $vnp_OrderInfo = urldecode($request->query('vnp_OrderInfo'));
            $vnp_PayDate = $request->query('vnp_PayDate');
            $vnp_ResponseCode = $request->query('vnp_ResponseCode');
            $vnp_TmnCode = $request->query('vnp_TmnCode');
            $vnp_TransactionNo = $request->query('vnp_TransactionNo');
            $vnp_TransactionStatus = $request->query('vnp_TransactionStatus');
            $vnp_TxnRef = $request->query('vnp_TxnRef');
            $vnp_SecureHash = $request->query('vnp_SecureHash');

            // Insert payment data into payment_vnpay table
            $payment = new Payment_Vnpay();
            $payment->booking_id = $vnp_TxnRef; // Use the booking_id
            $payment->vnp_TxnRef = $vnp_TxnRef;
            $payment->vnp_Amount = $vnp_Amount;
            $payment->vnp_BankCode = $vnp_BankCode;
            $payment->vnp_BankTranNo = $vnp_BankTranNo;
            $payment->vnp_CardType = $vnp_CardType;
            $payment->vnp_OrderInfo = $vnp_OrderInfo;
            $payment->vnp_PayDate = $vnp_PayDate;
            $payment->vnp_ResponseCode = $vnp_ResponseCode;
            $payment->vnp_TmnCode = $vnp_TmnCode;
            $payment->vnp_TransactionNo = $vnp_TransactionNo;
            $payment->vnp_TransactionStatus = $vnp_TransactionStatus;
            $payment->vnp_SecureHash = $vnp_SecureHash;

            // Add more fields to store, such as vnp_BankCode, vnp_ResponseCode, etc.
            $payment->save();


            // Update the booking status
            $booking1 = Booking::find($payment->booking_id);
            $booking = Payment_Vnpay::where('booking_id', $payment->vnp_TxnRef)->first();


            if ($booking) {
                if ($booking->vnp_ResponseCode == '00') {
                    // Tạo mã QR
                    $qrCode = QrCode::create("/qrtiketinfo/$booking1->id")
                        ->setSize(200);

                    // Kiểm tra và tạo thư mục nếu nó không tồn tại
                    if (!file_exists(public_path('qrcodes'))) {
                        mkdir(public_path('qrcodes'), 0777, true);
                    }

                    // Tạo và lưu mã QR như một tệp hình ảnh
                    $writer = new PngWriter();
                    $result = $writer->write($qrCode);
                    $qrcodePath = 'qrcodes/' . $booking1->id . '.png';
                    $result->saveToFile(public_path($qrcodePath));

                    // Đọc tệp hình ảnh và mã hóa nó thành base64
                    $qrcodeBase64 = base64_encode(file_get_contents(public_path($qrcodePath)));

                    // Nội dung email
                    $name = 'Thông tin đơn hàng ' . $request->input('name') . ' đến với boleto';
                    $show_time1 = ShowTime::find($booking1->showtime_id);

                    $moviename1 = Movie::find($show_time1->movie_id);

                    $bookingDetail1 = BookingDetail::where('booking_id', $booking1->id)->get();



                    if (isset($bookingDetail1)) {
                        // Extracting food_ids from booking details
                        $foodIds = $bookingDetail1->pluck('food_id');

                        // Retrieving food items using the extracted food_ids
                        $foods = MovieFood::whereIn('id', $foodIds)->get();
                    }

                    $room1 = Room::find($show_time1->room_id);
                    $cinema1 = Cinema::where('id', $room1->cinema_id)->first();
                    // Gửi email
                    Mail::send('admin.qr.mail', compact('name', 'booking1', 'qrcodeBase64', 'moviename1', 'room1', 'foods', 'cinema1', 'show_time1'), function ($message) use ($booking1, $qrcodePath) {
                        $message->from('anhandepgiai22@gmail.com', 'BoleTo');
                        $message->to($booking1->email, $booking1->name);
                        $message->subject('Thông Tin Đơn Hàng');

                        // Gắn thêm ảnh QR Code vào file đi kèm
                        $message->attach(public_path($qrcodePath));
                    });

                    // Xóa tệp hình ảnh tạm thời
                    unlink(public_path($qrcodePath));
                    // Đánh dấu đơn hàng là Thành Công
                    $booking1->status = 2;
                    $booking1->save();

                    $cacheKey = 'selected_seats_' . auth()->id() . '_showtime_' . $booking1->showtime_id;
                    Redis::del($cacheKey);
                    $thongbao = 'Cảm ơn bạn đã thanh toán!';
                } else {
                    // Payment failed, set status to an appropriate code for failed payments
                    $booking->status = 4; // Thất Bại
                    if ($booking->status == 4) {
                        $booking->delete(); // Delete the record
                        $thongbao = 'Thanh Toán Thất Bại';
                    }
                }
            }
        } else {
            $thongbao = 'Cảm ơn bạn đã thanh toán!';
        }


        $thongbao = $thongbao;
        return view('client.movies.thank', compact('thongbao'));

        // Now you have inserted payment data and updated the booking status based on the payment result
        // You can add further logic as needed
    }

    public function checkStatus()
    {
        try {
            // Delete bookings with status 1
            DB::table('bookings')->where('status', 1)->delete();

            // Get all bookings
            $bookings = DB::table('bookings')->get();
            if (isset($bookings)) {
                // Loop through each booking
                foreach ($bookings as $booking) {
                    if (isset($booking)) {
                        // Check if the movie time has ended for this booking
                        $show_time = DB::table('show_times')->where('id', $booking->showtime_id)->first();
                        if ($booking->status == 5 && $booking->hasUpdated == 0) {
                            DB::table('bookings')->where('id', $booking->id)->update(['status' => 6]);
                        }

                        // Replace 'your_condition' with the actual condition to check if the movie time has ended
                    }
                }
            }

            return "Records updated successfully";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }




    public function checkStatus2($id)
    {

        $bookings = Booking::where('user_id', $id)->get();

        if (isset($bookings)) {
            foreach ($bookings as $booking) {

                if (isset($booking)) {
                    $show_time = DB::table('show_times')->where('id', $booking->showtime_id)->first();
                    // Kiểm tra nếu không có dữ liệu

                    if (!$show_time) {
                        continue;
                    } elseif (strtotime($show_time->end_date) < time()) {

                        if ($booking->status == 2 && $booking->hasUpdated == 0) {
                            DB::table('bookings')->where('id', $booking->id)->update(['status' => 5]);
                        }
                    }
                    // Replace 'your_condition' with the actual condition to check if the movie time has ended

                }
            }
        }
    }






    // code của paypal
    public function paypal()
    {
        return view('client.paypal.test');
    }
    public function payment($id)
    {
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $booking = Booking::find($id);

        $total = round($booking->total / 24279, 2);


        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success', ['id' => $id]),
                "cancel_url" => route('paypal.payment/cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "$total"
                    ]
                ]
            ]
        ]);


        if (isset($response['id']) && $response['id'] != null) {

            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('cancel.payment')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('create.payment')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentCancel()
    {
        return redirect()
            ->route('paypal')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentSuccess(Request $request, $id)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $booking1 = Booking::find($id); // Tìm đặt phòng dựa trên booking_id

            $cacheKey = 'selected_seats_' . auth()->id() . '_showtime_' . $booking1->showtime_id;
            Redis::del($cacheKey);
            $total = ceil($booking1->total / 22000);
            $add =     payment_paypal::create([
                'booking_id' => $booking1->id, // Liên kết thông tin thanh toán với đặt phòng
                'total' => $total,
            ]);
            if ($add) {


                // Tạo mã QR
                $qrCode = QrCode::create("/qrtiketinfo/$booking1->id")
                    ->setSize(200);

                // Kiểm tra và tạo thư mục nếu nó không tồn tại
                if (!file_exists(public_path('qrcodes'))) {
                    mkdir(public_path('qrcodes'), 0777, true);
                }

                // Tạo và lưu mã QR như một tệp hình ảnh
                $writer = new PngWriter();
                $result = $writer->write($qrCode);
                $qrcodePath = 'qrcodes/' . $booking1->id . '.png';
                $result->saveToFile(public_path($qrcodePath));

                // Đọc tệp hình ảnh và mã hóa nó thành base64
                $qrcodeBase64 = base64_encode(file_get_contents(public_path($qrcodePath)));

                // Nội dung email
                $name = 'Thông tin đơn hàng ' . $request->input('name') . ' đến với boleto';
                $show_time1 = ShowTime::find($booking1->showtime_id);

                $moviename1 = Movie::find($show_time1->movie_id);

                $bookingDetail1 = BookingDetail::where('booking_id', $booking1->id)->get();



                if (isset($bookingDetail1)) {
                    // Extracting food_ids from booking details
                    $foodIds = $bookingDetail1->pluck('food_id');

                    // Retrieving food items using the extracted food_ids
                    $foods = MovieFood::whereIn('id', $foodIds)->get();
                }

                $room1 = Room::find($show_time1->room_id);
                $cinema1 = Cinema::where('id', $room1->cinema_id)->first();
                // Gửi email
                Mail::send('admin.qr.mail', compact('name', 'booking1', 'qrcodeBase64', 'moviename1', 'room1', 'foods', 'cinema1', 'show_time1'), function ($message) use ($booking1, $qrcodePath) {
                    $message->from('anhandepgiai22@gmail.com', 'BoleTo');
                    $message->to($booking1->email, $booking1->name);
                    $message->subject('Thông Tin Đơn Hàng');

                    // Gắn thêm ảnh QR Code vào file đi kèm
                    $message->attach(public_path($qrcodePath));
                });

                // Xóa tệp hình ảnh tạm thời
                unlink(public_path($qrcodePath));
                // Đánh dấu đơn hàng là Thành Công
                $booking1->status = 2;
                $booking1->save();
            } else {
                // Payment failed, set status to an appropriate code for failed payments
                $booking1->status = 3; // Thất Bại
                if ($booking1->status == 3) {
                    $booking1->delete(); // Delete the record

                }
            }
            // code mac dinh cua paypal

            return redirect()
                ->route('camonthanhtoan')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('camonthanhtoan')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function ticketFood(Request $request)
    {
        $food = MovieFood::all();

        return view('client.movies.movie-ticket-food', compact('food'));
    }
}
