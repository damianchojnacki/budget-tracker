<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'currency_id' => Currency::factory(),
            'name' => $this->faker->randomElement(['Main', 'Savings', 'Emergency']),
            'color' => $this->faker->hexColor(),
            'icon' => 'fas-money-bill-wave',
            'amount' => $this->faker->randomFloat(2, 1, 10000),
        ];
    }
}
