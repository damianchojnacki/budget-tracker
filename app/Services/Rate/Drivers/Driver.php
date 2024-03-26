<?php

namespace App\Services\Rate\Drivers;

interface Driver
{
    public function get(string $code): ?float;
}
