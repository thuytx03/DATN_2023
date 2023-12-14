<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoleTo Ticket</title>
    <style>
        body {
            font-family: DejaVu Sans;
            color: #000;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .ticket {
            background-color: #fff;
            margin: 50px auto;
            width: 80%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .ticket h1 {
            text-align: center;
            color: #333;
        }
        .ticket p {
            margin-bottom: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    @if ($foods->count() > 0)
    <div class="ticket">
        <h1>BoleTo Ticket Foods</h1>
        <p><strong>Danh sách món ăn :</strong><br>
            @foreach ($foods as $food)
                {{ $food->name }}:

                {{-- Retrieve the bookingdetail for the current food --}}
                @php
                    $currentBookingDetail = $bookingdetail->where('food_id', $food->id)->first();
                @endphp

                {{-- Check if the bookingdetail exists --}}
                @if ($currentBookingDetail)
                    {{ $currentBookingDetail->quantity }} phần
                @else
                    0 phần {{-- Or any default value --}}
                @endif

                @unless ($loop->last)
                    <br>
                @endunless
            @endforeach
        </p>
    </div>
@else
    {{-- Hiển thị thông báo khi không có đồ ăn --}}
@endif
</div>
    <div class="ticket">
        <h1>BoleTo Ticket</h1>
        <p><strong>Tên khách hàng:</strong> {{ $data['name'] }}</p>
        <p><strong>Tên phim:</strong> {{ $data['moviename'] }}</p>
        <p><strong>Tên phòng:</strong> {{ $data['roomname'] }}</p>
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
        <p><strong>Số điện thoại:</strong> {{ $data['phone'] }}</p>
        <p><strong>Ngày tạo:</strong> {{ $data['created_at'] }}</p>
        <p><strong>Ngày chiếu:</strong> {{ $startDate }}</p>
        <p><strong>Suất chiếu:</strong> {{ $screeningTime }}</p>
        <p><strong>Ghế:</strong> {{ str_replace(['[', ']', '"'], '', $data['list_seat']) }}</p>
        <p><strong>Giá Vé:</strong> {{ $data['total'] }}</p>
    </div>
</body>
</html>
