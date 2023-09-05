<?php

use App\Http\Controllers\Auth\OrganizationInvitationController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('cars/brands', CarBrandController::class)
    ->except('store', 'update', 'destroy');

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::apiResource('cars', CarController::class)
        ->except('store', 'update', 'destroy');

    Route::put('organization-invitations/{invitation}', [OrganizationInvitationController::class, 'accept'])
        ->name('organization-invitations.accept')
        ->middleware('signed');

    Route::delete('organization-invitations/{invitation}', [OrganizationInvitationController::class, 'cancel'])
        ->name('organization-invitations.cancel');
});
