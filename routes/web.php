<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PostTypeController;
use App\Http\Controllers\Admin\MovieFoodsController;
use App\Http\Controllers\Admin\FoodTypesController;


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

// Route::get('sign-in', function () {
//     return view('client.author.sign-in');
// })->name('sign-in');

// Route::get('sign-up', function () {
//     return view('client.author.sign-up');
// })->name('sign-up');

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
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
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
        Route::get('movie', function () {
            $title = 'MOVIE - ADMIN';
            return view('admin.index', compact('title'));
        })->name('admin.movie');

        Route::get('table', function () {
            return view('admin.table');
        })->name('admin.table');
    });
