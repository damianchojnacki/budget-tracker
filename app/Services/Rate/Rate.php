<?php

namespace App\Services\Rate;

class Rate
{
    public function __construct(
        public string $code,
        public float $value,
    ){}
}
