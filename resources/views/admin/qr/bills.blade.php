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
            page-break-inside: avoid; /* Avoid page break inside the .ticket div */
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
    @foreach ($list_seat as $seat)
    <div class="ticket">
        <h1>BoleTo Ticket</h1>
        <p><strong>Tên khách hàng:</strong> {{ $individual_data['name'] }}</p>
        <p><strong>Tên phim:</strong> {{ $individual_data['moviename'] }}</p>
        <p><strong>Tên phòng:</strong> {{ $individual_data['roomname'] }}</p>
        <p><strong>Email:</strong> {{ $individual_data['email'] }}</p>
        <p><strong>Số điện thoại:</strong> {{ $individual_data['phone'] }}</p>
        <p><strong>Ngày tạo:</strong> {{ $individual_data['created_at'] }}</p>
        <p><strong>Ngày chiếu:</strong> {{ date('d/m/Y', strtotime($individual_data['start_date'])) }}</p>
        <p><strong>Suất chiếu:</strong> {{ date('H:i', strtotime($individual_data['start_date'])) }}</p>
        @php
        $ghe = trim(str_replace(['[', ']', '"'], '', $seat));

// Tách chuỗi thành mảng các ký tự
$characters = str_split($seat);

// Lọc các ký tự là chữ cái
$horizontalValue = implode('', array_filter($characters, 'ctype_alpha'));

// Lọc các ký tự là số
$verticalValue = implode('', array_filter($characters, 'ctype_digit'));

// In ra kết quả
$seats = $seat1->where('row', $horizontalValue)
              ->where('column', $verticalValue)
              ->first();
$price = $seat_type->where('id',$seats->seat_type_id)
                    ->first();




    @endphp
        <!-- Sử dụng str_replace để loại bỏ dấu [] và dấu "" từ giá trị ghế -->
        <p><strong>Ghế:</strong> {{  $ghe }}</p>

        <p><strong>Giá Vé</strong> {{ $price->price }}</p>
    </div>
@endforeach

</body>
</html>



