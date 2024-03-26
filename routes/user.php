<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserOrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'show'])->name('show')->withoutMiddleware('verified');

Route::apiResource('organizations', UserOrganizationController::class)->only('store');
