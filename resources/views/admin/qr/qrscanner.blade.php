@extends('layouts.admin')
@section('title', 'QRCODE')
@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
@endpush

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
    #preview {
        margin-left: 300px;
        margin-top: 50px;
        width: 40%; /* Adjust the width as needed */
    }
  </style>
  <body>


    @if(isset($thongbao))
    <div class="alert alert-info">
        {{ $thongbao }}
    </div>
@endif
    <video id="preview"></video>

    <form action="{{ route('qr.store') }}" method="POST" id="form">
        @csrf
        <input type="hidden" name="param" id="id" >
    </form>

@if(isset($booking1)) {
    <div class="container mt-4">
        <table class="table table-bordered text-center mx-auto" id="dataTable" style="width: 80%;">
            <thead>
                <tr>
                    <th scope="col">Thông tin khách hàng</th>
                    <th scope="col">Danh sách ghế</th>
                    <th scope="col" >Thời Gian Đặt</th>
                    <th scope="col">Lịch chiếu</th>
                    <th scope="col">Số tiền</th>
                    <th scope="col">PTTT</th>
                </tr>
            </thead>
            <tbody>

                <tr>

                    <td>
                        - Họ và tên:{{ $booking1->name }} <br>
                        - Email:{{ $booking1->email }} <br>
                        - SĐT:{{ $booking1->phone }} <br>
                        - Địa chỉ:{{ $booking1->address }} <br>
                    </td>
                    <td>
                        {!! \Illuminate\Support\Str::limit(strip_tags($booking1->list_seat), 20) !!}
                    </td>
                    <td>
                        {{$booking1->created_at}}

                    </td>
                    <td> @php

                        echo $showTime1 ? $showTime1->start_date : 'N/A';
                    @endphp</td>


                    <td> {{ number_format($booking1->total, 0, ',', '.') }} VNĐ
                    </td>
                    <td>{{ $booking1->payment == 1 ? 'VNPay' : 'Paypal' }}</td>





            </tbody>
        </table>
    </div>
    <div class="container mt-4"> <!-- Thêm container và margin từ trên xuống -->
        <div class="text-center"> <!-- Căn giữa nút -->
            <button type="submit" class="btn btn-primary">In <i class="fa fa-print" aria-hidden="true"></i></button> <!-- Màu xanh và thiết lập kiểu nút -->
        </div>
    </div>

@else
    <div class="container mt-4">
        <table class="table table-bordered text-center mx-auto" id="dataTable" style="width: 80%;">
            <thead>
                <tr>
                    <th scope="col">Thông tin khách hàng</th>
                    <th scope="col">Danh sách ghế</th>
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
