<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('template');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/services', [App\Http\Controllers\HomeController::class, 'services'])->name('services');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');


Route::group(['prefix' => 'hotels'], function () {
    //NOTE: Hotels
    Route::get("/rooms/{id}",[App\Http\Controllers\Hotels\HotelsController::class,'rooms'])->name('hotels.rooms');

    Route::get("/rooms-details/{id}",[App\Http\Controllers\Hotels\HotelsController::class,'roomDetails'])->name('hotel.rooms.details');

    Route::post("/rooms-booking/{id}",[App\Http\Controllers\Hotels\HotelsController::class,'roomBooking'])->name('hotel.rooms.booking');

    //NOTE: Paymant
    Route::get("/payment",[App\Http\Controllers\Hotels\HotelsController::class,'payWithPaypal'])->name('hotel.payment')->middleware('check.price');

    Route::get("/success",[App\Http\Controllers\Hotels\HotelsController::class,'success'])->name('hotel.success')->middleware('check.price');
    
});



//NOTE: Users
Route::get("users/my-bookings",[App\Http\Controllers\Users\UsersController::class,'myBookings'])->name('users.bookings')->middleware('auth:web');

//NOTE: Admin panel
Route::get('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'viewLogin'])->name('view.login');
Route::post('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'checkLogin'])->name('check.login');

Route::get('admin/dashboard', [App\Http\Controllers\Admins\AdminsController::class, 'index'])->name('admins.dashboard');
