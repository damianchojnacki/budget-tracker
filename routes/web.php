<?php

use App\Http\Controllers\DocsController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\OrganizationInvitationController;
use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'dashboard')->name('homepage');

Route::get('/up', HealthCheckController::class)->name('up');

Route::get('docs/{path?}', DocsController::class)
    ->middleware(RestrictedDocsAccess::class)
    ->where('path', '(.*)')
    ->name('docs');

Route::group([
    'middleware' => ['auth', 'verified'],
], function () {
    Route::put('organization-invitations/{invitation}', [OrganizationInvitationController::class, 'accept'])
        ->name('organization-invitations.accept')
        ->middleware(['signed', 'throttle:6,1']);

    Route::delete('organization-invitations/{invitation}', [OrganizationInvitationController::class, 'cancel'])
        ->name('organization-invitations.cancel');
});
