<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('login');
});

// user dashboar route
Route::get('user', function () {
    return view('user.dashboard');
})->name('dashboard');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('user', function () {
    return view('user.dashboard');
})->name('user-profile');

// user dashboar route
Route::get('user', function () {
    return view('user.dashboard');
})->name('dashboard');
