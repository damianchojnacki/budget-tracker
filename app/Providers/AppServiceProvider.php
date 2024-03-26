<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        URL::macro('signature', function (string $route, array $attributes = [], Carbon $expiration = null) {
            $url = URL::signedRoute($route, $attributes, $expiration);

            $url = parse_url($url, PHP_URL_QUERY);

            if (! $url) {
                return null;
            }

            parse_str($url, $query);

            return $query['signature'];
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        JsonResource::withoutWrapping();

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch->locales(['en','pl']);
        });
    }
}
