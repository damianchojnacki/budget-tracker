<?php

namespace App\Services\Rate;

use Illuminate\Support\Facades\Facade;

class RateFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'rate';
    }
}
