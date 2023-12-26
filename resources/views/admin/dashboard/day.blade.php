@extends('layouts.admin')
@section('title')
Thống kê theo ngày
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thống kê hóa đơn theo ngày</h1>
        <div class="">
            <a href="{{route('dashboard.invoice.week')}}" class="btn btn-primary">Doanh thu theo tuần</a>
            <a href="{{route('dashboard.invoice.month')}}" class="btn btn-primary">Doanh thu theo tháng</a>
        </div>
    </div>
    <div class="mb-3">
        <a href="{{route('dashboard.invoice.seven')}}" class="btn btn-primary">7 ngày qua</a>
        <a href="{{route('dashboard.invoice.TwentyEight')}}" class="btn btn-primary">28 ngày qua</a>
        <form method="GET" action="{{ route('dashboard.invoice.calendar') }}" class="mt-2">
            @csrf
            <span><input type="date" name="start_date" class="btn btn-primary"></span>-->
            <span><input type="date" name="end_date" class="btn btn-primary"></span>
            <button type="submit" class="btn btn-info"><i class="fas fa-search m-1"></i></button>
        </form>

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
                                Tổng doanh thu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalConfirmedAmountByDate}} Vnđ</div>
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
                                Tổng hóa đơn
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalBookingsByDate}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                    <h6 class="m-0 font-weight-bold text-primary">Doanh thu theo giờ</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Doanh thu theo khoảng</div>
                            <a class="dropdown-item time-range" href="#">7 ngày qua</a>
                            <a class="dropdown-item time-range-month" href="#">28 ngày qua</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Chọn theo ngày: <input type="date" id="selected_date"></a>
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
                    <h6 class="m-0 font-weight-bold text-primary">Trạng thái hóa đơn</h6>
                    <div class="dropdown no-arrow">
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Chờ xác nhận
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Đã xác nhận
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Đã hủy
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tỉ lệ phần trăm</h6>
                </div>
                <div class="card-body">
                    @foreach($paymentMethodPercentages as $paymentMethod => $percentage)
                    @php
                    // Xác định màu sắc dựa trên phương thức thanh toán
                    $color = '';
                    switch ($paymentMethod) {
                    case '1':
                    $paymentMethod = 'VnPay';
                    $color = 'bg-warning';
                    break;
                    case '2':
                    $paymentMethod = 'PayPal';
                    $color = ''; // Mặc định không có màu sắc
                    break;
                    default:
                    $paymentMethod = 'Phương thức thanh toán khác';
                    $color = ''; // Mặc định không có màu sắc
                    }
                    @endphp
                    <h4 class="small font-weight-bold">{{ $paymentMethod }} <span class="float-right">{{ $percentage }}%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar {{ $color }}" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endforeach

                    @foreach($statusPercentages as $status => $percentage)
                    @php
                    // Xác định màu sắc dựa trên status
                    $statusColorClass = '';
                    switch ($status) {
                    case '2':
                    $statusName = "Chờ xác nhận";
                    $statusColorClass = 'bg-info';
                    break;
                    case '3':
                    $statusName = "Đã xác nhận";
                    $statusColorClass = 'bg-success';
                    break;
                    case '4':
                    $statusName = "Đã hủy";
                    $statusColorClass = 'bg-danger';
                    break;
                    // Thêm các case khác nếu có nhiều loại status khác
                    default:
                    $statusName = "Trạng thái khác";
                    $statusColorClass = ''; // Mặc định không có màu sắc
                    }
                    @endphp
                    <h4 class="small font-weight-bold">{{ $statusName }} <span class="float-right">{{ $percentage }}%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar {{ $statusColorClass }}" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/admin/dashboard/invoice/day/hourly-data',
            method: 'GET',
            success: function(response) {
                var hours = [];
                var amounts = [];
                console.log(response)

                // Duyệt qua dữ liệu phản hồi
                for (var i = 0; i < 24; i++) {
                    var found = response.find(item => item.hour === i);
                    if (found) {
                        hours.push(found.hour + 'h');
                        amounts.push(found.total_amount);
                    } else {
                        hours.push(i + 'h');
                        amounts.push(0);
                    }
                }

                var labels = hours;

                // Cập nhật labels và data của biểu đồ từ dữ liệu phản hồi hoặc giá trị mặc định 0
                myLineChart.data.labels = labels;
                myLineChart.data.datasets[0].data = amounts;

                // Cấu hình để hiển thị 'VNĐ' sau mỗi giá trị trên trục y

                // Cập nhật biểu đồ
                myLineChart.update();
            },
            error: function(err) {
                console.error('Lỗi:', err);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/admin/dashboard/invoice/day/getCountStatusDay',
            method: 'GET',
            success: function(response) {
                var status2Count = response.status2 || 0;
                var status3Count = response.status3 || 0;
                var status4Count = response.status4 || 0;
                updatePieChart([status2Count, status3Count, status4Count]);
            },
            error: function(err) {
                console.error('Lỗi:', err);
            }
        });
        var labels = ["Chờ xác nhận", "Đã xác nhận", "Đã hủy"];

        function updatePieChart(statusCounts) {
            // Cập nhật biểu đồ Pie Chart (ví dụ)
            // Không quên cập nhật phần này để phản ánh biểu đồ của bạn
            myPieChart.data.datasets[0].data = statusCounts;
            myPieChart.data.labels = labels;
            myPieChart.update();
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Xử lý sự kiện khi người dùng chọn 7 ngày qua từ dropdown menu
        $('.time-range').click(function(e) {
            e.preventDefault();
            var range = $(this).attr('data-range');
            fetchData(range);
        });

        // Hàm gửi yêu cầu AJAX và cập nhật biểu đồ
        function fetchData(range) {
            $.ajax({
                url: '/admin/dashboard/invoice/day/fetchLastSevenDaysData',
                type: 'GET',
                data: {
                    range: range
                },
                success: function(response) {
                    // Nhận dữ liệu từ Controller
                    var revenueData = response.revenueData;

                    // Tạo mảng dữ liệu mới với giá trị mặc định là 0 cho các ngày không có dữ liệu
                    var newData = [];
                    var labels = [];
                    for (var i = 0; i < 7; i++) {
                        var date = moment().subtract(i, 'days').format('YYYY-MM-DD');
                        labels.unshift(date);
                        newData.unshift(revenueData[date] || 0);
                    }

                    // Gọi hàm để cập nhật dữ liệu trong biểu đồ
                    updateChartData(labels, newData);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        // Hàm cập nhật dữ liệu mới trong biểu đồ
        function updateChartData(labels, newData) {
            myLineChart.data.labels = labels;
            myLineChart.data.datasets[0].data = newData;
            myLineChart.update();
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Xử lý sự kiện khi người dùng chọn 7 ngày qua từ dropdown menu
        $('.time-range-month').click(function(e) {
            e.preventDefault();
            var range = $(this).attr('data-range');
            fetchData(range);
        });

        // Hàm gửi yêu cầu AJAX và cập nhật biểu đồ
        function fetchData(range) {
            $.ajax({
                url: '/admin/dashboard/invoice/day/fetchLastTwentyEightDaysData',
                type: 'GET',
                data: {
                    range: range
                },
                success: function(response) {
                    // Nhận dữ liệu từ Controller
                    var revenueData = response.revenueData;

                    // Tạo mảng dữ liệu mới với giá trị mặc định là 0 cho các ngày không có dữ liệu
                    var newData = [];
                    var labels = [];
                    for (var i = 0; i < 28; i++) {
                        var date = moment().subtract(i, 'days').format('YYYY-MM-DD');
                        labels.unshift(date);
                        newData.unshift(revenueData[date] || 0);
                    }

                    // Gọi hàm để cập nhật dữ liệu trong biểu đồ
                    updateChartData(labels, newData);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        // Hàm cập nhật dữ liệu mới trong biểu đồ
        function updateChartData(labels, newData) {
            myLineChart.data.labels = labels;
            myLineChart.data.datasets[0].data = newData;
            myLineChart.update();
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#selected_date').change(function() {
            var selectedDate = $(this).val();
            fetchHourlyData(selectedDate);
        });

        function fetchHourlyData(date) {
            $.ajax({
                url: '/admin/dashboard/invoice/day/fetchHourlyData',
                type: 'GET',
                data: {
                    date: date
                },
                // Trong hàm success của AJAX
                // Trong hàm success của AJAX
                success: function(response) {
                    var hourlyData = response.hourlyData;

                    // Tạo mảng chứa giờ và tổng doanh thu tương ứng
                    var hours = [];
                    var revenues = [];

                    // Lặp qua các giờ từ 0 đến 23 và kiểm tra dữ liệu có trong hourlyData không
                    for (var i = 0; i < 24; i++) {
                        var hour = i.toString().padStart(2); // Format giờ thành chuỗi 2 chữ số
                        var hourtime = i.toString().padStart(2) + 'h'; // Format giờ thành chuỗi 2 chữ số
                        var revenue = hourlyData[hour] || 0; // Nếu không có dữ liệu, gán giá trị 0

                        // Thêm giờ và doanh thu vào mảng tương ứng
                        hours.push(hourtime);
                        revenues.push(revenue);
                    }

                    // Cập nhật dữ liệu và nhãn cho biểu đồ
                    myLineChart.data.labels = hours;
                    myLineChart.data.datasets[0].data = revenues;

                    // Cập nhật biểu đồ
                    myLineChart.update();
                },


                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    });
</script>
@endpush
