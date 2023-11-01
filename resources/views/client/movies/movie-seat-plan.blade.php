@extends('layouts.client')
@section('content')
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
                    <a href="movie-ticket-plan.html" class="custom-button back-button">
                        << back </a>
                </div>
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
    <style>
        .seat-type1 {
            margin-right: 10px;
            /* Điều chỉnh khoảng cách giữa các ghế loại 1 trên cùng một hàng */
        }

        /* Điều chỉnh khoảng cách giữa các ghế */
        .seat-area {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: center;
            /* Để căn giữa theo chiều ngang */
            align-items: center;
            /* Để căn giữa theo chiều dọc */
        }

        /* Điều chỉnh khoảng cách giữa các ghế trên cùng một hàng */
        .seat-line {
            display: flex;
            gap: 5px;
        }


        .sit-num {
            text-align: center;
        }

        .not-allowed {
            cursor: not-allowed;
        }
    </style>
    {{-- <input class="form-control" type="text" hidden name="showtime_id" value="{{ $showTime->id }}"> --}}

    <!-- ==========Movie-Section========== -->
    <div class="seat-plan-section padding-bottom padding-top">
        <div class="container">
            <div class="screen-area">
                <h4 class="screen">Màn hình</h4>
                <div class="screen-thumb">
                    <img src="{{ asset('client/assets/images/movie/screen-thumb.png') }}" alt="movie">
                </div>

                <h5 class="subtitle">Ghế thường</h5>
                <div class="screen-wrapper">
                    <ul class="seat-area">
                        @php
                            $currentRow = null;
                        @endphp
                        @foreach ($seatsThuong as $thuong)
                            @php
                                $seatNumber = $thuong->row . $thuong->column;
                                $isBooked = in_array($seatNumber, $bookedSeats);
                            @endphp
                            @if ($currentRow != $thuong->row)
                                @if ($currentRow !== null)
                    </ul>
                    </li>
                    @endif
                    <li class="seat-line">
                        <span>{{ $thuong->row }}</span>
                        <ul class="seat--area">
                            @endif
                            <li class="front-seat">
                                <ul>
                                    <li
                                        class="single-seat seat-type1 {{ $isBooked ? 'not-allowed' : 'single-seat1 seat-click ' }} ">
                                        <img src="{{ $isBooked ?  asset('client/assets/images/movie/seat01-free.png')  :  asset('client/assets/images/movie/seat01.png')}}"
                                            alt="seat">
                                        <span class="sit-num">{{ $thuong->row }}{{ $thuong->column }}</span>

                                    </li>
                                </ul>
                            </li>
                            @php
                                $currentRow = $thuong->row;
                            @endphp
                            @endforeach
                        </ul>
                    </li>
                    </ul>
                </div>

                <h5 class="subtitle">Ghế VIP</h5>
                <div class="screen-wrapper">
                    <ul class="seat-area">
                        @php
                            $currentRow = null;
                        @endphp
                        @foreach ($seatsVip as $vip)
                            @php
                                $seatNumber = $vip->row . $vip->column;
                                $isBooked = in_array($seatNumber, $bookedSeats);
                            @endphp
                            @if ($currentRow != $vip->row)
                                @if ($currentRow !== null)
                    </ul>
                    </li>
                    @endif
                    <li class="seat-line">
                        <span>{{ $vip->row }}</span>
                        <ul class="seat--area">
                            @endif
                            <li class="front-seat">
                                <ul>
                                    <li
                                        class="single-seat seat-type1 {{ $isBooked ? 'not-allowed' : 'single-seat1 seat-click ' }} ">
                                        <img src="{{ $isBooked ? asset('client/assets/images/movie/seat01-free.png')  : asset('client/assets/images/movie/seat01.png') }}"
                                            alt="seat">
                                        <span class="sit-num">{{ $vip->row }}{{ $vip->column }}</span>

                                    </li>
                                </ul>
                            </li>
                            @php
                                $currentRow = $vip->row;
                            @endphp
                            @endforeach
                        </ul>
                    </li>
                    </ul>
                </div>

                <h5 class="subtitle">Ghế đôi</h5>
                <div class="screen-wrapper">
                    <ul class="seat-area">
                        @php
                            $currentRow = null;
                        @endphp
                        @foreach ($seatsDoi as $doi)
                            @php
                                $seatNumber = $doi->row . $doi->column;
                                $isBooked = in_array($seatNumber, $bookedSeats);
                            @endphp
                            @if ($currentRow != $doi->row)
                                @if ($currentRow !== null)
                    </ul>
                    </li>
                    @endif
                    <li class="seat-line">
                        <span>{{ $doi->row }}</span>
                        <ul class="seat--area">
                            @endif
                            <li class="front-seat">
                                <ul>
                                    <li
                                        class="single-seat seat-type1 {{ $isBooked ? 'not-allowed' : 'single-seat1 seat-click ' }} ">
                                        <img src="{{ $isBooked ? asset('client/assets/images/movie/seat01-free.png')  : asset('client/assets/images/movie/seat01.png') }}"
                                            alt="seat">
                                        <span class="sit-num">{{ $doi->row }}{{ $doi->column }}</span>

                                    </li>

                                </ul>
                            </li>
                            @php
                                $currentRow = $doi->row;
                            @endphp
                            @endforeach
                        </ul>
                    </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="proceed-book bg_img" data-background="{{ asset('client/assets/images/movie/movie-bg-proceed.jpg') }}">
            <div class="proceed-to-book">
                <div class="book-item">
                    <span>Số ghế bạn chọn</span>
                    <h3 class="title"></h3>
                </div>
                <div class="book-item">
                    {{-- <a href="{{ route('thanh-toan', ['room_id' => $room->id, 'slug' => $showTime->movie->slug, 'showtime_id' => $showTime->id]) }}"
                            class="custom-button" id="thanh-toan-button">Thanh toán</a> --}}
                    <a href="#" class="custom-button" id="thanh-toan-button">Thanh toán</a>

                </div>
            </div>
        </div>

    </div>
    </div>
    <!-- ==========Movie-Section========== -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Sử dụng jQuery để chọn tất cả các ghế có class 'seat-click'
        const $seats = $('.seat-click');

        // Bắt đầu bằng việc vô hiệu hóa nút thanh toán
        $('#thanh-toan-button').prop('disabled', true);

        // Đặt sự kiện click cho nút thanh toán
        $('#thanh-toan-button').on('click', function(event) {
            // Kiểm tra xem có bất kỳ ghế nào đã được chọn
            const selectedSeats = $seats.filter('.seat-click.selected');
            if (selectedSeats.length === 0) {
                // Nếu không có ghế nào được chọn, hiển thị thông báo và ngừng xử lý sự kiện
                event.preventDefault(); // Ngừng chuyển hướng đến trang thanh toán
                alert('Vui lòng chọn ghế trước khi thanh toán.');
            }
        });

        // Đặt sự kiện click cho tất cả ghế
        $seats.on('click', function() {
            $(this).toggleClass('selected'); // Chuyển trạng thái chọn ghế

            // Kiểm tra xem có bất kỳ ghế nào đã được chọn
            const selectedSeats = $seats.filter('.seat-click.selected');
            if (selectedSeats.length > 0) {
                // Nếu có ghế được chọn, cập nhật thuộc tính href của nút thanh toán
                $('#thanh-toan-button').attr('href',
                    '{{ route('thanh-toan', ['room_id' => $room->id, 'slug' => $showTime->movie->slug, 'showtime_id' => $showTime->id]) }}'
                    );
            } else {
                // Nếu không có ghế nào được chọn, đặt lại thuộc tính href về trống hoặc href="#"
                $('#thanh-toan-button').attr('href', '#');
            }
        });
    </script>

    <script>
        var chosenSeats1 = @json(Session::get('selectedSeats', [])); // Sử dụng một mảng rỗng mặc định nếu session không tồn tại

        document.addEventListener("DOMContentLoaded", function() {
            var seatElements = document.querySelectorAll(".single-seat1");
            // if (!Array.isArray(chosenSeats1)) {
            //     chosenSeats1 = [];
            // }

            // Hàm hiển thị danh sách ghế đã chọn
            function updateChosenSeatsDisplay() {
                var chosenSeats1Text = chosenSeats1.join(", ");
                document.querySelector(".proceed-book .title").textContent = chosenSeats1Text;
            }

            seatElements.forEach(function(seat) {
                seat.addEventListener("click", function() {
                    var seatNum = seat.querySelector(".sit-num").textContent;

                    if (!chosenSeats1.includes(seatNum)) {
                        chosenSeats1.push(seatNum);
                        seat.classList.add("seat-selected");
                    } else {
                        chosenSeats1 = chosenSeats1.filter(function(seat) {
                            return seat !== seatNum;
                        });
                        seat.classList.remove("seat-selected");
                    }

                    // Lưu danh sách ghế đã chọn vào session
                    fetch('/save-selected-seats', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                selectedSeats: chosenSeats1
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data.message);
                            // Sau khi lưu vào session, cập nhật hiển thị danh sách ghế đã chọn
                            updateChosenSeatsDisplay();
                        });
                });
            });

            // Ban đầu, cập nhật hiển thị danh sách ghế đã chọn
            updateChosenSeatsDisplay();
        });
    </script>

    <script>
        var chosenSeats = @json(Session::get('selectedSeats'));

        document.addEventListener("DOMContentLoaded", function() {
            var seatElements = document.querySelectorAll(".seat-click");

            seatElements.forEach(function(seat) {
                var imgElement = seat.querySelector("img");
                var originalImageSrc = imgElement.src;
                var newImageSrc = "{{ asset('client/assets/images/movie/seat01-booked.png') }}";
                var seatNum = seat.querySelector(".sit-num").textContent;

                // Kiểm tra xem ghế có trong danh sách đã chọn hay không và cập nhật trạng thái của ghế
                if (chosenSeats.includes(seatNum)) {
                    imgElement.src = newImageSrc;
                    seat.classList.add("seat-selected");
                }

                seat.addEventListener("click", function() {
                    if (imgElement.src === originalImageSrc) {
                        imgElement.src = newImageSrc;
                        chosenSeats.push(seatNum); // Thêm ghế vào danh sách đã chọn
                        seat.classList.add("seat-selected");
                    } else {
                        imgElement.src = originalImageSrc;
                        chosenSeats = chosenSeats.filter(function(seat) {
                            return seat !== seatNum;
                        });
                        seat.classList.remove("seat-selected");
                    }
                });
            });
        });
    </script>
@endsection
