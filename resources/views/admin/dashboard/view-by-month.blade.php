@extends('layouts.admin')
@section('title')
    Thống kê lượt xem theo tháng
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thống kê lượt xem theo tháng</h1>
            <div class="">
                <a href="{{ route('dashboard.view-by-day') }}" class="btn btn-primary">Lượt xem theo
                    ngày</a>
                <a href="{{ route('dashboard.view-by-week') }}" class="btn btn-primary">Lượt xem theo
                    tuần</a>
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
                                    Phim xem nhiều nhất trong tháng
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
                                    Tổng số phim công chiếu trong tháng
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $showTimesMonth }} - lịch chiếu
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
                        <h6 class="m-0 font-weight-bold text-primary">Lượt xem theo tháng</h6>
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
                        <h6 class="m-0 font-weight-bold text-primary">Top 10 phim được xem nhiều nhất trong tháng</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($topMoviesMonth as $index => $value)
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
    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $.ajax({
            url: '/admin/view/monthlyData',
            type: 'GET',
            success: function(data) {
                console.log(data); // Kiểm tra cấu trúc của dữ liệu để xác định cách truy cập

                // Xử lý dữ liệu nhận được từ API để cập nhật biểu đồ
                if (Array.isArray(data)) {
                    var updatedLabels = [];
                    var updatedData = [];

                    // Tạo một đối tượng để ánh xạ tháng và doanh thu
                    var dataMap = {};
                    data.forEach(function(item) {
                        dataMap[item.month] = item.total_views;
                    });

                    // Tạo danh sách các tháng trong năm
                    var monthsOfYear = [
                        'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                        'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                    ];

                    // Duyệt qua các tháng trong năm để kiểm tra và cập nhật dữ liệu
                    monthsOfYear.forEach(function(month) {
                        var monthNumber = monthsOfYear.indexOf(month) + 1; // Chuyển đổi tên tháng sang số tháng (1-12)
                        var monthLabel = 'Tháng ' + monthNumber;

                        if (dataMap.hasOwnProperty(monthNumber)) {
                            updatedLabels.push(monthLabel);
                            updatedData.push(dataMap[monthNumber]);
                        } else {
                            updatedLabels.push(monthLabel);
                            updatedData.push(0); // Nếu không có dữ liệu, gán giá trị 0
                        }
                    });

                    // Cập nhật dữ liệu của biểu đồ
                    myLineChart.data.labels = updatedLabels;
                    myLineChart.data.datasets[0].data = updatedData;

                    myLineChart.update(); // Cập nhật biểu đồ
                } else {
                    console.error('Dữ liệu tháng không hợp lệ.');
                }
            },
            error: function(error) {
                console.error('Lỗi khi gọi API:', error);
            }
        });
    </script>
@endpush
