<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PostTypeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\CinemaController;
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

Route::get('/', function () {
    return view('client.index');
})->name('index');

Route::get('movie-list', function () {
    return view('client.movies.movie-list');
})->name('movie-list');

Route::get('movie-detail', function () {
    return view('client.movies.movie-detail');
})->name('movie-detail');

Route::group(['middleware' => 'guest'], function () {
    Route::match(['GET', 'POST'], '/login', [App\Http\Controllers\Auth\AuthClientController::class, 'login'])->name('login');
    Route::match(['GET', 'POST'], '/register', [App\Http\Controllers\Auth\AuthClientController::class, 'register'])->name('register');
    Route::match(['GET', 'POST'], '/forgot-password', [App\Http\Controllers\Auth\AuthClientController::class, 'forgotPassword'])->name('forgotPassword');
});


Route::middleware(['auth'])->group(function () {
    Route::prefix('food')->group(function () {
        Route::match(['GET', 'POST'], '/', [FoodController::class, 'food'])->name('food');
        Route::get('/get-food-by-type/{foodTypeId}', [FoodController::class, 'getFoodByType']);
    });
});



// route cua google
Route::get('auth/google', [SocialController::class, 'signInwithGoogle'])->name('login_google');
Route::get('callback/google', [SocialController::class, 'callbackToGoogle']);
// ket thuc route google
// route logout
Route::get('logout', [SocialController::class, 'logout'])->name('logout');

// ket thuc route mang xa hoi
Route::prefix('admin')->group(function () {
    //login
    Route::match(['GET', 'POST'], '/login', [AuthAdminController::class, 'login'])->name('login.admin');
    //dashboard
    Route::match(['GET', 'POST'], '/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
        Route::get('/get-cinemas/{provinceId}',  [SeatController::class, 'getCinemas']);
        Route::get('/get-rooms/{cinemaId}',  [SeatController::class, 'getRooms']);
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
Route::get('movie-ticket-plan', function () {
    return view('client.movies.movie-ticket-plan');
})->name('movie-ticket-plan');

Route::get('movie-seat-plan', function () {
    return view('client.movies.movie-seat-plan');
})->name('movie-seat-plan');

Route::get('movie-checkout', function () {
    return view('client.movies.movie-checkout');
})->name('movie-checkout');

Route::get('movie-food', function () {
    return view('client.movies.movie-food');
})->name('movie-food');

Route::get('blog', function () {
    return view('client.blogs.blog');
})->name('blog');

Route::get('about-us', function () {
    return view('client.pages.about-us');
})->name('about-us');

Route::get('contact', function () {
    return view('client.contacts.contact');
})->name('contact');



