@extends('layouts.admin')
@section('title', 'QRCODE')
@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
@endpush
<style>

    #preview {
        width: 100%;
        max-width: 600px;
    }
    .sanner {
        position: absolute;
        border: 3px solid #00ff00; /* Màu của đường scan */
        box-sizing: border-box;
        pointer-events: none;
    }
</style>

@section('content')
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Code Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <style>
  /* body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background: #000;
} */

#preview {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1; /* This will ensure the video is always on top */
}

.scanner {
    position: relative;
    height: 400px;
    width: 400px;
    margin-left: 300px;
    border-radius: 20px;
    border: solid 1px white; /* Change the border color to white */
    background-color: blue; /* Change the background color to turquoise */
    overflow: hidden; /* This will keep the scanning line within the scanner box */
}

.scanner::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 10px;
    width: 100%;
    background: rgba(0, 255, 0, 0.6);
    animation: scan 1s linear infinite;
    z-index: 2; /* This will ensure the scanning line is always on top of the video */
}

@keyframes scan {
    0% { top: 0; }
    100% { top: 100%; }
}

  </style>
  <body>


    @if(isset($thongbao))
    <div class="alert alert-info">
        {{ $thongbao }}
    </div>
@endif
<div class="scanner">
    <video id="preview"></video>
</div>
    <form action="{{ route('qr.store') }}" method="POST" id="form">
        @csrf
        <input type="hidden" name="param" id="id" >
    </form>

@if(isset($bookings)) {

    <div class="container mt-4">
        <table class="table table-bordered text-center mx-auto" id="dataTable" style="width: 80%;">
            <thead>
                <tr>
                    <th scope="col">Thông tin khách hàng</th>
                    <th scope="col"> Tên Phim</th>
                    <th scope="col">Ca Chiếu</th>
                    <th scope="col">Phòng Chiếu</th>
                    <th scope="col">Thời Gian Đặt</th>
                    <th scope="col">Lịch chiếu</th>
                    <th scope="col">Số tiền</th>
                    <th scope="col">PTTT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $value)
                @if($value->status == 3)
                <tr>

                    <td>
                        - Họ và tên:{{ $value->name }} <br>
                        - Email:{{ $value->email }} <br>
                        - SĐT:{{ $value->phone }} <br>
                        - Địa chỉ:{{ $value->address }} <br>
                    </td>
                    @php
    $showtime1 = $showTime->where('id', $value->showtime_id)->first();
    $movie1 = $showtime1 ? $movie->where('id', $showtime1->movie_id)->first() : null;
    $room1 = $showtime1 ? $rooms->where('id', $showtime1->room_id)->first() : null;
@endphp

<td>{{ $movie1 ? $movie1->name : '' }}</td>
<td>{{ $room1 ? $room1->name : '' }}</td>
                    <td>
                        {!! \Illuminate\Support\Str::limit(strip_tags($value->list_seat), 20) !!}
                    </td>

                    <td>{{$value->created_at}}</td>
                    <td>
                        @php
                            $showTime1 = $showTime->firstWhere('id', $value->showtime_id);
                            echo $showTime1 ? $showTime1->start_date : 'N/A';
                        @endphp
                    </td>



                    <td> {{ number_format($value->total, 0, ',', '.') }} VNĐ
                    </td>
                    <td>{{ $value->payment == 1 ? 'VNPay' : 'Paypal' }}</td>


@endif
                @endforeach

            </tbody>
        </table>
    </div>
@endif
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>



   <script type="text/javascript">
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        scanner.addListener('scan', function (content) {
            console.log(content);
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });

        scanner.addListener('scan', function(c) {
            document.getElementById('id').value = c;
            document.getElementById('form').submit();
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
@endsection
