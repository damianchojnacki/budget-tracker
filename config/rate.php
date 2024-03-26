<?php

use App\Services\Rate\Drivers\CoinCapDriver;
use App\Services\Rate\Drivers\CurrencyApiDriver;

return [
    'crypto' => [
        'driver' => 'currency-api',
    ],

    'fiat' => [
        'driver' => 'currency-api',
    ],

    'metal' => [
        'driver' => 'currency-api',
    ],

    'drivers' => [
        'coincap' => [
            'class' => CoinCapDriver::class
        ],
        'currency-api' => [
            'class' => CurrencyApiDriver::class
        ],
    ]
];
