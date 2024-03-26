<?php

namespace App\Services\Rate\Drivers;

use App\Services\Rate\Rate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CoinCapDriver implements Driver
{
    /**
     * @var Collection<Rate>
     */
    protected Collection $rates;

    protected string $url = 'https://api.coincap.io/v2/rates';

    protected Collection $assets;

    /**
     * @param  array<string>|Collection<string>  $assets
     */
    public function __construct(array|Collection $assets = [])
    {
        if (! ($assets instanceof Collection)) {
            $assets = collect($assets);
        }

        $this->assets = $assets;
    }

    protected function getQuery(): string
    {
        return '?ids='.strtolower($this->assets->implode(','));
    }

    /**
     * @return Collection<Rate>
     */
    protected function getRates(): Collection
    {
        return Cache::remember($this->url, 3600 * 24, function () {
            return Http::get($this->url)
                ->collect('data')
                ->map(function ($crypto) {
                    return new Rate(
                        code: strtolower($crypto['symbol']),
                        value: $crypto['rateUsd']
                    );
                });
        });
    }

    public function get(string $code): ?float
    {
        if (! ($this->rates ?? null)) {
            $this->rates = $this->getRates();
        }

        return $this->rates
            ->where('code', strtolower($code))
            ->first()
            ?->value;
    }
}
