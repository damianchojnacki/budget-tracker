<?php

namespace Database\Factories;

use App\Models\Budget;
use App\Models\Currency;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Budget>
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
            'name' => fake()->randomElement(['Main', 'Savings', 'Emergency']),
            'color' => fake()->hexColor(),
            'icon' => 'fas-money-bill-wave',
            'amount' => fake()->randomFloat(2, 1, 10000),
        ];
    }
}
