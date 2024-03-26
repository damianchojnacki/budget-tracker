<?php

namespace App\Services\Rate\Drivers;

use App\Services\Rate\Rate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyApiDriver implements Driver
{
    /**
     * @var Collection<Rate>
     */
    protected Collection $rates;
    protected string $url = "https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/usd.json";
    protected Collection $assets;

    /**
     * @return Collection<Rate>
     */
    protected function getRates(): Collection
    {
        return Cache::remember($this->url, 3600 * 24, function () {
            return Http::get($this->url)
                ->collect('usd')
                ->mapWithKeys(function ($rate, $code){
                    return [$code => new Rate(
                        code: strtolower($code),
                        value: $rate,
                    )];
                })
                ->values();
        });
    }

    public function get(string $code): ?float
    {
        if(!($this->rates ?? null)){
           $this->rates = $this->getRates();
        }

        return $this->rates
            ->where('code', strtolower($code))
            ->first()
            ?->value;
    }
}
