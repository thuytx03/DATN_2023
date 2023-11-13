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
            height: 100vh;
        }

        .order-info-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 90%;
            margin: auto;
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

        @media only screen and (min-width: 600px) {
            .order-info-box {
                max-width: 600px;
            }
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

        <button class="button">Mã QR THÔNG TIN VÉ CỦA BẠN Ở TRONG FILE ĐÍNH KÈM, HÃY ĐƯA ẢNH QR NÀY CHO NHÂN VIÊN XUẤT VÉ</button>
    </div>
</body>
</html>
