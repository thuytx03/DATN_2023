@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
@endpush
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách danh mục bài viết</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="{{ route('post-type.add') }}">
                    <button class="btn btn-success">Thêm mới</button>
                </a>
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
                                <div id="dataTable_filter" class="dataTables_filter"><label>Tìm kiếm:<input
                                            type="search"
                                            class="form-control form-control-sm"
                                            placeholder=""
                                            aria-controls="dataTable"></label>
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
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Name: activate to sort column ascending"
                                            style="width: 111.2px;">Tên
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="Name: activate to sort column ascending"
                                            style="width: 111.2px;">Cha
                                        </th>

                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="total: activate to sort column ascending"
                                            style="width: 96.2px;">Ảnh
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
                                            colspan="1" aria-label="ảnh: activate to sort column ascending"
                                            style="width: 82.2px;">Trạng thái
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable" rowspan="1"
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
                                                    <input type="checkbox" class="child-checkbox">
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
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="switch1" {{ $postType->status == 1 ? 'checked' : '' }} />
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('post-type.edit',['id' => $postType->id]) }}">
                                                    <button class="btn btn-primary ">Sửa</button>
                                                </a>
                                                <button type="submit"
                                                        class="btn btn-xs btn-danger btn-flat show_confirm"
                                                        data-toggle="tooltip" title='Delete'>Xóa
                                                </button>
                                                <form
                                                    action="{{ route('post-type.destroy', ['id' => $postType->id]) }}"
                                                    method="post" id="delete">
                                                    @csrf
                                                </form>
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
        $(document).ready(function() {
            var switches = Array.from(document.querySelectorAll('.switch1'));
            switches.forEach(function(elem) {
                new Switchery(elem);
            });
        });
    </script>
    <script type="text/javascript">
        function alertCofirmation() {
            $('.show_confirm').click(function (event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                swal({
                    title: `Bạn có muốn xóa danh mục này không ?`,
                    text: "Nếu bạn xóa, Nó sẽ biến mất mãi mãi.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            document.getElementById('delete').submit();
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
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>

@endpush
