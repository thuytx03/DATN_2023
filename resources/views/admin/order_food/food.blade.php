@extends('layouts.admin')
@section('title')
Thông tin chi tiết đơn hàng
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Thông tin chi tiết đơn hàng</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col text-right">
                </div>
            </div>
            <div class="col">
                <a href="{{ route('food.list') }}" class="btn btn-success">
                    Danh sách
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered text-center mt-2" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th scope="col">Tên món ăn</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Số lượng</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($orderDetails as $orderDetails)
                                    <tr>
                                        <td>{{$orderDetails->name}}</td>
                                        <td>{{$orderDetails->price}}</td>
                                        <td><img src="{{ $orderDetails->image ? Storage::url($orderDetails->image) : asset('images/image-not-found.jpg') }}" alt="" width="80px"></td>
                                        <td>{{$orderDetails->quantity}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection