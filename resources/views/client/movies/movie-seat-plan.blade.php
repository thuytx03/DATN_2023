@extends('layouts.client')
@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img seat-plan-banner"
        data-background="{{ asset('client/assets/images/banner/banner04.jpg') }}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content style-two">
                    <h3 class="title">{{ $showTime->movie->name }}</h3>
                    <div class="tags">
                        <a href="#0">Rạp: {{ $showTime->room->cinema->name }}</a>
                        <a href="#0">Phòng: {{ $showTime->room->name }}</a>
                        <a href="#0">Thời gian: {{ date('H:i', strtotime($showTime->start_date)) }} ~
                            {{ date('H:i', strtotime($showTime->start_end)) }}</a>

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
                    <a href="{{ route('lich-chieu', ['id' => $showTime->movie->id, 'slug' => $showTime->movie->slug]) }}"
                        class="custom-button back-button">
                        Quay lại </a>
                </div>
                <div class="item text-white ">
                    <div class="tags ">
                        <a href="#0" class="text-white">Rạp: {{ $showTime->room->cinema->name }}</a> -
                        <a href="#0" class="text-white">Phòng: {{ $showTime->room->name }}</a> -
                        <a href="#0" class="text-white">Thời gian: {{ date('H:i', strtotime($showTime->start_date)) }}
                            ~ {{ date('H:i', strtotime($showTime->start_end)) }}</a>
                        <a href="#" style="display:none" id="showtime-link"
                            data-showtime-id="{{ $showTime->id }}">{{ $showTime->id }}</a>

                    </div>
                </div>
                <div class="item">
                    <h5 class="title" id="countdown"></h5>
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

        .modal-dialog {
            max-width: 800px;
        }

        .modal-content {
            height: 600px;
        }

        .quantity-input {
            display: flex;
            align-items: center;
            color: black;
        }

        .quantity-input button {
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            color: black;
        }

        .quantity-input input {
            text-align: center;
            width: 50px;
            color: black;

        }
    </style>


    <!-- ==========Movie-Section========== -->
    <div class="seat-plan-section padding-bottom padding-top">
        <div class="container">
            <div class="screen-area">
                <h4 class="screen">Màn hình</h4>
                <div class="screen-thumb">
                    <img src="{{ asset('client/assets/images/movie/screen-thumb.png') }}" alt="movie">
                </div>


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
                                <input type="hidden" value="{{ $isBooked ? 0 : $thuong->seatType->price }}"
                                    name="seatThuong">

                                <ul>

                                    <li class="single-seat seat-type1 {{ $isBooked ? 'not-allowed' : 'single-seat1 seat-click ' }} "
                                        id="seat-{{ $thuong->row }}{{ $thuong->column }}">
                                        <img src="{{ $isBooked ? asset('client/assets/images/movie/seatDaChon.png') : asset('client/assets/images/movie/seatThuong.png') }}"
                                            width="64" alt="seat" class="{{ $isBooked ? 'not-allowed' : 'thuy' }}">
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
                                <input type="hidden" value="{{ $isBooked ? 0 : $vip->seatType->price }}" name="seatVip">
                                <ul>


                                    <li class="single-seat seat-type1 {{ $isBooked ? 'not-allowed' : 'single-seat1 seat-click ' }} "
                                        id="seat-{{ $vip->row }}{{ $vip->column }}">
                                        <img src="{{ $isBooked ? asset('client/assets/images/movie/seatDaChon.png') : asset('client/assets/images/movie/seatVip.png') }}"
                                            width="64" alt="seat" class="{{ $isBooked ? 'not-allowed' : 'thuy' }}">
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
                                <input type="hidden" value="{{ $isBooked ? 0 : $doi->seatType->price }}" name="seatDoi">

                                <ul class="ul-price">
                                    <li id="seat-{{ $doi->row }}{{ $doi->column }}"
                                        class="single-seat seat-type1  {{ $isBooked ? 'not-allowed' : 'single-seat1 seat-click seat ' }} ">
                                        <img src="{{ $isBooked ? asset('client/assets/images/movie/seatDaChon.png') : asset('client/assets/images/movie/seatDoi.png') }}"
                                            width="64" alt="seat"
                                            class="{{ $isBooked ? 'not-allowed' : ' thuy seat ' }}" id="thuy-img"
                                            data-seat="{{ $doi->row }}{{ $doi->column }}">
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


            <div class="row text-center ">
                <div class="status mx-auto d-flex">
                    <ul class="m-2">
                        <li><img src="{{ asset('client/assets/images/movie/seatDangGiu.png') }}" width="64"
                                alt=""></li>
                        <li>Đang giữ ghế</li>
                    </ul>
                    <ul class="m-2">
                        <li><img src="{{ asset('client/assets/images/movie/seatDangChon.png') }}" alt=""></li>
                        <li>Đang chọn</li>
                    </ul>
                    <ul class="m-2">
                        <li><img src="{{ asset('client/assets/images/movie/seatDaChon.png') }}" width="64"
                                alt=""></li>
                        <li>Đã chọn</li>
                    </ul>
                    <ul class="m-2">
                        <li><img src="{{ asset('client/assets/images/movie/seatThuong.png') }}" width="64"
                                alt=""></li>
                        <li>Ghế thường</li>
                    </ul>
                    <ul class="m-2">
                        <li><img src="{{ asset('client/assets/images/movie/seatVip.png') }}" width="64"
                                alt="">
                        </li>
                        <li>Ghế Vip</li>
                    </ul>
                    <ul class="m-2">
                        <li><img src="{{ asset('client/assets/images/movie/seatDoi.png') }}" width="64"
                                alt=""></li>
                        <li>Ghế Đôi</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="proceed-book bg_img mb-3"
            data-background="{{ asset('client/assets/images/movie/movie-bg-proceed.jpg') }}">
            <div class="proceed-to-book">
                <div class="book-item">
                    <span>Số ghế bạn chọn</span>
                    <h3 class="title"></h3>
                </div>

                <div class="book-item ">
                    <span>Tổng tiền</span>
                    <h3 class="total-price"></h3>
                </div>


                <div class="book-item">
                    <a href="#" class="custom-button " id="thanh-toan-button">Tiếp tục</a>
                </div>
            </div>
        </div>
    </div>
    {{-- @if (count($selectedSeats) > 0)
        <ul>
            @foreach ($selectedSeats as $seat)
                <li>{{ $seat }}</li>
            @endforeach
        </ul>
    @else
        <p>No seats selected.</p>
    @endif --}}
    <!-- ==========Movie-Section========== -->

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/app.js"></script>


    <!-- Trong view A -->
    <script>
        const baseUrl = 'http://127.0.0.1:8000';
        window.csrfToken = "{{ csrf_token() }}";

        // Kiểm tra xem đã lưu trạng thái thời gian vào localStorage chưa
        const savedTimeExpired = window.localStorage.getItem('timeExpired');
        let targetTime;

        // Tạo thời gian mục tiêu (target time) chỉ khi cần
        if (!savedTimeExpired) {
            targetTime = new Date();
            targetTime.setMinutes(targetTime.getMinutes() + 1);
            window.localStorage.setItem('targetTime', targetTime.getTime());
        } else {
            // Nếu đã lưu, khôi phục thời gian từ localStorage
            const savedTargetTime = window.localStorage.getItem('targetTime');
            targetTime = new Date(parseInt(savedTargetTime));
        }

        function updateCountdown() {
            const currentTime = new Date();
            const timeDifference = targetTime - currentTime;

            const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

            const countdownElement = document.getElementById("countdown");
            countdownElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            if (timeDifference <= 0) {
                countdownElement.textContent = "00:00";
                clearSeatsCache(); // Gọi hàm khi đếm ngược đạt 0
            } else {
                requestAnimationFrame(updateCountdown);
            }
        }

        function clearSeatsCache() {
            axios.post(`${baseUrl}/clear-seats-cache`, {}, {
                    headers: {
                        'X-CSRF-TOKEN': window.csrfToken
                    }
                })
                .then(response => {
                    // Hiển thị thông báo thành công
                    window.alert('Bạn đã hết thời gian chọn ghế!!!');
                    window.location.href = 'path-to-view-a';
                    window.location.reload();
                    // Bạn cũng có thể tùy chỉnh thông báo hoặc sử dụng thư viện thông báo ở đây

                    console.log(response.data.message);
                })
                .catch(error => {
                    console.error('Lỗi khi xóa cache và phiên:', error);
                });
        }

        requestAnimationFrame(updateCountdown);
    </script>


    <script>
        window.Echo.channel('laravel_database_seat-selected-channel')
            .listen('.seat-selected', (e) => {
                console.log(e);
                // console.log(e.showtime_id);
                // const userId = {{ auth()->id() }};
                // console.log("userId: " + userId);

                const selectedSeats = e.selectedSeats;

                // Update seat images and cursor based on the selectedSeats array and user ID
                selectedSeats.forEach((seat) => {
                    const seatElement = document.getElementById(`seat-${seat}`);

                    if (seatElement) {
                        const isSeatSelected = seatElement.classList.contains('seat-selected');
                        const showTimeId = document.getElementById("showtime-link").getAttribute(
                            "data-showtime-id");

                        const check = e.userId === {{ auth()->id() }} && e.showtime_id === showTimeId;

                        if (e.showtime_id === showTimeId) {
                            // Kiểm tra trạng thái hiện tại trước khi cập nhật
                            if (isSeatSelected === check) {
                                const imageUrl = check ?
                                    '{{ asset('client/assets/images/movie/seatDangChon.png') }}' :
                                    '{{ asset('client/assets/images/movie/seatDangGiu.png') }}';

                                seatElement.querySelector('img').src = imageUrl;

                                if (check) {
                                    seatElement.style.pointerEvents = 'auto';
                                } else {
                                    seatElement.style.pointerEvents = 'none';
                                }
                            }


                        }
                    }
                });

            });
    </script>





    {{-- kiểm tra ghế  --}}
    <script>
        // Sử dụng jQuery để chọn tất cả các ghế có class 'seat-click'
        const $seats = $('.seat-click');

        // Bắt đầu bằng việc vô hiệu hóa nút thanh toán
        $('#thanh-toan-button').prop('disabled', true);

        // Đặt sự kiện click cho nút thanh toán
        $('#thanh-toan-button').on('click', function(event) {
            // Kiểm tra xem có bất kỳ ghế nào đã được chọn
            const selectedSeats = $seats.filter('.seat-selected');
            if (selectedSeats.length === 0) {
                // Nếu không có ghế nào được chọn, hiển thị thông báo và ngừng xử lý sự kiện
                event.preventDefault(); // Ngừng chuyển hướng đến trang thanh toán
                alert('Vui lòng chọn ghế trước khi thanh toán.');
                return; // Stop further execution
            }

            const selectedSeatNumbers = selectedSeats.map(function() {
                return $(this).find('.sit-num').text();
            }).get();

            // Tạo một danh sách các hàng A đến Z
            const rows = [];
            for (let row = 'A'.charCodeAt(0); row <= 'Z'.charCodeAt(0); row++) {
                rows.push(String.fromCharCode(row));
            }

            // Kiểm tra từng hàng A đến Z
            for (let i = 0; i < rows.length; i++) {
                const currentRow = rows[i];
                if (selectedSeatNumbers.includes(currentRow + '2') && !selectedSeatNumbers.includes(currentRow +
                        '1')) {
                    event.preventDefault();
                    alert('Vui lòng không để trống ghế ' + currentRow + '1.');
                }
                if (selectedSeatNumbers.includes(currentRow + '9') && !selectedSeatNumbers.includes(currentRow +
                        '10')) {
                    event.preventDefault();
                    alert('Vui lòng không để trống ghế ' + currentRow + '10.');
                }
            }

            // Tạo một danh sách tất cả các ghế từ 'A' đến 'Z'
            const allSeats = [];
            for (let row = 'A'.charCodeAt(0); row <= 'Z'.charCodeAt(0); row++) {
                for (let seatNum = 1; seatNum <= 10; seatNum++) {
                    allSeats.push(String.fromCharCode(row) + seatNum);
                }
            }

            // Kiểm tra xem có ghế nào bị bỏ trống giữa các ghế đã chọn
            let isAnySeatEmpty = false;
            for (let i = 0; i < allSeats.length; i++) {
                if (selectedSeatNumbers.includes(allSeats[i])) {
                    continue;
                }
                // Kiểm tra xem có ghế nào bị bỏ trống giữa các ghế đã chọn
                if (i > 0 && i < allSeats.length - 1) {
                    const prevSeat = allSeats[i - 1];
                    const nextSeat = allSeats[i + 1];
                    if (
                        selectedSeatNumbers.includes(prevSeat) &&
                        selectedSeatNumbers.includes(nextSeat)
                    ) {
                        isAnySeatEmpty = true;
                        break;
                    }
                }
            }

            if (isAnySeatEmpty) {
                event.preventDefault();
                alert('Vui lòng không chừa 1 ghế trống bên trái hoặc bên phải của các ghế bạn đã chọn.');
            }
        });

        // Đặt sự kiện click cho tất cả ghế
        $seats.on('click', function() {
            $(this).toggleClass('seat-selected'); // Chuyển trạng thái chọn ghế

            // Kiểm tra xem có bất kỳ ghế nào đã được chọn
            const selectedSeats = $seats.filter('.seat-selected');
            if (selectedSeats.length > 0) {
                // Nếu có ghế được chọn, cập nhật thuộc tính href của nút thanh toán
                $('#thanh-toan-button').attr('href',
                    '{{ route('chon-do-an', ['room_id' => $room->id, 'slug' => $showTime->movie->slug, 'showtime_id' => $showTime->id]) }}'
                );
            } else {
                // Nếu không có ghế nào được chọn, đặt lại thuộc tính href về trống hoặc href="#"
                $('#thanh-toan-button').attr('href', '#');
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var chosenSeats = @json(Session::get('selectedSeats', []));
            var seatElements = document.querySelectorAll(".seat-click");
            var showTimeId = document.getElementById("showtime-link").getAttribute("data-showtime-id");

            function updateChosenSeatsDisplay() {
                var chosenSeatsText = chosenSeats.join(", ");
                document.querySelector(".proceed-book .title").textContent = chosenSeatsText;
            }

            seatElements.forEach(function(seat, index) {
                var imgElement = seat.querySelector("img");
                var originalImageSrc = imgElement.src;
                var newImageSrc = "{{ asset('client/assets/images/movie/seatDangChon.png') }}";
                var seatNum = seat.querySelector(".sit-num").textContent;

                if (chosenSeats.includes(seatNum)) {
                    imgElement.src = newImageSrc;
                    seat.classList.add("seat-selected");
                }

                imgElement.addEventListener("click", function(event) {
                    event.stopPropagation();

                    // Toggle the seat selection state
                    if (imgElement.src === originalImageSrc) {
                        imgElement.src = newImageSrc;
                        chosenSeats.push(seatNum);
                        seat.classList.add("seat-selected");

                        // Auto-select the corresponding seat for seats with the "seat" class
                        if (seat.classList.contains("seat")) {
                            var oppositeIndex = (index % 2 === 0) ? index + 1 : index - 1;
                            var oppositeSeat = seatElements[oppositeIndex];

                            if (oppositeSeat) {
                                var oppositeImgElement = oppositeSeat.querySelector("img");
                                var oppositeSeatNum = oppositeSeat.querySelector(".sit-num")
                                    .textContent;

                                oppositeImgElement.src = newImageSrc;
                                chosenSeats.push(oppositeSeatNum);
                                oppositeSeat.classList.add("seat-selected");
                            }
                        }
                    } else {
                        imgElement.src = originalImageSrc;
                        chosenSeats = chosenSeats.filter(function(seat) {
                            return seat !== seatNum;
                        });
                        seat.classList.remove("seat-selected");

                        // Deselect the corresponding seat for seats with the "seat" class
                        if (seat.classList.contains("seat")) {
                            var oppositeIndex = (index % 2 === 0) ? index + 1 : index - 1;
                            var oppositeSeat = seatElements[oppositeIndex];

                            if (oppositeSeat) {
                                var oppositeImgElement = oppositeSeat.querySelector("img");
                                var oppositeSeatNum = oppositeSeat.querySelector(".sit-num")
                                    .textContent;

                                oppositeImgElement.src = originalImageSrc;
                                chosenSeats = chosenSeats.filter(function(seat) {
                                    return seat !== oppositeSeatNum;
                                });
                                oppositeSeat.classList.remove("seat-selected");
                            }
                        }
                    }

                    function formatCurrency(amount) {
                        // Format the amount with the desired currency symbol
                        return amount.toLocaleString('en-US', {
                            style: 'currency',
                            currency: 'VND'
                        }).replace(/^(\D+)/, '');
                    }

                    fetch('/save-selected-seats', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                showtime_id: showTimeId,
                                selectedSeats: chosenSeats
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data.message);
                            updateChosenSeatsDisplay();

                            // Định dạng giá theo VNĐ và cập nhật trên giao diện người dùng

                            document.querySelector(".total-price").textContent = formatCurrency(
                                data.totalPrice) + " VNĐ";
                        });


                    const selectedSeats = $('.seat-click').filter('.seat-selected');
                    if (selectedSeats.length > 0) {
                        $('#thanh-toan-button').attr('href',
                            '{{ route('chon-do-an', ['room_id' => $room->id, 'slug' => $showTime->movie->slug, 'showtime_id' => $showTime->id]) }}'
                        );
                    } else {
                        $('#thanh-toan-button').attr('href', '#');
                    }
                });
            });

            updateChosenSeatsDisplay();
        });
    </script>
@endsection
