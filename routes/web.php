<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PostTypeController;
<<<<<<< HEAD
use App\Http\Controllers\Admin\MovieFoodsController;
use App\Http\Controllers\Admin\FoodTypesController;

=======
use App\Http\Controllers\Admin\VoucherController;
>>>>>>> 76bc4dadfa66b045a5763406bc8acf886c2fa8b2

Route::get('/', function () {
    return view('client.index');
})->name('index');

Route::get('movie-list', function () {
    return view('client.movies.movie-list');
})->name('movie-list');

Route::group(['middleware' => 'guest'], function () {
    Route::match(['GET', 'POST'], '/login', [App\Http\Controllers\Auth\AuthClientController::class, 'login'])->name('login');
    Route::match(['GET', 'POST'], '/register', [App\Http\Controllers\Auth\AuthClientController::class, 'register'])->name('register');
    Route::match(['GET', 'POST'], '/forgot-password', [App\Http\Controllers\Auth\AuthClientController::class, 'forgotPassword'])->name('forgotPassword');
});
Route::get('movie-detail', function () {
    return view('client.movies.movie-detail');
})->name('movie-detail');
//
Route::middleware(['auth'])->group(function () {
    // Spatie
    Route::match(['GET', 'POST'], '/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    //user
    Route::match(['GET', 'POST'], '/admin/list/users', [App\Http\Controllers\UserController::class, 'index'])->name('list-user');
    Route::match(['GET', 'POST'], '/admin/form/add/user', [App\Http\Controllers\UserController::class, 'create'])->name('form-add-user');
    Route::match(['GET', 'POST'], '/admin/add/user', [App\Http\Controllers\UserController::class, 'store'])->name('add-user');
    Route::match(['GET', 'POST'], '/admin/role/{id}', [App\Http\Controllers\UserController::class, 'role'])->name('role');
    Route::match(['GET', 'POST'], '/admin/insert/role/{id}', [App\Http\Controllers\UserController::class, 'insert_role'])->name('insert-role');
    Route::match(['GET', 'POST'], '/admin/permission/{id}', [App\Http\Controllers\UserController::class, 'permission'])->name('permission');
    Route::match(['GET', 'POST'], '/admin/insert/permission/{id}', [App\Http\Controllers\UserController::class, 'insert_permission'])->name('insert-permission');
    //role
    Route::match(['GET', 'POST'], '/admin/list/role', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('list-role');
    Route::match(['GET', 'POST'], '/admin/add/role', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('add-role');
    Route::match(['GET', 'POST'], '/admin/form/add/role', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('form-add-role');
    Route::match(['GET', 'POST'], '/admin/edit/role/{id}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('update-role');
    Route::match(['GET', 'POST'], '/admin/form/edit/role/{id}', [App\Http\Controllers\Admin\RoleController::class, 'show'])->name('form-update-role');
    Route::match(['GET', 'POST'], '/admin/delete/role/{id}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('delete-role');
    //permission
    Route::match(['GET', 'POST'], '/admin/list/permission', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('list-permission');
    Route::match(['GET', 'POST'], '/admin/add/permission', [App\Http\Controllers\Admin\PermissionController::class, 'store'])->name('add-permission');
    Route::match(['GET', 'POST'], '/admin/form/add/permission', [App\Http\Controllers\Admin\PermissionController::class, 'create'])->name('form-add-permission');
    Route::match(['GET', 'POST'], '/admin/edit/permission/{id}', [App\Http\Controllers\Admin\PermissionController::class, 'update'])->name('update-permission');
    Route::match(['GET', 'POST'], '/admin/form/edit/permission/{id}', [App\Http\Controllers\Admin\PermissionController::class, 'show'])->name('form-update-permission');
    Route::match(['GET', 'POST'], '/admin/delete/permission/{id}', [App\Http\Controllers\Admin\PermissionController::class, 'destroy'])->name('delete-permission');
    //bin-role
    Route::match(['GET', 'POST'], '/admin/bin/list/role', [App\Http\Controllers\Admin\RoleController::class, 'list_bin'])->name('list-bin-role');
    Route::match(['GET', 'POST'], '/admin/bin/restore/role/{id}', [App\Http\Controllers\Admin\RoleController::class, 'restore_bin'])->name('restore-bin-role');
    Route::match(['GET', 'POST'], '/admin/bin/delete/role/{id}', [App\Http\Controllers\Admin\RoleController::class, 'delete_bin'])->name('delete-bin-role');
    //bin-permission
    Route::match(['GET', 'POST'], '/admin/bin/list/permission', [App\Http\Controllers\Admin\PermissionController::class, 'list_bin'])->name('list-bin-permission');
    Route::match(['GET', 'POST'], '/admin/bin/restore/permission/{id}', [App\Http\Controllers\Admin\PermissionController::class, 'restore_bin'])->name('restore-bin-permission');
    Route::match(['GET', 'POST'], '/admin/bin/delete/permission/{id}', [App\Http\Controllers\Admin\PermissionController::class, 'delete_bin'])->name('delete-bin-permission');
    //room
    Route::match(['GET', 'POST'], '/admin/list/room', [App\Http\Controllers\Admin\RoomController::class, 'index'])->name('list-room');
    Route::match(['GET', 'POST'], '/admin/add/room', [App\Http\Controllers\Admin\RoomController::class, 'store'])->name('add-room');
    Route::match(['GET', 'POST'], '/admin/form/add/room', [App\Http\Controllers\Admin\RoomController::class, 'create'])->name('form-add-room');
    Route::match(['GET', 'POST'], '/admin/edit/room/{id}', [App\Http\Controllers\Admin\RoomController::class, 'update'])->name('update-room');
    Route::match(['GET', 'POST'], '/admin/form/edit/room/{id}', [App\Http\Controllers\Admin\RoomController::class, 'show'])->name('form-update-room');
    Route::match(['GET', 'POST'], '/admin/delete/room/{id}', [App\Http\Controllers\Admin\RoomController::class, 'destroy'])->name('delete-room');
    //room_type
    Route::match(['GET', 'POST'], '/admin/list/room/type', [App\Http\Controllers\Admin\RoomTypeController::class, 'index'])->name('list-room-type');
    Route::match(['GET', 'POST'], '/admin/add/room/type', [App\Http\Controllers\Admin\RoomTypeController::class, 'store'])->name('add-room-type');
    Route::match(['GET', 'POST'], '/admin/form/add/room/type', [App\Http\Controllers\Admin\RoomTypeController::class, 'create'])->name('form-add-room-type');
    Route::match(['GET', 'POST'], '/admin/edit/room/type/{id}', [App\Http\Controllers\Admin\RoomTypeController::class, 'update'])->name('update-room-type');
    Route::match(['GET', 'POST'], '/admin/form/edit/room/type/{id}', [App\Http\Controllers\Admin\RoomTypeController::class, 'show'])->name('form-update-room-type');
    Route::match(['GET', 'POST'], '/admin/delete/room/type/{id}', [App\Http\Controllers\Admin\RoomTypeController::class, 'destroy'])->name('delete-room-type');
});

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

// route cua google
Route::get('auth/google', [SocialController::class, 'signInwithGoogle'])->name('login_google');
Route::get('callback/google', [SocialController::class, 'callbackToGoogle']);
// ket thuc route google
// route logout
Route::get('logout', [SocialController::class, 'logout'])->name('logout');

// ket thuc route mang xa hoi
Route::prefix('admin')
    ->group(function () {
        //login
            Route::match(['GET', 'POST'], '/login', [App\Http\Controllers\Auth\AuthAdminController::class, 'login'])->name('login');
            Route::match(['GET', 'POST'], '/register', [App\Http\Controllers\Auth\AuthAdminController::class, 'register'])->name('register');

        /*
         * Category Blog
         */
        Route::prefix('post-type')->group(function () {
            Route::get('/', [PostTypeController::class, 'index'])->name('post-type.index');
            Route::get('/create', [PostTypeController::class, 'create'])->name('post-type.add');
            Route::post('/store', [PostTypeController::class, 'store'])->name('post-type.store');
            Route::get('/edit/{id}', [PostTypeController::class, 'edit'])->name('post-type.edit');
            Route::post('/update/{id}', [PostTypeController::class, 'update'])->name('post-type.update');
            Route::post('/destroy/{id}', [PostTypeController::class, 'destroy'])->name('post-type.destroy');
        });
<<<<<<< HEAD
        Route::prefix('movie-food')->group(function(){
            Route::get('/', [MovieFoodsController::class, 'index'])->name('movie-foode.index');
            Route::get('/create', [MovieFoodsController::class, 'create'])->name('movie-foode.add'); 
            Route::post('/store', [MovieFoodsController::class, 'store'])->name('movie-foode.store');
            Route::get('/edit/{id}', [MovieFoodsController::class, 'edit'])->name('movie-foode.edit'); 
            Route::get('/destroy/{id}',[MovieFoodsController::class, 'destroy'])->name('movie-foode.destroy');
            Route::get('/indexsd', [MovieFoodsController::class, 'indexsd'])->name('movie-foode.indexsd');
            Route::get('/unTrash/{id}', [MovieFoodsController::class, 'unTrash'])->name('movie-foode.unTrash');
            Route::get('/destroyTrash/{id}', [MovieFoodsController::class, 'destroySoftDelete'])->name('movie-foode.destroyTrash');
            Route::post('/update/{id}', [MovieFoodsController::class, 'update'])->name('movie-foode.update');
            Route::post('/permanentlyDeleteSelected', [MovieFoodsController::class, 'permanentlyDeleteSelected'])->name('movie-foode.permanentlyDeleteSelected');
            Route::post('/unTrashAll', [MovieFoodsController::class, 'unTrashAll'])->name('movie-foode.unTrashAll');
            Route::post('/deleteAll', [MovieFoodsController::class, 'deleteAll'])->name('movie-foode.destroys');
            Route::get('/changeStatus/{id}', [MovieFoodsController::class, 'changeStatus'])->name('movie-foode.changeStatus');
        });
        Route::prefix('food_types')->group(function(){
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
=======

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
>>>>>>> 76bc4dadfa66b045a5763406bc8acf886c2fa8b2
        Route::get('movie', function () {
            $title = 'MOVIE - ADMIN';
            return view('admin.index', compact('title'));
        })->name('admin.movie');

        Route::get('table', function () {
            return view('admin.table');
        })->name('admin.table');
    });
