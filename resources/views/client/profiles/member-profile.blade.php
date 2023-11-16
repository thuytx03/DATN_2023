@extends('client.profiles.layout.temp')

@section('profile')
    <style>
        #progress-container {
            position: relative;
            width: 100%;
            margin-top: 80px; /* Khoảng cách từ thanh tiến trình đến nội dung trên */
        }

        #myProgress {
            width: 100%;
            height: 20px; /* Độ cao của thanh tiến trình */
            background-color: #ddd;
            position: relative;
            overflow: hidden;
            border-radius: 10px; /* Bo tròn các góc của thanh tiến trình */
        }

        #myBar {
            height: 100%;
            background-color: #4CAF50;
            width: {{ $percentSpent }}%;
            border-radius: 10px; /* Bo tròn các góc của thanh tiến trình */
            transition: width 0.5s ease; /* Hiệu ứng chuyển động khi thay đổi width */
        }

        .limit-marker {
    height: 20px;
    width: 2px;
    background-color: #000;
    position: absolute;
    top: 0;
    border-right: 3px dotted #b1154a; /* Sửa giá trị 1px thành 2px để làm nổi bật hơn */
}

        .level-name-container {
            position: absolute;
            bottom: -60px; /* Khoảng cách từ tên đến thanh tiến trình */
            left: 0;
            width: 100%;
            text-align: center; /* Canh giữa nội dung */
            display: flex;
            justify-content: space-between;
        }
        .level-min-controller {
            position: absolute;
            bottom: 30px; /* Khoảng cách từ tên đến thanh tiến trình */
            left: 0;
            width: 100%;
            text-align: center; /* Canh giữa nội dung */
            display: flex;
            justify-content: space-between;
        }
        .level-min {
            z-index: 1;
            display: inline-block;
            background-color: #4CAF50; /* Màu nền của tên (xanh lá cây) */
            padding: 5px 10px; /* Khoảng cách bên trong */
            color: #fff; /* Màu chữ (trắng) */
            border-radius: 5px; /* Bo tròn các góc của tên */
        }

        .level-name {
            z-index: 1;
            display: inline-block;
            background-color: #4CAF50; /* Màu nền của tên (xanh lá cây) */
            padding: 5px 10px; /* Khoảng cách bên trong */
            color: #fff; /* Màu chữ (trắng) */
            border-radius: 5px; /* Bo tròn các góc của tên */
        }

        .limit-marker {
            margin-top: -42px; /* Điều chỉnh margin để thẻ kẻ vạch thẳng hàng */
            height: 20px;
        }
        .highlighted-text::after {
        content: "";
        display: inline-block;
        height: 3px;
        width: 100%;
        background-color: #4CAF50; /* Màu nền bạn muốn làm nổi bật */
    }
    #table-container {
            margin-top: 150px; /* Adjust the margin as needed */
        }

        .table {
            color:  #4CAF50;
            /* Add any additional styling for your table if needed */
        }
    </style>


    <h5 class="mt-2">
        Cấp Độ Hiện Tại Của Bạn :
        <span class="highlighted-text">{{$membershiplv->name}}</span>
    </h5>

    <div id="progress-container">

        <div id="myProgress">
            <div id="myBar"></div>
        </div>
        <div class="level-name-container">
            @foreach ($limits as $limit)

                @php
                    $position = ($limit->min_limit / $highestLimit) * 100;
                @endphp

                <div class="limit-marker" style="left: {{ $position }}%;"></div>
                <div class="level-name" style="left: {{ $position }}%;">{{ $limit->name }}</div>

            @endforeach
        </div>
        <div class="level-min-controller">
            @foreach ($limits as $limit)
                @php
                    $position = ($limit->min_limit / $highestLimit) * 100;
                    $formattedMinLimit = number_format($limit->min_limit / 1000000, 2); // Chia cho 1 triệu và làm tròn đến 2 chữ số thập phân
                @endphp
                <div class="level-min" style="left: {{ $position }}%;">{{ $formattedMinLimit }} triệu</div>
            @endforeach
        </div>
    </div>
    <div id="table-container">
        <table class="table" border="1px">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Mã Số Thẻ</th>
                    <th>Ngày Tạo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $user_name->name }}</td>
                    <td>{{ $member->card_number }}</td>
                    <td>{{ $member->created_at}} </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
