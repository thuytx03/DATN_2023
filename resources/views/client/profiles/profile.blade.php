@extends('client.profiles.layout.temp')
@section('profile')
<style>
    #avatar {
        border-radius: 50%;
        width: 150px;
        height: 150px;
    }
    #profile-top {
        margin-left: 40px;
        margin-top: 40px;
    }
    .vertical-hr {
      border-left: 1px solid white;
      height: 200px;
      /* margin-left: 20px;  */
    }
    #profile-info{
        margin-top: 40px;
    }
</style>
<h4>Thông tin chung</h4>
<div class="row" id="profile-top">
    <img src="{{ ($user->avatar == null) ? asset('admin/img/undraw_profile_1.svg') : Storage::url($user->avatar) }}" alt="" srcset="" id="avatar">
    <h4 style="margin: 40px 40px;">Xin chào, {{$user->name}}</h4>

</div>
<div class="row" id="profile-info">
    <div class="col-5">
        <h5>Thông tin cá nhân</h5>
        <br>
        <p>Họ tên: {{$user->name}}</p>
        <p>Email: {{$user->email}}</p>
        <p>Số điện thoại: {{$user->phone}}</p>
        <p>Tổng chi tiêu: </p>
    </div>
    <div class="vertical-hr"></div>
    <div class="col-5">
        <h5>Mã giảm giá</h5>

        <br>
        <p>Vé xem phim: 0 Voucher</p>
        <p>Bỏng nước: 0 Voucher</p>
        <p>Quà tặng: 0 Voucher</p>

    </div>
</div>
@endsection
