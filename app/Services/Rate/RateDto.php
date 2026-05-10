<?php

namespace App\Services\Rate;

class RateDto
{
    public function __construct(
        public string $code,
        public float $value,
    ) {}
}
