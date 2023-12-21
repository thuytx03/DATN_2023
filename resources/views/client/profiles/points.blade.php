@extends('client.profiles.layout.temp')
@section('profile')
<style>
    form {
        /* margin-top: 20px; */
    }

    label {
        margin-top: 20px;
    }
</style>

@php

$MembershipLevel = $MembershipLevels->firstWhere('id', $members->level_id);
$bookings = $bookings->where('user_id', $members->user_id);

// Khởi tạo biến tổng
$total_point_will_claim = 0;



foreach ($bookings as $booking) {
    $point_will_claim = 0;
    if ($booking->status == 4 && $booking->hasUpdated == 0) {
        $booking->hasUpdated = '1';
    }
    if ($booking->status == 2 || $booking->status == 5 && $booking->hasUpdated == 0 || ($booking->status == 3 && $booking->hasUpdated == 0) || ($booking->status == 4 && $booking->hasUpdated == 0)) {
        if (isset($booking->price_ticket) > 0 && isset($booking->price_food) > 0) {
            $benefit_percentage = $MembershipLevel->benefits / 100;
            $benefit_percentage1 = $MembershipLevel->benefits_food / 100;
            $price_ticket_point = ($booking->price_ticket) * $benefit_percentage;
            $price_ticket_food_point = ($booking->price_food) * $benefit_percentage1;
            $point_will_claim += $price_ticket_point + $price_ticket_food_point;
        } else if (isset($booking->price_ticket) > 0 || isset($booking->price_food)) {
            $benefit_percentage = $MembershipLevel->benefits / 100;
            $price_ticket_point = ($booking->price_ticket) * $benefit_percentage;
            $point_will_claim += $price_ticket_point;
        }

        // Round the $point_will_claim using the provided function
        $point_will_claim = $profile->roundNumber($point_will_claim);

        $total_point_will_claim += $point_will_claim;
    }
}



@endphp
<section>
    <h4 class="mt-2">Điểm Thưởng Của Bạn :</h4>
    <h6 class="mt-2">ĐIỂM CỦA BẠN SẼ ĐƯỢC CỘNG SAU KHI CHÚNG TÔI KIỂM TRA</h6>
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </div>

    @endif
<form action="" method="post" class="" enctype="multipart/form-data">
    @csrf
    <div class="d-flex">
        @if (isset($point_will_claim) > 0)
       <div class="col-5">

        <label for="">Tổng điểm trong năm</label>
        <input type="text" name="name" value="{{ $members->total_bonus_points ?: 'Bạn Chưa Có Giao Dịch ' }}" readonly>
        <label for="">Điểm Bạn Sắp Nhận Được</label>


        <input type="text" name="name" value="{{$total_point_will_claim ?: 'Bạn Chưa có giao dịch ' }}" readonly>


        <label for="">Điểm Hiện Tại</label>
        <input type="text" name="name" value="{{ $members->current_bonus_points ?: 'Bạn Chưa có giao dịch' }}" readonly>
       </div>


        @else
        <div class="col-5">

            <label for="">Tổng điểm trong năm</label>
            <input type="text" name="name" value="{{ $members->total_bonus_points ?: 'Bạn Chưa Có Giao Dịch ' }}" readonly>
            <label for="">Điểm Bạn Sắp Nhận Được</label>
            @if (isset($point_will_claim ))
            <input type="text" name="name" value="{{ $point_will_claim  ?: 'Bạn Chưa có giao dịch ' }}" readonly>
            @else
            <input type="text" name="name" value=" Bạn Chưa có giao dịch " readonly>
            @endif
            <label for="">Điểm Hiện Tại</label>
            <input type="text" name="name" value="{{ $members->current_bonus_points ?: 'Bạn Chưa có giao dịch' }}" readonly>


        </div>
        @endif

    </div>

</form>
@endsection
