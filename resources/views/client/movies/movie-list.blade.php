@extends('layouts.client')
@section('content')

    <!-- ==========Banner-Section========== -->
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="{{asset('client/assets/images/banner/banner02.jpg')}}"></div>
        <div class="container">
            <div class="banner-content">
                <h1 class="title bold">Nhận <span class="color-theme">vé</span> xem phim</h1>
                <p>Mua vé xem phim trước, tìm thời gian chiếu phim, xem trailer, đọc các bài đánh giá phim và hơn thế nữa</p>
            </div>
    </section>

    <!-- ==========Banner-Section========== -->

    <!-- ==========Ticket-Search========== -->
    <section class="search-ticket-section padding-top pt-lg-0">
        <div class="container">
            <div class="search-tab bg_img" data-background=" {{asset('client/assets/images/ticket/ticket-bg01.jpg')}}">
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
        <div class="container">
            <div class="row flex-wrap-reverse justify-content-center">
                <div class="col-sm-10 col-md-8 col-lg-3">
                    <div class="widget-1 widget-banner">
                        <div class="widget-1-body">
                            <a href="#0">
                                <img src="{{asset('client/assets/images/sidebar/banner/banner01.jpg')}}" alt="banner">
                            </a>
                        </div>
                    </div>
                    <div class="widget-1 widget-check">
                        <div class="widget-header">
                            <h5 class="m-title">Lọc theo</h5>
                            <a href="#0" class="clear-check" id="clearAll">Xóa tất cả</a>
                        </div>
                        <div class="widget-1-body">
                            <h6 class="subtitle">Quốc gia</h6>
                            <div class="check-area">
                                @foreach($countries as $country)
                                    <div class="form-group">
                                        <input type="checkbox" name="countries" id="country{{$country->id}}" data-genre-id="{{$country->id}}">
                                        <label for="country{{$country->id}}">{{$country->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="widget-1 widget-check">
                        <div class="widget-1-body">
                            <h6 class="subtitle">Trải nghiệm</h6>
                            <div class="check-area">
                                <div class="form-group">
                                    <input type="checkbox" name="mode" id="mode1"><label for="mode1">2D</label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="mode" id="mode2"><label for="mode2">3D</label>
                                </div>
                            </div>
                            <div class="add-check-area">
                                <a href="#0">Xem thêm <i class="plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="widget-1 widget-check">
                        <div class="widget-1-body">
                            <h6 class="subtitle">Thể loại</h6>
                            <div class="check-area">
                                @foreach ($genres as $genre)
                                    <div class="form-group">
                                        <input type="checkbox" name="genre" id="genre{{$genre->id}}" data-genre-id="{{$genre->id}}"><label for="genre{{$genre->id}}">{{$genre->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="add-check-area">
                                <a href="#0">Xem thêm <i class="plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="widget-1 widget-banner">
                        <div class="widget-1-body">
                            <a href="#0">
                                <img src="{{asset('client/assets/images/sidebar/banner/banner02.jpg')}}" alt="banner">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 mb-50 mb-lg-0">
                    <div class="filter-tab tab">
                        <div class="filter-area">
                            <div class="filter-main">
                                <div class="left">
                                    <div class="item">
                                        <span class="show">Xem :</span>
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
                                        <span class="show">Sắp xếp theo :</span>
                                        <select class="select-bar" id="sort-by">
                                            <option value="0">Chọn</option>
                                            <option value="trending">Trending</option>
                                            <option value="most-view">Lượt xem</option>
                                            <option value="showing-time">Đang chiếu</option>
                                        </select>
                                    </div>
                                </div>
                                <ul class="grid-button tab-menu">
                                    <li class="active">
                                        <i class="fas fa-th "></i>
                                    </li>
                                    <li class="">
                                        <i class="fas fa-bars"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-area">
                            <div class="tab-item active">
                                <div class="row mb-10 justify-content-center" id="movie-list">
                                    @include("client.movies.partial-movies")
                                </div>
                            </div>
                        </div>
                        <div class="pagination-area text-center">
                            <a href="#0"><i class="fas fa-angle-double-left"></i><span>Prev</span></a>
                            <a href="#0">1</a>
                            <a href="#0">2</a>
                            <a href="#0" class="active">3</a>
                            <a href="#0">4</a>
                            <a href="#0">5</a>
                            <a href="#0"><span>Next</span><i class="fas fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- ==========Movie-Section========== -->
    <script>
        jQuery(document).ready(function() {
            $('.ticket-search-form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                formData += '&_token={{ csrf_token() }}'; // Thêm token CSRF vào dữ liệu gửi đi
                $.ajax({
                    type: 'POST',
                    url: "{{ route('movie.search') }}",
                    data: formData,
                    success: function(response) {
                        $('#movie-list').html(response);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countryCheckboxes = document.querySelectorAll('input[name="countries"]');
            const genreCheckboxes = document.querySelectorAll('input[name="genre"]');
            const clearAllButton = document.getElementById('clearAll'); // Thêm dòng này để lấy tham chiếu đến nút "Xóa tất cả"

            function filterMovies() {
                const selectedCountries = Array.from(document.querySelectorAll('input[name="countries"]:checked'))
                    .map(checkbox => checkbox.getAttribute('data-genre-id'));
                console.log(selectedCountries)
                const selectedGenres = Array.from(document.querySelectorAll('input[name="genre"]:checked'))
                    .map(checkbox => checkbox.getAttribute('data-genre-id'));
                console.log(selectedGenres)
                const token = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('movie.filter') }}",
                    data: {
                        _token: token,
                        country: selectedCountries,
                        genres: selectedGenres
                    },
                    success: function(data) {
                        document.getElementById('movie-list').innerHTML = data;
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi trong quá trình gửi yêu cầu:', error);
                    }
                });
                console.log(data)
            }

            countryCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', filterMovies);
            });

            genreCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', filterMovies);
            });

            // Thêm sự kiện cho nút "Xóa tất cả"
            clearAllButton.addEventListener('click', function() {
                countryCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });

                genreCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Gọi hàm filterMovies để xử lý việc lọc dữ liệu
                filterMovies();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#sort-by').change(function() {
                var selectedValue = $(this).val();

                // Gửi Ajax request đến controller thông qua route mới
                $.ajax({
                    url: '{{ route("movie.sort") }}', // Sử dụng route mới đã đặt tên
                    type: 'GET',
                    data: {
                        sortBy: selectedValue
                    },
                    success: function(data) {
                        // Cập nhật nội dung của tab với dữ liệu mới từ controller
                        $('#movie-list').html(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

@endsection
