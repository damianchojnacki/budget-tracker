<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;

    public function frontendDomain(): string|false|null
    {
        return parse_url(config('app.frontend_url'), PHP_URL_HOST) ?? null;
    }
    /**
     * The trusted proxies for this application.
     *
     * @return array<string|false|null>
     */
    protected function proxies(): array
    {
        return [
            $this->frontendDomain(),
        ];
    }
}
