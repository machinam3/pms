<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/lockscreen', function () {
    return view('auth.lockscreen');
})->name('lockscreen');
    Route::get('/home', function () {
    return view('users.index');
});
});
