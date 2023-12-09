@extends('layouts.admin')
@push('styles')
<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

<style>
    .dropdown-menu a:hover {
        background-color: aquamarine;
        /* Đổi màu khi đưa chuột vào */
        color: #0069d9;
        /* Đổi màu chữ khi đưa chuột vào */
    }
</style>
@endpush
@section('title')
Danh sách đơn đặt đồ ăn
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Danh sách đơn đặt đồ ăn</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col text-right">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            Hành động
                        </button>
                        <div class="dropdown-menu">
                            <a href="#" id="delete-selected" class="dropdown-item">Xoá đã chọn</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="dataTable_length"><label>Hiển thị <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> Mục</label>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <form action="{{route('food.list')}}" method="GET">
                                <div class="row">
                                    <div class="dataTables_length mr-3" id="dataTable_length"><label>Lọc
                                            <select name="status" aria-controls="dataTable" class="custom-select custom-select-sm form-control ">
                                                <option value="">Vui lòng chọn</option>
                                                <option value="1">Chưa xử lý</option>
                                                <option value="2">Đã xác nhận</option>
                                                <option value="3">Đã hủy bỏ</option>
                                                <option value="4">Hoàn thành</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div id="dataTable_filter" class="dataTables_filter">
                                        <label>
                                            <input type="search" name="search" class="form-control form-control-sm" placeholder="" aria-controls="dataTable">
                                            <button class="btn btn-outline-success form-control-sm" type="submit">
                                                Tìm kiếm
                                            </button>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered text-center mt-2" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="">
                                            <input type="checkbox" class="" id="select-all">
                                        </th>
                                        <th scope="col">Id</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Ngày đặt</th>
                                        <th scope="col">Ngày nhận</th>
                                        <th scope="col">Tổng tiền</th>
                                        <th scope="col">Phương thức thanh toán</th>
                                        <th scope="col">Ghi chú</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($orders as $orders)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="child-checkbox" name="ids[]" value="{{$orders->id}}">
                                        </td>
                                        <td>{{$orders->user_id}}</td>
                                        <td>{{$orders->email}}</td>
                                        <td>{{$orders->order_date}}</td>
                                        <td>{{$orders->order_end}}</td>
                                        <td>{{$orders->total_amount}}</td>
                                        <td>
                                            @if($orders->payment_method == 1)
                                            Thanh toán nội địa Vnpay
                                            @elseif($orders->payment_method == 2)
                                            Thanh toán quốc tế Paypal
                                            @endif
                                        </td>
                                        <td>{{$orders->note}}</td>
                                        <td>
                                            <select class="custom-select custom-select-sm form-control switch-status" data-item-id="{{ $orders->id }}">
                                                <option value="1" {{ $orders->status == 1 ? 'selected' : '' }}>Chưa xử lý</option>
                                                <option value="2" {{ $orders->status == 2 ? 'selected' : '' }}>Đã xác nhận</option>
                                                <option value="3" {{ $orders->status == 3 ? 'selected' : '' }}>Đã hủy bỏ</option>
                                                <option value="4" {{ $orders->status == 4 ? 'selected' : '' }}>Hoàn thành</option>
                                            </select>
                                            <div class="cancel-reason mt-2" style="display:none;">
                                                <form class="cancel-form" action="{{ route('food.update',['id'=>$orders->id]) }}" method="POST">
                                                    @csrf
                                                    <input type="text" class="form-control" name="reason" placeholder="Nhập lý do hủy đơn">
                                                    <button class="btn btn-primary mt-2">Xác nhận</button>
                                                </form>
                                            </div>
                                            @if ($orders->status == 3)
                                            <div class="cancel-reason mt-2">
                                                <span class="btn btn-danger">Lý do hủy: {{$orders->reason}}</span>
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn" type="button" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('food.user',['id'=>$orders->id])}}">Thông tin người đặt hàng</a>
                                                    <a class="dropdown-item" href="{{route('food.detail',['id'=>$orders->id])}}">Thông tin đơn hàng</a>
                                                    <a class="dropdown-item show_confirm" href="{{route('food.delete',['id'=>$orders->id])}}">Xoá đơn hàng
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
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
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        var switches = Array.from(document.querySelectorAll('.switch1'));
        switches.forEach(function(elem) {
            new Switchery(elem);
        });
    });
</script>
<script type="text/javascript">
    function alertConfirmation() {
        $('.show_confirm').click(function(event) {
            var href = $(this).attr("href"); // Lấy URL từ thuộc tính href của thẻ <a>
            var name = $(this).data("name");
            event.preventDefault();

            Swal.fire({
                    title: 'Xác nhận xóa',
                    text: 'Bạn có chắc chắn muốn xóa các mục đã chọn?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        // Người dùng đã xác nhận xóa
                        // Chuyển hướng đến URL xóa
                        window.location.href = href;
                    } else {
                        // Người dùng đã bấm nút "Hủy"
                        // Không làm gì cả hoặc có thể xử lý khác nếu cần
                    }
                });
        });
    }


    alertConfirmation();

    function selectAllCheckbox() {
        document.getElementById('select-all').addEventListener('change', function() {
            let checkboxes = document.getElementsByClassName('child-checkbox');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        let childCheckboxes = document.getElementsByClassName('child-checkbox');
        for (let checkbox of childCheckboxes) {
            checkbox.addEventListener('change', function() {
                document.getElementById('select-all').checked = false;
            });
        }
    }
    selectAllCheckbox();

    function updateStatus() {
        $('.switch-status').change(function() {
            const orderId = $(this).data('item-id');
            const status = $(this).val();
            const cancelReasonDiv = $(this).closest('td').find('.cancel-reason');

            if (status == 3) {
                cancelReasonDiv.show();
            } else {
                cancelReasonDiv.hide();
            }

            $.ajax({
                method: 'POST',
                url: '/admin/order/update-status/' + orderId,
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
            });
        });
    }

    updateStatus();




    function deleteSelected() {
        $(document).ready(function() {
            $('#delete-selected').click(function(e) {
                e.preventDefault();

                var selectedCheckboxes = $('.child-checkbox:checked');

                if (selectedCheckboxes.length > 0) {
                    var selectedIds = [];
                    selectedCheckboxes.each(function() {
                        selectedIds.push($(this).val());
                    });

                    Swal.fire({
                        title: 'Xác nhận xóa',
                        text: 'Bạn có chắc chắn muốn xóa các mục đã chọn?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: '/admin/order/deleteAll', // Thay thế bằng tuyến đường xử lý xoá của bạn
                                data: {
                                    ids: selectedIds,
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function(response) {
                                    // Xử lý phản hồi từ máy chủ nếu cần
                                    location.reload();
                                },
                                error: function() {
                                    location.reload();
                                }
                            });
                        }
                    });
                }
            });
        });
    }

    deleteSelected();
</script>
@endpush