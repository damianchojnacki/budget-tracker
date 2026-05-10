<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\View\PanelsRenderHook;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use LaravelLang\Locales\Facades\Locales;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        URL::macro('signature', function (string $route, array $attributes = [], ?Carbon $expiration = null): null|array|string {
            $url = URL::signedRoute($route, $attributes, $expiration);

            $url = parse_url($url, PHP_URL_QUERY);

            if (!$url) {
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

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch): void {
            $switch->locales(['en', 'pl']);
        });

        LanguageSwitch::configureUsing(static function (LanguageSwitch $switch): void {
            $switch->locales(Locales::installed()->pluck('code')->toArray())
                ->displayLocale()
                ->flags(
                    collect(Locales::available()->pluck('code'))->mapWithKeys(
                        static fn (string $lang): array => [$lang => asset('vendor/blade-flags/language-' . $lang . '.svg')]
                    )->toArray()
                )
                ->renderHook(PanelsRenderHook::USER_MENU_PROFILE_AFTER);
        });

        Authenticate::redirectUsing(static fn (): string => Filament::getLoginUrl());

        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(config('app.api_rate_limit_by_minute'))->by($request->user()?->id ?: $request->ip()));
    }
}
