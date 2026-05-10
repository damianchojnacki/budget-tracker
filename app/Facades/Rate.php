<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Rate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'rate';
    }
}
