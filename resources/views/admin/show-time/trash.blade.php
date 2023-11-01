@extends('layouts.admin')
@section('title')
    Thùng rác lịch chiếu
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thùng rác lịch chiếu</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('show-time.index') }}">
                            <button class="btn btn-success">Danh sách</button>
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hành động
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" id="restore-selected">Khôi phục mục đã chọn</a>
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
                                <div class="dataTables_length" id="dataTable_length"><label>Hiển thị <select
                                            name="dataTable_length" aria-controls="dataTable"
                                            class="custom-select custom-select-sm form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> Mục</label></div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <form action="{{ route('show-time.trash') }}" method="get">
                                    <div class="row">
                                        <div class="dataTables_length mr-2" id="dataTable_length"><label>Lọc
                                                <select name="status" aria-controls="dataTable"
                                                        class="custom-select custom-select-sm form-control ">
                                                    <option value="all">Tất cả</option>
                                                    <option value="1">Hoạt động</option>
                                                    <option value="0">Không hoạt động</option>
                                                </select>
                                            </label>
                                        </div>
                                        <div id="dataTable_filter" class="dataTables_filter"><label>
                                                {{--                                                <input type="search" name="search" class="form-control form-control-sm"--}}
                                                {{--                                                       placeholder="" aria-controls="dataTable">--}}
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
                                <table class="table table-bordered dataTable no-footer" id="dataTable" width="100%"
                                       cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                       style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th class="pr-2 text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="id: activate to sort column descending" style="width: 5.2px;">
                                            <label>
                                                <input type="checkbox" id="select-all">
                                            </label>
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="Name: activate to sort column ascending"
                                            style="width: 111.2px;">Phòng chiếu
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="Name: activate to sort column ascending"
                                            style="width: 111.2px;">Phim chiếu
                                        </th>

                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="total: activate to sort column ascending"
                                            style="width: 50.2px;">Ngày chiếu
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="ảnh: activate to sort column ascending"
                                            style="width: 50.2px;">Giờ kết thúc
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="ảnh: activate to sort column ascending"
                                            style="width: 50.2px;">Trạng thái
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="action: activate to sort column ascending"
                                            style="width: 60.2px;">Hoạt động
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deleteItems as $showTime)
                                        <tr class="text-center">
                                            <td class="sorting_1 text-center">
                                                <label>
                                                    <input type="checkbox" class="child-checkbox" name="selectedIds"
                                                           value="{{ $showTime->id }}">
                                                </label>
                                            </td>
                                            <td>{{ $showTime->room->name }}</td>
                                            <td>{{ $showTime->movie->name }}</td>
                                            <td >
                                                <small>{{ $showTime->start_date }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $showTime->end_date }}</small>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="{{ $showTime->status }}"
                                                       name="status" data-item-id="{{ $showTime->id }}"
                                                       class="switch1 switch-status switchery-small"
                                                    {{ $showTime->status == 1 ? 'checked' : '' }}/>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <!-- Icon here (e.g., three dots icon) -->
                                                    <i class="fas fa-ellipsis-v p-2" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                           href="{{ route('show-time.restore',['id' => $showTime->id]) }}">Khôi phục mục đã chọn</a>
                                                        <a class="dropdown-item show_confirm"
                                                           href="{{ route('show-time.delete',['id' => $showTime->id]) }}">Xóa vĩnh viễn</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                                                                        Hiển thị {{ $deleteItems->firstItem() }} đến {{ $deleteItems->lastItem() }}
                                                                        của {{ $deleteItems->total() }} mục
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                    <ul class="pagination">
                                                                                {{ $deleteItems->links('pagination::bootstrap-4') }}
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
    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script>
        $(document).ready(function () {
            var switches = Array.from(document.querySelectorAll('.switch1'));
            switches.forEach(function (elem) {
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
                    text: 'Bạn có chắc chắn muốn xóa mục đã chọn?',
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
            document.getElementById('select-all').addEventListener('change', function () {
                let checkboxes = document.getElementsByClassName('child-checkbox');
                for (let checkbox of checkboxes) {
                    checkbox.checked = this.checked;
                }
            });

            let childCheckboxes = document.getElementsByClassName('child-checkbox');
            for (let checkbox of childCheckboxes) {
                checkbox.addEventListener('change', function () {
                    document.getElementById('select-all').checked = false;
                });
            }
        }

        selectAllCheckbox();
        function restoreSelected() {
            $(document).ready(function () {
                $('#restore-selected').click(function (e) {
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
                                selectedCheckboxes.each(function () {
                                    selectedIds.push($(this).val());
                                });

                                $.ajax({
                                    type: 'POST',
                                    url: '/admin/show-time/restoreSelected',
                                    data: {
                                        ids: selectedIds,
                                        _token: '{{ csrf_token() }}',
                                    },
                                    success: function (response) {
                                        // Xử lý phản hồi từ máy chủ nếu cần
                                        location.reload();
                                    },
                                    error: function () {
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
                                    url: '/admin/show-time/permanentlyDeleteSelected', // Thay thế bằng tuyến đường xử lý xoá của bạn
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
