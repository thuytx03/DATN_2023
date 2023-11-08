@extends('client.profiles.layout.temp')
@section('profile')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </div>
    @endif
    <h4>Đổi mật khẩu</h4>
    <form action="{{route('profile.changePassword')}}" method="post">
        @csrf
        <label for="">Mật khẩu cũ</label>
        <input type="password" name="oldPassword">
        <label for="">Mật khẩu mới</label>
        <input type="password" name="password">
        <label for="">Nhập lại mật khẩu</label>
        <input type="password" name="password_confirmation">
        <button type="submit" class="btn btn-success" style="width: 150px; margin-top: 40px; background-image: -webkit-linear-gradient(169deg, #5560ff 17%, #aa52a1 63%, #ff4343 100%);">Đổi mật khẩu</button>
    </form>
</div>

@endsection