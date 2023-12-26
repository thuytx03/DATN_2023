@extends('layouts.admin')
@section('content')
    <div class="col-md-12">
        <div class="card mb-4">
            <h3 class="card-header">Chi tiết hoá đơn</h3>
            <div class="card-body">
                <div class="row">
                    <h5 class="col-6">Tên khách hàng: {{ $booking->name }}</h5>
                    <h5 class="col-6">Email: {{ $booking->email }}</h5>
                    <h5 class="col-6">Số điện thoại: {{ $booking->phone }}</h5>
                    <h5 class="col-6">Địa chỉ: {{ $booking->address }}</h5>
                    <h5 class="col-6">Thời gian: {{ $booking->created_at }}</h5>
                    <h5 class="col-6 text-danger">Phương thức thanh toán:
                        {{ $booking->payment == 1 ? 'VNPay' : 'PayPal' }}</h5>
                    <h5 class="col-6 text-danger">Trạng thái hoá đơn:
                        {{ $booking->status == 2
                            ? 'Chờ xác nhận'
                            : ($booking->status == 3
                                ? 'Đã xác nhận'
                                : ($booking->status == 4
                                    ? 'Đã huỷ'
                                    : '')) }}
                    </h5>
                    @if($booking->status== '4')
                    <h5 class="col-6 text-danger">Lý do huỷ:
                        {{ $booking->cancel_reason  }}
                    </h5>
                    @endif
                </div>
                <h4 class="mt-3 mb-3">Phim đã đặt</h4>
                <div class="table-responsive text-nowrap text-center">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tên phim</th>
                                <th>Ảnh</th>
                                <th>Danh sách ghế</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody class="">

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
                </div>


                <h4 class="mt-3 mb-3">Đồ ăn đã đặt</h4>
                <div class="table-responsive text-nowrap text-center">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tên </th>
                                <th>Ảnh</th>
                                <th>Số lượng</th>
                                <th>Giá</th>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
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
            </div>
        </div>
    </div>
@endsection
