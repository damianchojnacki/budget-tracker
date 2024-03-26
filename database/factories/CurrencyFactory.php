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
            'organization_id' => null,
            'type' => $this->faker->randomElement(CurrencyType::cases()),
            'name' => $this->faker->randomElement(['US Dollar', 'Euro', 'Pound Sterling', 'Japanese Yen', 'Chinese Yuan', 'Indian Rupee', 'Australian Dollar', 'Canadian Dollar', 'Swiss Franc', 'South African Rand']),
            'code' => $this->faker->randomElement(['USD', 'EUR', 'GBP', 'JPY', 'CNY', 'INR', 'AUD', 'CAD', 'CHF', 'ZAR']),
            'symbol' => $this->faker->randomElement(['$', '€', '£', '¥', '¥', '₹', '$', '$', '₣', 'R']),
            'rate' => $this->faker->randomFloat(2, 0.01, 100),
        ];
    }
}
