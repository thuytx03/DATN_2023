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
            text-align: left;
            max-width: 600px; /* Fix max-width for better responsiveness */
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
            margin-top: 20px;
            text-align: center;
        }

        .button:hover {
            background-color: #0056b3;
        }

        /* New styles for borders */
        .border-info {
            border: 1px solid #000;
            border-radius:10px;
            padding: 10px;
            margin: 10px 0;
        }

        .important-info {
            font-weight: bold;
            color: #007BFF;
        }

        .highlight {
            background-color: #e0f3ff;
            padding: 5px;
            border-radius: 3px;
        }

        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #ff0000;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="order-info-box">
        <div class="border-info">
            <p class="order-details important-info">Thông Tin Vé</p>
            <p class="order-details">Xin chào, <span class="important-info">{{ $booking1->name }}</span>! </p>
            <h4 class="important-info highlight">Tên Phim: {{$moviename1->name}}</h4>
            <h4 class="highlight">Thời gian chiếu phim: {{$show_time1->start_date}}</h4>
            <h4 class="highlight">Phòng Chiếu: {{$room1->name}}</h4>
            <h4 class="highlight" >Đồ Ăn:</h4>
           @if ($foods->count() > 0)
            <p>
                @foreach ($foods as $food)
                    {{ $food->name }}{{ $loop->last ? '' : ', ' }}
                @endforeach
            </p>

        @else


                <p>Không có đặt đồ ăn</p>

        @endif

            <h4 class="highlight">Danh Sách Ghế: {!! \Illuminate\Support\Str::limit(str_replace(['"', '[', ']'], '', strip_tags($booking1->list_seat)), 20) !!}</h4>
            <h4 class="highlight">Rạp Chiếu: {{$cinema1->name}}</h4>

            <!-- New line for displaying the total amount -->
            <p class="total-amount highlight">Tổng Tiền: {{$booking1->total}}</p>
        </div>

        <div class="border-info">
            <p class="order-details important-info">Thông Tin Người Nhận</p>
            <h4 class="highlight">Người Đặt: {{$booking1->name}}</h4>
            <h4 class="highlight">Số Điện Thoại: {{$booking1->phone}}</h4>
            <h4 class="highlight">Email: {{$booking1->email}}</h4>
            <p class="button">Mã QR THÔNG TIN VÉ CỦA BẠN Ở TRONG FILE ĐÍNH KÈM, HÃY ĐƯA ẢNH QR NÀY CHO NHÂN VIÊN XUẤT VÉ</p>
        </div>


    </div>
</body>
</html>
