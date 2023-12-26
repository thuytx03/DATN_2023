<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.user') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @role('Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh')
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('dashboard.user') }}">
            <i class="fa-solid fa-user"></i>
            <span>Thống kê</span>
        </a>
    </li>
    @endrole
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Quản lý
    </div>
    @role('Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh|Staff-Qr-HaNoi|Staff-Qr-HaiPhong|Staff-Qr-ThaiBinh|Staff-Qr-NamDinh|Staff-Qr-NinhBinh')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#qr" aria-expanded="true" aria-controls="qr">
            <i class="fa fa-qrcode" aria-hidden="true"></i>
            <span>Quét QR </span>
        </a>
        <div id="qr" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('qr.scanner') }}">Quét Mã Cho Khách </a>
            </div>
        </div>
    </li>
    @endrole
    @role('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwosss" aria-expanded="true" aria-controls="collapseTwosss">
            <i class="fa-solid fa-location-pin"></i>
            <span>Quản lý rạp phim</span>
        </a>
        <div id="collapseTwosss" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('cinema.index') }}">Danh sách rạp phim</a>
                <a class="collapse-item" href="{{ route('province.index') }}">Danh sách khu vực</a>
                <!-- link -->
            </div>
        </div>
    </li>
    @endrole
    <!-- Nav Item - Pages Collapse Menu -->
    @role('Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room" aria-expanded="true" aria-controls="room">
            <i class="fa-solid fa-archway"></i>
            <span>Quản lý phòng</span>
        </a>
        <div id="room" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('room.list') }}">Quản lý phòng</a>
                @role('Admin')
                <a class="collapse-item" href="{{ route('room-type.list') }}">Quản lý loại phòng</a>
                @endrole
            </div>
        </div>
    </li>
    @endrole
    @role('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#order" aria-expanded="true" aria-controls="order">
            <i class="fa-solid fa-archway"></i>
            <span>Quản lý đơn đặt đồ ăn</span>
        </a>
        <div id="order" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('food.list') }}">Quản lý đặt đồ ăn</a>
            </div>
        </div>
    </li>
    @endrole
    @role('Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh|Staff-Booking-HaNoi|Staff-Booking-HaiPhong|Staff-Booking-ThaiBinh|Staff-Booking-NamDinh|Staff-Booking-NinhBinh')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#orderTicker" aria-expanded="true" aria-controls="orderTicker">
            <i class="fa-solid fa-ticket"></i>
            <span>Quản lý đơn đặt vé</span>
        </a>
        <div id="orderTicker" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('booking.index') }}">Quản lý đặt vé</a>
            </div>
        </div>
    </li>
    @endrole
    @role('Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh')
    <li class="nav-item">

        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
            <i class="fa-solid fa-file"></i>
            <span>Quản lý lịch chiếu</span>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('show-time.index') }}">Danh sách lịch chiếu</a>
                <!-- link -->
            </div>
        </div>
    </li>
    @endrole
    @role('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#movie" aria-expanded="true" aria-controls="movie">
            <i class="fa-solid fa-film"></i>
            <span>Quản lý phim</span>
        </a>
        <div id="movie" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('genre.index') }}">Thể loại Phim</a>
                <!-- link -->
                <a class="collapse-item" href="{{ route('movie.index') }}">Danh sách Phim</a>
                <a class="collapse-item" href="{{ route('feed-back.index') }}">Đánh giá phim</a>
            </div>
        </div>
    </li>
    @endrole
    @role('Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#seat" aria-expanded="true" aria-controls="seat">
            <i class="fa-solid fa-chair"></i>

            <span>Quản lý ghế</span>
        </a>
        <div id="seat" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @role('Admin')
                <a class="collapse-item" href="{{ route('seat-type.index') }}">Danh sách loại ghế</a>
                @endrole
                <!-- link -->
                <a class="collapse-item" href="{{ route('seat.index') }}">Danh sách ghế</a>
            </div>
        </div>
    </li>
    @endrole
    @role('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#magiamgia" aria-expanded="false" aria-controls="magiamgia">

            <i class="fa-solid fa-ticket"></i>
            <span>Quản lý mã giảm giá</span>
        </a>
        <div id="magiamgia" class="collapse" aria-labelledby="headingVoucher" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('voucher.index') }}">Danh sách mã giảm giá</a>
            </div>
        </div>
    </li>
    @endrole
    @role('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">

            <i class="fa-solid fa-blog"></i>

            <span>Quản lý bài viết</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingPost" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('post-type.index') }}">Danh mục bài viết</a>
                <a class="collapse-item" href="{{ route('post.index') }}">Bài viết</a>
                <a class="collapse-item" href="{{ route('comment.index') }}">Bình luận bài viết</a>
                <a class="collapse-item" href="{{ route('reply.index') }}"> Trả lời bình luận </a>
            </div>
        </div>
    </li>
    @endrole
    @role('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#monan" aria-expanded="flase" aria-controls="monan">
            <i class="fa-solid fa-bell-concierge"></i>
            <span>Quản lý món ăn</span>
        </a>
        <div id="monan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('food_types.index') }}">Danh mục món ăn</a>
                <a class="collapse-item" href="{{ route('movie-foode.index') }}"> Danh sách món ăn</a>
            </div>
            @endrole
    </li>
    @role('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#country" aria-expanded="true" aria-controls="country">
            <i class="fas fa-film"></i>
            <span>Quản lý quốc gia</span>
        </a>
        <div id="country" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('country.index') }}">Danh sách quốc gia</a>
                <!-- link -->
            </div>
        </div>
    </li>
    @endrole
    @role('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#mailbox" aria-expanded="true" aria-controls="mailbox">
            <i class="fas fa-film"></i>
            <span>Quản lý hòm thư</span>
        </a>
        <div id="mailbox" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('contact.index') }}">Danh sách hòm thư</a>
                <!-- link -->
            </div>
        </div>
    </li>
    @endrole
    <!-- logo -->
    @role('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#logo-slider" aria-expanded="true" aria-controls="logo-slider">

            <i class="fa-solid fa-sliders"></i>
            <span>Logo & Slider</span>

        </a>
        <div id="logo-slider" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('logo.edit', 1) }}">Logo</a>
                <a class="collapse-item" href="{{ route('slider.index') }}">Slider</a>

            </div>
        </div>
    </li>
    @endrole
    <!-- end logo -->
    @role('Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoabc" aria-expanded="true" aria-controls="collapseTwoabc">
            <i class="fa-solid fa-user"></i>
            <span>Quản lý người dùng</span>
        </a>
        <div id="collapseTwoabc" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('user.index') }}">Danh sách người dùng</a>
                <a class="collapse-item" href="{{ route('role.list') }}">Quản lý vai trò</a>
                @role('Admin')
                <a class="collapse-item" href="{{ route('permission.list') }}">Quản lý quyền</a>
                <!-- link -->
                @endrole
            </div>
        </div>
    </li>
    @endrole
    @role('Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#MBSL" aria-expanded="true" aria-controls="MBSL">
            <i class="fa-solid fa-person-arrow-up-from-line"></i>
            <span>Quản lý hội viên </span>
        </a>
        <div id="MBSL" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('MBSL.list') }}">Quản lý cấp độ </a>
                <a class="collapse-item" href="{{route('member.list')}}">Quản lý điểm thưởng </a>
            </div>
        </div>
    </li>
    @endrole
</ul>