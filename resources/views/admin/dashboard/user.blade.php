@extends('layouts.admin')
@section('title')
Thống kê người dùng
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thống kê người dùng</h1>
        <div>
            <a href="{{route('dashboard.invoice.day')}}" class="btn btn-info">Thống kê doanh thu</a>
            <a href="{{route('dashboard.view')}}" class="btn btn-secondary">Thống kê lượt xem</a>
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
                                Ngày
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="day">{{$todayUsersCount}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                Tuần
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="week">{{$weekUsersCount}}</div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                Tháng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="month">{{$monthUsersCount}}</div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê theo tháng</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Thống kê:</div>
                            <a class="dropdown-item" href="#">Thông kê theo ngày</a>
                            <a class="dropdown-item" href="#">Thống kê theo tuần</a>
                            <a class="dropdown-item" href="#">Thống kê theo tháng</a>
                        </div>
                    </div>
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
                    <h6 class="m-0 font-weight-bold text-primary">Biểu đồ hình tròn</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Thống kê:</div>
                            <a class="dropdown-item" href="#">Thống kê theo ngày</a>
                            <a class="dropdown-item" href="#">Thống kê theo tuần</a>
                            <a class="dropdown-item" href="#">Thống kê theo tháng</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Google
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Facbook
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Boleto
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-6 mb-4">

            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                </div>
                <div class="card-body">
                    <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                        CSS bloat and poor page performance. Custom CSS classes are used to create
                        custom components and custom utility classes.</p>
                    <p class="mb-0">Before working with this theme, you should become familiar with the
                        Bootstrap framework, especially the utility classes.</p>
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
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/admin/dashboard/getMonthlyStats',
            method: 'GET',
            success: function(response) {
                var data = new Array(12).fill(0); // Initialize an array for all 12 months with zero values
                var months = response.map(item => item.month);

                // Update data array with fetched user counts for respective months
                response.forEach(item => {
                    var monthIndex = item.month - 1; // Adjust month to zero-based index
                    data[monthIndex] = item.user_count;
                });

                var monthNames = ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"];

                var labels = monthNames;

                updateChart(data, labels);
            },
            error: function(err) {
                console.error('Error:', err);
            }
        });

        function updateChart(data, labels) {
            myLineChart.data.labels = labels;
            myLineChart.data.datasets[0].data = data;
            myLineChart.update();
        }
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/admin/dashboard/getUserCounts',
            method: 'GET',
            success: function(response) {
                // Sử dụng thông tin từ đối tượng response để cập nhật biểu đồ
                var googleUsers = response.google || 0; // Số lượng người dùng Google
                var facebookUsers = response.facebook || 0; // Số lượng người dùng Facebook
                var otherUsers = response.other || 0; // Số lượng người dùng Other

                updatePieChart([googleUsers, facebookUsers, otherUsers]);
            },
            error: function(err) {
                console.error('Error:', err);
            }
        });
        var labels = ["Google","Facebook","Boleto"];
        function updatePieChart(userCounts) {
            myPieChart.data.datasets[0].data = userCounts;
            myPieChart.data.labels = labels;
            myPieChart.update();
        }
    });
</script>
@endpush
