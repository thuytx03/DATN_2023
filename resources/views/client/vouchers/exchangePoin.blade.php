@extends('layouts.client')
@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="{{ asset('client/assets/images/banner/banner02.jpg') }}">
        </div>
        <div class="container">
            <div class="banner-content">
                <h1 class="title bold">Đổi điểm thưởng <span class="color-theme">lấy</span> mã giảm giá</h1>
                <p>Trang này là trang dùng điểm thưởng để đổi các mã giảm giá. Điểm thưởng sẽ nhận được khi bạn đặt vé xem phim</p>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <section class="movie-section padding-top padding-bottom">
        <div class="container">
            <div class="row flex-wrap-reverse justify-content-center">

                <div class="col-lg-12 mb-50 mb-lg-0">
                    <div class="filter-tab tab">
                        <div class="filter-area">
                            <div class="filter-main">
                                <div class="left">
                                    <div class="item">
                                        <span class="show">Show :</span>
                                        <select class="select-bar">
                                            <option value="12">12</option>
                                            <option value="15">15</option>
                                            <option value="18">18</option>
                                            <option value="21">21</option>
                                            <option value="24">24</option>
                                            <option value="27">27</option>
                                            <option value="30">30</option>
                                        </select>
                                    </div>
                                    <div class="item">
                                        <span class="show">Sort By :</span>
                                        <select class="select-bar">
                                            <option value="showing">now showing</option>
                                            <option value="exclusive">exclusive</option>
                                            <option value="trending">trending</option>
                                            <option value="most-view">most view</option>
                                        </select>
                                    </div>
                                </div>
                                <ul class="grid-button tab-menu">
                                    <li class="active">
                                        <i class="fas fa-th"></i>
                                    </li>
                                    <li>
                                        <i class="fas fa-bars"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-area">

                            <div class="tab-item active">
                                <div class="movie-area mb-10">
                                    @foreach ($voucher as $value)
                                        {{-- @php
                                            $now = now();
                                            $end_date = $value->end_date;
                                            $interval = $now->diff($end_date);

                                            $hoursRemaining = $interval->h;
                                            $minutesRemaining = $interval->i;
                                        @endphp --}}
                                        <div class="movie-list">
                                            <div class="movie-thumb c-thumb">
                                                <a href="movie-details.html" class="w-100 bg_img h-100"
                                                    data-background="{{ asset('client/img/voucher.png') }}">
                                                    <img class="d-sm-none" src="{{ asset('client/img/voucher.png') }}"
                                                        alt="movie">
                                                </a>
                                            </div>
                                            <div class="movie-content bg-one">
                                                <h5 class="title">
                                                    @if ($value->type == 1)
                                                        <a href="movie-details.html">Giảm giá {{ $value->value }}%</a>
                                                    @else
                                                        <a href="movie-details.html">Giảm giá
                                                            {{ number_format($value->value, 0, ',', '.') }} VNĐ </a>
                                                    @endif
                                                </h5>

                                                {{-- <div class="duration">
                                                    @if ($value->status == 3)
                                                        Hết Hạn
                                                    @elseif($value->status == 4)
                                                        Hết mã khuyến mãi
                                                    @elseif ($hoursRemaining < 1)
                                                        <span class="content">Sắp hết hạn còn {{ $minutesRemaining }}
                                                            phút</span>
                                                    @elseif ($hoursRemaining < 24)
                                                        <span class="content">Sắp hết hạn còn {{ $hoursRemaining }} giờ
                                                            {{ $minutesRemaining }} phút</span>
                                                    @else
                                                        <span class="content">Hạn sử dụng đến
                                                            {{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}</span>
                                                    @endif
                                                </div> --}}
                                                <div class="release">
                                                    <span>Mã giảm giá cần dùng: <span
                                                            class="duration">{{ $value->poin }}</span> điểm để mở khoá
                                                </div>
                                                <div class="release">
                                                  {{ $value->description }}
                                                </div>

                                                <div class="book-area">
                                                    <div class="book-ticket">
                                                        @if (in_array($value->id, $unlockedVoucherIds))
                                                            <div class="react-item ml-auto">
                                                                <a href="{{ route('home.voucher.detail', ['id' => $value->id]) }}"
                                                                    class="custom-button">Xem chi tiết</a>

                                                            </div>
                                                        @else
                                                            <form
                                                                action="{{ route('home.voucher.detail', ['id' => $value->id]) }}"
                                                                method="get" class="ml-auto">
                                                                @csrf
                                                                <div class="react-item ">
                                                                    <button type="submit" class="custom-button">Đổi
                                                                        điểm</button>
                                                                </div>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Movie-Section========== -->
@endsection
