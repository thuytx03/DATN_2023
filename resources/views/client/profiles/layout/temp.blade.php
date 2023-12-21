@extends('layouts.client')
@section('content')
<style>
    #profile_cont {
        background-color: #032055;
        height:100%;
        margin-top: 150px;
        padding-top: 20px;
        margin-bottom: 40px;
        padding-bottom: 50px;
    }

    #left-col {
        margin-top: 40px;
        background-color: #001232;
        height: 400px;
        margin-left: 20px;
        padding-top: 20px;

    }
    #left-col a{
        margin: 10px 20px;
        color: white;
    }
    #left-col a:hover{
        color: #032055;
    }
    #right-col {
        /*   */
        height: 800px;
        margin-left: 20px;

    }
    #image{
        width: 70px;
    }
</style>
<section>
    <div class="container" id="profile_cont">
        @yield('title')
        <div class="row">
            <div class="col-3 d-flex flex-column" id="left-col">
                <a href="{{route('profile')}}">Thông tin chung</a>
                <a href="{{route('profile.edit')}}">Chi tiết tài khoản</a>
                <a href="{{route('profile.changePassword')}}">Đổi mật khẩu</a>

                <a href="{{route('profile.history')}}">Lịch sử giao dịch</a>
                <a href="{{route('profile.points')}}">Điểm Thưởng</a>
                <a href="{{route('profile.member')}}">Thẻ Thành Viên</a>


            </div>
            <div class="col-8" id="right-col">
                @yield('profile')
            </div>
        </div>
    </div>
</section>
@endsection
