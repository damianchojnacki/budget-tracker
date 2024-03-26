<?php

namespace App\Providers;

use App\Enums\CurrencyType;
use App\Models\Currency;
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
        $this->mergeConfigFrom(config_path('rate.php'), 'rate');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // drivers
        $this->app->singleton(CoinCapDriver::class, fn() => new CoinCapDriver());
        $this->app->singleton(CurrencyApiDriver::class, fn() => new CurrencyApiDriver());

        $this->app->singleton('rate', fn() => new RateService());
        $this->app->alias('rate', RateService::class);
    }
}
