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
Route::get('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'viewLogin'])->name('view.login')->middleware('check.for.login');
Route::post('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'checkLogin'])->name('check.login')->middleware('check.for.login');



Route::group(['prefix' => 'admin','middleware' => 'auth:admin'], function () {
    //SECTION - Admins
    Route::get('/index', [App\Http\Controllers\Admins\AdminsController::class, 'index'])->name('admins.dashboard');
    Route::get('/all-admins', [App\Http\Controllers\Admins\AdminsController::class, 'allAdmins'])->name('admins.all');
    Route::get('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'createAdmins'])->name('admins.create');
    Route::post('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'storeAdmins'])->name('admins.store');
    //!SECTION - Hotels
    Route::get('/all-hotels', [App\Http\Controllers\Admins\AdminsController::class, 'allHotels'])->name('hotels.all');
    Route::get('/create-hotels', [App\Http\Controllers\Admins\AdminsController::class, 'createHotels'])->name('hotels.create');
    Route::post('/create-hotels', [App\Http\Controllers\Admins\AdminsController::class, 'storeHotels'])->name('hotels.store');
    Route::get('/edit-hotels/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'editHotels'])->name('hotels.edit');
    Route::post('/update-hotels/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'updateHotels'])->name('hotels.update');
    Route::get('/delete-hotels/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteHotels'])->name('hotels.delete');
    //SECTION - Rooms
    Route::get('/all-rooms', [App\Http\Controllers\Admins\AdminsController::class, 'allRooms'])->name('rooms.all');
});
