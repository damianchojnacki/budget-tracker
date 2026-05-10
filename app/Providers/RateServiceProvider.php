<?php

namespace App\Providers;

use App\Services\Rate\Drivers\CoinCapDriver;
use App\Services\Rate\Drivers\CurrencyApiDriver;
use App\Services\Rate\RateService;
use Illuminate\Support\ServiceProvider;

class RateServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // drivers
        $this->app->singleton(CoinCapDriver::class, fn (): CoinCapDriver => new CoinCapDriver);
        $this->app->singleton(CurrencyApiDriver::class, fn (): CurrencyApiDriver => new CurrencyApiDriver);

        $this->app->singleton('rate', fn (): RateService => new RateService);
        $this->app->alias('rate', RateService::class);
    }
}
