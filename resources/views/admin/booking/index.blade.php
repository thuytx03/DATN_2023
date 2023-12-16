@extends('layouts.admin')
@push('styles')
<link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
@endpush
@section('title')
Danh sách hoá đơn
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Danh sách hoá đơn </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                {{-- <div class="col">
                        <a href="{{ route('booking.store') }}" class="btn btn-success">
                Thêm mới
                </a>
            </div> --}}
            <div class="col text-right">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        Hành động
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('booking.trash') }}">Thùng rác</a>
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
                        <div class="dataTables_length mr-2" id="dataTable_length"><label>Trạn thái
                                <select name="status" aria-controls="dataTable" class="custom-select custom-select-sm form-control ">
                                    <option value="">Vui lòng chọn</option>
                                    <option value="2">Chờ xác nhận</option>
                                    <option value="3">Đã xác nhận</option>
                                    <option value="4">Đã huỷ</option>
                                </select>
                            </label>
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-6">
                        <form action="{{ route('booking.index') }}" method="get">
                            <div class="row">
                                <div class="dataTables_length mr-2" id="dataTable_length"><label>Lọc
                                        <select name="status" aria-controls="dataTable" class="custom-select custom-select-sm form-control ">
                                            <option value="">Vui lòng chọn</option>
                                            <option value="2">Chờ xác nhận</option>
                                            <option value="3">Đã xác nhận</option>
                                            <option value="4">Đã huỷ</option>
                                        </select>
                                    </label>
                                </div>
                                <div id="dataTable_filter" class="dataTables_filter"><label>
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
                                    <th scope="col">Thông tin khách hàng</th>
                                    <th scope="col">Danh sách ghế</th>
                                    <th scope="col">Lịch chiếu</th>
                                    <th scope="col">Số tiền</th>
                                    <th scope="col">PTTT</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($bookings as $value)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="child-checkbox" name="ids[]" value="{{ $value->id }}">
                                    </td>
                                    <td>
                                        - Họ và tên:{{ $value->name }} <br>
                                        - Email:{{ $value->email }} <br>
                                        - SĐT:{{ $value->phone }} <br>
                                        - Địa chỉ:{{ $value->address }} <br>
                                    </td>
                                    <td>
                                        {!! \Illuminate\Support\Str::limit(implode(', ', json_decode($value->list_seat, true)), 20) !!}
                                    </td>


                                    <td>{{ $value->showtime->start_date  }}</td>
                                    <td> {{ number_format($value->total, 0, ',', '.') }} VNĐ
                                    </td>
                                    <td>{{ $value->payment == 1 ? 'VNPay' : 'Paypal' }}</td>

                                    <td>
                                        {{-- chờ xác nhận, đã xác nhận, đã huỷ --}}
                                        {{ $value->status == 2
                                                        ? 'Chờ xác nhận'
                                                        : ($value->status == 3
                                                            ? 'Đã xác nhận'
                                                            : ($value->status == 4
                                                                ? 'Đã huỷ'
                                                                : '')) }}
                                    </td>

                                    <td>

                                        <div class="dropdown">
                                            <button class="btn " type="button" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                {{-- <a class="dropdown-item"
                                                                href="{{ route('booking.update', ['id' => $value->id]) }}">Sửa</a> --}}
                                                <a class="dropdown-item " href="{{ route('booking.detail', ['id' => $value->id]) }}">Chi
                                                    tiết
                                                </a>
                                                @if ($value->status == 2)
                                                <a class="dropdown-item" href="{{ route('booking.confirm', ['id' => $value->id]) }}">Xác
                                                    nhận
                                                </a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#cancelOrderModal{{ $value->id }}">Huỷ đơn</a>

                                                @elseif($value->status == 3)
                                                <a class="dropdown-item" href="{{ route('booking.unConfirm', ['id' => $value->id]) }}">Chờ
                                                    xác nhận
                                                </a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#cancelOrderModal{{ $value->id }}">Huỷ đơn</a>
                                                @elseif($value->status == 4)
                                                <a class="dropdown-item" href="{{ route('booking.confirm', ['id' => $value->id]) }}">Xác
                                                    nhận
                                                </a>
                                                @endif

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="cancelOrderModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cancelOrderModalLabel">Huỷ đơn vé
                                                </h5>
                                                <button type="button " class="close " style="border:none; background:none" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('booking.cancel', $value->id) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="cancelReason">Lý do huỷ đơn hàng:</label>
                                                        <textarea class="form-control" id="cancelReason" name="cancel_reason" rows="3" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-danger mt-3">Xác
                                                        nhận huỷ đơn hàng</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-5 mb-3
                            ">
                        <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                            Hiển thị {{ $bookings->firstItem() }} đến {{ $bookings->lastItem() }}
                            của {{ $bookings->total() }} mục
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                            <ul class="pagination">
                                {{ $bookings->links('pagination::bootstrap-4') }}
                            </ul>
                        </div>
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



    function deleteSelected() {
        $(document).ready(function() {
            $('#delete-selected').click(function(e) {
                e.preventDefault();

                var selectedCheckboxes = $('.child-checkbox:checked');

                if (selectedCheckboxes.length > 0) {
                    Swal.fire({
                        title: 'Xác nhận xóa',
                        text: 'Bạn có chắc chắn muốn xóa các mục đã chọn?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var selectedIds = [];
                            selectedCheckboxes.each(function() {
                                selectedIds.push($(this).val());
                            });

                            $.ajax({
                                type: 'POST',
                                url: '/admin/booking/deleteAll', // Thay thế bằng tuyến đường xử lý xoá của bạn
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
