<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\RoleHasCinema;
use App\Models\Room;
use App\Models\Movie;
use App\Models\MovieView;
use App\Models\ShowTime;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function __construct()
    {
        $methods = get_class_methods(__CLASS__); // Lấy danh sách các phương thức trong class hiện tại

        // Loại bỏ những phương thức không cần áp dụng middleware (ví dụ: __construct, __destruct, ...)
        $methods = array_diff($methods, ['__construct', '__destruct', '__clone', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo']);

        $this->middleware('role:Admin|Manage-HaNoi|Manage-HaiPhong|Manage-ThaiBinh|Manage-NamDinh|Manage-NinhBinh', ['only' => $methods]);
    }

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
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
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
                'currentDate' => $currentDate
            ]);
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds
            $currentDate = Carbon::now()->toDateString();

            $totalBookingsByDate = Booking::whereDate('created_at', $currentDate)->whereIn('showtime_id', $showtimeIds)->count();

            $totalConfirmedAmountByDate = Booking::where('status', 3)
                ->whereDate('created_at', Carbon::today())
                ->whereIn('showtime_id', $showtimeIds)
                ->sum('total');

            $totalBookings = Booking::whereDate('created_at', Carbon::today())->whereIn('showtime_id', $showtimeIds)->count();

            $statusCounts = Booking::whereDate('created_at', Carbon::today())
                ->whereIn('showtime_id', $showtimeIds)
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
                ->whereIn('showtime_id', $showtimeIds)
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
                'currentDate' => $currentDate
            ]);
        }
    }

    public function getHourlyRevenue()
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            try {
                $hourlyRevenueData = Booking::selectRaw('HOUR(created_at) as hour, SUM(total) as total_amount')
                    ->groupByRaw('HOUR(created_at)')
                    ->orderByRaw('HOUR(created_at)')
                    ->where('status', 3)
                    ->whereDate('created_at', Carbon::today())
                    ->whereIn('showtime_id', $showtimeIds)
                    ->get();
                return response()->json($hourlyRevenueData);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Lỗi khi lấy dữ liệu số tiền theo từng giờ.'], 500);
            }
        }
    }

    public function getCountStatusDay()
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            try {
                $status2Count = Booking::where('status', 2)->whereDate('created_at', Carbon::today())->whereIn('showtime_id', $showtimeIds)->count();
                $status3Count = Booking::where('status', 3)->whereDate('created_at', Carbon::today())->whereIn('showtime_id', $showtimeIds)->count();
                $status4Count = Booking::where('status', 4)->whereDate('created_at', Carbon::today())->whereIn('showtime_id', $showtimeIds)->count();

                return response()->json([
                    'status2' => $status2Count,
                    'status3' => $status3Count,
                    'status4' => $status4Count,
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
            }
        }
    }

    public function sevenDay(Request $request)
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
            $endDate = Carbon::now()->endOfDay();
            $startDate = Carbon::now()->subDays(6)->startOfDay();

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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            $endDate = Carbon::now()->endOfDay();
            $startDate = Carbon::now()->subDays(6)->startOfDay();

            $totalBookingsThisSevenDays = Booking::whereBetween('created_at', [$startDate, $endDate])->whereIn('showtime_id', $showtimeIds)->count();

            $totalConfirmedAmountThisSevenDays = Booking::where('status', 3)
                ->whereIn('showtime_id', $showtimeIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total');

            $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->whereIn('showtime_id', $showtimeIds)->count();

            $statusCounts = Booking::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('showtime_id', $showtimeIds)
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
                ->whereIn('showtime_id', $showtimeIds)
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
    }

    public function calendar(Request $request)
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            if ($startDate > $endDate) {
                toastr()->error('Ngày bắt đầu không được lớn hơn ngày kết thúc');
                return redirect()->route('dashboard.invoice.day');
            }
            if ($startDate && $endDate) {
                try {
                    $startDate = Carbon::parse($startDate)->startOfDay();
                    $endDate = Carbon::parse($endDate)->endOfDay();

                    $totalBookingsThisCalendar = Booking::whereBetween('created_at', [$startDate, $endDate])->count();

                    $totalConfirmedAmountThisCalendar = Booking::where('status', 3)
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

                    return view('admin.dashboard.calendar', [
                        'totalBookingsThisCalendar' => $totalBookingsThisCalendar,
                        'totalConfirmedAmountThisCalendar' => $totalConfirmedAmountThisCalendar,
                        'statusPercentages' => $statusPercentages,
                        'paymentMethodPercentages' => $paymentMethodPercentages,
                        'startDate' => $startDate->toDateString(), // Truyền ngày bắt đầu khoảng thời gian
                        'endDate' => $endDate->toDateString() // Truyền ngày kết thúc khoảng thời gian
                    ]);
                } catch (\Exception $e) {
                    toastr()->error('Ngày không hợp lệ');
                    return redirect()->route('dashboard.invoice.day');
                }
            } else {
                toastr()->error('Vui lòng chọn đầy đủ ngày');
                return redirect()->route('dashboard.invoice.day');
            }
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            if ($startDate > $endDate) {
                toastr()->error('Ngày bắt đầu không được lớn hơn ngày kết thúc');
                return redirect()->route('dashboard.invoice.day');
            }
            if ($startDate && $endDate) {
                try {
                    $startDate = Carbon::parse($startDate)->startOfDay();
                    $endDate = Carbon::parse($endDate)->endOfDay();

                    $totalBookingsThisCalendar = Booking::whereBetween('created_at', [$startDate, $endDate])->whereIn('showtime_id', $showtimeIds)->count();

                    $totalConfirmedAmountThisCalendar = Booking::where('status', 3)
                        ->whereIn('showtime_id', $showtimeIds)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->sum('total');

                    $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->whereIn('showtime_id', $showtimeIds)->count();

                    $statusCounts = Booking::whereBetween('created_at', [$startDate, $endDate])
                        ->whereIn('showtime_id', $showtimeIds)
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
                        ->whereIn('showtime_id', $showtimeIds)
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
                        'startDate' => $startDate->toDateString(), // Truyền ngày bắt đầu khoảng thời gian
                        'endDate' => $endDate->toDateString() // Truyền ngày kết thúc khoảng thời gian
                    ]);
                } catch (\Exception $e) {
                    toastr()->error('Ngày không hợp lệ');
                    return redirect()->route('dashboard.invoice.day');
                }
            } else {
                toastr()->error('Vui lòng chọn đầy đủ ngày');
                return redirect()->route('dashboard.invoice.day');
            }
        }
    }

    public function getCountStatusCalendar(Request $request)
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
            try {
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                if ($startDate && $endDate) {
                    $endDate = Carbon::parse($endDate)->endOfDay();
                    $startDate = Carbon::parse($startDate)->startOfDay();

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
                } else {
                    return response()->json(['error' => 'Vui lòng chọn đầy đủ ngày.'], 400);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
            }
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            try {
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                if ($startDate && $endDate) {
                    $endDate = Carbon::parse($endDate)->endOfDay();
                    $startDate = Carbon::parse($startDate)->startOfDay();

                    $status2Count = Booking::where('status', 2)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->whereIn('showtime_id', $showtimeIds)
                        ->count();

                    $status3Count = Booking::where('status', 3)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->whereIn('showtime_id', $showtimeIds)
                        ->count();

                    $status4Count = Booking::where('status', 4)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->whereIn('showtime_id', $showtimeIds)
                        ->count();

                    return response()->json([
                        'status2' => $status2Count,
                        'status3' => $status3Count,
                        'status4' => $status4Count,
                    ]);
                } else {
                    return response()->json(['error' => 'Vui lòng chọn đầy đủ ngày.'], 400);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
            }
        }
    }

    public function twentyEight(Request $request)
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
            $endDate = Carbon::now()->endOfDay();
            $startDate = Carbon::now()->subDays(27)->startOfDay(); // 28 days ago

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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            $endDate = Carbon::now()->endOfDay();
            $startDate = Carbon::now()->subDays(27)->startOfDay(); // 28 days ago

            $totalBookingsThisTwentyEight = Booking::whereBetween('created_at', [$startDate, $endDate])->whereIn('showtime_id', $showtimeIds)->count();

            $totalConfirmedAmountThisTwentyEight = Booking::where('status', 3)
                ->whereIn('showtime_id', $showtimeIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total');

            $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->whereIn('showtime_id', $showtimeIds)->count();

            $statusCounts = Booking::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('showtime_id', $showtimeIds)
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
                ->whereIn('showtime_id', $showtimeIds)
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
    }

    public function getCountStatusSeven()
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
            try {
                $endDate = Carbon::now()->endOfDay();
                $startDate = Carbon::now()->subDays(6)->startOfDay(); // Ngày 7 ngày trước

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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            try {
                $endDate = Carbon::now()->endOfDay();
                $startDate = Carbon::now()->subDays(6)->startOfDay(); // Ngày 7 ngày trước

                $status2Count = Booking::where('status', 2)
                    ->whereIn('showtime_id', $showtimeIds)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

                $status3Count = Booking::where('status', 3)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->whereIn('showtime_id', $showtimeIds)
                    ->count();

                $status4Count = Booking::where('status', 4)
                    ->whereIn('showtime_id', $showtimeIds)
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
    }

    public function getCountStatusTwentyEight()
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
            try {
                $endDate = Carbon::now()->endOfDay();
                $startDate = Carbon::now()->subDays(27)->startOfDay(); // Ngày 28 ngày trước

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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            try {
                $endDate = Carbon::now()->endOfDay();
                $startDate = Carbon::now()->subDays(27)->startOfDay(); // Ngày 28 ngày trước

                $status2Count = Booking::where('status', 2)
                    ->whereIn('showtime_id', $showtimeIds)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

                $status3Count = Booking::where('status', 3)
                    ->whereIn('showtime_id', $showtimeIds)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

                $status4Count = Booking::where('status', 4)
                    ->whereIn('showtime_id', $showtimeIds)
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
    }

    public function fetchLastSevenDaysData(Request $request)
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {

            // Lấy ngày hiện tại
            $endDate = Carbon::now()->endOfDay();

            // Lấy ngày 7 ngày trước
            $startDate = Carbon::now()->subDays(6)->startOfDay();

            // Truy vấn cơ sở dữ liệu để lấy doanh thu từ bảng bookings trong khoảng thời gian này
            $revenueData = Booking::where('status', 3)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_amount'))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy(DB::raw('DATE(created_at)'))
                ->pluck('total_amount', 'date');

            return response()->json(['revenueData' => $revenueData]);
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            // Lấy ngày hiện tại
            $endDate = Carbon::now()->endOfDay();

            // Lấy ngày 7 ngày trước
            $startDate = Carbon::now()->subDays(6)->startOfDay();

            // Truy vấn cơ sở dữ liệu để lấy doanh thu từ bảng bookings trong khoảng thời gian này
            $revenueData = Booking::where('status', 3)
                ->whereIn('showtime_id', $showtimeIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_amount'))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy(DB::raw('DATE(created_at)'))
                ->pluck('total_amount', 'date');

            return response()->json(['revenueData' => $revenueData]);
        }
    }

    public function fetchLastTwentyEightDaysData(Request $request)
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
            // Lấy ngày hiện tại
            $endDate = Carbon::now()->endOfDay();

            // Lấy ngày 28 ngày trước
            $startDate = Carbon::now()->subDays(27)->startOfDay();

            // Truy vấn cơ sở dữ liệu để lấy doanh thu từ bảng bookings trong khoảng thời gian này
            $revenueData = Booking::where('status', 3)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_amount'))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy(DB::raw('DATE(created_at)'))
                ->pluck('total_amount', 'date');

            return response()->json(['revenueData' => $revenueData]);
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            // Lấy ngày hiện tại
            $endDate = Carbon::now()->endOfDay();

            // Lấy ngày 28 ngày trước
            $startDate = Carbon::now()->subDays(27)->startOfDay();

            // Truy vấn cơ sở dữ liệu để lấy doanh thu từ bảng bookings trong khoảng thời gian này
            $revenueData = Booking::where('status', 3)
                ->whereIn('showtime_id', $showtimeIds)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total_amount'))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy(DB::raw('DATE(created_at)'))
                ->pluck('total_amount', 'date');

            return response()->json(['revenueData' => $revenueData]);
        }
    }

    public function fetchDailyData(Request $request)
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Truy vấn cơ sở dữ liệu để lấy thống kê theo ngày trong khoảng ngày được chọn
            $dailyData = Booking::where('status', 3)
                ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                ->selectRaw('DATE(created_at) as date, SUM(total) as total_amount')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy(DB::raw('DATE(created_at)'))
                ->pluck('total_amount', 'date');

            return response()->json(['dailyData' => $dailyData]);
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Truy vấn cơ sở dữ liệu để lấy thống kê theo ngày trong khoảng ngày được chọn
            $dailyData = Booking::where('status', 3)
                ->whereIn('showtime_id', $showtimeIds)
                ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                ->selectRaw('DATE(created_at) as date, SUM(total) as total_amount')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy(DB::raw('DATE(created_at)'))
                ->pluck('total_amount', 'date');

            return response()->json(['dailyData' => $dailyData]);
        }
    }

    public function week(Request $request)
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            $currentWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $totalBookingsThisWeek = Booking::whereBetween('created_at', [$currentWeek, $endOfWeek])->whereIn('showtime_id', $showtimeIds)
                ->count();

            $totalConfirmedAmountThisWeek = Booking::where('status', 3)
                ->whereIn('showtime_id', $showtimeIds)
                ->whereBetween('created_at', [$currentWeek, $endOfWeek])
                ->sum('total');

            $totalBookings = Booking::whereBetween('created_at', [$currentWeek, $endOfWeek])->whereIn('showtime_id', $showtimeIds)->count();

            $statusCounts = Booking::whereBetween('created_at', [$currentWeek, $endOfWeek])
                ->whereIn('showtime_id', $showtimeIds)
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
                ->whereIn('showtime_id', $showtimeIds)
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
    }

    public function getWeeklyRevenue()
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            try {
                $currentWeekStart = Carbon::now()->startOfWeek();
                $currentWeekEnd = Carbon::now()->endOfWeek();

                // Lấy dữ liệu theo từng ngày trong tuần và tổng doanh thu tương ứng
                $weeklyRevenueData = Booking::selectRaw('DATE(created_at) as week, SUM(total) as total_amount')
                    ->whereIn('showtime_id', $showtimeIds)
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
    }

    public function getCountStatusWeek()
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            try {
                $currentWeekStart = Carbon::now()->startOfWeek();
                $currentWeekEnd = Carbon::now()->endOfWeek();

                $status2Count = Booking::where('status', 2)->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->whereIn('showtime_id', $showtimeIds)->count();
                $status3Count = Booking::where('status', 3)->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->whereIn('showtime_id', $showtimeIds)->count();
                $status4Count = Booking::where('status', 4)->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])->whereIn('showtime_id', $showtimeIds)->count();

                return response()->json([
                    'status2' => $status2Count,
                    'status3' => $status3Count,
                    'status4' => $status4Count,
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
            }
        }
    }

    public function month(Request $request)
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            $totalBookingsThisMonth = Booking::whereYear('created_at', '=', Carbon::now()->year)->whereIn('showtime_id', $showtimeIds)
                ->count();

            $totalConfirmedAmountThisMonth = Booking::where('status', 3)
                ->whereIn('showtime_id', $showtimeIds)
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->sum('total');

            $totalBookings = Booking::whereYear('created_at', '=', Carbon::now()->year)->whereIn('showtime_id', $showtimeIds)->count();

            $statusCounts = Booking::whereYear('created_at', '=', Carbon::now()->year)
                ->whereIn('showtime_id', $showtimeIds)
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
                ->whereIn('showtime_id', $showtimeIds)
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
    }

    public function getCountStatusMonth()
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            try {
                $status2Count = Booking::where('status', 2)->whereYear('created_at', '=', Carbon::now()->year)->whereIn('showtime_id', $showtimeIds)->count();
                $status3Count = Booking::where('status', 3)->whereYear('created_at', '=', Carbon::now()->year)->whereIn('showtime_id', $showtimeIds)->count();
                $status4Count = Booking::where('status', 4)->whereYear('created_at', '=', Carbon::now()->year)->whereIn('showtime_id', $showtimeIds)->count();

                return response()->json([
                    'status2' => $status2Count,
                    'status3' => $status3Count,
                    'status4' => $status4Count,
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Lỗi khi lấy thông tin booking theo trạng thái.'], 500);
            }
        }
    }

    public function getMonthlyRevenue()
    {
        $user = Auth::user(); // Hoặc cách lấy thông tin người dùng tương ứng với ứng dụng của bạn
        $roleNames = $user->getRoleNames()->toArray();
        if (in_array('Admin', $roleNames)) {
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
        } else {
            // Lấy role_id từ bảng role_has_cinema
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            $cinemaIds = RoleHasCinema::whereIn('role_id', $roleIds)->pluck('cinema_id')->toArray();
            // Lấy danh sách room_id từ bảng rooms dựa trên cinema_ids
            $roomIds = Room::whereIn('cinema_id', $cinemaIds)->pluck('id')->toArray();
            $showtimeIds = ShowTime::whereIn('room_id', $roomIds)->pluck('id')->toArray(); // Lấy danh sách các showtimeIds

            try {
                // Lấy dữ liệu theo từng tháng và tổng doanh thu tương ứng
                $monthlyRevenueData = Booking::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total_amount')
                    ->whereIn('showtime_id', $showtimeIds)
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


    public function getViewMovie(Request $request)
    {
        $query = MovieView::query()->with('movie');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('movie', function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->input('start_date'))->startOfDay();
            $end_date = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->whereBetween('date', [$start_date, $end_date]);
        }

        $query->join('movies', 'movies.id', '=', 'movie_views.movie_id')
            ->where('movies.start_date', '<=', now()) // Chỉ lấy những bộ phim đã và đang công chiếu
            ->select('movie_id', 'movies.name', DB::raw('DATE(date) as date'), DB::raw('SUM(count) as total_views'))
            ->groupBy('movie_id', 'movies.name', 'date')
            ->orderBy('total_views', 'desc');

        $movieView = $query->paginate(5);

        return view('admin.dashboard.view-day', compact('movieView'));
    }

    public function getViewMovieSevenDays(Request $request)
    {
        $query = MovieView::query();
        $startDate = Carbon::now()->subDays(7);
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->where('date', '>=', $startDate)
            ->where('movies.start_date', '<=', Carbon::now())
            ->join('movies', 'movie_views.movie_id', '=', 'movies.id')
            ->select(
                'movie_views.movie_id',
                'movies.name as movie_name',
                'movies.start_date as date',
                DB::raw('SUM(movie_views.count) as total_views'),
            )
            ->groupBy('movie_views.movie_id', 'movies.name', 'movies.start_date')
            ->orderBy('total_views', 'desc');
        $movieView = $query->paginate(5);
        return view('admin.dashboard.view-day-7', compact('movieView'));
    }

    public function getViewMovieTwentyEightDays(Request $request)
    {
        $query = MovieView::query();
        $startDate = Carbon::now()->subDays(28);
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        $query->where('date', '>=', $startDate)
            ->where('movies.start_date', '<=', Carbon::now())
            ->join('movies', 'movie_views.movie_id', '=', 'movies.id')
            ->select(
                'movie_views.movie_id',
                'movies.name as movie_name',
                'movies.start_date as date',
                DB::raw('SUM(movie_views.count) as total_views'),
            )
            ->groupBy('movie_views.movie_id', 'movies.name', 'movies.start_date')
            ->orderBy('total_views', 'desc');
        $movieView = $query->paginate(5);
        return view('admin.dashboard.view-day-28', compact('movieView'));
    }

    public function getViewByDay()
    {
        $totalViewsToday = MovieView::whereDate('date', Carbon::today())
            ->join('movies', 'movie_views.movie_id', '=', 'movies.id')
            ->select('movies.name', DB::raw('SUM(movie_views.count) as total_views'))
            ->groupBy('movies.name')
            ->orderByDesc('total_views')
            ->first();
        $showTimesToday = ShowTime::whereDate('start_date', Carbon::today())->count();
        $viewsToday = MovieView::whereDate('date', Carbon::today())
            ->select('date', 'count')
            ->get();
        $topMoviesToday = MovieView::whereDate('date', Carbon::today())
            ->join('movies', 'movie_views.movie_id', '=', 'movies.id')
            ->select('movies.name', DB::raw('SUM(movie_views.count) as total_views'))
            ->groupBy('movies.name')
            ->orderByDesc('total_views')
            ->take(10)
            ->get();
        return view('admin.dashboard.view-by-day', compact('totalViewsToday', 'showTimesToday', 'viewsToday', 'topMoviesToday'));
    }

    public function getViewByWeek()
    {
        // Lấy tổng số lượt xem của phim có lượt xem nhiều nhất trong tuần
        $mostViewedMovie = MovieView::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->join('movies', 'movie_views.movie_id', '=', 'movies.id')
            ->select('movies.name', DB::raw('SUM(movie_views.count) as total_views'))
            ->groupBy('movies.name')
            ->orderByDesc('total_views')
            ->first();

        // Lấy tổng số lịch chiếu trong tuần
        $showTimesWeek = ShowTime::whereBetween('start_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        // Lấy thông tin chi tiết về lượt xem của từng phim trong tuần
        $viewsWeek = MovieView::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->select('date', 'count')
            ->get();

        // Lấy top 10 phim được xem nhiều nhất trong tuần
        $topMoviesWeek = MovieView::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->join('movies', 'movie_views.movie_id', '=', 'movies.id')
            ->select('movies.name', DB::raw('SUM(movie_views.count) as total_views'))
            ->groupBy('movies.name')
            ->orderByDesc('total_views')
            ->take(10)
            ->get();

        return view('admin.dashboard.view-by-week', compact('mostViewedMovie', 'showTimesWeek', 'viewsWeek', 'topMoviesWeek'));
    }

    public function hourlyData()
    {
        // Replace 'your_date_here' with the date for which you want hourly data
        $selectedDate = Carbon::now();

        $hourlyData = MovieView::select(
            DB::raw('HOUR(date) as hour'),
            DB::raw('SUM(count) as total_views')
        )
            ->whereDate('date', $selectedDate)
            ->groupBy(DB::raw('HOUR(date)'))
            ->orderBy(DB::raw('HOUR(date)'))
            ->get();

        return response()->json($hourlyData);
    }

    public function weeklyData()
    {
        $selectedDate = Carbon::now();

        $weeklyViewsData = MovieView::select(
            DB::raw('DATE(date) as date'),
            DB::raw('SUM(count) as total_views')
        )
            ->whereBetween('date', [
                Carbon::now()->startOfWeek(), // Ngày đầu tuần
                Carbon::now()->endOfWeek()    // Ngày cuối tuần
            ])
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy(DB::raw('DATE(date)'))
            ->get();

        $data = [];
// Mảng chứa các nhãn thứ 'T2', 'T3',..., 'T8'
        $daysOfWeek = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'];

// Lặp qua dữ liệu và lưu vào mảng
        foreach ($weeklyViewsData as $views) {
            // Lấy số thứ tự của ngày trong tuần
            $dayOfWeekNumber = date('N', strtotime($views->date));

            // Lấy nhãn thứ tương ứng
            $label = $daysOfWeek[$dayOfWeekNumber - 1]; // -1 vì PHP bắt đầu từ 1, thứ hai là ngày thứ 2

            $data[] = [
                'label' => $label,
                'value' => $views->total_views
            ];
        }

        return response()->json($data);
    }

    public function getViewByMonth()
    {
// Lấy tổng số lượt xem của phim có lượt xem nhiều nhất trong tháng
        $mostViewedMovie = MovieView::whereMonth('date', Carbon::now()->month)
            ->join('movies', 'movie_views.movie_id', '=', 'movies.id')
            ->select('movies.name', DB::raw('SUM(movie_views.count) as total_views'))
            ->groupBy('movies.name')
            ->orderByDesc('total_views')
            ->first();

// Lấy tổng số lịch chiếu trong tháng
        $showTimesMonth = ShowTime::whereMonth('start_date', Carbon::now()->month)->count();

// Lấy thông tin chi tiết về lượt xem của từng phim trong tháng
        $viewsMonth = MovieView::whereMonth('date', Carbon::now()->month)
            ->select('date', 'count')
            ->get();

// Lấy top 10 phim được xem nhiều nhất trong tháng
        $topMoviesMonth = MovieView::whereMonth('date', Carbon::now()->month)
            ->join('movies', 'movie_views.movie_id', '=', 'movies.id')
            ->select('movies.name', DB::raw('SUM(movie_views.count) as total_views'))
            ->groupBy('movies.name')
            ->orderByDesc('total_views')
            ->take(10)
            ->get();

        return view('admin.dashboard.view-by-month', compact('mostViewedMovie', 'showTimesMonth', 'viewsMonth', 'topMoviesMonth'));

    }

    public function monthlyData()
    {
        $selectedDate = Carbon::now();

        $monthlyViewsData = MovieView::select(
            DB::raw('YEAR(date) as year'),
            DB::raw('MONTH(date) as month'),
            DB::raw('SUM(count) as total_views')
        )
            ->whereYear('date', '=', Carbon::now()->year)
            ->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'))
            ->get();

        $data = [];
        foreach ($monthlyViewsData as $views) {
            $data[] = [
                'month' => $views->month, // Tháng
                'total_views' => $views->total_views
            ];
        }

        return response()->json($data);
    }

}
