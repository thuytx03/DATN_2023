@extends('layouts.client')
@section('content')
    <style>
        .checkout-widget .payment-option li.active a::after {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            top: -15px;
            right: -15px;
            background: url({{ asset('client/assets/images/payment/check.png') }}) no-repeat center center;
            background-size: cover;
        }

        .checkout-widget.checkout-card .payment-card-form .form-group.check-group label::after {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            top: 7px;
            left: 0;
            background: url(./img/check.png ) no-repeat center center;
            background-size: cover;
            display: none;
        }
    </style>
    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img seat-plan-banner" data-background="./assets/images/banner/banner04.jpg">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content style-two">
                    <h3 class="title">Venus</h3>
                    <div class="tags">
                        <a href="#0">City Walk</a>
                        <a href="#0">English - 2D</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Page-Title========== -->
    <section class="page-title bg-one">
        <div class="container">
            <div class="page-title-area">
                <div class="item md-order-1">
                    <a href="#" class="custom-button back-button" onclick="goBack()">
                        <!-- <i class="flaticon-double-right-arrows-angles"></i> -->
                        << back </a>
                </div>

                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>

                <div class="item date-item">
                    <span class="date">MON, SEP 09 2020</span>
                    <select class="select-bar">
                        <option value="sc1">09:40</option>
                        <option value="sc2">13:45</option>
                        <option value="sc3">15:45</option>
                        <option value="sc4">19:50</option>
                    </select>
                </div>
                <div class="item">
                    <h5 class="title">05:00</h5>
                    <p>Mins Left</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Page-Title========== -->

    <!-- ==========Movie-Section========== -->
    <div class="movie-facility padding-bottom padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-widget checkout-contact">
                        <h5 class="title">Mã giảm giá </h5>
                        <form class="checkout-contact-form">
                            <div class="form-group">
                                <input type="text" placeholder="Nhập mã giảm giá tại đây!">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Nhập" class="custom-button">
                            </div>
                        </form>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                    <form action="{{ route('thanh-toan', ['room_id' => $room->id, 'slug' => $showTime->movie->slug, 'showtime_id' => $showTime->id]) }}" class="" method="post">
                        @csrf
                    <div class="checkout-widget checkout-contact">
                        <h5 class="title">Thông tin liên hệ</h5>

                            <div class="form-group">
                                <input type="text" placeholder="Họ và tên" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Email" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Số điện thoại" name="phone" value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Địa chỉ" name="address" value="{{ old('address') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Ghi chú" name="note" value="{{ old('note') }}">
                            </div>


                    </div>
                    <div class="checkout-widget checkout-card mb-0">
                        <h5 class="title">Phương thức thanh toán </h5>
                        <ul class="payment-option">
                            <li class="active" onclick="selectPayment(1)">
                                <a href="#0">
                                    <img src="{{ asset('client/assets/images/payment/card.png') }}" alt="payment">
                                    <span>VNPay</span>
                                </a>
                                <input type="radio" name="payment" value="1" checked hidden>
                            </li>
                            <li onclick="selectPayment(2)">
                                <a href="#0">
                                    <img src="{{ asset('client/assets/images/payment/card.png') }}" alt="payment">
                                    <span>PayPal</span>
                                </a>
                                <input type="radio" name="payment" value="2" hidden>
                            </li>
                        </ul>

                        <script>
                            function selectPayment(value) {
                                // Lấy danh sách tất cả các phần tử li
                                var paymentOptions = document.querySelectorAll('.payment-option li');

                                // Bỏ chọn tất cả các input radio
                                var paymentRadios = document.querySelectorAll('input[name="payment"]');
                                for (var i = 0; i < paymentRadios.length; i++) {
                                    paymentRadios[i].checked = false;
                                }

                                // Tìm li tương ứng và chọn input radio trong li đó
                                for (var i = 0; i < paymentOptions.length; i++) {
                                    paymentOptions[i].classList.remove('active'); // Loại bỏ class "active" khỏi tất cả các li
                                }
                                paymentOptions[value - 1].classList.add('active'); // Thêm class "active" cho li đã chọn
                                paymentRadios[value - 1].checked = true; // Chọn input radio tương ứng
                            }
                        </script>
                        <p class="notice">
                            Bằng cách nhấp vào "Thanh toán", bạn đồng ý với các <a href="#0">Điều khoản và điều
                                kiện</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="booking-summery bg-one">
                        <h4 class="title">Chi tiết hoá đơn</h4>
                        <ul>
                            <li>
                                <h6 class="subtitle">Phim : {{ $showTime->movie->name }}</h6>
                                {{-- <span class="info">English-2d</span> --}}
                            </li>
                            <li>
                                <h6 class="subtitle"><span>Rạp: {{ $room->cinema->name }}</span></h6>
                            </li>
                             <li>
                                <h6 class="subtitle"><span>Phòng: {{ $room->name }}</span></h6>
                                <div class="info"><span>Ngày chiếu: {{ $showTime->start_date }}</span></div>
                            </li>
                            <li>
                                <h6 class="subtitle"><span>Tổng số ghế</span><span>{{ count(Session::get('selectedSeats', [])) }}</span></h6>
                                <div class="info">
                                    <span>Hàng ghế:
                                        @foreach (Session::get('selectedSeats', []) as $seat)
                                            {{ $seat }}
                                            @if (!$loop->last)
                                                ,
                                            @endif

                                        @endforeach
                                    </span>
                                </div>
                            </li>


                            <li>
                                <h6 class="subtitle mb-0"><span>Tiền vé </span><span>{{ $totalPrice }}</span></h6>
                            </li>
                        </ul>
                        {{-- <ul class="side-shape">
                            <li>
                                <h6 class="subtitle"><span>combos</span><span>$57</span></h6>
                                <span class="info"><span>2 Nachos Combo</span></span>
                            </li>
                            <li>
                                <h6 class="subtitle"><span>food & bevarage</span></h6>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <span class="info"><span>price</span><span>$207</span></span>
                                <span class="info"><span>vat</span><span>$15</span></span>
                            </li>
                        </ul> --}}
                    </div>
                    <div class="proceed-area  text-center">
                        <h6 class="subtitle"><span>Tổng tiền</span><span>$222</span></h6>
                       <input type="hidden" name="">
                        <button type="submit" class="custom-button back-button">Thanh toán</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->
    <script>
        // Lấy danh sách tất cả các phần tử li trong ul.payment-option
        var paymentOptions = document.querySelectorAll('.payment-option li');

        // Lặp qua danh sách và thêm sự kiện click vào mỗi phần tử li
        for (var i = 0; i < paymentOptions.length; i++) {
            paymentOptions[i].addEventListener('click', function() {
                // Loại bỏ class "active" khỏi tất cả các phần tử li
                for (var j = 0; j < paymentOptions.length; j++) {
                    paymentOptions[j].classList.remove('active');
                }

                // Thêm class "active" vào phần tử li hiện tại (đã được nhấp vào)
                this.classList.add('active');
            });
        }
    </script>
@endsection
