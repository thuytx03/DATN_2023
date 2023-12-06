@extends('layouts.admin')
@section('title')
Thống kê theo tháng 
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thống kê hóa đơn theo tháng</h1>
        <div class="">
            <a href="{{route('dashboard.invoice.day')}}" class="btn btn-primary">Doanh thu theo ngày</a>
            <a href="{{route('dashboard.invoice.week')}}" class="btn btn-primary">Doanh thu theo tuần</a>
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
                                Tổng doanh thu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalConfirmedAmountThisMonth}} Vnđ</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalBookingsThisMonth}}</div>
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
                    <h6 class="m-0 font-weight-bold text-primary">Doanh thu theo tháng</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
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
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
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
<script>
    $(document).ready(function() {
        // Gọi API từ Laravel để lấy dữ liệu doanh thu theo tháng
        $.ajax({
            url: '/admin/dashboard/invoice/month/monthly-data',
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
                        dataMap[item.month] = item.total_amount;
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
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/admin/dashboard/invoice/month/getCountStatusMonth',
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
@endpush