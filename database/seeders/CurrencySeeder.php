<?php

namespace Database\Seeders;

use App\Enums\CurrencyType;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fiats = [
            [
                'name' => 'US Dollar',
                'symbol' => '$',
                'code' => 'USD',
            ],
            [
                'name' => 'Euro',
                'symbol' => '€',
                'code' => 'EUR',
            ],
            [
                'name' => 'British Pound',
                'symbol' => '£',
                'code' => 'GBP',
            ],
            [
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'code' => 'JPY',
            ],
            [
                'name' => 'Australian Dollar',
                'symbol' => '$',
                'code' => 'AUD',
            ],
            [
                'name' => 'Canadian Dollar',
                'symbol' => '$',
                'code' => 'CAD',
            ],
            [
                'name' => 'Swiss Franc',
                'symbol' => 'CHF',
                'code' => 'CHF',
            ],
            [
                'name' => 'Chinese Yuan Renminbi',
                'symbol' => '¥',
                'code' => 'CNY',
            ],
            [
                'name' => 'Swedish Krona',
                'symbol' => 'kr',
                'code' => 'SEK',
            ],
            [
                'name' => 'New Zealand Dollar',
                'symbol' => '$',
                'code' => 'NZD',
            ],
            [
                'name' => 'Mexican Peso',
                'symbol' => '$',
                'code' => 'MXN',
            ],
            [
                'name' => 'Singapore Dollar',
                'symbol' => '$',
                'code' => 'SGD',
            ],
            [
                'name' => 'Hong Kong Dollar',
                'symbol' => '$',
                'code' => 'HKD',
            ],
            [
                'name' => 'Norwegian Krone',
                'symbol' => 'kr',
                'code' => 'NOK',
            ],
            [
                'name' => 'South Korean Won',
                'symbol' => '₩',
                'code' => 'KRW',
            ],
            [
                'name' => 'Turkish Lira',
                'symbol' => '₺',
                'code' => 'TRY',
            ],
            [
                'name' => 'Russian Ruble',
                'symbol' => '₽',
                'code' => 'RUB',
            ],
            [
                'name' => 'Indian Rupee',
                'symbol' => '₹',
                'code' => 'INR',
            ],
            [
                'name' => 'Brazilian Real',
                'symbol' => 'R$',
                'code' => 'BRL',
            ],
            [
                'name' => 'South African Rand',
                'symbol' => 'R',
                'code' => 'ZAR',
            ],
            [
                'name' => 'Philippine Peso',
                'symbol' => '₱',
                'code' => 'PHP',
            ],
            [
                'name' => 'Czech Koruna',
                'symbol' => 'Kč',
                'code' => 'CZK',
            ],
            [
                'name' => 'Indonesian Rupiah',
                'symbol' => 'Rp',
                'code' => 'IDR',
            ],
            [
                'name' => 'Malaysian Ringgit',
                'symbol' => 'RM',
                'code' => 'MYR',
            ],
            [
                'name' => 'Hungarian Forint',
                'symbol' => 'Ft',
                'code' => 'HUF',
            ],
            [
                'name' => 'Icelandic Krona',
                'symbol' => 'kr',
                'code' => 'ISK',
            ],
            [
                'name' => 'Croatian Kuna',
                'symbol' => 'kn',
                'code' => 'HRK',
            ],
            [
                'name' => 'Bulgarian Lev',
                'symbol' => 'лв',
                'code' => 'BGN',
            ],
            [
                'name' => 'Romanian Leu',
                'symbol' => 'lei',
                'code' => 'RON',
            ],
            [
                'name' => 'Danish Krone',
                'symbol' => 'kr',
                'code' => 'DKK',
            ],
            [
                'name' => 'Thai Baht',
                'symbol' => '฿',
                'code' => 'THB',
            ],
            [
                'name' => 'Polish Zloty',
                'symbol' => 'zł',
                'code' => 'PLN',
            ],
            [
                'name' => 'Israeli Shekel',
                'symbol' => '₪',
                'code' => 'ILS',
            ],
            [
                'name' => 'Chilean Peso',
                'symbol' => '$',
                'code' => 'CLP',
            ],
            [
                'name' => 'Saudi Arabian Riyal',
                'symbol' => '﷼',
                'code' => 'SAR',
            ],
            [
                'name' => 'Colombian Peso',
                'symbol' => '$',
                'code' => 'COP',
            ],
            [
                'name' => 'Nigerian Naira',
                'symbol' => '₦',
                'code' => 'NGN',
            ],
            [
                'name' => 'United Arab Emirates Dirham',
                'symbol' => 'د.إ',
                'code' => 'AED',
            ],
            [
                'name' => 'Slovak Koruna',
                'symbol' => 'Sk',
                'code' => 'SKK',
            ],
            [
                'name' => 'Qatari Riyal',
                'symbol' => '﷼',
                'code' => 'QAR',
            ],
            [
                'name' => 'Costa Rican Colon',
                'symbol' => '₡',
                'code' => 'CRC',
            ],
            [
                'name' => 'Peruvian Nuevo Sol',
                'symbol' => 'S/.',
                'code' => 'PEN',
            ],
            [
                'name' => 'New Taiwan Dollar',
                'symbol' => 'NT$',
                'code' => 'TWD',
            ],
            [
                'name' => 'Dominican Peso',
                'symbol' => 'RD$',
                'code' => 'DOP',
            ],
            [
                'name' => 'Uruguayan Peso',
                'symbol' => '$U',
                'code' => 'UYU',
            ],
            [
                'name' => 'Egyptian Pound',
                'symbol' => '£',
                'code' => 'EGP',
            ],
            [
                'name' => 'Vietnamese Dong',
                'symbol' => '₫',
                'code' => 'VND',
            ],
        ];

        $cryptos = [
            [
                'name' => 'Bitcoin',
                'code' => 'BTC',
            ],
            [
                'name' => 'Ethereum',
                'code' => 'ETH',
            ],
            [
                'name' => 'Cardano',
                'code' => 'ADA',
            ],
            [
                'name' => 'Binance Coin',
                'code' => 'BNB',
            ],
            [
                'name' => 'Tether',
                'code' => 'USDT',
            ],
            [
                'name' => 'XRP',
                'code' => 'XRP',
            ],
            [
                'name' => 'Solana',
                'code' => 'SOL',
            ],
            [
                'name' => 'Polkadot',
                'code' => 'DOT',
            ],
            [
                'name' => 'Dogecoin',
                'code' => 'DOGE',
            ],
            [
                'name' => 'USD Coin',
                'code' => 'USDC',
            ],
            [
                'name' => 'Terra',
                'code' => 'LUNA',
            ],
            [
                'name' => 'Avalanche',
                'code' => 'AVAX',
            ],
            [
                'name' => 'Uniswap',
                'code' => 'UNI',
            ],
            [
                'name' => 'Chainlink',
                'code' => 'LINK',
            ],
            [
                'name' => 'Litecoin',
                'code' => 'LTC',
            ],
            [
                'name' => 'Bitcoin Cash',
                'code' => 'BCH',
            ],
            [
                'name' => 'Algorand',
                'code' => 'ALGO',
            ],
            [
                'name' => 'Cosmos',
                'code' => 'ATOM',
            ],
            [
                'name' => 'Crypto.com Coin',
                'code' => 'CRO',
            ],
            [
                'name' => 'Stellar',
                'code' => 'XLM',
            ],
            [
                'name' => 'VeChain',
                'code' => 'VET',
            ]
        ];

        $metals = [
            [
                'name' => 'Gold Bullion Coin 1oz',
                'code' => 'XAU',
            ],
            [
                'name' => 'Gold Bullion Coin 1/2oz',
                'code' => 'XAU',
            ],
            [
                'name' => 'Gold Bullion Coin 1/4oz',
                'code' => 'XAU',
            ],
            [
                'name' => 'Silver Bullion Coin 1oz',
                'code' => 'XAG',
            ],
            [
                'name' => 'Silver Bullion Coin 1/2oz',
                'code' => 'XAG',
            ],
            [
                'name' => 'Silver Bullion Coin 1/4oz',
                'code' => 'XAG',
            ],
            [
                'name' => 'Platinum',
                'code' => 'XPT',
            ],
            [
                'name' => 'Palladium',
                'code' => 'XPD',
            ],
        ];

        $stocks = [
            [
                'name' => 'Apple',
                'code' => 'AAPL',
            ],
            [
                'name' => 'Microsoft',
                'code' => 'MSFT',
            ],
            [
                'name' => 'Amazon',
                'code' => 'AMZN',
            ],
            [
                'name' => 'Alphabet',
                'code' => 'GOOGL',
            ],
            [
                'name' => 'Facebook',
                'code' => 'FB',
            ],
            [
                'name' => 'Tesla',
                'code' => 'TSLA',
            ],
            [
                'name' => 'Nvidia',
                'code' => 'NVDA',
            ],
            [
                'name' => 'PayPal',
                'code' => 'PYPL',
            ],
            [
                'name' => 'Visa',
                'code' => 'V',
            ],
            [
                'name' => 'JPMorgan Chase',
                'code' => 'JPM',
            ],
            [
                'name' => 'Johnson & Johnson',
                'code' => 'JNJ',
            ],
            [
                'name' => 'Walmart',
                'code' => 'WMT',
            ],
            [
                'name' => 'UnitedHealth Group',
                'code' => 'UNH',
            ],
            [
                'name' => 'Mastercard',
                'code' => 'MA',
            ],
            [
                'name' => 'Home Depot',
                'code' => 'HD',
            ],
            [
                'name' => 'Procter & Gamble',
                'code' => 'PG',
            ],
            [
                'name' => 'Bank of America',
                'code' => 'BAC',
            ],
            [
                'name' => 'Verizon',
                'code' => 'VZ',
            ],
            [
                'name' => 'Intel',
                'code' => 'INTC',
            ],
            [
                'name' => 'Netflix',
                'code' => 'NFLX',
            ],
            [
                'name' => 'Adobe',
                'code' => 'ADBE',
            ],
            [
                'name' => 'Salesforce',
                'code' => 'CRM',
            ],
        ];

        $bonds = [
            [
                'name' => 'United States 10-Year Bond',
                'code' => 'US10Y',
            ],
            [
                'name' => 'United States 5-Year Bond',
                'code' => 'US5Y',
            ],
            [
                'name' => 'United States 2-Year Bond',
                'code' => 'US2Y',
            ],
            [
                'name' => 'United States 3-Month Bond',
                'code' => 'US3M',
            ],
            [
                'name' => 'United States 1-Month Bond',
                'code' => 'US1M',
            ],
        ];

        Currency::insert(
            collect($fiats)->map(function ($currency){
                $currency['type'] = CurrencyType::FIAT;
                $currency['updated_at'] = now();
                $currency['created_at'] = now();

                return $currency;
            })->toArray(),
        );

        Currency::insert(
            collect($cryptos)->map(function ($currency){
                $currency['type'] = CurrencyType::CRYPTO;
                $currency['updated_at'] = now();
                $currency['created_at'] = now();

                return $currency;
            })->toArray(),
        );

        Currency::insert(
            collect($metals)->map(function ($currency){
                $currency['type'] = CurrencyType::PRECIOUS_METAL;
                $currency['updated_at'] = now();
                $currency['created_at'] = now();

                return $currency;
            })->toArray(),
        );

        Currency::insert(
            collect($stocks)->map(function ($currency){
                $currency['type'] = CurrencyType::STOCK;
                $currency['updated_at'] = now();
                $currency['created_at'] = now();

                return $currency;
            })->toArray(),
        );

        Currency::insert(
            collect($bonds)->map(function ($currency){
                $currency['type'] = CurrencyType::BOND;
                $currency['updated_at'] = now();
                $currency['created_at'] = now();

                return $currency;
            })->toArray(),
        );
    }
}
