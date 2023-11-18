@extends('layouts.client')
@section('content')
    <style>
        .seat-plan-wrapper li .movie-schedule .item {
            color: #ffffff;
            padding: 5px;
            width: 70px;
            background: #162f5f;
            position: relative;
            mask-position: center center;
            -webkit-mask-position: center center;
            text-align: center;
            mask-image: url({{ asset('client/assets/images/ticket/movie-seat.png') }});
            -webkit-mask-image: url({{ asset('client/assets/images/ticket/movie-seat.png') }});
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
            cursor: pointer;
            -webkit-transition: all ease 0.3s;
            transition: all ease 0.3s;
            margin: 5px;
        }
    </style>
    <style>
        .province {
            width: 120px;
            background: none;
            outline: none;
            border: none;
            margin-left: 5px;
        }

        .cinema {
            width: 150px;
            background: none;
            outline: none;
            border: none;
            margin-left: 5px;
        }

        .province option {
            background: white;
            color: black;
        }

        .cinema option {
            background: white;
            color: black;
        }
    </style>

    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img" data-background="{{ Storage::url($movie->poster) }}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content">
                    <h3 class="title">{{ $movie->name }}</h3>
                    <div class="tags">
                        <a href="#0">{{ $movie->language }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Book-Section========== -->
    <section class="book-section bg-one">
        <div class="container">
            <div class="tab-area">

                <div class="tab-item active">

                    <form class="ticket-search-form" method="get"
                        action="{{ route('lich-chieu', ['id' => $movie->id, 'slug' => $movie->slug]) }}">

                        <div class="form-group">
                            <div class="item md-order-1">
                                <a href="{{ route('movie.detail', ['slug' => $movie->slug, 'id' => $movie->id]) }}"
                                    class="custom-button back-button">
                                    Quay lại </a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{ asset('client/assets/images/ticket/city.png') }}" alt="ticket">
                            </div>
                            <span class="type">Tỉnh</span>
                            <select class="province " name="province_id" id="province_id">
                                <option value="">Vui lòng chọn</option>
                                @foreach ($province as $value)
                                    <option value="{{ $value->id }}"
                                        {{ request()->province_id == $value->id ? 'selected' : '' }}>{{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{ asset('client/assets/images/ticket/cinema.png') }}" alt="ticket">
                            </div>
                            <span class="type">Rạp</span>
                            <select class="cinema" name="cinema_id" id="cinema_id">
                                <option value="">Vui lòng chọn</option>
                                @foreach ($cinemasByProvince as $value)
                                    <option value="{{ $value->id }}"
                                        {{ request()->cinema_id == $value->id ? 'selected' : '' }}>{{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{ asset('client/assets/images/ticket/date.png') }}" alt="ticket">
                            </div>
                            <span class="type">Ngày</span>
                            <select class="select-bar" name="selected_date" id="selected_date">

                                @for ($i = 0; $i < 7; $i++)
                                    @php
                                        $date = now()->addDays($i);
                                    @endphp
                                    <option value="{{ $date->format('Y-m-d') }}"
                                        {{ request()->selected_date == $date->format('Y-m-d') ? 'selected' : '' }}>
                                        {{ $date->format('d/m/Y') }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="">
                            <button type="submit" class="custom-button" style="height: 45px">Tìm kiếm</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- ==========Book-Section========== -->




    <style>
        .accordion-child {
            display: none !important;
        }

        .accordion-child.active1 {
            display: block !important;

        }
    </style>

    <!-- ==========Movie-Section========== -->
    <div class="ticket-plan-section padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 mb-5 mb-lg-0">
                    <ul class="seat-plan-wrapper bg-five">
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                        @if (count($cinemaSchedules) > 0)
                            @foreach ($cinemaSchedules as $cinemaName => $roomSchedules)
                                @if (count($roomSchedules) > 0)
                                    <li class="accordion-parent">
                                        <div class="movie-name">
                                            <div class="icons">
                                                <i class="far fa-heart"></i>
                                                <i class="fas fa-heart"></i>
                                            </div>
                                            <a href="#0" class="name text-white">Rạp: {{ $cinemaName }}</a>
                                            <div class="location-icon">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                        </div>
                                        <div class="movie-schedule">
                                            <div class="ml-auto">
                                                <div class="toggle-accordion">
                                                    <i class="fa-solid fa-chevron-down"></i>
                                                    <i class="fa-solid fa-chevron-up" style="display:none;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="accordion-child">
                                        @foreach ($roomSchedules as $roomName => $showTimes)
                                            <div class="movie-schedule">
                                                <a href="#0" class="name text-white mt-2">Phòng:
                                                    {{ $roomName }}</a>
                                                    @foreach ($showTimes['roomShowtimes'] as $showTime)
                                                    <div>
                                                        <div class="item">
                                                            <a href="{{ route('chon-ghe', ['room_id' => $showTime->room_id, 'slug' => $movie->slug, 'showtime_id' => $showTime->id]) }}"
                                                                class="text-white">
                                                                {{ date('H:i', strtotime($showTime->start_date)) }}
                                                            </a>
                                                        </div>

                                                        <p style="font-size: 11px;" class="text-center mt-1">
                                                           {{ $showTimes['availableSeatCounts'][$showTime->id] }} ghế trống

                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li class="accordion-parent">
                                <div class="movie-name">
                                    <a href="#0" class a="name text-white">Không có lịch chiếu nào cho phim này tại các
                                        rạp.</a>
                                </div>
                                <div class="movie-schedule">
                                    <a href="#0" class a="name text-white">Phim sẽ có lịch chiếu trong thời gian sắp
                                        tới!</a>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy tất cả các phần tử có class "accordion-parent"
            var accordionParents = document.querySelectorAll(".accordion-parent");

            // Lặp qua từng "accordion-parent"
            accordionParents.forEach(function(parent) {
                // Lắng nghe sự kiện click
                parent.addEventListener("click", function() {
                    // Tìm phần tử con "accordion-child" của "accordion-parent"
                    var child = this.nextElementSibling;

                    // Tìm phần tử con chứa các biểu tượng
                    var icons = this.querySelector(".toggle-accordion");

                    // Kiểm tra nếu "accordion-child" đã có class "active1"
                    if (child.classList.contains("active1")) {
                        // Nếu đã có, loại bỏ class "active1" và ẩn nó
                        child.classList.remove("active1");
                        // Thay đổi biểu tượng thành chevron-down
                        icons.querySelector(".fa-chevron-up").style.display = "none";
                        icons.querySelector(".fa-chevron-down").style.display = "block";
                    } else {
                        // Nếu chưa có, thêm class "active1" và hiển thị nó
                        child.classList.add("active1");
                        // Thay đổi biểu tượng thành chevron-up
                        icons.querySelector(".fa-chevron-up").style.display = "block";
                        icons.querySelector(".fa-chevron-down").style.display = "none";
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#province_id').change(function() {
                var provinceId = $(this).val();
                if (provinceId) {
                    $.ajax({
                        type: 'GET',
                        url: '/get-cinemas/' + provinceId,
                        success: function(data) {
                            // Xóa danh sách rạp hiện tại
                            $('#cinema_id').empty();

                            // Thêm danh sách rạp mới
                            $.each(data, function(key, value) {
                                $('#cinema_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });

                            // Sau khi thêm danh sách rạp mới, thêm option "Vui lòng chọn"
                            $('#cinema_id').prepend('<option value="">Vui lòng chọn</option>');
                        }
                    });
                } else {
                    // Nếu không chọn tỉnh, xóa danh sách rạp và thêm lại option "Vui lòng chọn"
                    $('#cinema_id').empty().append('<option value="">Vui lòng chọn</option>');
                }
            });
        });
    </script>

@endsection
