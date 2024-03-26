<?php

namespace App\Services\Rate;

use App\Enums\CurrencyType;
use App\Models\Currency;
use App\Services\Rate\Drivers\Driver;
use Illuminate\Contracts\Container\BindingResolutionException;

class RateService
{
    protected Driver $cryptoDriver;
    protected Driver $fiatDriver;
    protected Driver $stockDriver;
    protected Driver $metalDriver;

    /**
     * @throws DriverNotFoundException|BindingResolutionException
     */
    public function __construct()
    {
        $this->resolveDrivers();
    }

    /**
     * @throws DriverNotFoundException|BindingResolutionException
     */
    protected function resolveDrivers(): void
    {
        $this->cryptoDriver = $this->driver(config('rate.crypto.driver'));
        $this->fiatDriver = $this->driver(config('rate.fiat.driver'));
        $this->metalDriver = $this->driver(config('rate.metal.driver'));
    }

    /**
     * @throws DriverNotFoundException|BindingResolutionException
     */
    public function driver(string $driver): Driver
    {
        $class = config("rate.drivers.{$driver}.class");

        if (!class_exists($class)) {
            throw new DriverNotFoundException("Driver `{$driver}` not found. Please specify correct driver in rate config.");
        }

        $driver = app()->make($class);

        if (!$driver instanceof Driver) {
            throw new DriverNotFoundException("Driver `{$class}` must be instance of " . Driver::class);
        }

        return $driver;
    }

    /**
     * @throws DriverNotFoundException
     */
    public function get(Currency $currency): ?float
    {
        return match ($currency->type) {
            CurrencyType::CRYPTO => $this->cryptoDriver->get($currency->code),
            CurrencyType::FIAT => $this->fiatDriver->get($currency->code),
            CurrencyType::PRECIOUS_METAL => $this->metalDriver->get($currency->code),
            CurrencyType::STOCK => $this->metalDriver->get($currency->code),
            CurrencyType::BOND => $this->metalDriver->get($currency->code),
            default => throw new DriverNotFoundException("Driver for {$currency->type->name} not found.")
        };
    }

    public function convert(float $value, Currency $from, Currency $to): float
    {
        return $value / $from->rate * $to->rate;
    }
}
