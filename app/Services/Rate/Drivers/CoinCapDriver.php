<?php

namespace App\Services\Rate\Drivers;

use App\Services\Rate\RateDto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CoinCapDriver implements Driver
{
    /**
     * @var Collection<int, RateDto>
     */
    protected Collection $rates;

    protected string $url = 'https://api.coincap.io/v2/rates';

    /**
     * @var Collection<int, string>
     */
    protected Collection $assets;

    /**
     * @param  array<string>|Collection<int, string>  $assets
     */
    public function __construct(array|Collection $assets = [])
    {
        if (!($assets instanceof Collection)) {
            $assets = collect($assets);
        }

        $this->assets = $assets;
    }

    public function get(string $code): ?float
    {
        if (!($this->rates ?? null)) {
            $this->rates = $this->getRates();
        }

        return $this->rates
            ->where('code', strtolower($code))
            ->first()
            ?->value;
    }

    protected function getQuery(): string
    {
        return '?ids=' . strtolower($this->assets->implode(','));
    }

    /**
     * @return Collection<int, RateDto>
     */
    protected function getRates(): Collection
    {
        return Cache::remember($this->url, 3600 * 24, fn () => Http::get($this->url)
            ->collect('data')
            ->map(fn (array $crypto): RateDto => new RateDto(
                code: strtolower((string) $crypto['symbol']),
                value: $crypto['rateUsd']
            )));
    }
}
