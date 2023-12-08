@extends('layouts.admin')
@push('styles')
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
@endpush
@section('title')
    Thùng rác đánh giá phim
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thùng rác đánh giá phim</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <a href="{{ route('feed-back.index') }}" class="btn btn-success">Danh sách</a>
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

                            <div class="col-sm-12 col-md-12">
                                <form action="{{ route('feed-back.trash') }}" method="get">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="status">Lọc theo số sao :</label>
                                            <select name="status" id="status"
                                                    class="custom-select custom-select-sm form-control">
                                                <option value="all">Chọn trạng thái</option>
                                                <option value="1">1 sao</option>
                                                <option value="2">2 sao</option>
                                                <option value="3">3 sao</option>
                                                <option value="4">4 sao</option>
                                                <option value="5">5 sao</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="search">Tìm kiếm theo tên người dùng :</label>
                                            <div class="input-group">
                                                <input type="search" name="search" id="search"
                                                       class="form-control form-control-sm" placeholder="Tìm kiếm ">
                                                <div class="input">
                                                    <button class="btn btn-success p-1 ml-2" type="submit">Tìm kiếm
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered text-center mt-2" id="dataTable" width="100%"
                                       cellspacing="0">
                                    <thead>

                                    <td class="pr-2 " tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                        aria-sort="ascending" aria-label="id: activate to sort column descending"
                                        style="width: 50px;">
                                        <label>
                                            <input type="checkbox" id="select-all">
                                        </label>
                                    </td>
                                    <th name="title" class="title">Người dùng</th>
                                    <th>Phim</th>
                                    <th>Số sao</th>
                                    <th>Nội dung</th>
                                    <th>Hành Động</th>

                                    </thead>

                                    <tbody>
                                    @foreach($feedbacks as $feedback)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="child-checkbox" value="{{$feedback->id}}"
                                                       name="ids[]">
                                            </td>
                                            <td>
                                                {{ $feedback->user_name }} <br>
                                                <small style="font-weight: bold">Created at
                                                    : {{ $feedback->created_at }}</small>

                                            </td>
                                            <td>{{ $feedback->movie_name }}</td>
                                            <td>{{ $feedback->rating }} sao</td>
                                            <td>{{ $feedback->message }}</td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <!-- Icon here (e.g., three dots icon) -->
                                                    <i class="fas fa-ellipsis-v p-2" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false"></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item show_confirm"
                                                           href="{{ route('feed-back.delete',['id' => $feedback->id]) }}">Xóa vĩnh viễn</a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('feed-back.restore', ['id' => $feedback->id]) }}">Khôi
                                                            phục</a>
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
                                    Hiển thị {{ $feedbacks->firstItem() }} đến {{ $feedbacks->lastItem() }}
                                    của {{ $feedbacks->total() }} mục
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                    <ul class="pagination">
                                        {{ $feedbacks->links('pagination::bootstrap-4') }}
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
@push('styles')
    <style>

    </style>
@endpush
@push('scripts')
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <!-- <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            var switches = Array.from(document.querySelectorAll('.switch1'));
            switches.forEach(function (elem) {
                new Switchery(elem);
            });
        });
    </script>

    <!-- Page level custom scripts -->

    <script type="text/javascript">
        function alertConfirmation() {
            $('.show_confirm').click(function (event) {
                var href = $(this).attr("href"); // Lấy URL từ thuộc tính href của thẻ <a>
                var name = $(this).data("name");
                event.preventDefault();

                swal({
                    title: `Bạn có muốn xóa đánh giá này không ?`,
                    text: "Nếu bạn xóa, Nó sẽ biến mất mãi mãi. ",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            // Chuyển hướng đến URL xóa khi người dùng xác nhận
                            window.location.href = href;
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
    </script>

    <!-- Page level custom scripts -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#searchInput').on('input', function () {
                var searchText = $(this).val().toLowerCase();
                $('#dataTable tbody tr').each(function () {
                    var text = $(this).find('.title').text().toLowerCase(); // Tìm kiếm theo cột tên
                    if (text.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });

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
                                    url: '/admin/feed-back/restoreSelected',
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
                                    url: '/admin/feed-back/permanentlyDeleteSelected', // Thay thế bằng tuyến đường xử lý xoá của bạn
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



    <script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <!-- Page level plugins -->
    <!-- <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script> -->
    <!-- <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> -->
@endpush
