@extends('layouts.admin')
@section('title')
    Thống kê lượt xem theo ngày
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thống kê lượt xem theo ngày</h1>
            <div class="">
                <a href="{{ route('dashboard.view-by-week') }}" class="btn btn-primary">Lượt xem theo
                    tuần</a>
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
                                    Phim xem nhiều nhất trong ngày
                                </div>
                                @if($totalViewsToday != null)
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        <p>{{ $totalViewsToday->name }} : {{ $totalViewsToday->total_views }} Lượt
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
                                    Tổng số phim công chiếu trong ngày
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $showTimesToday }} - lịch chiếu
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
                        <h6 class="m-0 font-weight-bold text-primary">Lượt xem theo giờ</h6>
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
                        <h6 class="m-0 font-weight-bold text-primary">Top 10 phim được xem nhiều nhất trong ngày</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($topMoviesToday as $index => $value)
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
        $(document).ready(function () {
            $.ajax({
                url: '/admin/view/hourlyData', // Adjust the URL accordingly
                method: 'GET',
                success: function (response) {
                    var hours = [];
                    var views = [];
                    console.log(response)

                    // Duyệt qua dữ liệu phản hồi
                    for (var i = 0; i < 24; i++) {
                        var found = response.find(item => item.hour === i);
                        if (found) {
                            hours.push(found.hour + 'h');
                            views.push(found.total_views);
                        } else {
                            hours.push(i + 'h');
                            views.push(0);
                        }
                    }

                    var labels = hours;

                    // Cập nhật labels và data của biểu đồ từ dữ liệu phản hồi hoặc giá trị mặc định 0
                    myLineChart.data.labels = labels;
                    myLineChart.data.datasets[0].data = views;

                    // Cấu hình để hiển thị 'VNĐ' sau mỗi giá trị trên trục y

                    // Cập nhật biểu đồ
                    myLineChart.update();
                },
                error: function (err) {
                    console.error('Lỗi:', err);
                }
            });
        });
    </script>
@endpush
