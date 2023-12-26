@extends('layouts.admin')
@push('styles')
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
@endpush
@section('title')
    Thùng rác hoá đơn vé
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thùng rác hoá đơn vé</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <a href="{{ route('booking.index') }}" class="btn btn-success">
                            Danh sách
                        </a>
                    </div>
                    <div class="col text-right">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-expanded="false">
                                Hành động
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" id="restore-selected" >Khôi phục mục đã chọn</a>
                                <a href="#" id="delete-selected" class="dropdown-item">Xoá vĩnh viễn các mục đã chọn</a>
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
                                <form action="{{ route('booking.trash') }}" method="get">
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
                                                {!! \Illuminate\Support\Str::limit(strip_tags($value->list_seat), 20) !!}
                                            </td>


                                            <td>{{ $value->showtime->start_date }}</td>
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


                                        </tr>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">


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
                            text: 'Bạn có chắc chắn muốn xóa vĩnh viễn các mục đã chọn?',
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
                                    url: '/admin/booking/permanentlyDeleteSelected', // Thay thế bằng tuyến đường xử lý xoá của bạn
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
        function restoreSelected() {
            $(document).ready(function() {
                $('#restore-selected').click(function(e) {
                    e.preventDefault();

                    var selectedCheckboxes = $('.child-checkbox:checked');

                    if (selectedCheckboxes.length > 0) {
                        Swal.fire({
                            title: 'Xác nhận khôi phục',
                            text: 'Bạn có chắc chắn muốn khôi phục các mục đã chọn?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Khôi phục',
                            cancelButtonText: 'Hủy',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var selectedIds = [];
                                selectedCheckboxes.each(function() {
                                    selectedIds.push($(this).val());
                                });

                                $.ajax({
                                    type: 'POST',
                                    url: '/admin/booking/restoreSelected',
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
        restoreSelected();
    </script>
@endpush
