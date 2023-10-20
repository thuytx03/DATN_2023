@extends('layouts.admin')
@push('styles')
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
@endpush
@section('title')
    Danh sách Món Ăn
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"> Danh sách Món Ăn</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <a href="{{route('movie-foode.add')}}" class="btn btn-success">
                            Thêm mới
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
                                <div class="dataTables_length" id="dataTable_length"><label>Hiển thị <select
                                            name="dataTable_length" aria-controls="dataTable"
                                            class="custom-select custom-select-sm form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> Mục</label>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <form action="">
                                <div class="row">
                                    <div class="dataTables_length mr-3" id="dataTable_length"><label>Lọc <select
                                                name="food_type_id" aria-controls="dataTable"
                                                class="custom-select custom-select-sm form-control " >
                                                <option value="">Vui lòng chọn</option>
                                                @foreach ( $types as $types1 ) 
                                                        <option value="{{$types1->id}}">{{$types1->name}}</option>                                            
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>

                                    <div id="dataTable_filter" class="dataTables_filter"><label>Tìm kiếm:<input
                                                type="search" class="form-control form-control-sm" placeholder=""
                                                aria-controls="dataTable"name="keyword" value="{{request()->keyword}}"" ></label>
                                    </div>
                                    <button class="btn btn-primare" type="submit">Tìm Kiếm</button>
                                </div>
                            </form>
                                </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered text-center mt-2" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <<tr role="row">
                                            <th class="pr-2 text-center" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="id: activate to sort column descending" style="width: 5.2px;">
                                                <label>
                                                    <input type="checkbox" id="select-all">
                                                </label>
                                            </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Name: activate to sort column ascending"
                                                style="width: 111.2px;">Tên
                                            </th>
    
                                            <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="total: activate to sort column ascending"
                                                style="width: 96.2px;">giá
                                            </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="ảnh: activate to sort column ascending"
                                                style="width: 82.2px;">ảnh
                                            </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="ảnh: activate to sort column ascending"
                                            style="width: 82.2px;">Mô Tả
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                    colspan="1" aria-label="ảnh: activate to sort column ascending"
                                    style="width: 82.2px;">Số Lượng Còn Lại
                                </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="action: activate to sort column ascending"
                                                style="width: 60.2px;">Hoạt động
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($listfood as $value)

                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="child-checkbox" value="{{$value->id}}" name="ids[]">
                                                </td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->price }}</td>
                                                <td class="text-center">
                                                    <img alt="Avatar" width="60"
                                                    
                                                    src="{{ ($value->image == null) ? asset('images/image-not-found.jpg') : Storage::url($value->image) }}" alt="Image">
    
                                                </td>
                                                <td>{{ $value->description }}</td>
                                                <td>{{ $value->quantity }}</td>
                                                   
                                                </td>
                                                    <td class="text-center">
                                                <button class="btn " type="button" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('movie-foode.destroyTrash', ['id' => $value->id]) }}">xóa hoàn toàn</a>
                                                    <a class="dropdown-item show_success"
                                                        href="{{ route('movie-foode.unTrash', ['id' => $value->id]) }}">Khôi Phục
                                                    </a>

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
                                    
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                    <ul class="pagination">
                                        
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
                                    url: '/admin/movie-food/unTrashAll',
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
                                    url: '/admin/movie-food/permanentlyDeleteSelected', // Thay thế bằng tuyến đường xử lý xoá của bạn
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

