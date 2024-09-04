<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [AuthController::class, 'user']);

    Route::post('category', [CategoryController::class, 'store']);
    Route::get('category/{id}', [CategoryController::class, 'show']);
    Route::post('/category/{id}', [CategoryController::class, 'update_post']);
    Route::put('category/{id}', [CategoryController::class, 'update']);
    Route::delete('category/{id}', [CategoryController::class, 'destroy']);

    Route::resource('room', RoomController::class);
    Route::post('/room/{id}', [RoomController::class, 'update_post']);

    Route::get('get-reservasi', [ReservasiController::class, 'getReservasi']);

    Route::post('check-in/{id}', [ReservasiController::class, 'checkIn']);
    Route::post('check-out/{id}', [ReservasiController::class, 'checkOut']);

    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::get('category', [CategoryController::class, 'index']);

Route::get('available-hotel/{id_category}/{checkIn}/{checkOut}', [ReservasiController::class, 'getAvailable']);
Route::post('booking', [ReservasiController::class, 'reserved']);
