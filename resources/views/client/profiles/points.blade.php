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
<section>
    <h4 class="mt-2">Điểm Thưởng Của Bạn :</h4>
    <h6 class="mt-2">ĐIỂM CỦA BẠN SẼ ĐƯỢC CỘNG SAU KHI KẾT THÚC XUẤT CHIẾU</h6>
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
        @if ($members->bonus_points_will_be_received)
        <div class="col-5">
            @php
            
          
            $MembershipLevel = $MembershipLevels->firstWhere('id', $members->level_id);
            // dd($MembershipLevel);
            $bookingss = $bookings->where('user_id', $members->user_id);
        
            $total_poin_will_claim = 0; // Khởi tạo biến tổng

foreach ($bookingss as $booking) {
    if (isset($booking->price_ticket) && isset($booking->price_food)) {
        $benefit_percentage = $MembershipLevel->benefits / 100;
        $benefit_percentage1 = $MembershipLevel->benefits_food / 100;
        $price_ticket_point = ($booking->price_ticket) * $benefit_percentage;
        $price_ticket_food_point = ($booking->price_food) * $benefit_percentage1;
        $poin_will_claim = $price_ticket_point + $price_ticket_food_point;
    } elseif (isset($booking->price_ticket) || isset($booking->price_food)) {
        $benefit_percentage = $MembershipLevel->benefits / 100;
        $price_ticket_point = ($booking->price_ticket) * $benefit_percentage;
        $poin_will_claim = $price_ticket_point;
    }

   
    $total_poin_will_claim += $poin_will_claim;
}
          
        
       @endphp
          
            <label for="">Điểm Hiện Tại Của Bạn : </label>
          
            <input type="text" name="name"  style="width:500px" value="{{ $members->total_bonus_points ?: 'Điểm sẽ được cập nhật khi phim kết thúc vui lòng đợi' }}" readonly>
            <label for="">Điểm Bạn Sắp Nhận Được :</label>
            @if ($members->total_spending == 0 )
            <input type="text" name="name" style="width:500px" value="{{ $total_poin_will_claim  ?: 'Không có thông tin' }}" readonly>
        @elseif ( $total_poin_will_claim > 0 )
        <input type="text" name="name" style="width:500px" value="{{ $total_poin_will_claim ?: 'Không có thông tin' }}" readonly>
            @php
            $total_poin_will_claim = 0; // Đặt lại biến $total_poin_will_claim thành 0
            @endphp
           
           
        @endif
            <label for="">Tổng Điểm Của Bạn :</label>
            <input type="text" name="name"  style="width:500px" value="{{ $members->current_bonus_points ?: 'Điểm sẽ được cập nhật khi phim kết thúc vui lòng đợi' }}" readonly>

          
        </div>
        @else 
        <div class="col-5">
            <label for="">Điểm Hiện Tại Của Bạn</label>
            <input type="text" name="name" value="{{ $members->total_bonus_points ?: 'Bạn Chưa Có Giao Dịch ' }}" readonly>
            <label for="">Điểm Bạn Sắp Nhận Được</label>
            <input type="text" name="name" value="{{ $members->bonus_points_will_be_received ?: 'Bạn Chưa có giao dịch ' }}" readonly>
            <label for="">Điểm Hiện Tại</label>
            <input type="text" name="name" value="{{ $members->current_bonus_points ?: 'Bạn Chưa có giao dịch' }}" readonly>

          
        </div>
        @endif
     
    </div>
</form>
@endsection