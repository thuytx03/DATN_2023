<style>
    .dropdown-toggle::after {
        display: none;
    }
</style>
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
        <div class="header-wrapper row">
            <div class="logo">
                <a href="{{ route('index') }}">
                    <img src=" {{asset('client/assets/images/logo/logo.png')}}" alt="logo">
                </a>
            </div>
            <ul class="menu mx-auto">
                <li>
                    <a href="{{ route('index') }}" class="active">Trang chủ</a>

                </li>
                <li>
                    <a href="#0">Phim</a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('phim.danh-sach') }}">Danh sách phim</a>
                        </li>

                        <li>
                            <a href="{{route('home.favorite.list')}}">Phim Yêu Thích</a>
                        </li>


                    </ul>
                </li>

                <li>
                    <a href="{{ route('food') }}">Đồ ăn</a>

                </li>
                <li>
                    <a href="#0">Mã Giảm Giá</a>
                    <ul class="submenu">
                        <li>
                            <a href="{{route('home.voucher.list')}}">Danh Sách Mã Giảm Giá</a>
                        </li>
                        <li>
                            <a href="{{route('doi-diem')}}">Đổi điểm</a>
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
                    <a href="{{ route('contact') }}">Liên hệ</a>
                </li>
                @guest
                <li class="header-button ">
                    <a class="" style="padding: 10px 20px;" href="{{ route('login') }}">Đăng nhập</a>
                </li>
                @else

                <li>
                    <a class="nav-link dropdown-toggle" style="margin-top: 3px; " href="{{route('profile')}}" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2">{{ Auth::user()->name }}</span>
                        <img width="50px" class="img-profile rounded-circle" src="{{ (Auth::user()->avatar == null) ? asset('admin/img/undraw_profile_1.svg') : Storage::url(Auth::user()->avatar) }}">
                    </a>
                    <!-- Dropdown - User Information -->
                    <ul class="submenu">
                        <li><a href="{{route('profile')}}">Thông tin cá nhân</a></li>
                        <li><a href="{{route('profile.changePassword')}}">Đổi mật khẩu</a></li>
                        <li><a href="{{route('logout')}}">Đăng xuất</a></li>
                    </ul>
                </li>

                @endif
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
