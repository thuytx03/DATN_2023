@extends('layouts.admin')
@section('title')
    Danh sách danh mục
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách danh mục bài viết</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('post-type.add') }}">
                            <a class="btn btn-success">Thêm mới</a>
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hành động
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('post-type.trash') }}">Thùng rác</a>
                                <a class="dropdown-item" id="btnDeleteAll" href="">Xóa tất cả</a>
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
                                <div class="row">
                                    <div class="dataTables_length mr-3" id="dataTable_length"><label>Lọc: <select
                                                name="status_filter" aria-controls="dataTable"
                                                class="custom-select custom-select-sm form-control" id="status_filter">
                                                <option value="" selected>Tất cả</option>
                                                <option value="1">Hoạt động</option>
                                                <option value="0">Không hoạt động</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div id="dataTable_filter" class="dataTables_filter"><label>Tìm kiếm:<input
                                                type="search" class="form-control form-control-sm" placeholder=""
                                                aria-controls="dataTable"></label>
                                    </div>
                                </div>
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
                                            style="width: 111.2px;">Tên
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="Name: activate to sort column ascending"
                                            style="width: 111.2px;">Cha
                                        </th>

                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="total: activate to sort column ascending"
                                            style="width: 96.2px;">Ảnh
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="ảnh: activate to sort column ascending"
                                            style="width: 82.2px;">Trạng thái
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="action: activate to sort column ascending"
                                            style="width: 60.2px;">Hoạt động
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($postTypes as $postType)
                                        <tr class="odd">
                                            <td class="sorting_1 text-center">
                                                <label>
                                                    <input type="checkbox" class="child-checkbox" name="selectedIds"
                                                           value="{{ $postType->id }}">
                                                </label>
                                            </td>
                                            <td class="text-center">{{ $postType->name }}</td>
                                            <td class="text-center">
                                                @foreach($postType->ancestors as $item)
                                                    {{ $item->name}} <br>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                <img alt="Avatar" width="60"
                                                     src="{{ ($postType->image == null) ? asset('images/image-not-found.jpg') : Storage::url($postType->image) }}">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="switch1"
                                                       value="{{ $postType->status == 1 ? 1 : 0 }}" {{ $postType->status == 1 ? 'checked' : '' }} />
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <!-- Icon here (e.g., three dots icon) -->
                                                    <i class="fas fa-ellipsis-v p-2 " data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                           href="{{ route('post-type.edit',['id' => $postType->id]) }}">Sửa</a>
                                                        <a class="dropdown-item show_confirm"
                                                           href="{{ route('post-type.destroy',['id' => $postType->id]) }}">Xóa</a>
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
                                    Hiển thị {{ $postTypes->firstItem() }} đến {{ $postTypes->lastItem() }}
                                    của {{ $postTypes->total() }} mục
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                    <ul class="pagination">
                                        {{ $postTypes->links('pagination::bootstrap-4') }}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            var switches = Array.from(document.querySelectorAll('.switch1'));
            switches.forEach(function (elem) {
                new Switchery(elem);
            });
        });
    </script>
    <script type="text/javascript">
        function alertCofirmation() {
            $('.show_confirm').click(function (event) {
                var href = $(this).attr("href");
                var name = $(this).data("name");
                event.preventDefault();
                swal({
                    title: `Bạn có muốn xóa danh mục này không ?`,
                    text: "Nếu bạn xóa, Nó sẽ vào thùng rác.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = href;
                        }
                    });
            });
        }

        alertCofirmation();

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
        // Bắt sự kiện khi thay đổi lựa chọn trong dropdown
        document.getElementById('status_filter').addEventListener('change', function () {
            var status = this.value; // Lấy giá trị đã chọn
            filterTableByStatus(status);
        });

        // Hàm để lọc bảng theo trạng thái
        function filterTableByStatus(status) {
            var table = document.getElementById('dataTable');
            var rows = table.getElementsByTagName('tr');
            // Duyệt qua từng hàng trong bảng
            for (var i = 1; i < rows.length; i++) {
                var row = rows[i];
                var cell = row.cells[4]; // Cột trạng thái
                var switchInput = cell.querySelector('.switch1');
                if (switchInput) {
                    var switchValue = switchInput.value;
                }

                // Lấy giá trị trạng thái từ cell
                var cellValue = cell.innerText.trim();
                // Hiển thị/ẩn hàng dựa trên trạng thái đã chọn
                if (status === '') {
                    row.style.display = ''; // Hiển thị tất cả nếu không có lọc
                } else if (switchValue === status) {
                    row.style.display = ''; // Hiển thị nếu trạng thái khớp
                } else {
                    row.style.display = 'none'; // Ẩn nếu không khớp
                }
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>

@endpush
