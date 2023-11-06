    <!-- ==========Preloader========== -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ==========Preloader========== -->
    <!-- ==========Overlay========== -->
    <div class="overlay"></div>
    <a href="#0" class="scrollToTop">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- ==========Overlay========== -->

    <!-- ==========Header-Section========== -->
    <header class="header-section">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="{{ route('index') }}">
                        <img src=" {{asset('client/assets/images/logo/logo.png')}}" alt="logo">
                    </a>
                </div>
                <ul class="menu">
                    <li>
                        <a href="#0" class="active">Home</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('index') }}">Home One</a>
                            </li>
                            <li>
                                <a href="#0" class="active">Home Two</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">Phim</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('phim.danh-sach') }}">Danh sách phim</a>
                            </li>
                            <li>
                                <a href="movie-details-2.html">Movie Details 2</a>
                            </li>
                            <li>
                                <a href="{{route('home.favorite.list')}}">Phim Yêu Thích</a>
                            </li>
                            <li>
                                <a href="">Movie Ticket Plan</a>
                            </li>
                            <li>
                                <a href="">Movie Seat Plan</a>
                            </li>
                            <li>
                                <a href="">Movie Checkout</a>
                            </li>
                            <li>
                                <a href="{{ route('food') }}">Movie Food</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">events</a>
                        <ul class="submenu">
                            <li>
                                <a href="events.html">Events</a>
                            </li>
                            <li>
                                <a href="event-details.html">Event Details</a>
                            </li>
                            <li>
                                <a href="event-speaker.html">Event Speaker</a>
                            </li>
                            <li>
                                <a href="event-ticket.html">Event Ticket</a>
                            </li>
                            <li>
                                <a href="event-checkout.html">Event Checkout</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">Mã Giảm Giá</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('home.voucher.list')}}">Danh Sách Mã Giảm Giá</a>
                            </li>

                        </ul>
                    </li>
                    <li>
                        <a href="#0">pages</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('about-us') }}">About Us</a>
                            </li>
                            <li>
                                <a href="apps-download.html">Apps Download</a>
                            </li>
                            <li>
                                <a href="sign-in.html">Sign In</a>
                            </li>
                            <li>
                                <a href="sign-up.html">Sign Up</a>
                            </li>
                            <li>
                                <a href="404.html">404</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">Bài Viết</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('blog') }}">Bài Viết</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">contact</a>
                    </li>
                    <li class="header-button pr-0">
                        <a href="{{ route('login') }}">join us</a>
                    </li>
                </ul>
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>
    <!-- ==========Header-Section========== -->
