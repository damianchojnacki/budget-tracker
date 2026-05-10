<?php

use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\RateServiceProvider;
use App\Providers\TelescopeServiceProvider;
use SocialiteProviders\Manager\ServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    TelescopeServiceProvider::class,
    ServiceProvider::class,
    AdminPanelProvider::class,
    RateServiceProvider::class,
];
