<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LandingPageController::class, 'index'])->name('landing_page.index');
Route::post('booking', [LandingPageController::class, 'booking'])->name('booking.hotel');
Route::post('booking-vehicle', [LandingPageController::class, 'bookingVehicle'])->name('booking.vehicle');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::get('register', [AuthController::class, 'register'])->name('register.index');
    Route::post('register', [AuthController::class, 'postRegister'])->name('register.post');
});

Route::middleware('auth')->group(function () {    
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('is_admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('check-in/{id}', [DashboardController::class, 'checkIn'])->name('hotel.checkin');
    Route::post('check-out/{id}', [DashboardController::class, 'checkOut'])->name('hotel.checkout');
    
    Route::get('category-hotel', [CategoryController::class, 'index'])->name('category-hotel.index');
    Route::post('category-hotel/store', [CategoryController::class, 'store'])->name('category-hotel.store');
    Route::post('category-hotel/edit/{id}', [CategoryController::class, 'edit'])->name('category-hotel.edit');
    Route::get('category-hotel/delete/{id}', [CategoryController::class, 'delete'])->name('category-hotel.delete');
    
    Route::get('room', [RoomController::class, 'index'])->name('room.index');
    Route::post('room/store', [RoomController::class, 'store'])->name('room.store');
    Route::post('room/edit/{id}', [RoomController::class, 'edit'])->name('room.edit');
    Route::get('room/delete/{id}', [RoomController::class, 'delete'])->name('room.delete');

    Route::post('start-rent/{id}', [DashboardController::class, 'startRent'])->name('vehicle.start-rent');
    Route::post('end-rent/{id}', [DashboardController::class, 'endRent'])->name('vehicle.end-rent');
    
    Route::get('category-vehicle', [VCategoryController::class, 'index'])->name('categoriesV.index');
    Route::post('category-vehicle/store', [VCategoryController::class, 'store'])->name('categoriesV.store');
    Route::post('category-vehicle/edit/{id}', [VCategoryController::class, 'edit'])->name('categoriesV.edit');
    Route::get('category-vehicle/delete/{id}', [VCategoryController::class, 'delete'])->name('categoriesV.delete');

    Route::get('vehicle', [VehicleController::class, 'index'])->name('vehicle.index');
    Route::post('vehicle/store', [VehicleController::class, 'store'])->name('vehicle.store');
    Route::post('vehicle/edit/{id}', [VehicleController::class, 'edit'])->name('vehicle.edit');
    Route::get('vehicle/delete/{id}', [VehicleController::class, 'delete'])->name('vehicle.delete');

    Route::post('logout-admin', [AuthController::class, 'logout_admin'])->name('logout-admin');
});

