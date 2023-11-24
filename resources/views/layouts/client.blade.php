<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href=" {{asset('client/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('client/assets/css/all.min.css') }}">
    <link rel="stylesheet" href=" {{asset('client/assets/css/animate.css') }}">
    <link rel="stylesheet" href=" {{asset('client/assets/css/flaticon.css')}}">
    <link rel="stylesheet" href=" {{asset('client/assets/css/magnific-popup.css')}}">
    <link rel="stylesheet" href=" {{asset('client/assets/css/odometer.css')}}">
    <link rel="stylesheet" href=" {{asset('client/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('client/assets/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href=" {{asset('client/assets/css/nice-select.css')}}">
    <link rel="stylesheet" href=" {{asset('client/assets/css/jquery.animatedheadline.css')}}">
    <link rel="stylesheet" href="{{asset('client/assets/css/main.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
          integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href=" {{asset('client/assets/images/favicon.png')}}" type="image/x-icon">

    <title>Boleto - Online Ticket Booking Website HTML Template</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body>
<!-- header -->
@include('layouts.client.header')
<!-- end-header -->


@yield('content')


<!-- ==========Newslater-Section========== -->
@include('layouts.client.footer')

<!-- ==========Newslater-Section========== -->


<script src="  {{asset('client/assets/js/jquery-3.3.1.min.js')}}"></script>
<script src=" {{asset('client/assets/js/modernizr-3.6.0.min.js')}}"></script>
<script src=" {{asset('client/assets/js/plugins.js')}}"></script>
<script src=" {{asset('client/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('client/assets/js/heandline.js ')}}"></script>
<script src=" {{asset('client/assets/js/isotope.pkgd.min.js')}}"></script>
<script src=" {{asset('client/assets/js/magnific-popup.min.js')}}"></script>
<script src="{{asset('client/assets/js/owl.carousel.min.js ')}}"></script>
<script src=" {{asset('client/assets/js/wow.min.js')}}"></script>
<script src=" {{asset('client/assets/js/countdown.min.js')}}"></script>
<script src=" {{asset('client/assets/js/odometer.min.js')}}"></script>
<script src=" {{asset('client/assets/js/viewport.jquery.js')}}"></script>
<script src=" {{asset('client/assets/js/nice-select.js')}}"></script>
<script src=" {{asset('client/assets/js/main.js')}}"></script>


@stack('scripts')

</body>

</html>
