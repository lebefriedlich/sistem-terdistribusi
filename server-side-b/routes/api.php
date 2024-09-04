<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [AuthController::class, 'user']);
    
    Route::post('categoriesV', [CategoryController::class, 'store']);
    Route::get('categoriesV/{id}', [CategoryController::class, 'show']);
    Route::post('/categoriesV/{id}', [CategoryController::class, 'update_post']);
    Route::put('categoriesV/{id}', [CategoryController::class, 'update']);
    Route::delete('categoriesV/{id}', [CategoryController::class, 'destroy']);
    
    Route::resource('vehicles', VehicleController::class);
    Route::post('/vehicles/{id}', [VehicleController::class, 'update_post']);
    
    Route::get('/get-rental', [RentalController::class, 'getRental']);
    
    Route::post('start-rent/{id}', [RentalController::class, 'startRent']);
    Route::post('finish-rent/{id}', [RentalController::class, 'finishRent']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('categoriesV', [CategoryController::class, 'index']);

Route::get('available-vehicle/{id_category}/{start_date}/{end_date}', [RentalController::class, 'getAvailable']);
Route::post('rental', [RentalController::class, 'rented']);

