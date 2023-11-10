@extends('layouts.client')
@section('content')
<html>
<head>
    <title>Cảm ơn bạn đã thanh toán!</title>
    <style>
        /* CSS để căn giữa nội dung và làm cho nó trở nên responsive */
        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 80vh;
            margin: 0;
        }

        h1 {
            padding-bottom: 40px;
        }

        /* Đảm bảo rằng ảnh QR code là responsive */
        .qr-code {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="content">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1>{{$thongbao}}</h1>
        <p>Thanh toán của bạn đã được xác nhận, Kiểm Tra thông tin hóa đơn qua email của bạn</p>
        <?php $qrCodeUrl = route('qr.redirect', ['param' => "generate-barcode/{$id}"]); ?> 
        <div class="d-flex justify-content-center mb-4" style="margin-top: 30px;">
            {!! DNS2D::getBarcodeHTML($qrCodeUrl, 'QRCODE', 4, 4, '#0077cc', true) !!}
        </div>
    </div>
</body>
</html>
@endsection