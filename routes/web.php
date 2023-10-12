<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
Route::match(['GET', 'POST'], '/login', [App\Http\Controllers\Auth\SocialController::class, 'login'])->name('login');
Route::match(['GET', 'POST'], '/register', [App\Http\Controllers\Auth\AuthClientController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
//Spatie 
Route::match(['GET', 'POST'], '/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dasboard')->middleware('role:JungX-Admin');
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
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        /*
         * Category Blog
         */
        Route::prefix('category-post')->group(function () {
            Route::get('/',[CategoryPostController::class,'index']);
        });


        Route::get('movie', function () {
            $title = 'MOVIE - ADMIN';
            return view('admin.index', compact('title'));
        })->name('admin.movie');

        Route::get('table', function () {
            return view('admin.table');
        })->name('admin.table');
    });
