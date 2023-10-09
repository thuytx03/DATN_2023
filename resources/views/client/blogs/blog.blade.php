@extends('layouts.client')
@section('content')
   <!-- ==========Banner-Section========== -->
   <section class="main-page-header speaker-banner bg_img" data-background="./assets/images/banner/banner07.jpg">
        <div class="container">
            <div class="speaker-banner-content">
                <h2 class="title">blog - 01</h2>
                <ul class="breadcrumb">
                    <li>
                        <a href="index.html">
                            Home
                        </a>
                    </li>
                    <li>
                        blog
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Blog-Section========== -->
    <section class="blog-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 mb-50 mb-lg-0">
                    <article>
                        <div class="post-item">
                            <div class="post-thumb">
                                <a href="blog-details.html">
                                    <img src=" {{asset('client/assets/images/blog/blog01.jpg')}}" alt="blog">
                                </a>
                            </div>
                            <div class="post-content">
                                <div class="post-header">
                                    <h4 class="title">
                                        <a href="blog-details.html">
                                            Increase Event Ticket Sales For Film Production With the Right Advertising
                                            Strategies
                                        </a>
                                    </h4>
                                    <div class="meta-post">
                                        
                                        <a href="#0" class="mr-4"><i class="fa-regular fa-comment"></i>20 Comments</a>
                                        <a href="#0"><i class="fa-regular fa-eye"></i>466 View</a>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac cursus
                                        leo. Nullam dolor nunc, hendrerit non velit id, pharetra viverra elit.
                                    </p>
                                </div>
                                <div class="entry-content">
                                    <div class="left">
                                        <span class="date">Dece 15, 2020 BY </span>
                                        <div class="authors">
                                            <div class="thumb">
                                                <a href="#0"><img src="{{asset('client/assets/images/blog/author.jpg')}}" alt="#0"></a>
                                            </div>
                                            <h6 class="title"><a href="#0">Alvin Mcdaniel</a></h6>
                                        </div>
                                    </div>
                                    <a href="#0" class="buttons">Read More <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="post-item">
                            <div class="post-thumb">
                                <div class="owl-carousel owl-theme blog-slider">
                                    <img src="{{asset('client/assets/images/blog/blog02.jpg')}}" alt="blog">
                                    <img src="{{asset('client/assets/images/blog/blog03.jpg')}}" alt="blog">
                                    <img src="{{asset('client/assets/images/blog/blog04.jpg')}}" alt="blog">
                                    <img src="{{asset('client/assets/images/blog/blog01.jpg')}}" alt="blog">
                                </div>
                                <div class="blog-prev">
                                    <!-- <i class="flaticon-double-right-arrows-angles"></i> -->
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                                <div class="blog-next active">
                                    <!-- <i class="flaticon-double-right-arrows-angles"></i> -->
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="post-content">
                                <div class="post-header">
                                    <h4 class="title">
                                        <a href="blog-details.html">
                                            Factors To Take Into Consideration When You Want To Buy Tickets Online
                                        </a>
                                    </h4>
                                    <div class="meta-post">
                                        <a href="#0" class="mr-4"><i class="fa-regular fa-comment"></i>20 Comments</a>
                                        <a href="#0"><i class="fa-regular fa-eye"></i>466 View</a>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac cursus
                                        leo. Nullam dolor nunc, hendrerit non velit id, pharetra viverra elit.
                                    </p>
                                </div>
                                <div class="entry-content">
                                    <div class="left">
                                        <span class="date">Dece 15, 2020 BY </span>
                                        <div class="authors">
                                            <div class="thumb">
                                                <a href="#0"><img src="{{asset('client/assets/images/blog/author.jpg')}}" alt="#0"></a>
                                            </div>
                                            <h6 class="title"><a href="#0">Alvin Mcdaniel</a></h6>
                                        </div>
                                    </div>
                                    <a href="#0" class="buttons">Read More <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="post-item">
                            <div class="post-thumb">
                                <img src="{{asset('client/assets/images/blog/blog03.jpg')}}" alt="blog">
                                <a href="https://www.youtube.com/embed/GT6-H4BRyqQ" class="video-button video-popup">
                                    <i class="flaticon-play-button"></i>
                                </a>
                            </div>
                            <div class="post-content">
                                <div class="post-header">
                                    <h4 class="title">
                                        <a href="blog-details.html">
                                            Movie Ticket Prices: One Size Fits All? It's Time to Experiment
                                        </a>
                                    </h4>
                                    <div class="meta-post">
                                        <a href="#0" class="mr-4"><i class="fa-regular fa-comment"></i>20 Comments</a>
                                        <a href="#0"><i class="fa-regular fa-eye"></i>466 View</a>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac cursus
                                        leo. Nullam dolor nunc, hendrerit non velit id, pharetra viverra elit.
                                    </p>
                                </div>
                                <div class="entry-content">
                                    <div class="left">
                                        <span class="date">Dece 15, 2020 BY </span>
                                        <div class="authors">
                                            <div class="thumb">
                                                <a href="#0"><img src="{{asset('client/assets/images/blog/author.jpg')}}" alt="#0"></a>
                                            </div>
                                            <h6 class="title"><a href="#0">Alvin Mcdaniel</a></h6>
                                        </div>
                                    </div>
                                    <a href="#0" class="buttons">Read More <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="post-item">
                            <div class="post-thumb">
                                <a href="blog-details.html">
                                    <img src="{{asset('client/assets/images/blog/blog04.jpg')}}" alt="blog">
                                </a>
                            </div>
                            <div class="post-content">
                                <div class="post-header">
                                    <h4 class="title">
                                        <a href="blog-details.html">
                                            Movie Ticket Prices: One Size Fits All? It's Time to Experiment
                                        </a>
                                    </h4>
                                    <div class="meta-post">
                                        <a href="#0" class="mr-4"><i class="fa-regular fa-comment"></i>20 Comments</a>
                                        <a href="#0"><i class="fa-regular fa-eye"></i>466 View</a>
                                    </div>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac cursus
                                        leo. Nullam dolor nunc, hendrerit non velit id, pharetra viverra elit.
                                    </p>
                                </div>
                                <div class="entry-content">
                                    <div class="left">
                                        <span class="date">Dece 15, 2020 BY </span>
                                        <div class="authors">
                                            <div class="thumb">
                                                <a href="#0"><img src="{{asset('client/assets/images/blog/author.jpg')}}" alt="#0"></a>
                                            </div>
                                            <h6 class="title"><a href="#0">Alvin Mcdaniel</a></h6>
                                        </div>
                                    </div>
                                    <a href="#0" class="buttons">Read More <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </article>
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
                <div class="col-lg-4 col-sm-10 col-md-8">
                    <aside>
                        <div class="widget widget-search">
                            <h5 class="title">search</h5>
                            <form class="search-form">
                                <input type="text" placeholder="Enter your Search Content" required>
                                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i>Search</button>
                            </form>
                        </div>
                        <div class="widget widget-post">
                            <h5 class="title">latest post</h5>
                            <div class="slider-nav">
                                <span class="fa-solid fa-arrow-left widget-prev"></span>
                                <span class="fa-solid fa-arrow-right widget-next active"></span>
                            </div>
                            <div class="widget-slider owl-carousel owl-theme">
                                <div class="item">
                                    <div class="thumb">
                                        <a href="#0">
                                            <img src=" {{asset('client/assets/images/blog/slider01.jpg')}}" alt="blog">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h6 class="p-title">
                                            <a href="#0">Three Ways to Book Sporting Event Tickets</a>
                                        </h6>
                                        <div class="meta-post">
                                            <a href="#0" class="mr-4"><i class="fa-regular fa-comment"></i>20 Comments</a>
                                            <a href="#0"><i class="fa-regular fa-eye"></i>466 View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="thumb">
                                        <a href="#0">
                                            <img src=" {{asset('client/assets/images/blog/slider01.jpg')}}" alt="blog">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h6 class="p-title">
                                            <a href="#0">Three Ways to Book Sporting Event Tickets</a>
                                        </h6>
                                        <div class="meta-post">
                                            <a href="#0" class="mr-4"><i class="fa-regular fa-comment"></i>20 Comments</a>
                                            <a href="#0"><i class="fa-regular fa-eye"></i>466 View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget widget-follow">
                            <h5 class="title">Follow Us</h5>
                            <ul class="social-icons">
                                <li>
                                    <a href="#0" class="">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0" class="active">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0" class="">
                                        <i class="fab fa-pinterest-p"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <i class="fab fa-google"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget-categories">
                            <h5 class="title">categories</h5>
                            <ul>
                                <li>
                                    <a href="#0">
                                        <span>Showtimes & Tickets</span><span>50</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>Latest Trailers</span><span>43</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>Coming Soon </span><span>34</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>In Theaters</span><span>63</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>Release Calendar </span><span>11</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>Stars</span><span>30</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#0">
                                        <span>Horror Movie </span><span>55</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget-tags">
                            <h5 class="title">featured tags</h5>
                            <ul>
                                <li>
                                    <a href="#0">creative</a>
                                </li>
                                <li>
                                    <a href="#0">design</a>
                                </li>
                                <li>
                                    <a href="#0">skill</a>
                                </li>
                                <li>
                                    <a href="#0">template</a>
                                </li>
                                <li>
                                    <a href="#0" class="active">landing</a>
                                </li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Blog-Section========== -->
@endsection