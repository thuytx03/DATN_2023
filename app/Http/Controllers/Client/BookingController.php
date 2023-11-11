<?php

namespace App\Http\Controllers\Client;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\MovieFood;
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
use App\Models\Voucher;
use Illuminate\Support\Facades\Mail;


class BookingController extends Controller
{
    public function index(BookingRequest $request, $room_id, $slug, $showtime_id)
    {
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
                // Lấy giá dựa trên 'seat_type_id' từ bảng 'seat_types'.
                $seatType = SeatType::find($seatInfo->seat_type_id);
                if ($seatType) {
                    // Lưu giá của từng ghế vào mảng $prices.
                    $prices[] = $seatType->price;
                }
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
            $booking->total = $request->total;
            $booking->payment = $request->payment;
            $booking->status = 1;
            $booking->note = $request->note;
            if (Session::has('selectedSeats')) {
                $listSeat = Session::get('selectedSeats', []);
                // dd($listSeat);
                $selectedSeatsJson = json_encode($listSeat);
                // dd($selectedSeatsJson);
                $booking->list_seat = $selectedSeatsJson;
            }
            $booking->total = $request->totalPrice;
            $booking->save();

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



            if ($booking->payment == 1) {
                // Thực hiện thanh toán VNPay
                $result = $this->paymentVNP($booking->id, $booking->total);
            } elseif ($booking->payment == 2) {
                return redirect()->route('paypal.payment', ['id' => $booking->id]);
            }
             // Lấy thông tin mã voucher từ session
            //  $voucherData = session('voucher');
            //  if($voucherData){
            //     $voucher=Voucher::where('code', $voucherData['code'])->first();
            //     if ($voucher->quantity > 0) {
            //         $voucher->quantity--;
            //         $voucher->save();
            //     }
            //  }
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

        if ($request->has('vnp_Amount')) {

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
            $booking = Payment_Vnpay::where('booking_id',$payment->vnp_TxnRef)->first();
            $id = $payment->vnp_TxnRef;
            if ($booking) {
                if ($booking->vnp_ResponseCode == '00') {


                    $qrCode = QrCode::format('png')
                    // ->merge('images/image-not-found.png', 0.5, true)
                    ->size(500)->errorCorrection('H')
                    ->generate('abc/cdf/{$booking1->id}');


                    // $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(500)->generate("abc/cdf/{$booking1->id}");
                    $qrCodeImageBase64 = base64_encode($qrCode);

// Nội dung email
$name = 'Thông tin đơn hàng   ' . '  ' . $request->input('name') . '' . 'đến với boleto';

// Gửi email
Mail::send('admin.qr.mail', compact('name', 'id', 'booking1', 'qrCodeImageBase64'), function ($message) use ($booking1, $qrCodeImageBase64) {
    $message->from('dumpfuck@gmail.com', 'Boleto');
    $message->sender('john@johndoe.com', 'John Doe');
    $message->to($booking1->email, $booking1->name);
    $message->subject('Thông Tin Đơn Hàng');

    // Đính kèm ảnh QR Code từ base64


    // Đặt inline để hiển thị ảnh trực tiếp trong email (tùy chọn)
    $message->embedData(base64_decode($qrCodeImageBase64), 'qrcode.png', 'image/png');
});
                    $booking1->status = 2; // Thành Công
                    $thongbao = 'Cảm ơn bạn đã thanh toán!';
                    $booking->save();

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
            $thongbao = "Bạn Đã Thanh Toán Thành Công";
        }

        $thongbao = $thongbao;
        return view('client.movies.thank', compact('thongbao'));

        // Now you have inserted payment data and updated the booking status based on the payment result
        // You can add further logic as needed
    }
    public function checkStatus()
    {
        try {
            // Replace 'your_table_name' with the actual name of the table
            DB::table('bookings')->where('status', 1)->delete();
            return "Records with status 1 deleted successfully";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    // code của paypal
    public function paypal()
    {
        return view('client.paypal.test');
    }
    public function payment($id)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $booking = Booking::find($id)->first();
        $total = ceil($booking->total / 22000);

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
    public function paymentSuccess(Request $request,$id)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $booking = Booking::find($id); // Tìm đặt phòng dựa trên booking_id

            $total = ceil($booking->total / 22000);
            $add =     payment_paypal::create([
                'booking_id' => $booking->id, // Liên kết thông tin thanh toán với đặt phòng
                'total' => $total,
            ]);
            if ($add) {
                $booking->status = 2; // Thành Công

                $booking->save();
            } else {
                // Payment failed, set status to an appropriate code for failed payments
                $booking->status = 3; // Thất Bại
                if ($booking->status == 3) {
                    $booking->delete(); // Delete the record

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
