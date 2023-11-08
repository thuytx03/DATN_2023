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
    <div class="row" id="history">
        <h4 class="mt-3">Lịch sử giao dịch vé</h4>
        <table class="table table-striped table-dark table-bordered" id="history-table">
            <thead>
                <td>Tên phim</td>
                <td>Thời gian mua</td>
                <td>Số lượng ghế</td>
                <td>Tổng tiền ghế</td>
                <td>Tổng tiền món ăn</td>
                <td>tổng tiền</td>
                <td>Hàng động</td>
            </thead>
            <tbody>
                @foreach($booking as $value)
                <tr>
                    <td>{{ $value->showtime->movie->name }}</td>
                    <td>{{ $value->created_at}}</td>
                    @php
                    $seat = json_decode($value->list_seat);
                    $totalSeat=count($seat);

                    @endphp
                    <td>{{ $totalSeat }}</td>
                    <td>{{ $value->price_ticket }}</td>
                    <td>{{ $value->price_food }}</td>
                    <td>{{ $value->total }}</td>
                    <td><a href="{{ route('transaction.history.detail',['id'=>$value->id]) }}">Chi tiết</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $booking->links() }}
    </div>

</section>
@endsection
