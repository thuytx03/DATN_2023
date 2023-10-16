<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PostTypeController;

Route::get('/', function () {
    return view('client.index');
})->name('index');

Route::get('movie-list', function () {
    return view('client.movies.movie-list');
})->name('movie-list');


Route::get('movie-detail', function () {
    return view('client.movies.movie-detail');
})->name('movie-detail');

//login-register
Route::middleware(['auth', 'role:JungX-Admin'])->group(function () {
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
        Route::prefix('login')->group(function () {
            Route::match(['GET', 'POST'], '/login', [App\Http\Controllers\Auth\AuthAdminController::class, 'login'])->name('login');
            Route::match(['GET', 'POST'], '/register', [App\Http\Controllers\Auth\AuthAdminController::class, 'register'])->name('register');
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
            Route::post('/destroy/{id}', [PostTypeController::class, 'destroy'])->name('post-type.destroy');
        });
        Route::get('movie', function () {
            $title = 'MOVIE - ADMIN';
            return view('admin.index', compact('title'));
        })->name('admin.movie');

        Route::get('table', function () {
            return view('admin.table');
        })->name('admin.table');
    });
