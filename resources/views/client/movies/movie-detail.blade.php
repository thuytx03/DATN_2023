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
    {{--    @push('styles')--}}

    {{--    @endpush--}}
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
                                <i class="fas fa-calendar-alt"></i><span>{{ substr($movie->start_date, 0, 10) }}</span>
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
                                    Đánh giá phim
                                </li>
                            </ul>
                            <div class="tab-area">
                                <div class="tab-item">
                                    <div class="item">
                                        <h5 class="sub-title">Mô tả phim</h5>
                                        <p>{{ $movie->description }}</p>
                                    </div>
                                </div>
                                <div class="tab-item active">
                                    @if(auth()->check() && $canUserReviewMovie)
                                        <div class="container mb-4 ml-2">
                                            <div class="item" id="item-star">
                                                <div class="item-header">
                                                    <div class="d-flex align-items-center">
                                                        <div class="m-2" style="font-size: 18px">Đánh giá phim :</div>
                                                        <div class="rate-it list-inline d-flex" style="cursor: pointer">
                                                            @for ($count = 1; $count <= 5; $count++)
                                                                <span
                                                                    class="rating-it"
                                                                    data-rating="{{ $count }}"
                                                                    data-movie-id="{{ $movie->id }}"
                                                                    style="font-size: 30px; margin: 0 4px">&#9733;</span>
                                                                @if($count == 1)
                                                                    <span style="display: none"
                                                                          id="movieID">{{ $movie->id }}</span>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <button class="btn btn-info" type="submit" id="submitComment">Đánh
                                                        giá
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @foreach($reviews as $review)
                                        <div class="movie-review-item d-flex flex-wrap">
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
                                                <div class="review d-flex">
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
{{--                                    <div class="load-more text-center">--}}
{{--                                        <a href="#0" class="custom-button transparent">Xem thêm</a>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            $(document).ready(function () {
                let selectedRating = 0;
                const stars = document.querySelectorAll('.rating-it');
                // Get the rating from the last highlighted star
                for (const star of stars) {
                    star.classList.add('highlight');

                    star.addEventListener('click', () => {
                        selectedRating = parseInt(star.getAttribute('data-rating'));

                        // Remove the 'highlight' class from all stars
                        for (const star of stars) {
                            star.classList.remove('highlight');
                        }

                        // Add the 'highlight' class to the clicked star and all preceding stars
                        for (let i = 1; i <= selectedRating; i++) {
                            const currentStar = stars[i - 1];
                            currentStar.classList.add('highlight');
                        }
                    });
                }
                const movieID = $('#movieID').text();

                // Handle the click event on the submit button
                $('#submitComment').click(function (event) {
                    event.preventDefault();
                    // Get the rating and message values
                    const rating = document.querySelectorAll('.rating-it.highlight').length;
                    const message = $('#message').val();
                    // Send the data to the server using AJAX
                    $.ajax({
                        url: '/submit-message-rating',
                        method: 'POST',
                        data: {
                            movie_id: movieID,
                            rating: rating,
                            message: message,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            if (response.message) {
                                toastr.success(response.message,'Thành công !')
                            }
                            if(response.messageError) {
                                toastr.error(response.messageError,'Thất bại !')
                            }
                        },
                        error: function (error) {

                            toastr.error(error.responseJSON.message, 'Thất bại !');
                        }
                    });
                });
            });
        });

    </script>

@endpush
