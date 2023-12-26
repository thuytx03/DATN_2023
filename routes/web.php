<?php

use App\Http\Controllers\Admin\BookingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\FeedbackController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PostTypeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\CinemaController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MovieFoodsController;
use App\Http\Controllers\Admin\FoodTypesController;
use App\Http\Controllers\Admin\OrderFoodController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Auth\AuthAdminController;
use App\Http\Controllers\Client\FoodController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\FavoriteController;
use App\Http\Controllers\Client\VouchersController;
use App\Http\Controllers\Admin\ShowTimeController;
use App\Http\Controllers\Admin\SeatController;
use App\Http\Controllers\Admin\SeatTypeController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\MovieSeatPlanController;
use App\Http\Controllers\Client\MovieTicketPlanController;
use App\Http\Controllers\admin\MemberShipLevelsController;
use App\Http\Controllers\admin\MemberController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\MovieControllerClient;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\RatingController;
use Illuminate\Auth\Middleware\Authorize;
use App\Http\Controllers\client\QrcodeController;
use App\Http\Controllers\Admin\QrAdminController;
use Endroid\QrCode\QrCode;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::post('/submit-message-rating', [RatingController::class, 'submitRatingAndMessage'])->name('submit-message-rating');

// qrclinet
Route::match(['GET', 'POST'], '/qrtiketinfo/{id}', [QrcodeController::class, 'qrtiketinfo'])->name('qr.qrtiketinfo');
// ket thuc
// phim
Route::prefix('phim')->group(function () {
    Route::get('/danh-sach', [MovieControllerClient::class, 'list'])->name('phim.danh-sach');
    Route::get('/{slug}/{id}', [MovieControllerClient::class, 'detail'])->name('movie.detail');
    Route::post('/filter', [MovieControllerClient::class, 'filter'])
        ->name('movie.filter')
        ->middleware('web');
    Route::post('/search', [MovieControllerClient::class, 'search'])->name('movie.search');
    Route::get('/sap-xep', [MovieControllerClient::class, 'sort'])->name('movie.sort');
    Route::post('/search-by-name', [MovieControllerClient::class, 'searchByName'])->name('movie.searchByName');
    Route::post('/now-showing', [MovieControllerClient::class, 'nowShowingMovies'])->name('movie.showing');
});

//lịch chiếu
Route::get('/lich-chieu/{id}/{slug}', [MovieTicketPlanController::class, 'index'])->name('lich-chieu');
Route::get('/get-cinemas/{provinceId}', [MovieTicketPlanController::class, 'getCinemasByProvince']);
//kết thúc lịch chiếu

///điều khoản , chính sách
Route::get('gioi-thieu', function () {
    return view('client.about.about-us');
})->name('gioi-thieu');

Route::get('chinh-sach-thanh-toan', function () {
    return view('client.about.payment-policy');
})->name('chinh-sach-thanh-toan');
Route::get('chinh-sach-bao-mat', function () {
    return view('client.about.privacy-policy');
})->name('chinh-sach-bao-mat');
Route::get('dieu-khoan-chung', function () {
    return view('client.about.terms-conditions');
})->name('dieu-khoan-chung');
Route::get('dieu-khoan-giao-dich', function () {
    return view('client.about.terms-use');
})->name('dieu-khoan-giao-dich');
Route::get('thanh-vien', function () {
    return view('client.about.membership');
})->name('thanh-vien');
////

// danh mục mã giảm giá trang người dùng
Route::prefix('vouchers')->group(function () {
    Route::get('/voucher-list', [VouchersController::class, 'vouchers'])->name('home.voucher.list');
    Route::get('/voucher-detail/{id}', [VouchersController::class, 'detailVouchers'])->name('home.voucher.detail');
});

Route::group(['middleware' => 'guest'], function () {
    Route::match(['GET', 'POST'], '/login', [App\Http\Controllers\Auth\AuthClientController::class, 'login'])->name('login');
    Route::match(['GET', 'POST'], '/register', [App\Http\Controllers\Auth\AuthClientController::class, 'register'])->name('register');
    Route::match(['GET', 'POST'], '/forgot-password', [App\Http\Controllers\Auth\AuthClientController::class, 'forgotPassword'])->name('forgotPassword');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('food')->group(function () {
        Route::match(['GET', 'POST'], '/', [FoodController::class, 'food'])->name('food');
        Route::match(['GET', 'POST'], '/get-food-by-type/{foodTypeId}', [FoodController::class, 'getFoodByType']);
        Route::match(['GET', 'POST'], '/check-voucher', [FoodController::class, 'checkVoucher']);
    });
});

// phim yeu thich
Route::prefix('favorite')->group(function () {
    // Route::get('/favorite-list', [favorite::class, 'favorite'])->name('home.favorite.list');
    Route::get('/add/{id}', [FavoriteController::class, 'addFavorite'])->name('home.favorite.add');
    Route::get('/list', [FavoriteController::class, 'listFavorite'])->name('home.favorite.list');
});
//blogs
Route::get('bai-viet', [PostController::class, 'index'])->name('blog');
Route::get('/bai-viet-chi-tiet/{slug}/{id}', [PostController::class, 'show'])->name('blog-detail');

Route::middleware(['auth'])->group(function () {
    Route::prefix('vouchers')->group(function () {
        Route::post('/apllyVouchers', [VouchersController::class, 'apllyVouchers'])->name('home.voucher.apllyVouchers');
        Route::match(['GET', 'POST'], '/doi-diem', [VouchersController::class, 'exchangePoin'])->name('doi-diem');
    });
    Route::post('them-binh-luan-bai-viet', [PostController::class, 'store'])->name('blog-cmt.store');
    Route::post('tra-loi-binh-luan-bai-viet', [PostController::class, 'repStore'])->name('replie.repStore');
    //ghế
    Route::get('/lich-chieu/chon-ghe/{room_id}/{slug}/{showtime_id}', [MovieSeatPlanController::class, 'index'])->name('chon-ghe');
    Route::get('/lich-chieu/chon-do-an/{room_id}/{slug}/{showtime_id}', [MovieSeatPlanController::class, 'foodPlan'])->name('chon-do-an');
    Route::post('/save-selected-seats', [MovieSeatPlanController::class, 'saveSelectedSeats'])->name('save-selected-seats');
    Route::post('/luu-thong-tin-san-pham', [MovieSeatPlanController::class, 'luuThongTinSanPham'])->name('luu-thong-tin-san-pham');
    Route::post('/clear-seats-cache', [MovieSeatPlanController::class, 'clearSeatsCache']);

    //thanh toán
    Route::match(['GET', 'POST'], '/thanh-toan/{room_id}/{slug}/{showtime_id}', [BookingController::class, 'index'])->name('thanh-toan');
    Route::match(['GET', 'POST'], '/thanh-toan/do-an', [BookingController::class, 'ticketFood'])->name('thanh-toan.do-an');
    Route::get('/camon', [BookingController::class, 'thanks'])->name('camonthanhtoan');

    // paypal
    Route::get('paypal', [BookingController::class, 'paypal'])->name('paypal');
    Route::get('paypal/payment/{id}', [BookingController::class, 'payment'])->name('paypal.payment');
    Route::get('paypal/payment/success/{id}', [BookingController::class, 'paymentSuccess'])->name('paypal.payment.success');
    Route::get('paypal/payment/cancel', [BookingController::class, 'paymentCancel'])->name('paypal.payment/cancel');
    // hết paypal

    //profile
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/lich-su-giao-dich-ve', [ProfileController::class, 'transaction_history'])->name('profile.history');
    Route::get('/chi-tiet/lich-su-giao-dich-ve/{id}', [ProfileController::class, 'transaction_history_detail'])->name('transaction.history.detail');
    Route::match(['GET', 'POST'], '/change-password', [ProfileController::class, 'change_password'])->name('profile.changePassword');
    Route::match(['GET', 'POST'], '/edit-profile', [ProfileController::class, 'edit_profile'])->name('profile.edit');
    Route::match(['GET', 'POST'], '/points', [ProfileController::class, 'points'])->name('profile.points');
    Route::match(['GET', 'POST'], '/member', [ProfileController::class, 'member'])->name('profile.member');
});

//contact
Route::get('contact', function () {
    return view('client.contacts.contact');
})->name('contact');

// route cua google
Route::get('auth/google', [SocialController::class, 'signInwithGoogle'])->name('login_google');
Route::get('callback/google', [SocialController::class, 'callbackToGoogle']);
// ket thuc route google
// route logout
Route::get('logout', [SocialController::class, 'logout'])->name('logout');

// ket thuc route mang xa hoi
Route::match(['GET', 'POST'], '/admin/login', [AuthAdminController::class, 'login'])->name('login.admin');

Route::group(['prefix' => 'admin', 'middleware' => 'auth.check'], function () {
    //dashboard
    Route::group(['prefix' => 'dashboard'], function () {
        // Các route trong nhóm 'dashboard' với middleware 'role:manager'
        Route::match(['GET', 'POST'], '/', [DashboardController::class, 'user'])->name('dashboard.user');
        Route::match(['GET', 'POST'], '/invoice/day', [DashboardController::class, 'day'])->name('dashboard.invoice.day');
        Route::match(['GET', 'POST'], '/invoice/day/hourly-data', [DashboardController::class, 'getHourlyRevenue']);
        Route::match(['GET', 'POST'], '/invoice/day/getCountStatusDay', [DashboardController::class, 'getCountStatusDay']);
        Route::match(['GET', 'POST'], '/invoice/day/fetchLastSevenDaysData', [DashboardController::class, 'fetchLastSevenDaysData']);
        Route::match(['GET', 'POST'], '/invoice/day/fetchLastTwentyEightDaysData', [DashboardController::class, 'fetchLastTwentyEightDaysData']);
        Route::match(['GET', 'POST'], '/invoice/day/fetchDailyData', [DashboardController::class, 'fetchDailyData']);
        Route::match(['GET', 'POST'], '/invoice/day/7', [DashboardController::class, 'sevenDay'])->name('dashboard.invoice.seven');
        Route::match(['GET', 'POST'], '/invoice/day/28', [DashboardController::class, 'twentyEight'])->name('dashboard.invoice.TwentyEight');
        Route::match(['GET', 'POST'], '/invoice/day/calendar', [DashboardController::class, 'calendar'])->name('dashboard.invoice.calendar');
        Route::match(['GET', 'POST'], '/invoice/day/getCountStatusCalendar', [DashboardController::class, 'getCountStatusCalendar']);
        Route::match(['GET', 'POST'], '/invoice/day/getCountStatusSeven', [DashboardController::class, 'getCountStatusSeven']);
        Route::match(['GET', 'POST'], '/invoice/day/getCountStatusTwentyEight', [DashboardController::class, 'getCountStatusTwentyEight']);
        Route::match(['GET', 'POST'], '/invoice/week', [DashboardController::class, 'week'])->name('dashboard.invoice.week');
        Route::match(['GET', 'POST'], '/invoice/week/weekly-data', [DashboardController::class, 'getWeeklyRevenue']);
        Route::match(['GET', 'POST'], '/invoice/week/getCountStatusWeek', [DashboardController::class, 'getCountStatusWeek']);
        Route::match(['GET', 'POST'], '/invoice/month', [DashboardController::class, 'month'])->name('dashboard.invoice.month');
        Route::match(['GET', 'POST'], '/invoice/month/monthly-data', [DashboardController::class, 'getMonthlyRevenue']);
        Route::match(['GET', 'POST'], '/invoice/month/getCountStatusMonth', [DashboardController::class, 'getCountStatusMonth']);
        Route::match(['GET', 'POST'], '/getMonthlyStats', [DashboardController::class, 'getMonthlyStats']);
        Route::match(['GET', 'POST'], '/getUserCounts', [DashboardController::class, 'getUserCounts']);
    });
    Route::prefix('view')->group(function () {
        Route::match(['GET', 'POST'], '/', [DashboardController::class, 'getViewMovie'])->name('dashboard.view');
        Route::match(['GET', 'POST'], '/view-day', [DashboardController::class, 'getViewByDay'])->name('dashboard.view-by-day');
        Route::match(['GET', 'POST'], '/view-week', [DashboardController::class, 'getViewByWeek'])->name('dashboard.view-by-week');
        Route::match(['GET', 'POST'], '/view-month', [DashboardController::class, 'getViewByMonth'])->name('dashboard.view-by-month');
        Route::get( '/hourlyData', [DashboardController::class, 'hourlyData'])->name('dashboard.hourlyData');
        Route::get( '/weeklyData', [DashboardController::class, 'weeklyData'])->name('dashboard.weeklyData');
        Route::get( '/monthlyData', [DashboardController::class, 'monthlyData'])->name('dashboard.monthlyData');
        Route::match(['GET', 'POST'], '/fetchLastSevenDaysData', [DashboardController::class, 'getViewMovieSevenDays'])->name('dashboard.view.seven');
        Route::match(['GET', 'POST'], '/fetchLastTwentyEightDaysData', [DashboardController::class, 'getViewMovieTwentyEightDays'])->name('dashboard.view.twenty');
    });
    //role
    Route::prefix('role')->group(function () {
        Route::match(['GET', 'POST'], '/', [RoleController::class, 'index'])->name('role.list');
        Route::match(['GET', 'POST'], '/store', [RoleController::class, 'store'])->name('role.add');
        Route::match(['GET', 'POST'], '/create', [RoleController::class, 'create'])->name('role.form-add');
        Route::match(['GET', 'POST'], '/edit/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::match(['GET', 'POST'], '/update/{id}', [RoleController::class, 'show'])->name('role.form-update');
        Route::match(['GET', 'POST'], '/destroy/{id}', [RoleController::class, 'destroy'])->name('role.delete');
        Route::match(['GET', 'POST'], '/deleteAll', [RoleController::class, 'deleteAll'])->name('role.delete-all');
        Route::match(['GET', 'POST'], '/bin', [RoleController::class, 'list_bin'])->name('bin.list-role');
        Route::match(['GET', 'POST'], '/restore/{id}', [RoleController::class, 'restore_bin'])->name('bin.restore-role');
        Route::match(['GET', 'POST'], '/restoreSelected', [RoleController::class, 'restore_bin_all'])->name('bin.restore-role-all');
        Route::match(['GET', 'POST'], '/delete/{id}', [RoleController::class, 'delete_bin'])->name('bin.delete-role');
        Route::match(['GET', 'POST'], '/permanentlyDeleteSelected', [RoleController::class, 'delete_bin_all'])->name('bin.delete-role-all');
    });
    //permission
    Route::prefix('permission')->group(function () {
        Route::match(['GET', 'POST'], '/', [PermissionController::class, 'index'])->name('permission.list');
        Route::match(['GET', 'POST'], '/store', [PermissionController::class, 'store'])->name('permission.add');
        Route::match(['GET', 'POST'], '/create', [PermissionController::class, 'create'])->name('permission.form-add');
        Route::match(['GET', 'POST'], '/edit/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::match(['GET', 'POST'], '/update/{id}', [PermissionController::class, 'show'])->name('permission.form-update');
        Route::match(['GET', 'POST'], '/destroy/{id}', [PermissionController::class, 'destroy'])->name('permission.delete');
        Route::match(['GET', 'POST'], '/deleteAll', [PermissionController::class, 'deleteAll'])->name('permission.delete-all');
        Route::match(['GET', 'POST'], '/bin', [PermissionController::class, 'list_bin'])->name('bin.list-permission');
        Route::match(['GET', 'POST'], '/restore/{id}', [PermissionController::class, 'restore_bin'])->name('bin.restore-permission');
        Route::match(['GET', 'POST'], '/restoreSelected', [PermissionController::class, 'restore_bin_all'])->name('bin.restore-permission-all');
        Route::match(['GET', 'POST'], '/delete/{id}', [PermissionController::class, 'delete_bin'])->name('bin.delete-permission');
        Route::match(['GET', 'POST'], '/permanentlyDeleteSelected', [PermissionController::class, 'delete_bin_all'])->name('bin.delete-permission-all');
    });
    Route::prefix('qrcode')->group(function () {
        Route::match(['GET', 'POST'], '/', [QrAdminController::class, 'index'])->name('qr.scanner');
        Route::match(['GET', 'POST'], '/store', [QrAdminController::class, 'store'])->name('qr.store');
        Route::match(['GET', 'POST'], '/qrcodeScanner/{id}', [QrcodeController::class, 'checkQr'])->name('qr.scan');
        Route::match(['GET', 'POST'], '/printfPDF', [QrAdminController::class, 'inPdf'])->name('qr.inPdf');
        Route::match(['GET', 'POST'], '/printfWord', [QrAdminController::class, 'processForm'])->name('qr.printfWord');
    });
    Route::prefix('membershiplevels')->group(function () {
        Route::match(['GET', 'POST'], '/', [MemberShipLevelsController::class, 'index'])->name('MBSL.list');
        Route::match(['GET', 'POST'], '/create', [MemberShipLevelsController::class, 'create'])->name('MBSL.add');
        Route::match(['GET', 'POST'], '/store', [MemberShipLevelsController::class, 'store'])->name('MBSL.store');
        Route::match(['GET', 'POST'], '/edit/{id}', [MemberShipLevelsController::class, 'edit'])->name('MBSL.edit');
        Route::match(['GET', 'POST'], '/update/{id}', [MemberShipLevelsController::class, 'update'])->name('MBSL.update');
        Route::get('/changeStatus/{id}', [MemberShipLevelsController::class, 'changeStatus'])->name('MBSL.changeStatus');
        Route::get('/destroy/{id}', [MemberShipLevelsController::class, 'destroy'])->name('MBSL.destroy');
        Route::get('/trash', [MemberShipLevelsController::class, 'trash'])->name('MBSL.trash');
        Route::post('/unTrashAll', [MemberShipLevelsController::class, 'restoreSelected'])->name('MBSL.unTrashAll');
        Route::get('/restore/{id}', [MemberShipLevelsController::class, 'restore'])->name('MBSL.restore');
        Route::get('/permanentlyDelete/{id}', [MemberShipLevelsController::class, 'permanentlyDelete'])->name('MBSL.permanentlyDelete');
        Route::post('/deleteAll', [MemberShipLevelsController::class, 'deleteAll'])->name('MBSL.deleteAll');
        Route::post('/permanentlyDeleteSelected', [MemberShipLevelsController::class, 'permanentlyDeleteSelected'])->name('MBSL.permanentlyDeleteSelected');
    });
    // member
    Route::prefix('member')->group(function () {
        Route::match(['GET', 'POST'], '/', [MemberController::class, 'index'])->name('member.list');
        Route::get('/changeStatus/{id}', [MemberController::class, 'changeStatus'])->name('member.changeStatus');
        Route::match(['GET', 'POST'], '/edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
        Route::match(['GET', 'POST'], '/update/{id}', [MemberController::class, 'update'])->name('member.update');
        Route::match(['GET', 'POST'], '/delete/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
        Route::get('/trash', [MemberController::class, 'trash'])->name('member.trash');
        Route::post('/unTrashAll', [MemberController::class, 'restoreSelected'])->name('member.unTrashAll');
        Route::get('/restore/{id}', [MemberController::class, 'restore'])->name('member.restore');
        Route::post('/deleteAll', [MemberController::class, 'deleteAll'])->name('member.deleteAll');
        Route::get('/permanentlyDelete/{id}', [MemberController::class, 'permanentlyDelete'])->name('member.permanentlyDelete');
        Route::post('/permanentlyDeleteSelected', [MemberController::class, 'permanentlyDeleteSelected'])->name('member.permanentlyDeleteSelected');
    });
    //room
    Route::prefix('room')->group(function () {
        Route::match(['GET', 'POST'], '/', [RoomController::class, 'index'])->name('room.list');
        Route::match(['GET', 'POST'], '/store', [RoomController::class, 'store'])->name('room.add');
        Route::match(['GET', 'POST'], '/create', [RoomController::class, 'create'])->name('room.form-add');
        Route::match(['GET', 'POST'], '/edit/{id}', [RoomController::class, 'update'])->name('room.update');
        Route::match(['GET', 'POST'], '/update/{id}', [RoomController::class, 'show'])->name('room.form-update');
        Route::match(['GET', 'POST'], '/destroy/{id}', [RoomController::class, 'destroy'])->name('room.delete');
        Route::match(['GET', 'POST'], '/deleteAll', [RoomController::class, 'deleteAll'])->name('room.delete-all');
        Route::match(['GET', 'POST'], '/update-status/{id}', [RoomController::class, 'updateStatus'])->name('room.update-status');
        Route::match(['GET', 'POST'], '/bin', [RoomController::class, 'list_bin'])->name('bin.list-room');
        Route::match(['GET', 'POST'], '/restore/{id}', [RoomController::class, 'restore_bin'])->name('bin.restore-room');
        Route::match(['GET', 'POST'], '/restoreSelected', [RoomController::class, 'restore_bin_all'])->name('bin.restore-room-all');
        Route::match(['GET', 'POST'], '/delete/{id}', [RoomController::class, 'delete_bin'])->name('bin.delete-room');
        Route::match(['GET', 'POST'], '/permanentlyDeleteSelected', [RoomController::class, 'delete_bin_all'])->name('bin.delete-room-all');
    });
    //room-type
    Route::prefix('room-type')->group(function () {
        Route::match(['GET', 'POST'], '/', [RoomTypeController::class, 'index'])->name('room-type.list');
        Route::match(['GET', 'POST'], '/store', [RoomTypeController::class, 'store'])->name('room-type.add');
        Route::match(['GET', 'POST'], '/create', [RoomTypeController::class, 'create'])->name('room-type.form-add');
        Route::match(['GET', 'POST'], '/edit/{id}', [RoomTypeController::class, 'update'])->name('room-type.update');
        Route::match(['GET', 'POST'], '/update/{id}', [RoomTypeController::class, 'show'])->name('room-type.form-update');
        Route::match(['GET', 'POST'], '/destroy/{id}', [RoomTypeController::class, 'destroy'])->name('room-type.delete');
        Route::match(['GET', 'POST'], '/deleteAll', [RoomTypeController::class, 'deleteAll'])->name('room-type.delete-all');
        Route::match(['GET', 'POST'], '/update-status/{id}', [RoomTypeController::class, 'updateStatus'])->name('room-type.update-status');
        Route::match(['GET', 'POST'], '/bin', [RoomTypeController::class, 'list_bin'])->name('bin.list-room-type');
        Route::match(['GET', 'POST'], '/restore/{id}', [RoomTypeController::class, 'restore_bin'])->name('bin.restore-room-type');
        Route::match(['GET', 'POST'], '/restoreSelected', [RoomTypeController::class, 'restore_bin_all'])->name('bin.restore-room-type-all');
        Route::match(['GET', 'POST'], '/delete/{id}', [RoomTypeController::class, 'delete_bin'])->name('bin.delete-room-type');
        Route::match(['GET', 'POST'], '/permanentlyDeleteSelected', [RoomTypeController::class, 'delete_bin_all'])->name('bin.delete-room-type-all');
    });

    //order food
    Route::prefix('order')->group(function () {
        Route::match(['GET', 'POST'], '/', [OrderFoodController::class, 'index'])->name('food.list');
        Route::match(['GET', 'POST'], '/store', [OrderFoodController::class, 'store'])->name('food.add');
        Route::match(['GET', 'POST'], '/edit/{id}', [OrderFoodController::class, 'update'])->name('food.update');
        Route::match(['GET', 'POST'], '/destroy/{id}', [OrderFoodController::class, 'destroy'])->name('food.delete');
        Route::match(['GET', 'POST'], '/user/{id}', [OrderFoodController::class, 'user'])->name('food.user');
        Route::match(['GET', 'POST'], '/food/{id}', [OrderFoodController::class, 'food'])->name('food.detail');
        Route::match(['GET', 'POST'], '/update-status/{id}', [OrderFoodController::class, 'updateStatus'])->name('food.update-status');
        Route::match(['GET', 'POST'], '/deleteAll', [OrderFoodController::class, 'deleteAll'])->name('food.delete-all');
    });

    //booking
    Route::prefix('booking')->group(function () {
        Route::get('/', [BookingsController::class, 'index'])->name('booking.index');
        Route::match(['GET', 'POST'], '/store', [BookingsController::class, 'store'])->name('booking.store');
        Route::match(['GET', 'POST'], '/update/{id}', [BookingsController::class, 'update'])->name('booking.update');
        Route::post('/deleteAll', [BookingsController::class, 'deleteAll'])->name('booking.deleteAll');
        Route::get('/trash', [BookingsController::class, 'trash'])->name('booking.trash');
        Route::post('/permanentlyDeleteSelected', [BookingsController::class, 'permanentlyDeleteSelected'])->name('booking.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [BookingsController::class, 'restoreSelected'])->name('booking.restoreSelected');
        Route::get('/{id}/detail', [BookingsController::class, 'detail'])->name('booking.detail');
        Route::get('/{id}/confirm', [BookingsController::class, 'confirm'])->name('booking.confirm');
        Route::get('/{id}/unconfirm', [BookingsController::class, 'unConfirm'])->name('booking.unConfirm');
        Route::POST('/{id}/cancel', [BookingsController::class, 'cancel'])->name('booking.cancel');
    });
    /*
     * Category Blog
     */
    Route::prefix('post-type')->group(function () {
        Route::get('/', [PostTypeController::class, 'index'])->name('post-type.index');
        Route::get('/create', [PostTypeController::class, 'create'])->name('post-type.add');
        Route::post('/store', [PostTypeController::class, 'store'])->name('post-type.store');
        Route::get('/edit/{id}', [PostTypeController::class, 'edit'])->name('post-type.edit');
        Route::post('/update/{id}', [PostTypeController::class, 'update'])->name('post-type.update');
        Route::get('/destroy/{id}', [PostTypeController::class, 'destroy'])->name('post-type.destroy');
        Route::get('/trash', [PostTypeController::class, 'trash'])->name('post-type.trash');
        Route::get('/restore/{id}', [PostTypeController::class, 'restore'])->name('post-type.restore');
        Route::get('/delete/{id}', [PostTypeController::class, 'delete'])->name('post-type.delete');
        Route::post('/update-status/{id}', [PostTypeController::class, 'updateStatus'])->name('post-type.updateStatus');
        Route::post('/deleteAll', [PostTypeController::class, 'deleteAll'])->name('post-type.deleteAll');
        Route::post('/permanentlyDeleteSelected', [PostTypeController::class, 'permanentlyDeleteSelected'])->name('post-type.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [PostTypeController::class, 'restoreSelected'])->name('post-type.restoreSelected');
    });

    //route bài viết
    Route::prefix('post')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\Post\PostController::class, 'index'])->name('post.index');
        Route::get('/create', [App\Http\Controllers\Admin\Post\PostController::class, 'create'])->name('post.add');
        Route::post('/store', [App\Http\Controllers\Admin\Post\PostController::class, 'store'])->name('post.store');
        Route::post('/status/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'updateStatus']);
        Route::post('/deleteAll', [App\Http\Controllers\Admin\Post\PostController::class, 'deleteAll'])->name('post.deleteAll');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'edit'])->name('post.edit');
        Route::get('/show/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'show'])->name('post.show');
        Route::put('/update/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'update'])->name('post.update');
        // Route::post('/destroy/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'destroy'])->name('post.destroy');
        Route::get('/destroy/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'destroy'])->name('post.destroy');
        Route::get('/trash', [App\Http\Controllers\Admin\Post\PostController::class, 'trash'])->name('post.trash');
        Route::post('/permanentlyDeleteSelected', [App\Http\Controllers\Admin\Post\PostController::class, 'permanentlyDeleteSelected'])->name('post.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [App\Http\Controllers\Admin\Post\PostController::class, 'restoreSelected'])->name('post.restoreSelected');

        Route::get('/restore/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'restore'])->name('post.restore');
        Route::get('/force-delete/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'forceDelete'])->name('post.forceDelete');
    });
    ///
    Route::prefix('comment')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'index'])->name('comment.index');
        // Route::get('/create', [App\Http\Controllers\Admin\Post\PostController::class, 'create'])->name('post.add');
        // Route::post('/store', [App\Http\Controllers\Admin\Post\PostController::class, 'store'])->name('post.store');
        Route::post('/status/{id}', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'updateStatus']);
        Route::post('/deleteAll', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'deleteAll'])->name('comment.deleteAll');
        // Route::get('/edit/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'edit'])->name('post.edit');
        // Route::get('/show/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'show'])->name('post.show');
        // Route::put('/update/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'update'])->name('post.update');
        // Route::post('/destroy/{id}', [App\Http\Controllers\Admin\Post\PostController::class, 'destroy'])->name('post.destroy');
        Route::get('/destroy/{id}', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'destroy'])->name('comment.destroy');
        Route::get('/trash', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'trash'])->name('comment.trash');
        Route::post('/permanentlyDeleteSelected', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'permanentlyDeleteSelected'])->name('comment.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'restoreSelected'])->name('comment.restoreSelected');

        Route::get('/restore/{id}', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'restore'])->name('comment.restore');
        Route::get('/force-delete/{id}', [App\Http\Controllers\Admin\Post\CommentPostController::class, 'forceDelete'])->name('comment.forceDelete');
    });
    // ///// trả lời bình luận
    Route::prefix('reply')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\Post\ReplyController::class, 'index'])->name('reply.index');
        Route::post('/status/{id}', [App\Http\Controllers\Admin\Post\ReplyController::class, 'updateStatus']);
        Route::post('/deleteAll', [App\Http\Controllers\Admin\Post\ReplyController::class, 'deleteAll'])->name('reply.deleteAll');
        Route::get('/destroy/{id}', [App\Http\Controllers\Admin\Post\ReplyController::class, 'destroy'])->name('reply.destroy');
        Route::get('/trash', [App\Http\Controllers\Admin\Post\ReplyController::class, 'trash'])->name('reply.trash');
        Route::post('/permanentlyDeleteSelected', [App\Http\Controllers\Admin\Post\ReplyController::class, 'permanentlyDeleteSelected'])->name('reply.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [App\Http\Controllers\Admin\Post\ReplyController::class, 'restoreSelected'])->name('reply.restoreSelected');
        Route::get('/restore/{id}', [App\Http\Controllers\Admin\Post\ReplyController::class, 'restore'])->name('reply.restore');
        Route::get('/force-delete/{id}', [App\Http\Controllers\Admin\Post\ReplyController::class, 'forceDelete'])->name('reply.forceDelete');
    });

    // ///////////
    /*
     * Movie Genre
     */
    Route::prefix('genre')->group(function () {
        Route::get('/', [GenreController::class, 'index'])->name('genre.index');
        Route::get('/create', [GenreController::class, 'create'])->name('genre.add');
        Route::post('/store', [GenreController::class, 'store'])->name('genre.store');
        Route::get('/edit/{id}', [GenreController::class, 'edit'])->name('genre.edit');
        Route::post('/update/{id}', [GenreController::class, 'update'])->name('genre.update');
        Route::get('/destroy/{id}', [GenreController::class, 'destroy'])->name('genre.destroy');
        Route::get('/trash', [GenreController::class, 'trash'])->name('genre.trash');
        Route::get('/restore/{id}', [GenreController::class, 'restore'])->name('genre.restore');
        Route::get('/delete/{id}', [GenreController::class, 'delete'])->name('genre.delete');
        Route::post('/update-status/{id}', [GenreController::class, 'updateStatus'])->name('genre.updateStatus');
        Route::post('/deleteAll', [GenreController::class, 'deleteAll'])->name('genre.deleteAll');
        Route::post('/permanentlyDeleteSelected', [GenreController::class, 'permanentlyDeleteSelected'])->name('genre.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [GenreController::class, 'restoreSelected'])->name('genre.restoreSelected');
    });
    /*
     * Movie
     */
    Route::prefix('movie')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('movie.index');
        Route::get('/create', [MovieController::class, 'create'])->name('movie.add');
        Route::post('/store', [MovieController::class, 'store'])->name('movie.store');
        Route::get('/edit/{id}', [MovieController::class, 'edit'])->name('movie.edit');
        Route::get('/show/{id}', [MovieController::class, 'show'])->name('movie.show');
        Route::post('/update/{id}', [MovieController::class, 'update'])->name('movie.update');
        Route::get('/destroy/{id}', [MovieController::class, 'destroy'])->name('movie.destroy');
        Route::get('/trash', [MovieController::class, 'trash'])->name('movie.trash');
        Route::post('/update-status/{id}', [MovieController::class, 'updateStatus'])->name('movie.updateStatus');
        Route::get('/restore/{id}', [MovieController::class, 'restore'])->name('movie.restore');
        Route::get('/delete/{id}', [MovieController::class, 'delete'])->name('movie.delete');
        Route::post('/deleteAll', [MovieController::class, 'deleteAll'])->name('movie.deleteAll');
        Route::post('/permanentlyDeleteSelected', [MovieController::class, 'permanentlyDeleteSelected'])->name('movie.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [MovieController::class, 'restoreSelected'])->name('movie.restoreSelected');
    });
    Route::prefix('/feed-back')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('feed-back.index');
        Route::get('/destroy/{id}', [FeedbackController::class, 'destroy'])->name('feed-back.destroy');
        Route::get('/trash', [FeedbackController::class, 'trash'])->name('feed-back.trash');
        Route::post('/deleteAll', [FeedbackController::class, 'deleteAll'])->name('feed-back.deleteAll');
        Route::get('/delete/{id}', [FeedbackController::class, 'delete'])->name('feed-back.delete');
        Route::get('/restore/{id}', [FeedbackController::class, 'restore'])->name('feed-back.restore');
        Route::post('/permanentlyDeleteSelected', [FeedbackController::class, 'permanentlyDeleteSelected'])->name('feed-back.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [FeedbackController::class, 'restoreSelected'])->name('feed-back.restoreSelected');
    });

    // đồ ăn
    Route::prefix('movie-food')->group(function () {
        Route::get('/', [MovieFoodsController::class, 'index'])->name('movie-foode.index');
        Route::get('/create', [MovieFoodsController::class, 'create'])->name('movie-foode.add');
        Route::post('/store', [MovieFoodsController::class, 'store'])->name('movie-foode.store');
        Route::get('/edit/{id}', [MovieFoodsController::class, 'edit'])->name('movie-foode.edit');
        Route::get('/destroy/{id}', [MovieFoodsController::class, 'destroy'])->name('movie-foode.destroy');
        Route::get('/indexsd', [MovieFoodsController::class, 'indexsd'])->name('movie-foode.indexsd');
        Route::get('/unTrash/{id}', [MovieFoodsController::class, 'unTrash'])->name('movie-foode.unTrash');
        Route::get('/destroyTrash/{id}', [MovieFoodsController::class, 'destroySoftDelete'])->name('movie-foode.destroyTrash');
        Route::post('/update/{id}', [MovieFoodsController::class, 'update'])->name('movie-foode.update');
        Route::post('/permanentlyDeleteSelected', [MovieFoodsController::class, 'permanentlyDeleteSelected'])->name('movie-foode.permanentlyDeleteSelected');
        Route::post('/unTrashAll', [MovieFoodsController::class, 'unTrashAll'])->name('movie-foode.unTrashAll');
        Route::post('/deleteAll', [MovieFoodsController::class, 'deleteAll'])->name('movie-foode.destroys');
        Route::get('/changeStatus/{id}', [MovieFoodsController::class, 'changeStatus'])->name('movie-foode.changeStatus');
    });

    Route::prefix('seat-type')->group(function () {
        Route::get('/', [SeatTypeController::class, 'index'])->name('seat-type.index');
        Route::match(['GET', 'POST'], '/store', [SeatTypeController::class, 'store'])->name('seat-type.store');
        Route::match(['GET', 'POST'], '/update/{id}', [SeatTypeController::class, 'update'])->name('seat-type.update');
        Route::get('/destroy/{id}', [SeatTypeController::class, 'destroy'])->name('seat-type.destroy');
        Route::post('/deleteAll', [SeatTypeController::class, 'deleteAll'])->name('seat-type.deleteAll');
        Route::post('/update-status/{id}', [SeatTypeController::class, 'updateStatus'])->name('seat-type.updateStatus');
        Route::get('/trash', [SeatTypeController::class, 'trash'])->name('seat-type.trash');
        Route::get('/permanentlyDelete/{id}', [SeatTypeController::class, 'permanentlyDelete'])->name('seat-type.permanentlyDelete');
        Route::post('/permanentlyDeleteSelected', [SeatTypeController::class, 'permanentlyDeleteSelected'])->name('seat-type.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [SeatTypeController::class, 'restoreSelected'])->name('seat-type.restoreSelected');
        Route::get('/restore/{id}', [SeatTypeController::class, 'restore'])->name('seat-type.restore');
    });
    Route::prefix('seat')->group(function () {
        Route::get('/', [SeatController::class, 'index'])->name('seat.index');
        Route::match(['GET', 'POST'], '/store', [SeatController::class, 'store'])->name('seat.store');
        Route::match(['GET', 'POST'], '/update/{room_id}', [SeatController::class, 'update'])->name('seat.update');
        Route::get('/destroy/{id}', [SeatController::class, 'destroy'])->name('seat.destroy');
        Route::post('/deleteAll', [SeatController::class, 'deleteAll'])->name('seat.deleteAll');
        Route::get('/get-cinemas/{provinceId}', [SeatController::class, 'getCinemas']);
        Route::get('/get-rooms/{cinemaId}', [SeatController::class, 'getRooms']);
    });

    /*
     * Showtime
     */
    Route::prefix('show-time')->group(function () {
        Route::get('/', [ShowTimeController::class, 'index'])->name('show-time.index');
        Route::get('/create', [ShowTimeController::class, 'create'])->name('show-time.add');
        Route::post('/store', [ShowTimeController::class, 'store'])->name('show-time.store');
        Route::get('/edit/{id}', [ShowTimeController::class, 'edit'])->name('show-time.edit');
        Route::get('/show/{id}', [ShowTimeController::class, 'show'])->name('show-time.show');
        Route::post('/update/{id}', [ShowTimeController::class, 'update'])->name('show-time.update');
        Route::get('/destroy/{id}', [ShowTimeController::class, 'destroy'])->name('show-time.destroy');
        Route::get('/restore/{id}', [ShowTimeController::class, 'restore'])->name('show-time.restore');
        Route::get('/trash', [ShowTimeController::class, 'trash'])->name('show-time.trash');
        Route::get('/delete/{id}', [ShowTimeController::class, 'delete'])->name('show-time.delete');
        Route::post('/update-status/{id}', [ShowTimeController::class, 'updateStatus'])->name('show-time.updateStatus');
        Route::post('/deleteAll', [ShowTimeController::class, 'deleteAll'])->name('show-time.deleteAll');
        Route::post('/permanentlyDeleteSelected', [ShowTimeController::class, 'permanentlyDeleteSelected'])->name('show-time.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [ShowTimeController::class, 'restoreSelected'])->name('show-time.restoreSelected');
    });
    Route::prefix('food_types')->group(function () {
        Route::get('/', [FoodTypesController::class, 'index'])->name('food_types.index');
        Route::get('/changeStatus/{id}', [FoodTypesController::class, 'changeStatus'])->name('food_types.changeStatus');
        Route::get('/create', [FoodTypesController::class, 'create'])->name('food_types.add');
        Route::post('/store', [FoodTypesController::class, 'store'])->name('food_types.store');
        Route::get('/edit/{id}', [FoodTypesController::class, 'edit'])->name('food_types.edit');
        Route::post('/update/{id}', [FoodTypesController::class, 'update'])->name('food_types.update');
        Route::get('/destroy/{id}', [FoodTypesController::class, 'destroy'])->name('food_types.destroy');
        Route::get('/indexsd', [FoodTypesController::class, 'indexsd'])->name('food_types.indexsd');
        Route::get('/unTrash/{id}', [FoodTypesController::class, 'unTrash'])->name('food_types.unTrash');
        Route::post('/unTrashAll', [FoodTypesController::class, 'unTrashAll'])->name('food_types.unTrashAll');
        Route::get('/destroyTrash/{id}', [FoodTypesController::class, 'destroySoftDelete'])->name('food_types.destroyTrash');
        Route::post('/deleteAllSoft', [FoodTypesController::class, 'deleteAllSoft'])->name('food_types.deleteAllSoft');
        Route::get('/filterstatus', [FoodTypesController::class, 'filterstatus'])->name('food_types.filterstatus');
        Route::post('/deleteAll', [FoodTypesController::class, 'deleteAll'])->name('food_types.destroys');
        Route::post('/permanentlyDeleteSelected', [FoodTypesController::class, 'permanentlyDeleteSelected'])->name('food_types.permanentlyDeleteSelected');
    });
    // mã giảm giá
    Route::prefix('voucher')->group(function () {
        Route::get('/', [VoucherController::class, 'index'])->name('voucher.index');
        Route::match(['GET', 'POST'], '/store', [VoucherController::class, 'store'])->name('voucher.store');
        Route::match(['GET', 'POST'], '/update/{id}', [VoucherController::class, 'update'])->name('voucher.update');
        Route::get('/destroy/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy');
        Route::post('/deleteAll', [VoucherController::class, 'deleteAll'])->name('voucher.deleteAll');
        Route::post('/update-status/{id}', [VoucherController::class, 'updateStatus'])->name('voucher.updateStatus');
        Route::get('/trash', [VoucherController::class, 'trash'])->name('voucher.trash');
        Route::get('/permanentlyDelete/{id}', [VoucherController::class, 'permanentlyDelete'])->name('voucher.permanentlyDelete');
        Route::post('/permanentlyDeleteSelected', [VoucherController::class, 'permanentlyDeleteSelected'])->name('voucher.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [VoucherController::class, 'restoreSelected'])->name('voucher.restoreSelected');
        Route::get('/restore/{id}', [VoucherController::class, 'restore'])->name('voucher.restore');
    });

    ////

    // route logo
    Route::prefix('logo')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\Logo\LogoController::class, 'index'])->name('logo.index');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\Logo\LogoController::class, 'edit'])->name('logo.edit');
        Route::put('/update/{id}', [App\Http\Controllers\Admin\Logo\LogoController::class, 'update'])->name('logo.update');
    });

    //route slider
    Route::prefix('slider')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\Slider\SliderController::class, 'index'])->name('slider.index');
        Route::get('/create', [App\Http\Controllers\Admin\Slider\SliderController::class, 'create'])->name('slider.add');
        Route::post('/store', [App\Http\Controllers\Admin\Slider\SliderController::class, 'store'])->name('slider.store');
        Route::post('/status/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'updateStatus']);
        Route::post('/deleteAll', [App\Http\Controllers\Admin\Slider\SliderController::class, 'deleteAll'])->name('slider.deleteAll');
        Route::post('/permanentlyDeleteSelected', [App\Http\Controllers\Admin\Slider\SliderController::class, 'permanentlyDeleteSelected'])->name('slider.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [App\Http\Controllers\Admin\Slider\SliderController::class, 'restoreSelected'])->name('slider.restoreSelected');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'edit'])->name('slider.edit');
        Route::get('/show/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'show'])->name('slider.show');
        Route::put('/update/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'update'])->name('slider.update');
        // Route::slider('/destroy/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'destroy'])->name('slider.destroy');
        Route::get('/destroy/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'destroy'])->name('slider.destroy');
        Route::get('/trash', [App\Http\Controllers\Admin\Slider\SliderController::class, 'trash'])->name('slider.trash');
        Route::get('/restore/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'restore'])->name('slider.restore');
        Route::get('/force-delete/{id}', [App\Http\Controllers\Admin\Slider\SliderController::class, 'forceDelete'])->name('slider.forceDelete');
    });
    // người dùng
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.add');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('/deleteAll', [UserController::class, 'deleteAll'])->name('user.deleteAll');
        Route::post('/update-status/{id}', [UserController::class, 'updateStatus'])->name('user.updateStatus');
        Route::match(['GET', 'POST'], '/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/trash', [UserController::class, 'trash'])->name('user.trash');
        Route::get('/permanentlyDelete/{id}', [UserController::class, 'permanentlyDelete'])->name('user.permanentlyDelete');
        Route::post('/permanentlyDeleteSelected', [UserController::class, 'permanentlyDeleteSelected'])->name('user.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [UserController::class, 'restoreSelected'])->name('user.restoreSelected');
        Route::get('/force-delete/{id}', [UserController::class, 'forceDelete'])->name('user.forceDelete');
        Route::get('/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
    });
    // khu vực
    Route::prefix('province')->group(function () {
        Route::get('/', [ProvinceController::class, 'index'])->name('province.index');
        Route::get('/create', [ProvinceController::class, 'create'])->name('province.add');
        Route::post('/store', [ProvinceController::class, 'store'])->name('province.store');
        Route::get('/edit/{id}', [ProvinceController::class, 'edit'])->name('province.edit');
        Route::post('/update/{id}', [ProvinceController::class, 'update'])->name('province.update');
        Route::post('/deleteAll', [ProvinceController::class, 'deleteAll'])->name('province.deleteAll');
        Route::post('/update-status/{id}', [ProvinceController::class, 'updateStatus'])->name('province.updateStatus');
        Route::match(['GET', 'POST'], '/destroy/{id}', [ProvinceController::class, 'destroy'])->name('province.destroy');
        Route::get('/trash', [ProvinceController::class, 'trash'])->name('province.trash');
        Route::get('/permanentlyDelete/{id}', [ProvinceController::class, 'permanentlyDelete'])->name('province.permanentlyDelete');
        Route::post('/permanentlyDeleteSelected', [ProvinceController::class, 'permanentlyDeleteSelected'])->name('province.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [ProvinceController::class, 'restoreSelected'])->name('province.restoreSelected');
        Route::get('/restore/{id}', [ProvinceController::class, 'restore'])->name('province.restore');
    });
    // rạp phim
    Route::prefix('cinema')->group(function () {
        Route::get('/', [CinemaController::class, 'index'])->name('cinema.index');
        Route::get('/create', [CinemaController::class, 'create'])->name('cinema.add');
        Route::post('/store', [CinemaController::class, 'store'])->name('cinema.store');
        Route::get('/edit/{id}', [CinemaController::class, 'edit'])->name('cinema.edit');
        Route::post('/deleteAll', [CinemaController::class, 'deleteAll'])->name('cinema.deleteAll');
        Route::post('/update-status/{id}', [CinemaController::class, 'updateStatus'])->name('cinema.updateStatus');
        Route::post('/update/{id}', [CinemaController::class, 'update'])->name('cinema.update');
        Route::match(['GET', 'POST'], '/destroy/{id}', [CinemaController::class, 'destroy'])->name('cinema.destroy');
        Route::get('/trash', [CinemaController::class, 'trash'])->name('cinema.trash');
        Route::get('/permanentlyDelete/{id}', [CinemaController::class, 'permanentlyDelete'])->name('cinema.permanentlyDelete');
        Route::post('/permanentlyDeleteSelected', [CinemaController::class, 'permanentlyDeleteSelected'])->name('cinema.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [CinemaController::class, 'restoreSelected'])->name('cinema.restoreSelected');
        Route::get('/restore/{id}', [CinemaController::class, 'restore'])->name('cinema.restore');
    });

    //route quốc gia
    Route::prefix('country')->group(function () {
        Route::get('/', [CountryController::class, 'index'])->name('country.index');
        Route::get('/create', [CountryController::class, 'create'])->name('country.add');
        Route::post('/store', [CountryController::class, 'store'])->name('country.store');
        Route::get('/edit/{id}', [CountryController::class, 'edit'])->name('country.edit');
        Route::post('/update/{id}', [CountryController::class, 'update'])->name('country.update');
        Route::get('/destroy/{id}', [CountryController::class, 'destroy'])->name('country.destroy');
        Route::get('/trash', [CountryController::class, 'trash'])->name('country.trash');
        Route::get('/restore/{id}', [CountryController::class, 'restore'])->name('country.restore');
        Route::get('/delete/{id}', [CountryController::class, 'delete'])->name('country.delete');
        Route::post('/update-status/{id}', [CountryController::class, 'updateStatus'])->name('country.updateStatus');
        Route::post('/deleteAll', [CountryController::class, 'deleteAll'])->name('country.deleteAll');
        Route::post('/permanentlyDeleteSelected', [CountryController::class, 'permanentlyDeleteSelected'])->name('country.permanentlyDeleteSelected');
        Route::post('/restoreSelected', [CountryController::class, 'restoreSelected'])->name('country.restoreSelected');
        Route::get('/search', [CountryController::class, 'search'])->name('country.search');
        Route::get('/permanentlyDelete/{id}', [CountryController::class, 'permanentlyDelete'])->name('country.permanentlyDelete');
    });
    Route::prefix('contact')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('contact.index');
        Route::post('/send', [ContactController::class, 'sendContact'])->name('contact.send');
        Route::get('/reply/{id}', [ContactController::class, 'reply'])->name('contact.reply');
        Route::post('/replied/{id}', [ContactController::class, 'replied'])->name('contact.replied');
        Route::get('/destroy/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
        Route::get('/trash', [ContactController::class, 'trash'])->name('contact.trash');
        Route::get('/restore/{id}', [ContactController::class, 'restore'])->name('contact.restore');
        Route::get('/delete/{id}', [ContactController::class, 'delete'])->name('contact.delete');
        Route::get('/search', [CountryController::class, 'search'])->name('contact.search');
        Route::post('/store', [ContactController::class, 'store'])->name('contact.store');
    });
});

//route ảnh
Route::get('{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);

    if (!Storage::disk('public')->exists($filename)) {
        abort(404);
    }
    return response()->file($path);
})
    ->where('filename', '(.*)')
    ->name('admin.sliders.images.show');
