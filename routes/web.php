<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::prefix('/home')->controller(DashboardController::class)->name('dashboard.')->group(function () {
        Route::get('/', 'index')->name('index'); 
        
    });
   
    Route::prefix('/users')->controller(UserController::class)->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
});
Route::get('/lockscreen', function () {return view('auth.lockscreen');})->name('lockscreen');
});
