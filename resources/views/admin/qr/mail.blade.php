<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .order-info-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .order-heading {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .order-details {
            font-size: 18px;
        }

        .button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="order-info-box">
        <h1 class="order-heading">Thông tin đơn hàng của bạn</h1>
        <p class="order-details">Xin chào, {{ $name }}! Dưới đây là thông tin chi tiết về đơn hàng của bạn.</p>
        <p>- Họ và tên: {{ $booking1->name }} <br>
           - Email: {{ $booking1->email }} <br>
           - SĐT: {{ $booking1->phone }} <br>
           - Địa chỉ: {{ $booking1->address }} <br>
        </p>
        <p>Thời Gian Đặt {{ $booking1->created_at }}</p>
        <p>Danh Sách Ghế {!! \Illuminate\Support\Str::limit(strip_tags($booking1->list_seat), 20) !!} </p>

        <div class="card">
            <div class="card-body">
                <h1>Đây là mã QR của bạn</h1>
                <img src="data:image/png;base64, {!! $qrCodeImage !!}" alt="Mã QR">
            </div>
        </div>




        <button class="button">Xem chi tiết đơn hàng</button>
    </div>
</body>
</html>
