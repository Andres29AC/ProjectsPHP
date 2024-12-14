<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('template');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get("hotels/rooms/{id}",[App\Http\Controllers\Hotels\HotelsController::class,'rooms'])->name('hotels.rooms');

Route::get("hotels/rooms-details/{id}",[App\Http\Controllers\Hotels\HotelsController::class,'roomDetails'])->name('hotel.rooms.details');

Route::post("hotels/rooms-booking/{id}",[App\Http\Controllers\Hotels\HotelsController::class,'roomBooking'])->name('hotel.rooms.booking');

//NOTES: Paymant
Route::get("hotels/payment",[App\Http\Controllers\Hotels\HotelsController::class,'payWithPaypal'])->name('hotel.payment')->middleware('check.price');

Route::get("hotels/success",[App\Http\Controllers\Hotels\HotelsController::class,'success'])->name('hotel.success')->middleware('check.price');

