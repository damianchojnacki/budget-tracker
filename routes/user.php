<?php

use App\Http\Controllers\UserCarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'show'])->name('show')->withoutMiddleware('verified');
Route::apiResource('cars', UserCarController::class)->only('update');
