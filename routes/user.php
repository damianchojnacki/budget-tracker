<?php

use App\Http\Controllers\UserTripController;
use App\Http\Controllers\UserTripPointController;
use App\Http\Controllers\UserCarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'show'])->name('show')->withoutMiddleware('verified');
Route::apiResource('cars', UserCarController::class)->only('update');

Route::apiResource('trips', UserTripController::class);

Route::apiResource('trips.points', UserTripPointController::class)
    ->only('store');
