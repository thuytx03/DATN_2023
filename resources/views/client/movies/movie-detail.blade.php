@extends('layouts.client')
@section('content')
    <style>
        .abc {
            margin-left: 10px;

        }
    </style>
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
                            <h5 class="title">4.5</h5>
                            <div class="rated">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>
                        <p>Người dùng đánh giá</p>
                    </div>
                    <div class="item">
                        <div class="item-header">
                            <div class="rated rate-it">
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                            </div>
                            <h5 class="title">0.0</h5>
                        </div>
                        <p><a href="#0">Đánh giá phim</a></p>
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
                                    Đánh giá phim <span>147</span>
                                </li>
                            </ul>
                            <div class="tab-area">
                                <div class="tab-item">
                                    <div class="item">
                                        <h5 class="sub-title">Mô tả phim</h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vehicula eros
                                            sit amet est tincidunt aliquet. Fusce laoreet ligula ac ultrices eleifend.
                                            Donec hendrerit fringilla odio, ut feugiat mi convallis nec. Fusce elit ex,
                                            blandit vitae mattis sit amet, iaculis ac elit. Ut diam mauris, viverra sit
                                            amet dictum vel, aliquam ac quam. Ut mi nisl, fringilla sit amet erat et,
                                            convallis porttitor ligula. Sed auctor, orci id luctus venenatis, dui dolor
                                            euismod risus, et pharetra orci lectus quis sapien. Duis blandit ipsum ac
                                            consectetur scelerisque. </p>
                                    </div>
                                    <div class="item">
                                        <div class="header">
                                            <h5 class="sub-title">cast</h5>
                                            <div class="navigation">
                                                <div class="cast-prev"><i
                                                        class="flaticon-double-right-arrows-angles"></i></div>
                                                <div class="cast-next"><i
                                                        class="flaticon-double-right-arrows-angles"></i></div>
                                            </div>
                                        </div>
                                        <div class="casting-slider owl-carousel">
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{asset('assets/images/cast/cast01.jpg')}}"
                                                             alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">Bill Hader</a></h6>
                                                    <span class="cate">actor</span>
                                                    <p>As Richie Tozier</p>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{asset('assets/images/cast/cast02.jpg')}}"
                                                             alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">nora hardy</a></h6>
                                                    <span class="cate">actor</span>
                                                    <p>As raven</p>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{asset('assets/images/cast/cast03.jpg')}}"
                                                             alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">alvin peters</a></h6>
                                                    <span class="cate">actor</span>
                                                    <p>As magneto</p>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{asset('assets/images/cast/cast04.jpg')}}"
                                                             alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">josh potter</a></h6>
                                                    <span class="cate">actor</span>
                                                    <p>As quicksilver</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="header">
                                            <h5 class="sub-title">crew</h5>
                                            <div class="navigation">
                                                <div class="cast-prev-2"><i
                                                        class="flaticon-double-right-arrows-angles"></i></div>
                                                <div class="cast-next-2"><i
                                                        class="flaticon-double-right-arrows-angles"></i></div>
                                            </div>
                                        </div>
                                        <div class="casting-slider-two owl-carousel">
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{asset('assets/images/cast/cast05.jpg')}}"
                                                             alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">pete warren</a></h6>
                                                    <span class="cate">actor</span>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{asset('assets/images/cast/cast06.jpg')}}"
                                                             alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">howard bass</a></h6>
                                                    <span class="cate">executive producer</span>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{asset('assets/images/cast/cast07.jpg')}}"
                                                             alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">naomi smith</a></h6>
                                                    <span class="cate">producer</span>
                                                </div>
                                            </div>
                                            <div class="cast-item">
                                                <div class="cast-thumb">
                                                    <a href="#0">
                                                        <img src="{{asset('assets/images/cast/cast08.jpg')}}"
                                                             alt="cast">
                                                    </a>
                                                </div>
                                                <div class="cast-content">
                                                    <h6 class="cast-title"><a href="#0">tom martinez</a></h6>
                                                    <span class="cate">producer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-item active">
                                    <div class="container">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <input type="text" placeholder="Nhập bình luận về phim ..."
                                                       name="message">
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-info" type="submit">Bình luận</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="movie-review-item">
                                        <div class="author">
                                            <div class="thumb">
                                                <a href="#0">
                                                    <img src="{{asset('assets/images/cast/cast02.jpg')}}" alt="cast">
                                                </a>
                                            </div>
                                            <div class="movie-review-info">
                                                <span class="reply-date">13 ngày trước</span>
                                                <h6 class="subtitle"><a href="#0">Nguyễn Đức Quý</a></h6>
                                                <span><i class="fas fa-check"></i>Đánh giá được xác minh</span>
                                            </div>
                                        </div>
                                        <div class="movie-review-content">
                                            <div class="review" >
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <h6 class="cont-title">Bộ phim trên cả tuyệt vời</h6>
                                        </div>
                                    </div>
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
