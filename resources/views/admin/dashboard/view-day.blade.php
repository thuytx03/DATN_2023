@extends('layouts.admin')
@section('title')
    Thống kê lượt xem tính đến hiện tại
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thống kê lượt xem tính đến hiện tại</h1>
            <div>
                <a href="{{ route('dashboard.view-by-day') }}" class="btn btn-info">Thống kê theo ngày</a>
                <a href="{{ route('dashboard.view-by-week') }}" class="btn btn-dark">Thống kê theo tuần</a>
                <a href="{{ route('dashboard.view-by-month') }}" class="btn btn-secondary">Thống kê theo tháng</a>
            </div>
        </div>
        <div class="mb-3">
            <a href="{{ route('dashboard.view.seven') }}" class="btn btn-primary">7 ngày qua</a>
            <a href="{{ route('dashboard.view.twenty') }}" class="btn btn-primary">28 ngày qua</a>
            <form method="GET" action="" class="mt-2">
                @csrf
                <span><input type="date" name="start_date" class="btn btn-primary"></span>-->
                <span><input type="date" name="end_date" class="btn btn-primary"></span>
                <button type="submit" class="btn btn-info"><i class="fas fa-search m-1"></i></button>
            </form>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Thống kê lượt xem tính đến hiện tại</h4>
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
                                <form action="{{ route('dashboard.view') }}" method="get">
                                    <div class="row">
                                        <div id="dataTable_filter" class="dataTables_filter"><label> Tên phim
                                                <input type="search" name="search" class="form-control form-control-sm"
                                                       placeholder="" aria-controls="dataTable">
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
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="Name: activate to sort column ascending"
                                            style="width: 111.2px;">Ngày khởi chiếu
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="Name: activate to sort column ascending"
                                            style="width: 111.2px;">Tên phim
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                            rowspan="1"
                                            colspan="1" aria-label="total: activate to sort column ascending"
                                            style="width: 96.2px;">Tổng Lượt xem
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($movieView as $item)
                                        <tr class="text-center">
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->total_views }} Lượt xem</td>
{{--                                            <td>{{ number_format($item->total_views, 1, '.', ',') }} lượt xem</td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
                                    Hiển thị {{ $movieView->firstItem() }} đến {{ $movieView->lastItem() }}
                                    của {{ $movieView->total() }} mục
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                    <ul class="pagination">
                                        {{ $movieView->links('pagination::bootstrap-4') }}
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
@endpush
