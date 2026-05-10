<?php

namespace Database\Factories;

use App\Enums\CurrencyType;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //            'organization_id' => null,
            'type' => fake()->randomElement(CurrencyType::cases()),
            'name' => fake()->randomElement(['US Dollar', 'Euro', 'Pound Sterling', 'Japanese Yen', 'Chinese Yuan', 'Indian Rupee', 'Australian Dollar', 'Canadian Dollar', 'Swiss Franc', 'South African Rand']),
            'code' => fake()->randomElement(['USD', 'EUR', 'GBP', 'JPY', 'CNY', 'INR', 'AUD', 'CAD', 'CHF', 'ZAR']),
            'symbol' => fake()->randomElement(['$', '€', '£', '¥', '¥', '₹', '$', '$', '₣', 'R']),
            'rate' => fake()->randomFloat(2, 0.01, 100),
        ];
    }
}
