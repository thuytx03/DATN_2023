@extends('layouts.client')

@section('content')
<!-- ==========Banner-Section========== -->
<section class="banner-section">
    <div class="banner-bg bg_img bg-fixed" data-background=" {{asset('client/assets/images/banner/banner01.jpg')}}"></div>
    <div class="container">
        <div class="banner-content">
            <h1 class="title  cd-headline clip"><span class="d-block">Đặt vé</span> cho
                <span class="color-theme cd-words-wrapper p-0 m-0">
                    <b class="is-visible">Phim</b>
                    <b>Sự kiện</b>
                    <b>Thể thao</b>
                </span>
            </h1>
            <p>Bán vé an toàn, bảo mật, đáng tin cậy. Tấm vé xem giải trí trực tiếp của bạn!</p>
        </div>
    </div>
</section>
<!-- ==========Banner-Section========== -->

<!-- ==========Ticket-Search========== -->
<section class="search-ticket-section padding-top pt-lg-0">
    <div class="container">
        <div class="search-tab bg_img" data-background=" {{asset('client/assets/images/ticket/ticket-bg01.jpg')}}">
            <div class="row align-items-center mb--20">
                <div class="col-lg-6 mb-20">
                    <div class="search-ticket-header">
                        <h6 class="category">Chào mừng đến với Boleto </h6>
                        <h3 class="title">Bạn đang tìm kiếm cái gì ?</h3>
                    </div>
                </div>
                <div class="col-lg-6 mb-20">
                    <ul class="tab-menu ticket-tab-menu">
                        <li class="active">
                            <div class="tab-thumb">
                                <img src="{{asset('client/assets/images/ticket/ticket-tab01.png')}}" alt="ticket">
                            </div>
                            <span>Phim</span>
                        </li>
                        <li>
                            <div class="tab-thumb">
                                <img src="{{asset('client/assets/images/ticket/ticket-tab02.png')}}" alt="ticket">
                            </div>
                            <span>Sự kiện</span>
                        </li>
                        <li>
                            <div class="tab-thumb">
                                <img src="{{asset('client/assets/images/ticket/ticket-tab03.png')}}" alt="ticket">
                            </div>
                            <span>Thể thao</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-area">
                <div class="tab-item active">
                    <form class="ticket-search-form" method="post">
                        @csrf
                        <div class="form-group large">
                            <input type="text" placeholder="Tìm kiếm phim" name="search_query">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src="{{asset('client/assets/images/ticket/city.png ')}} " alt="ticket">
                            </div>
                            <span class="type">Quốc gia</span>
                            <select class="select-bar" name="country_id">
                                <option value="">Chọn quốc gia</option>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="thumb">
                                <img src=" {{asset('client/assets/images/ticket/date.png')}}" alt="ticket">
                            </div>
                            <span class="type">Ngày</span>
                            <select class="select-bar" name="start_date">
                                <option value="">Chọn ngày</option>
                                <option value="{{ $currentDate }}">{{ $currentDate }}</option>
                                <option value="{{ Carbon\Carbon::now()->addDays(1)->format('d/m/Y') }}">{{ Carbon\Carbon::now()->addDays(1)->format('d/m/Y') }}</option>
                                <option value="{{ Carbon\Carbon::now()->addDays(2)->format('d/m/Y') }}">{{ Carbon\Carbon::now()->addDays(2)->format('d/m/Y') }}</option>
                                <option value="{{ Carbon\Carbon::now()->addDays(3)->format('d/m/Y') }}">{{ Carbon\Carbon::now()->addDays(3)->format('d/m/Y') }}</option>
                                <option value="{{ Carbon\Carbon::now()->addDays(4)->format('d/m/Y') }}">{{ Carbon\Carbon::now()->addDays(4)->format('d/m/Y') }}</option>
                                <option value="{{ Carbon\Carbon::now()->addDays(5)->format('d/m/Y') }}">{{ Carbon\Carbon::now()->addDays(5)->format('d/m/Y') }}</option>
                                <option value="{{ Carbon\Carbon::now()->addDays(6)->format('d/m/Y') }}">{{ Carbon\Carbon::now()->addDays(6)->format('d/m/Y') }}</option>
                                <option value="{{ $sevenDaysLater }}">{{ $sevenDaysLater }}</option> <!-- Đã thêm biến $sevenDaysLater vào đây -->
                                <!-- Các ngày khác tương tự -->
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ==========Ticket-Search========== -->

<!-- ==========Movie-Section========== -->
<section class="movie-section padding-top padding-bottom">
    @include('client.movies.movie')
</section>


<!-- ==========Movie-Section========== -->

<!-- ==========Event-Section========== -->
@include('client.event')

<!-- ==========Event-Section========== -->

<!-- ==========Sports-Section========== -->
@include('client.sports')

<!-- ==========Sports-Section========== -->
@endsection
