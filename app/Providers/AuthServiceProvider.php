<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Authentik\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user): ?bool {
            if ($user->isAdmin()) {
                return true;
            }

            return null;
        });

        Gate::define('viewApiDocs', fn (User $user): bool => $user->isAdmin());

        Event::listen(static function (SocialiteWasCalled $event): void {
            $event->extendSocialite('authentik', Provider::class);
        });
    }
}
