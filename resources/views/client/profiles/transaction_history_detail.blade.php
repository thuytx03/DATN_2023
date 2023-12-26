@extends('client.profiles.layout.temp')
@section('profile')
<style>
    #history-table {
        margin-top: 40px;
        background-color: #032055;
        border: white solid;
    }

</style>
<section>
    <div class="row mt-3">
        <p class="col-6">Tên khách hàng: {{ $booking->name }}</p>
        <p class="col-6">Email: {{ $booking->email }}</p>
        <p class="col-6">Số điện thoại: {{ $booking->phone }}</p>
        <p class="col-6">Địa chỉ: {{ $booking->address }}</p>
        <p class="col-6">Thời gian: {{ $booking->created_at }}</p>
        <p class="col-6 ">Phương thức thanh toán:
            {{ $booking->payment == 1 ? 'VNPay' : 'PayPal' }}</p>
        <p class="col-6 ">Trạng thái hoá đơn:
            {{ $booking->status == 2
                ? 'Chờ xác nhận'
                : ($booking->status == 3
                    ? 'Đã xác nhận'
                    : ($booking->status == 4
                        ? 'Đã huỷ'
                        : '')) }}
        </p>
        @if($booking->status== '4')
        <p class="col-6 ">Lý do huỷ:
            {{ $booking->cancel_reason  }}
        </p>
        @endif
    </div>
    <div class="row" id="history">
        <h5 class="mt-4 ml-3">Phim đã đặt</h5>
        <table class="table table-striped table-dark table-bordered" id="history-table">
            <thead>
                <tr>
                    <th>Tên phim</th>
                    <th>Ảnh</th>
                    <th>Danh sách ghế</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $booking->showtime->movie->name }}</td>
                    <td>
                        <img src="{{ Storage::url($booking->showtime->movie->poster) }}" width="50" alt="">
                    </td>
                    <td>
                        {!! implode(', ', json_decode($booking->list_seat, true)) !!}

                    </td>
                    <td>
                        {{ number_format($booking->price_ticket, 0, ',', '.') }} VNĐ

                    </td>
                </tr>
            </tbody>
        </table>

        <h5 class="mt-4 ml-3">Đồ ăn đã đặt</h5>
        <table class="table table-striped table-dark table-bordered" id="history-table">
            <thead>
                <tr>
                    <th>Tên </th>
                    <th>Ảnh</th>
                    <th>Số lượng</th>
                    <th>Giá</th>

                </tr>
            </thead>
            <tbody>
                @foreach($booking_detail as $value)
                <tr>
                    <td>{{ $value->food->name }}</td>
                    <td>
                        <img src="{{ Storage::url($value->food->name) }}" width="50" alt="">
                    </td>
                    <td>
                        {{ $value->quantity }}
                    </td>
                    <td>
                        {{ number_format($value->price, 0, ',', '.') }} VNĐ

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</section>
@endsection
