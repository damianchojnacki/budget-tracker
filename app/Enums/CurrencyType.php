<?php

namespace App\Enums;

enum CurrencyType: string
{
    use StringEnumHelpers;

    case FIAT = 'fiat';
    case CRYPTO = 'crypto';
    case PRECIOUS_METAL = 'precious_metal';
    case STOCK = 'stock';
    case BOND = 'bond';

    public function getName(): string
    {
        return match ($this) {
            self::FIAT => __('Fiat'),
            self::CRYPTO => __('Crypto'),
            self::PRECIOUS_METAL => __('Precious Metal'),
            self::STOCK => __('Stock'),
            self::BOND => __('Bond'),
        };
    }
}
