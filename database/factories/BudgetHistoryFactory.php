<?php

namespace Database\Factories;

use App\Models\Budget;
use App\Models\BudgetHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BudgetHistory>
 */
class BudgetHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'budget_id' => Budget::factory(),
            'amount' => fake()->randomFloat(2, 1, 10000),
            'created_at' => now()->subDays(rand(0, 90)),
            'updated_at' => fn (array $attributes) => $attributes['created_at'],
        ];
    }
}
