<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;



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
// route đăng nhập social media 
Route::get('/auth/facebook', function () {
    return Socialite::driver('facebook')->redirect();
});
Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();

});
 route::get('/auth/facebook/callback', function() {
return 'callbackloginfacebook';
 });



Route::prefix('admin')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('movie', function () {
            $title = 'MOVIE - ADMIN';
            return view('admin.index', compact('title'));
        })->name('admin.movie');

        Route::get('table', function () {
            return view('admin.table');
        })->name('admin.table');
    });
