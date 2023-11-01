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


    <!-- ==========Banner-Section========== -->
    <section class="details-banner hero-area bg_img"
        data-background="{{ asset('client/assets/images/banner/banner03.jpg') }}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-content">
                    <h3 class="title">Venus</h3>
                    <div class="tags">
                        <a href="#0">English</a>
                        <a href="#0">Hindi</a>
                        <a href="#0">Telegu</a>
                        <a href="#0">Tamil</a>
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
                    <form class="ticket-search-form">
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
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{ asset('client/assets/images/ticket/city.png') }}" alt="ticket">
                            </div>
                            <span class="type">Tỉnh</span>
                            <select class="province" name="province_id" id="province_id">
                                <option value="">Vui lòng chọn</option>
                                @foreach ($province as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{ asset('client/assets/images/ticket/date.png') }}" alt="ticket">
                            </div>
                            <span class="type">Ngày</span>
                            <select class="select-bar">
                                @for ($i = 0; $i < 7; $i++)
                                    @php
                                        $date = now()->addDays($i);
                                    @endphp
                                    <option value="{{ $date->format('d-m-y') }}">{{ $date->format('d/m/Y') }}</option>
                                @endfor
                            </select>

                        </div>

                        <div class="form-group large">
                            <input type="text" placeholder="Search fo Movies">
                            <button type="submit"><i class="fas fa-search"></i></button>
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

        .accordion-child.active {
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

                        @foreach ($ticketShowTime->groupBy('room_id') as $roomId => $showTimes)
                            <li>

                                <div class="movie-name">
                                    <div class="icons">
                                        <i class="far fa-heart"></i>
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <a href="#0" class="name text-white">{{ $showTimes[0]->room->cinema->name }}</a>
                                    <div class="location-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>

                                <div class="movie-schedule">
                                    @foreach ($showTimes as $showTime)
                                        <div class="item">
                                            <a href="{{ route('chon-ghe', ['room_id' => $showTime->room_id, 'slug' => $movie->slug, 'showtime_id' => $showTime->id]) }}"
                                                class="text-white">
                                                {{ date('H:i', strtotime($showTime->start_date)) }}
                                            </a>

                                        </div>
                                    @endforeach
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-10">
                    <div class="widget-1 widget-banner">
                        <div class="widget-1-body">
                            <a href="#0">
                                <img src="{{ asset('client/assets/images/sidebar/banner/banner03.jpg') }}" alt="banner">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Movie-Section========== -->


    {{-- <div class="ticket-plan-section padding-bottom padding-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 mb-5 mb-lg-0">
                    <ul class="seat-plan-wrapper bg-five">
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                        @foreach ($ticketShowTime->groupBy('room.cinema.id') as $cinemaId => $cinemaShowTimes)
                            <li class="accordion-parent">
                                <div class="movie-name">
                                    <div class="icons">
                                        <i class="far fa-heart"></i>
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <a href="#0" class="name text-white">{{ $cinemaShowTimes[0]->room->cinema->name }}</a>
                                    <div class="location-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>
                                <div class="movie-schedule">
                                    <div class="ml-auto">
                                        <div class="toggle-accordion">
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            @foreach ($cinemaShowTimes->groupBy('room_id') as $roomId => $showTimes)
                                <li class="accordion-child">
                                    <div class="movie-schedule">
                                        <div class="">
                                            <div
                                            >Phòng: {{ $showTimes[0]->room->name }}</div>
                                        </div>
                                        @foreach ($showTimes as $showTime)
                                        <div class="item">

                                            <a href="{{ route('chon-ghe', ['room_id' => $showTime->room_id, 'slug' => $movie->slug, 'showtime_id' => $showTime->id]) }}"
                                                class="text-white">
                                                {{ date('H:i', strtotime($showTime->start_date)) }}
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-10">
                    <div class="widget-1 widget-banner">
                        <div class="widget-1-body">
                            <a href="#0">
                                <img src="{{ asset('client/assets/images/sidebar/banner/banner03.jpg') }}" alt="banner">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Khi accordion-parent được click
            $(".accordion-parent").click(function() {
                var $toggleAccordion = $(this).find(".toggle-accordion");
                var $accordionChild = $(this).next(".accordion-child");

                // Toggle lớp CSS "active" cho accordion-child
                $accordionChild.toggleClass("active");

                // Thay đổi biểu tượng dấu cộng và dấu trừ
                if ($accordionChild.hasClass("active")) {
                    $toggleAccordion.find("i.fa-plus").removeClass("fa-plus").addClass("fa-minus");
                } else {
                    $toggleAccordion.find("i.fa-minus").removeClass("fa-minus").addClass("fa-plus");
                }
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
                        url: '/get-cinemas/' +
                            provinceId, // Điều hướng đến phương thức xử lý Ajax ở bước tiếp theo
                        success: function(data) {
                            // Xóa danh sách rạp hiện tại
                            $('#cinema_id').empty();

                            // Thêm danh sách rạp mới
                            $.each(data, function(key, value) {
                                $('#cinema_id').append('<option value="' + key + '">' +
                                    value + '</option>');

                            });
                        }
                    });
                } else {
                    // Nếu không chọn tỉnh, xóa danh sách rạp
                    $('#cinema_id').empty();
                }
            });
        });
    </script>
@endsection
