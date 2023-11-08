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
        <table class="table table-striped table-dark table-bordered" id="history-table">
            <thead>
                <td>Tên phim</td>
                <td>Thời gian mua</td>
                <td>Giá vé</td>
                <td>số lượng vé</td>
                <td>dịch vụ đi kèm</td>
                <td>tổng tiền</td>
            </thead>
        </table>
    </div>
</section>
@endsection