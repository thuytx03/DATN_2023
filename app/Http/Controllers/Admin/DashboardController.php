<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function user(Request $request)
    {
        $todayUsersCount = User::whereDate('created_at', Carbon::today())->count();

        // Thống kê tài khoản theo tuần
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $weekUsersCount = User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        // Thống kê tài khoản theo tháng
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $monthUsersCount = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Trả về view 'admin.dashboard.user' với dữ liệu
        return view('admin.dashboard.user', [
            'todayUsersCount' => $todayUsersCount,
            'weekUsersCount' => $weekUsersCount,
            'monthUsersCount' => $monthUsersCount,
        ]);
    }
    public function getMonthlyStats()
    {
        $monthlyStats = User::selectRaw('COUNT(*) as user_count, MONTH(created_at) as month')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        return response()->json($monthlyStats);
    }
    public function getUserCounts()
    {
        $googleUsers = User::where('gauth_id', 2)->count();
        $facebookUsers = User::where('facebook_id', 1)->count();
        $otherUsers = User::whereNull('gauth_id')->whereNull('facebook_id')->count();

        $userCounts = [
            'google' => $googleUsers,
            'facebook' => $facebookUsers,
            'other' => $otherUsers
        ];

        return response()->json($userCounts);
    }
    public function day(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();

        $totalBookingsByDate = Booking::whereDate('created_at', $currentDate)->count();

        $totalConfirmedAmountByDate = Booking::where('status', 3)
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        $totalBookings = Booking::whereDate('created_at', Carbon::today())->count();

        $statusCounts = Booking::whereDate('created_at', Carbon::today())
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusPercentages = [];
        foreach ($statusCounts as $status => $count) {
            $percentage = ($count / $totalBookings) * 100;
            $statusPercentages[$status] = round($percentage, 2);
        }
        $paymentMethodCounts = Booking::whereDate('created_at', Carbon::today())
            ->selectRaw('payment, COUNT(*) as count')
            ->groupBy('payment')
            ->pluck('count', 'payment')
            ->toArray();

        $paymentMethodPercentages = [];
        foreach ($paymentMethodCounts as $paymentMethod => $count) {
            $percentage = ($count / $totalBookings) * 100;
            $paymentMethodPercentages[$paymentMethod] = round($percentage, 2);
        }
        return view('admin.dashboard.day', [
            'totalBookingsByDate' => $totalBookingsByDate,
            'totalConfirmedAmountByDate' => $totalConfirmedAmountByDate,
            'statusPercentages' => $statusPercentages,
            'paymentMethodPercentages' => $paymentMethodPercentages,
            'currentDate'=>$currentDate
        ]);
    }
    public function getHourlyRevenue()
    {
        try {
            $hourlyRevenueData = Booking::selectRaw('HOUR(created_at) as hour, SUM(total) as total_amount')
                ->groupByRaw('HOUR(created_at)')
                ->orderByRaw('HOUR(created_at)')
                ->where('status', 3)
                ->whereDate('created_at', Carbon::today())
                ->get();
            return response()->json($hourlyRevenueData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi lấy dữ liệu số tiền theo từng giờ.'], 500);
        }
    }
    public function getCountStatusDay()
    {
        try {
            $status2Count = Booking::where('status', 2)->whereDate('created_at', Carbon::today())->count();
            $status3Count = Booking::where('status', 3)->whereDate('created_at', Carbon::today())->count();
            $status4Count = Booking::where('status', 4)->whereDate('created_at', Carbon::today())->count();

            return response()->json([
                'status2' => $status2Count,
                'status3' => $status3Count,
                'status4' => $status4Count,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
        }
    }
    public function sevenDay(Request $request)
    {
        $endDate = Carbon::now()->toDateString();
        $startDate = Carbon::now()->subDays(6)->toDateString();

        $totalBookingsThisSevenDays = Booking::whereBetween('created_at', [$startDate, $endDate])->count();

        $totalConfirmedAmountThisSevenDays = Booking::where('status', 3)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');

        $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->count();

        $statusCounts = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusPercentages = [];
        foreach ($statusCounts as $status => $count) {
            $percentage = ($count / $totalBookings) * 100;
            $statusPercentages[$status] = round($percentage, 2);
        }

        $paymentMethodCounts = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('payment, COUNT(*) as count')
            ->groupBy('payment')
            ->pluck('count', 'payment')
            ->toArray();

        $paymentMethodPercentages = [];
        foreach ($paymentMethodCounts as $paymentMethod => $count) {
            $percentage = ($count / $totalBookings) * 100;
            $paymentMethodPercentages[$paymentMethod] = round($percentage, 2);
        }

        return view('admin.dashboard.7day', [
            'totalBookingsThisSevenDay' => $totalBookingsThisSevenDays,
            'totalConfirmedAmountSevenDay' => $totalConfirmedAmountThisSevenDays,
            'statusPercentages' => $statusPercentages,
            'paymentMethodPercentages' => $paymentMethodPercentages
        ]);
    }
    public function calendar(Request $request)
    {
        $selectedDate = $request->input('selected_date');

        if ($selectedDate) {
            $selectedDate = Carbon::parse($selectedDate)->toDateString();

            $totalBookingsThisCalendar = Booking::whereDate('created_at', $selectedDate)->count();

            $totalConfirmedAmountThisCalendar = Booking::where('status', 3)
                ->whereDate('created_at', $selectedDate)
                ->sum('total');

            $totalBookings = Booking::whereDate('created_at', $selectedDate)->count();

            $statusCounts = Booking::whereDate('created_at', $selectedDate)
                ->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            $statusPercentages = [];
            foreach ($statusCounts as $status => $count) {
                $percentage = ($count / $totalBookings) * 100;
                $statusPercentages[$status] = round($percentage, 2);
            }

            $paymentMethodCounts = Booking::whereDate('created_at', $selectedDate)
                ->selectRaw('payment, COUNT(*) as count')
                ->groupBy('payment')
                ->pluck('count', 'payment')
                ->toArray();

            $paymentMethodPercentages = [];
            foreach ($paymentMethodCounts as $paymentMethod => $count) {
                $percentage = ($count / $totalBookings) * 100;
                $paymentMethodPercentages[$paymentMethod] = round($percentage, 2);
            }

            return view('admin.dashboard.calendar', [
                'totalBookingsThisCalendar' => $totalBookingsThisCalendar,
                'totalConfirmedAmountThisCalendar' => $totalConfirmedAmountThisCalendar,
                'statusPercentages' => $statusPercentages,
                'paymentMethodPercentages' => $paymentMethodPercentages,
                'selectedDate' => $selectedDate // Truyền ngày đã chọn để sử dụng trong view nếu cần
            ]);
        }else{
            toastr()->error('Vui lòng chọn ngày');
            return redirect()->route('dashboard.invoice.day');
        }

        return view('admin.dashboard.28day'); // Trả về view mặc định nếu không có ngày được chọn
    }
    public function getCountStatusCalendar(Request $request)
    {
        try {
            $selectedDate = $request->input('selected_date');

            if ($selectedDate) {
                $endDate = Carbon::parse($selectedDate)->toDateString();
                $startDate = Carbon::parse($selectedDate)->toDateString(); // Cùng một ngày

                $status2Count = Booking::where('status', 2)
                    ->whereDate('created_at', $startDate)
                    ->count();

                $status3Count = Booking::where('status', 3)
                    ->whereDate('created_at', $startDate)
                    ->count();

                $status4Count = Booking::where('status', 4)
                    ->whereDate('created_at', $startDate)
                    ->count();

                return response()->json([
                    'status2' => $status2Count,
                    'status3' => $status3Count,
                    'status4' => $status4Count,
                ]);
            } else {
                return response()->json(['error' => 'Không có ngày được chọn.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
        }
    }

    public function twentyEight(Request $request)
    {
        $endDate = Carbon::now()->toDateString();
        $startDate = Carbon::now()->subDays(27)->toDateString(); // 28 days ago

        $totalBookingsThisTwentyEight = Booking::whereBetween('created_at', [$startDate, $endDate])->count();

        $totalConfirmedAmountThisTwentyEight = Booking::where('status', 3)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');

        $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->count();

        $statusCounts = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusPercentages = [];
        foreach ($statusCounts as $status => $count) {
            $percentage = ($count / $totalBookings) * 100;
            $statusPercentages[$status] = round($percentage, 2);
        }

        $paymentMethodCounts = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('payment, COUNT(*) as count')
            ->groupBy('payment')
            ->pluck('count', 'payment')
            ->toArray();

        $paymentMethodPercentages = [];
        foreach ($paymentMethodCounts as $paymentMethod => $count) {
            $percentage = ($count / $totalBookings) * 100;
            $paymentMethodPercentages[$paymentMethod] = round($percentage, 2);
        }

        return view('admin.dashboard.28day', [
            'totalBookingsThisTwentyEight' => $totalBookingsThisTwentyEight,
            'totalConfirmedAmountThisTwentyEight' => $totalConfirmedAmountThisTwentyEight,
            'statusPercentages' => $statusPercentages,
            'paymentMethodPercentages' => $paymentMethodPercentages
        ]);
    }
    public function getCountStatusSeven()
    {
        try {
            $endDate = Carbon::now()->toDateString();
            $startDate = Carbon::now()->subDays(6)->toDateString(); // Ngày 7 ngày trước

            $status2Count = Booking::where('status', 2)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $status3Count = Booking::where('status', 3)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $status4Count = Booking::where('status', 4)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            return response()->json([
                'status2' => $status2Count,
                'status3' => $status3Count,
                'status4' => $status4Count,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
        }
    }

    public function getCountStatusTwentyEight()
    {
        try {
            $endDate = Carbon::now()->toDateString();
            $startDate = Carbon::now()->subDays(27)->toDateString(); // Ngày 28 ngày trước

            $status2Count = Booking::where('status', 2)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $status3Count = Booking::where('status', 3)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $status4Count = Booking::where('status', 4)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            return response()->json([
                'status2' => $status2Count,
                'status3' => $status3Count,
                'status4' => $status4Count,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
        }
    }
    public function fetchLastSevenDaysData(Request $request)
    {
        // Lấy ngày hiện tại
        $endDate = Carbon::now()->toDateString();

        // Lấy ngày 7 ngày trước
        $startDate = Carbon::now()->subDays(6)->toDateString();

        // Truy vấn cơ sở dữ liệu để lấy doanh thu từ bảng bookings trong khoảng thời gian này
        $revenueData = Booking::where('status', 3)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_amount'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->pluck('total_amount', 'date');

        return response()->json(['revenueData' => $revenueData]);
    }
    public function fetchLastTwentyEightDaysData(Request $request)
    {
        // Lấy ngày hiện tại
        $endDate = Carbon::now()->toDateString();

        // Lấy ngày 28 ngày trước
        $startDate = Carbon::now()->subDays(27)->toDateString();

        // Truy vấn cơ sở dữ liệu để lấy doanh thu từ bảng bookings trong khoảng thời gian này
        $revenueData = Booking::where('status', 3)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_amount'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->pluck('total_amount', 'date');

        return response()->json(['revenueData' => $revenueData]);
    }
    public function fetchHourlyData(Request $request)
    {
        $selectedDate = $request->input('selected_date');

        // Truy vấn cơ sở dữ liệu để lấy thống kê theo giờ trong ngày được chọn
        $hourlyData = Booking::where('status', 3)
            ->whereDate('created_at', $selectedDate)
            ->selectRaw('HOUR(created_at) as hour, SUM(total) as total_amount')
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy(DB::raw('HOUR(created_at)'))
            ->pluck('total_amount', 'hour');

        return response()->json(['hourlyData' => $hourlyData]);
    }

    public function week(Request $request)
    {
        $currentWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $totalBookingsThisWeek = Booking::whereBetween('created_at', [$currentWeek, $endOfWeek])
            ->count();

        $totalConfirmedAmountThisWeek = Booking::where('status', 3)
            ->whereBetween('created_at', [$currentWeek, $endOfWeek])
            ->sum('total');

        $totalBookings = Booking::whereBetween('created_at', [$currentWeek, $endOfWeek])->count();

        $statusCounts = Booking::whereBetween('created_at', [$currentWeek, $endOfWeek])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusPercentages = [];
        foreach ($statusCounts as $status => $count) {
            $percentage = ($count / $totalBookings) * 100;
            $statusPercentages[$status] = round($percentage, 2);
        }
        $paymentMethodCounts = Booking::whereBetween('created_at', [$currentWeek, $endOfWeek])
            ->selectRaw('payment, COUNT(*) as count')
            ->groupBy('payment')
            ->pluck('count', 'payment')
            ->toArray();

        $paymentMethodPercentages = [];
        foreach ($paymentMethodCounts as $paymentMethod => $count) {
            $percentage = ($count / $totalBookings) * 100;
            $paymentMethodPercentages[$paymentMethod] = round($percentage, 2);
        }
        return view('admin.dashboard.week', [
            'totalBookingsThisWeek' => $totalBookingsThisWeek,
            'totalConfirmedAmountThisWeek' => $totalConfirmedAmountThisWeek,
            'statusPercentages' => $statusPercentages,
            'paymentMethodPercentages' => $paymentMethodPercentages
        ]);
    }
    public function getWeeklyRevenue()
    {
        try {
            $currentWeekStart = Carbon::now()->startOfWeek();
            $currentWeekEnd = Carbon::now()->endOfWeek();

            // Lấy dữ liệu theo từng ngày trong tuần và tổng doanh thu tương ứng
            $weeklyRevenueData = Booking::selectRaw('DATE(created_at) as week, SUM(total) as total_amount')
                ->groupByRaw('DATE(created_at)')
                ->orderByRaw('DATE(created_at)')
                ->where('status', 3)
                ->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
                ->get();

            // Mảng để lưu trữ dữ liệu cho từng ngày trong tuần
            $data = [];

            // Mảng chứa các nhãn thứ 'T2', 'T3',..., 'T8'
            $daysOfWeek = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8'];

            // Lặp qua dữ liệu và lưu vào mảng
            foreach ($weeklyRevenueData as $revenue) {
                // Tìm vị trí của ngày trong tuần
                $dayOfWeek = date('N', strtotime($revenue->week));

                // Lấy nhãn thứ tương ứng
                $label = $daysOfWeek[$dayOfWeek - 1]; // -1 vì PHP bắt đầu từ 1, thứ hai là ngày thứ 2

                $data[] = [
                    'label' => $label,
                    'value' => $revenue->total_amount
                ];
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi lấy dữ liệu số tiền theo từng ngày trong tuần.'], 500);
        }
    }
    public function getCountStatusWeek()
    {
        try {
            $currentWeekStart = Carbon::now()->startOfWeek();
            $currentWeekEnd = Carbon::now()->endOfWeek();

            $status2Count = Booking::where('status', 2)->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->count();
            $status3Count = Booking::where('status', 3)->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->count();
            $status4Count = Booking::where('status', 4)->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->count();

            return response()->json([
                'status2' => $status2Count,
                'status3' => $status3Count,
                'status4' => $status4Count,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
        }
    }

    public function month(Request $request)
    {
        $totalBookingsThisMonth = Booking::whereYear('created_at', '=', Carbon::now()->year)
            ->count();

        $totalConfirmedAmountThisMonth = Booking::where('status', 3)
            ->whereYear('created_at', '=', Carbon::now()->year)
            ->sum('total');

        $totalBookings = Booking::whereYear('created_at', '=', Carbon::now()->year)->count();

        $statusCounts = Booking::whereYear('created_at', '=', Carbon::now()->year)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusPercentages = [];
        foreach ($statusCounts as $status => $count) {
            $percentage = ($count / $totalBookings) * 100;
            $statusPercentages[$status] = round($percentage, 2);
        }
        $paymentMethodCounts = Booking::whereYear('created_at', '=', Carbon::now()->year)
            ->selectRaw('payment, COUNT(*) as count')
            ->groupBy('payment')
            ->pluck('count', 'payment')
            ->toArray();

        $paymentMethodPercentages = [];
        foreach ($paymentMethodCounts as $paymentMethod => $count) {
            $percentage = ($count / $totalBookings) * 100;
            $paymentMethodPercentages[$paymentMethod] = round($percentage, 2);
        }
        return view('admin.dashboard.month', [
            'totalBookingsThisMonth' => $totalBookingsThisMonth,
            'totalConfirmedAmountThisMonth' => $totalConfirmedAmountThisMonth,
            'statusPercentages' => $statusPercentages,
            'paymentMethodPercentages' => $paymentMethodPercentages
        ]);
    }
    public function getCountStatusMonth()
    {
        try {
            $status2Count = Booking::where('status', 2)->whereYear('created_at', '=', Carbon::now()->year)->count();
            $status3Count = Booking::where('status', 3)->whereYear('created_at', '=', Carbon::now()->year)->count();
            $status4Count = Booking::where('status', 4)->whereYear('created_at', '=', Carbon::now()->year)->count();

            return response()->json([
                'status2' => $status2Count,
                'status3' => $status3Count,
                'status4' => $status4Count,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
        }
    }
    public function getMonthlyRevenue()
    {
        try {
            // Lấy dữ liệu theo từng tháng và tổng doanh thu tương ứng
            $monthlyRevenueData = Booking::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total_amount')
                ->where('status', 3)
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->groupByRaw('YEAR(created_at), MONTH(created_at)')
                ->get();

            // Mảng để lưu trữ dữ liệu cho từng tháng
            $data = [];

            // Lặp qua dữ liệu và lưu vào mảng
            foreach ($monthlyRevenueData as $revenue) {
                $data[] = [
                    'month' => $revenue->month, // Tháng
                    'total_amount' => $revenue->total_amount // Doanh thu tương ứng với tháng đó
                ];
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi khi lấy dữ liệu số tiền theo từng tháng.'], 500);
        }
    }
}
