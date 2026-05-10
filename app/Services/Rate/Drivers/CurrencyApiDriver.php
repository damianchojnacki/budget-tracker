<?php

namespace App\Services\Rate\Drivers;

use App\Services\Rate\RateDto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyApiDriver implements Driver
{
    /**
     * @var Collection<int, RateDto>
     */
    protected Collection $rates;

    protected string $url = 'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/usd.json';

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

    /**
     * @return Collection<int, RateDto>
     */
    protected function getRates(): Collection
    {
        return Cache::remember($this->url, 3600 * 24, function () {
            return Http::get($this->url)
                ->collect('usd')
                ->mapWithKeys(function (float|int $rate, string $code) {
                    return [$code => new RateDto(
                        code: strtolower($code),
                        value: $rate,
                    )];
                })
                ->values();
        });
    }
}
