<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array<string|null|false>
     */
    public function hosts(): array
    {
        return [
            $this->frontendDomain(),
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }

    public function frontendDomain(): string|false|null
    {
        return parse_url(config('app.frontend_url'), PHP_URL_HOST) ?? null;
    }
}
