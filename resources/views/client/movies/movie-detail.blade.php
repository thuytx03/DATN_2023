@extends('layouts.client')
@section('content')
    <style>
        .abc {
            margin-left: 10px;
        }

        .rating-it.highlight {
            color: #ffcc00; /* hoặc màu khác để làm nổi bật */
        }
    </style>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    @endpush
    <!-- ==========Banner-Section========== -->
    <section class="details-banner bg_img" data-background="{{asset('assets/images/banner/banner03.jpg')}}">
        <div class="container">
            <div class="details-banner-wrapper">
                <div class="details-banner-thumb">
                    <img alt="movies" width="60"
                         src="{{ $movie->poster ? Storage::url($movie->poster) : asset('images/image-not-found.jpg') }}"
                         alt="Image">
                    <a href="https://www.youtube.com/embed/KGeBMAgc46E" class="video-popup">
                        <img src="{{asset('client/assets/images/movie/video-button.png')}}" alt="movie">
                    </a>
                </div>
                <div class="details-banner-content offset-lg-3">
                    <h3 class="title">{{$movie->name}}
                    </h3>

                    <div class="tags">
                        <a href="#0">{{$movie->language}}</a>
                        <a href="#0">Việt Nam</a>

                    </div>
                    <a href="#0" class="button">{{$nameGenres}}</a>
                    @if(auth()->check())
                        @if(auth()->user()->favoriteMovies->contains($movie))

                            <a href="{{route('home.favorite.add',['id'=>$movie->id])}}" id="favorite-link"
                               style="color: white" data-movie-id="{{ $movie->id }}" class="custom-button abc">Hủy Yêu
                                Thích</a>

                        @else
                            <a href="{{route('home.favorite.add',['id'=>$movie->id])}}" id="favorite-link"
                               style="color: white" data-movie-id="{{ $movie->id }}" class="custom-button abc">Thêm Vào
                                Yêu Thích</a>
                        @endif
                    @else

                        <a href="{{route('home.favorite.add',['id'=>$movie->id])}}" id="favorite-link"
                           style="color: white" data-movie-id="{{ $movie->id }}" class="custom-button abc">Thêm Vào Yêu
                            Thích</a>

                    @endif


                    <div class="social-and-duration">
                        <div class="duration-area">
                            <div class="item">
                                <i class="fas fa-calendar-alt"></i><span>{{$movie->start_date}}</span>
                            </div>
                            <div class="item">
                                <i class="far fa-clock"></i><span>{{$movie->duration}} phút</span>
                            </div>
                        </div>
                        <ul class="social-share">
                            <li><a href="#0"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#0"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#0"><i class="fab fa-pinterest-p"></i></a></li>
                            <li><a href="#0"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#0"><i class="fab fa-google-plus-g"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Book-Section========== -->
    <section class="book-section bg-one">
        <div class="container">
            <div class="book-wrapper offset-lg-3">
                <div class="left-side">
                    <div class="item">
                        <div class="item-header">
                            <div class="thumb">
                                <img src="{{ asset('client/assets/images/movie/tomato2.png')}}" alt="movie">
                            </div>
                            <div class="counter-area">
                                <span class="counter-item odometer" data-odometer-final="88">0</span>
                            </div>
                        </div>
                        <p>tomatometer</p>
                    </div>
                    <div class="item">
                        <div class="item-header">
                            <div class="thumb">
                                <img src="{{asset('client/assets/images/movie/cake2.png')}}" alt="movie">
                            </div>
                            <div class="counter-area">
                                <span class="counter-item odometer" data-odometer-final="88">0</span>
                            </div>
                        </div>
                        <p>audience Score</p>
                    </div>
                    <div class="item">
                        <div class="item-header">
                            <h5 class="title">{{ $averageRating }}</h5>
                            <div class="rated list-inline d-flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="rating"
                                          style="font-size: 25px; margin: 0 2px; color: {{ $i <= $averageRating ? '#ffcc00' : '#ccc' }}">&#9733;</span>
                                @endfor
                            </div>
                        </div>
                        <p>Người dùng đánh giá</p>
                    </div>
                    @if(auth()->check() && $hasMovieBooked)
                        <div class="item" id="item-star">
                            <div class="item-header">
                                <div class="rate-it list-inline d-flex" style="cursor: pointer">
                                    @for ($count = 1; $count <= 5; $count++)
                                        <span class="rating-it {{ $count <= $movie->userRating() ? 'highlight' : '' }}"
                                              data-rating="{{ $count }}" data-movie-id="{{ $movie->id }}"
                                              style="font-size: 25px; margin: 0 2px">&#9733;</span>
                                        @if($count == 1)
                                            <span style="display: none" id="movieID">{{ $movie->id }}</span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p>Đánh giá phim</p>
                        </div>
                    @endif
                </div>
                <div class="button-container">
                    <a href="{{ route('lich-chieu',['id'=>$movie->id,'slug'=>$movie->slug]) }}" class="custom-button">Mua
                        vé</a>
                    <input type="hidden" name="id" value="{{ $movie->id }}">
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Book-Section========== -->
    <section class="movie-details-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center flex-wrap-reverse mb--50">
                <div class="col-lg-3 col-sm-10 col-md-6 mb-50">
                    <div class="widget-1 widget-tags">
                        <ul>
                            <li>
                                <a href="#0">2D</a>
                            </li>
                            <li>
                                <a href="#0">imax 2D</a>
                            </li>
                            <li>
                                <a href="#0">4DX</a>
                            </li>
                        </ul>
                    </div>
                    <div class="widget-1 widget-offer">
                        <h3 class="title">Ưu đãi áp dụng</h3>
                        <div class="offer-body">
                            <div class="offer-item">
                                <div class="thumb">
                                    <img src="{{asset('client/assets/images/sidebar/offer01.png')}}" alt="sidebar">
                                </div>
                                <div class="content">
                                    <h6>
                                        <a href="#0">Ưu đãi hoàn tiền của Amazon Pay</a>
                                    </h6>
                                    <p>Giành được tiền hoàn lại lên tới 300</p>
                                </div>
                            </div>
                            <div class="offer-item">
                                <div class="thumb">
                                    <img src="{{asset('assets/images/sidebar/offer02.png')}}" alt="sidebar">
                                </div>
                                <div class="content">
                                    <h6>
                                        <a href="#0">PayPal Offer</a>
                                    </h6>
                                    <p>Giao dịch lần đầu tiên với Paypal và được hoàn tiền 100% lên tới Rs. 500</p>
                                </div>
                            </div>
                            <div class="offer-item">
                                <div class="thumb">
                                    <img src="{{asset('assets/images/sidebar/offer03.png')}}" alt="sidebar">
                                </div>
                                <div class="content">
                                    <h6>
                                        <a href="#0">Ưu đãi của ngân hàng HDFC</a>
                                    </h6>
                                    <p>Được giảm giá 15% lên tới 100 INR* và giảm giá INR 50* khi áp dụng F&B T&C</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-1 widget-banner">
                        <div class="widget-1-body">
                            <a href="#0">
                                <img src="{{asset('assets/images/sidebar/banner/banner01.jpg')}}" alt="banner">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 mb-50">
                    <div class="movie-details">
                        <h3 class="title">Hình ảnh liên quan</h3>
                        <div class="details-photos owl-carousel">
                            @foreach($images as $image)
                                <div class="thumb">
                                    <a href="{{asset('assets/images/movie/movie-details01.jpg')}}" class="img-pop">
                                        <img
                                            src="{{ $image->movie_image ? Storage::url($image->movie_image) : asset('images/image-not-found.jpg') }}"
                                            alt="movie">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab summery-review">
                            <ul class="tab-menu">
                                <li>
                                    Mô tả
                                </li>
                                <li class="active">
                                    Đánh giá phim <span>147</span>
                                </li>
                            </ul>
                            <div class="tab-area">
                                <div class="tab-item">
                                    <div class="item">
                                        <h5 class="sub-title">Mô tả phim</h5>
                                        <p>Lấy cảm hứng từ tiểu thuyết Hồ Oán Hận, của nhà văn Hồng Thái, Người Vợ Cuối
                                            Cùng là một bộ phim tâm lý cổ trang, lấy bối cảnh Việt Nam vào triều Nguyễn.
                                            LINH - Người vợ bất đắc dĩ của một viên quan tri huyện, xuất thân là con của
                                            một gia đình nông dân nghèo khó, vì không thể hoàn thành nghĩa vụ sinh con
                                            nối dõi nên đã chịu sự chèn ép của những người vợ lớn trong gia đình. Sự gặp
                                            gỡ tình cờ của cô và người yêu thời thanh mai trúc mã của mình - NHÂN đã dẫn
                                            đến nhiều câu chuyện bất ngờ xảy ra khiến cuộc sống cô hoàn toàn thay
                                            đổi. </p>
                                    </div>
                                </div>
                                <div class="tab-item active">
                                    @if(auth()->check() && $hasMovieBooked && $hasUserCommented)
                                        <div class="container" id="review-message">
                                            <div class="form-group row">
                                                <div class="col-md-1">
                                                    <img width="50px" class="img-fluid"
                                                         src="{{ (Auth::user()->avatar == null) ? asset('admin/img/undraw_profile_1.svg') : Storage::url(Auth::user()->avatar) }}">
                                                </div>
                                                <div class="col-md-9 pl-1">
                                                    <input type="text" placeholder="Nhập bình luận về phim ..."
                                                           name="message" id="message">
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-info" type="submit" id="submitComment">Bình
                                                        luận
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @foreach($reviews as $review)
                                        <div class="movie-review-item">
                                            <div class="author">
                                                <div class="thumb">
                                                    <img
                                                        src="{{ $review->avatar == null ? asset('admin/img/undraw_profile_1.svg') : Storage::url($review->avatar)}}"
                                                        alt="cast">
                                                </div>
                                                <div class="movie-review-info">
                                                    <span class="reply-date">{{ $review->feed_back_created_at }}</span>
                                                    <h6 class="subtitle">{{ $review->user_name }}</h6>
                                                    <span><i class="fas fa-check"></i>Đánh giá được xác minh</span>
                                                </div>
                                            </div>
                                            <div class="movie-review-content">
                                                <div class="review">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <span class="rating"
                                                                  style="font-size: 25px; margin: 0 2px; color: #ffcc00">&#9733;</span>
                                                        @else
                                                            <span class="rating"
                                                                  style="font-size: 25px; margin: 0 2px; color: #ccc">&#9733;</span>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <h6 class="cont-title">{{ $review->message }}</h6>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="load-more text-center">
                                        <a href="#0" class="custom-button transparent">Xem thêm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            var selectedRating = 0;
            // Kiểm tra xem đã có xếp hạng từ trước không
            var initialRating = $('.rating-it.highlight').length;
            $('.rating-it').mouseenter(function () {
                var rating = $(this).data('rating');
                highlightStars(rating);
            });
            $('.rating-it').mouseleave(function () {
                if (selectedRating === 0) {
                    resetStars();
                }
            });
            $('.rating-it').click(function () {
                var rating = $(this).data('rating');
                var movieId = $(this).data('movie-id');
                selectedRating = rating;
                sendRating(rating, movieId);
            });

            function highlightStars(rating) {
                $('.rating-it').css('color', '#ccc');
                $('.rating-it').each(function (index) {
                    if (index < rating) {
                        $(this).css('color', '#ffcc00');
                    }
                });
            }

            if (initialRating > 0) {
                highlightStars(initialRating);
                $('.rating-it').unbind('mouseenter mouseleave');
            }

            function resetStars() {
                $('.rating-it').css('color', '#ccc');
                $('.rating-it').each(function (index) {
                    if (index < selectedRating) {
                        $(this).css('color', '#ffcc00');
                    }
                });
            }

            function sendMessage(rating) {
                $('#submitComment').on('click', function () {
                    var movieId = $('#movieID').text(); // hoặc .html()
                    movieId = parseInt(movieId);
                    var message = ($('#message').val() === '') ? null : $('#message').val();
                    $.ajax({
                        type: 'POST',
                        url: '/submit-message', // Thay đổi route tùy thuộc vào tên route của bạn
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "message": message,
                            'movie_id': movieId,
                            'rating': $('.rating-it.highlight').length
                        },
                        success: function(response) {
                            if (response.message) {
                                Swal.fire({
                                    title: 'Bình luận thành công',
                                    text: response.message,
                                    icon: 'success',
                                    cancelButtonText: 'Đóng',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#review-message").hide();
                                    }
                                });
                            }
                        },
                        error: function(error) {
                            if (error.responseJSON && error.responseJSON.messageNotNull) {
                                Swal.fire({
                                    title: 'Đánh giá thất bại',
                                    text: error.responseJSON.messageNotNull,
                                    icon: 'warning',
                                    cancelButtonText: 'Đóng',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // resetStars();
                                    }
                                });
                            }
                        }
                    });
                });
            }

            sendMessage(initialRating);

            function sendRating(rating, movie_id) {
                $.ajax({
                    type: 'POST',
                    url: '/submit-rating',
                    data: {
                        rating: rating,
                        movie_id: movie_id,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        if (response.messageSuccess) {
                            Swal.fire({
                                title: 'Đánh giá thành công',
                                text: response.messageSuccess,
                                icon: 'success',
                                cancelButtonText: 'Đóng',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    highlightStars(response.rating);
                                    initialRating = response.rating;
                                    $('.rating-it').unbind('mouseenter mouseleave');
                                }
                            });
                        }
                    },
                    error: function (xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.messageOver) {
                            Swal.fire({
                                title: 'Đánh giá thất bại',
                                text: xhr.responseJSON.messageOver,
                                icon: 'warning',
                                cancelButtonText: 'Đóng',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // resetStars();
                                }
                            });
                        }

                        if (xhr.responseJSON && xhr.responseJSON.messageBookingMovie) {
                            Swal.fire({
                                title: 'Đánh giá thất bại',
                                text: xhr.responseJSON.messageBookingMovie,
                                icon: 'warning',
                                cancelButtonText: 'Đóng',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    resetStars();
                                    $('.rating-it').css('color', '#ccc');
                                }
                            });
                        }
                        if (xhr.responseJSON && xhr.responseJSON.messageEnough) {
                            Swal.fire({
                                title: 'Đánh giá thất bại',
                                text: xhr.responseJSON.messageEnough,
                                icon: 'warning',
                                cancelButtonText: 'Đóng',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    resetStars();
                                }
                            });
                        }
                    },
                });
            }
        });

    </script>

@endpush
