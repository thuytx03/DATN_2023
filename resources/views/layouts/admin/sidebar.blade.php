<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Quản lý
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#room" aria-expanded="true" aria-controls="room">
            <i class="fas fa-fw fa-folder"></i>
            <span>Quản lý phòng</span>
        </a>
        <div id="room" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('list-room')}}">Quản lý phòng</a>
                <a class="collapse-item" href="{{route('list-room-type')}}">Quản lý loại phòng</a>
            </div>
        </div>
    </li>
    <li class="nav-item">

        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#movie" aria-expanded="true" aria-controls="movie">
            <i class="fas fa-fw fa-cog"></i>
            <span>Quản lý phim</span>
        </a>
        <div id="movie" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('genre.index') }}">Thể loại Phim</a>
                <!-- link -->
                <a class="collapse-item" href="{{ route('movie.index') }}">Danh sách Phim</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#magiamgia" aria-expanded="false" aria-controls="magiamgia">
            <i class="fa-solid fa-ticket"></i>
            <span>Quản lý mã giảm giá</span>
        </a>
        <div id="magiamgia" class="collapse" aria-labelledby="headingVoucher" data-parent="#accordionSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('voucher.index') }}">Danh sách mã giảm giá</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Quản lý bài viết</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingPost" data-parent="#accordionSidebar" style="">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('post-type.index') }}">Danh mục bài viết</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#monan" aria-expanded="flase" aria-controls="monan">
            <i class="fas fa-hamburger"></i>
            <span>Quản lý món ăn</span>
        </a>
        <div id="monan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('food_types.index')}}">Danh mục món ăn</a>
                <a class="collapse-item" href="{{route('movie-foode.index')}}"> Danh sách món ăn</a>
            </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Quản lý user</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('list-user') }}">Danh sách user</a>
                <!-- link -->
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">

            <i class="fas fa-fw fa-folder"></i>
            <span>Quản lý quyền</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">      
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('list-role')}}">Quản lý vai trò</a>
                <a class="collapse-item" href="{{route('list-permission')}}">Quản lý quyền</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Cài đặt hệ thống
    </div>



</ul>
