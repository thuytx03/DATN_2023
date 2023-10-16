<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PostTypeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;

Route::get('/', function () {
    return view('client.index');
})->name('index');

Route::get('movie-list', function () {
    return view('client.movies.movie-list');
})->name('movie-list');


Route::get('movie-detail', function () {
    return view('client.movies.movie-detail');
})->name('movie-detail');

Route::get('sign-in', function () {
    return view('client.author.sign-in');
})->name('sign-in');

Route::get('sign-up', function () {
    return view('client.author.sign-up');
})->name('sign-up');

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
            Route::get('/destroy/{id}', [PostTypeController::class, 'destroy'])->name('post-type.destroy');
        });
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
        });

        Route::get('table', function () {
            return view('admin.table');
        })->name('admin.table');
    });
