@extends('layouts.admin')
@section('title')
    Thống kê lượt xem theo tuần
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thống kê lượt xem theo tuần</h1>
            <div class="">
                <a href="{{ route('dashboard.view-by-day') }}" class="btn btn-primary">Lượt xem theo
                    ngày</a>
                <a href="{{ route('dashboard.view-by-month') }}" class="btn btn-primary">Lượt xem theo
                    tháng</a>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Phim được xem nhiều nhất trong tuần
                                </div>
                                @if($mostViewedMovie != null)
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        <p>{{ $mostViewedMovie->name }} : {{ $mostViewedMovie->total_views }} Lượt
                                            xem</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Tổng số phim công chiếu trong tuần
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $showTimesWeek }} - lịch chiếu
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Lượt xem theo tuần</h6>
                        <!-- ... (your existing dropdown code) ... -->
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Top 10 phim được xem nhiều nhất trong tuần</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($topMoviesWeek as $index => $value)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span> Top {{ $index + 1 }}. {{ $value->name }}</span>
                                    <span class="badge badge-primary badge-pill">{{ $value->total_views }} lượt xem</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $.ajax({
            url: '/admin/view/weeklyData',
            type: 'GET',
            success: function(data) {
                console.log(data); // Kiểm tra cấu trúc của dữ liệu để xác định cách truy cập

                // Xử lý dữ liệu nhận được từ API để cập nhật biểu đồ
                if (Array.isArray(data)) {
                    var updatedLabels = [];
                    var updatedData = [];

                    // Tạo một đối tượng để ánh xạ nhãn và giá trị
                    var dataMap = {};
                    data.forEach(function(item) {
                        dataMap[item.label] = item.value;
                    });

                    // Tạo danh sách các ngày trong tuần
                    var daysOfWeek = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'];

                    // Duyệt qua các ngày trong tuần để kiểm tra và cập nhật dữ liệu
                    daysOfWeek.forEach(function(day) {
                        if (dataMap.hasOwnProperty(day)) {
                            updatedLabels.push(day);
                            updatedData.push(dataMap[day]);
                        } else {
                            updatedLabels.push(day);
                            updatedData.push(0); // Nếu không có dữ liệu, gán giá trị 0
                        }
                    });

                    // Cập nhật dữ liệu của biểu đồ
                    myLineChart.data.labels = updatedLabels;
                    myLineChart.data.datasets[0].data = updatedData;

                    myLineChart.update(); // Cập nhật biểu đồ
                } else {
                    console.error('Dữ liệu nhãn không hợp lệ.');
                }
            },
            error: function(error) {
                console.error('Lỗi khi gọi API:', error);
            }
        });
    </script>
@endpush
