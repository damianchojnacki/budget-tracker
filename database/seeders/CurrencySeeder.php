<?php

namespace Database\Seeders;

use App\Enums\CurrencyType;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $fiats = [
            ['name' => 'US Dollar',                     'symbol' => '$',   'code' => 'USD', 'precision' => 2],
            ['name' => 'Euro',                          'symbol' => '€',   'code' => 'EUR', 'precision' => 2],
            ['name' => 'British Pound',                 'symbol' => '£',   'code' => 'GBP', 'precision' => 2],
            ['name' => 'Japanese Yen',                  'symbol' => '¥',   'code' => 'JPY', 'precision' => 0],
            ['name' => 'Australian Dollar',             'symbol' => '$',   'code' => 'AUD', 'precision' => 2],
            ['name' => 'Canadian Dollar',               'symbol' => '$',   'code' => 'CAD', 'precision' => 2],
            ['name' => 'Swiss Franc',                   'symbol' => 'CHF', 'code' => 'CHF', 'precision' => 2],
            ['name' => 'Chinese Yuan Renminbi',         'symbol' => '¥',   'code' => 'CNY', 'precision' => 2],
            ['name' => 'Swedish Krona',                 'symbol' => 'kr',  'code' => 'SEK', 'precision' => 2],
            ['name' => 'New Zealand Dollar',            'symbol' => '$',   'code' => 'NZD', 'precision' => 2],
            ['name' => 'Mexican Peso',                  'symbol' => '$',   'code' => 'MXN', 'precision' => 2],
            ['name' => 'Singapore Dollar',              'symbol' => '$',   'code' => 'SGD', 'precision' => 2],
            ['name' => 'Hong Kong Dollar',              'symbol' => '$',   'code' => 'HKD', 'precision' => 2],
            ['name' => 'Norwegian Krone',               'symbol' => 'kr',  'code' => 'NOK', 'precision' => 2],
            ['name' => 'South Korean Won',              'symbol' => '₩',   'code' => 'KRW', 'precision' => 0],
            ['name' => 'Turkish Lira',                  'symbol' => '₺',   'code' => 'TRY', 'precision' => 2],
            ['name' => 'Russian Ruble',                 'symbol' => '₽',   'code' => 'RUB', 'precision' => 2],
            ['name' => 'Indian Rupee',                  'symbol' => '₹',   'code' => 'INR', 'precision' => 2],
            ['name' => 'Brazilian Real',                'symbol' => 'R$',  'code' => 'BRL', 'precision' => 2],
            ['name' => 'South African Rand',            'symbol' => 'R',   'code' => 'ZAR', 'precision' => 2],
            ['name' => 'Philippine Peso',               'symbol' => '₱',   'code' => 'PHP', 'precision' => 2],
            ['name' => 'Czech Koruna',                  'symbol' => 'Kč',  'code' => 'CZK', 'precision' => 2],
            ['name' => 'Indonesian Rupiah',             'symbol' => 'Rp',  'code' => 'IDR', 'precision' => 0],
            ['name' => 'Malaysian Ringgit',             'symbol' => 'RM',  'code' => 'MYR', 'precision' => 2],
            ['name' => 'Hungarian Forint',              'symbol' => 'Ft',  'code' => 'HUF', 'precision' => 0],
            ['name' => 'Icelandic Krona',               'symbol' => 'kr',  'code' => 'ISK', 'precision' => 0],
            ['name' => 'Croatian Kuna',                 'symbol' => 'kn',  'code' => 'HRK', 'precision' => 2],
            ['name' => 'Bulgarian Lev',                 'symbol' => 'лв',  'code' => 'BGN', 'precision' => 2],
            ['name' => 'Romanian Leu',                  'symbol' => 'lei', 'code' => 'RON', 'precision' => 2],
            ['name' => 'Danish Krone',                  'symbol' => 'kr',  'code' => 'DKK', 'precision' => 2],
            ['name' => 'Thai Baht',                     'symbol' => '฿',   'code' => 'THB', 'precision' => 2],
            ['name' => 'Polish Zloty',                  'symbol' => 'zł',  'code' => 'PLN', 'precision' => 2],
            ['name' => 'Israeli Shekel',                'symbol' => '₪',   'code' => 'ILS', 'precision' => 2],
            ['name' => 'Chilean Peso',                  'symbol' => '$',   'code' => 'CLP', 'precision' => 0],
            ['name' => 'Saudi Arabian Riyal',           'symbol' => '﷼',   'code' => 'SAR', 'precision' => 2],
            ['name' => 'Colombian Peso',                'symbol' => '$',   'code' => 'COP', 'precision' => 0],
            ['name' => 'Nigerian Naira',                'symbol' => '₦',   'code' => 'NGN', 'precision' => 0],
            ['name' => 'United Arab Emirates Dirham',   'symbol' => 'د.إ', 'code' => 'AED', 'precision' => 2],
            ['name' => 'Slovak Koruna',                 'symbol' => 'Sk',  'code' => 'SKK', 'precision' => 2],
            ['name' => 'Qatari Riyal',                  'symbol' => '﷼',   'code' => 'QAR', 'precision' => 2],
            ['name' => 'Costa Rican Colon',             'symbol' => '₡',   'code' => 'CRC', 'precision' => 2],
            ['name' => 'Peruvian Nuevo Sol',            'symbol' => 'S/.', 'code' => 'PEN', 'precision' => 2],
            ['name' => 'New Taiwan Dollar',             'symbol' => 'NT$', 'code' => 'TWD', 'precision' => 2],
            ['name' => 'Dominican Peso',                'symbol' => 'RD$', 'code' => 'DOP', 'precision' => 2],
            ['name' => 'Uruguayan Peso',                'symbol' => '$U',  'code' => 'UYU', 'precision' => 2],
            ['name' => 'Egyptian Pound',                'symbol' => '£',   'code' => 'EGP', 'precision' => 2],
            ['name' => 'Vietnamese Dong',               'symbol' => '₫',   'code' => 'VND', 'precision' => 0],
        ];

        $cryptos = [
            ['name' => 'Bitcoin',           'code' => 'BTC',  'precision' => 8],
            ['name' => 'Ethereum',          'code' => 'ETH',  'precision' => 8],
            ['name' => 'Cardano',           'code' => 'ADA',  'precision' => 6],
            ['name' => 'Binance Coin',      'code' => 'BNB',  'precision' => 6],
            ['name' => 'Tether',            'code' => 'USDT', 'precision' => 2],
            ['name' => 'XRP',               'code' => 'XRP',  'precision' => 6],
            ['name' => 'Solana',            'code' => 'SOL',  'precision' => 6],
            ['name' => 'Polkadot',          'code' => 'DOT',  'precision' => 6],
            ['name' => 'Dogecoin',          'code' => 'DOGE', 'precision' => 4],
            ['name' => 'USD Coin',          'code' => 'USDC', 'precision' => 2],
            ['name' => 'Terra',             'code' => 'LUNA', 'precision' => 6],
            ['name' => 'Avalanche',         'code' => 'AVAX', 'precision' => 6],
            ['name' => 'Uniswap',           'code' => 'UNI',  'precision' => 6],
            ['name' => 'Chainlink',         'code' => 'LINK', 'precision' => 6],
            ['name' => 'Litecoin',          'code' => 'LTC',  'precision' => 8],
            ['name' => 'Bitcoin Cash',      'code' => 'BCH',  'precision' => 8],
            ['name' => 'Algorand',          'code' => 'ALGO', 'precision' => 6],
            ['name' => 'Cosmos',            'code' => 'ATOM', 'precision' => 6],
            ['name' => 'Crypto.com Coin',   'code' => 'CRO',  'precision' => 4],
            ['name' => 'Stellar',           'code' => 'XLM',  'precision' => 4],
            ['name' => 'VeChain',           'code' => 'VET',  'precision' => 4],
        ];

        $metals = [
            ['name' => 'Gold',      'code' => 'XAU', 'symbol' => 'oz.', 'precision' => 4],
            ['name' => 'Silver',    'code' => 'XAG', 'symbol' => 'oz.', 'precision' => 4],
            ['name' => 'Platinum',  'code' => 'XPT', 'symbol' => 'oz.', 'precision' => 4],
            ['name' => 'Palladium', 'code' => 'XPD', 'symbol' => 'oz.', 'precision' => 4],
        ];

        $stocks = [
            ['name' => 'Apple',             'code' => 'AAPL', 'precision' => 2],
            ['name' => 'Microsoft',         'code' => 'MSFT', 'precision' => 2],
            ['name' => 'Amazon',            'code' => 'AMZN', 'precision' => 2],
            ['name' => 'Alphabet',          'code' => 'GOOGL', 'precision' => 2],
            ['name' => 'Facebook',          'code' => 'FB',   'precision' => 2],
            ['name' => 'Tesla',             'code' => 'TSLA', 'precision' => 2],
            ['name' => 'Nvidia',            'code' => 'NVDA', 'precision' => 2],
            ['name' => 'PayPal',            'code' => 'PYPL', 'precision' => 2],
            ['name' => 'Visa',              'code' => 'V',    'precision' => 2],
            ['name' => 'JPMorgan Chase',    'code' => 'JPM',  'precision' => 2],
            ['name' => 'Johnson & Johnson', 'code' => 'JNJ',  'precision' => 2],
            ['name' => 'Walmart',           'code' => 'WMT',  'precision' => 2],
            ['name' => 'UnitedHealth Group', 'code' => 'UNH',  'precision' => 2],
            ['name' => 'Mastercard',        'code' => 'MA',   'precision' => 2],
            ['name' => 'Home Depot',        'code' => 'HD',   'precision' => 2],
            ['name' => 'Procter & Gamble',  'code' => 'PG',   'precision' => 2],
            ['name' => 'Bank of America',   'code' => 'BAC',  'precision' => 2],
            ['name' => 'Verizon',           'code' => 'VZ',   'precision' => 2],
            ['name' => 'Intel',             'code' => 'INTC', 'precision' => 2],
            ['name' => 'Netflix',           'code' => 'NFLX', 'precision' => 2],
            ['name' => 'Adobe',             'code' => 'ADBE', 'precision' => 2],
            ['name' => 'Salesforce',        'code' => 'CRM',  'precision' => 2],
        ];

        $bonds = [
            ['name' => 'United States 10-Year Bond', 'code' => 'US10Y', 'precision' => 3],
            ['name' => 'United States 5-Year Bond',  'code' => 'US5Y',  'precision' => 3],
            ['name' => 'United States 2-Year Bond',  'code' => 'US2Y',  'precision' => 3],
            ['name' => 'United States 3-Month Bond', 'code' => 'US3M',  'precision' => 3],
            ['name' => 'United States 1-Month Bond', 'code' => 'US1M',  'precision' => 3],
        ];

        $now = now();

        foreach (
            [
                CurrencyType::FIAT->value => $fiats,
                CurrencyType::CRYPTO->value => $cryptos,
                CurrencyType::PRECIOUS_METAL->value => $metals,
                CurrencyType::STOCK->value => $stocks,
                CurrencyType::BOND->value => $bonds,
            ] as $type => $currencies
        ) {
            Currency::insert(
                collect($currencies)
                    ->map(fn ($currency) => array_merge($currency, [
                        'type' => $type,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]))
                    ->toArray(),
            );
        }
    }
}
