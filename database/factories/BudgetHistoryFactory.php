<?php

namespace Database\Factories;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BudgetHistory>
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
            'amount' => $this->faker->randomFloat(2, 1, 10000),
            'created_at' => now()->subDays(rand(0, 90)),
            'updated_at' => function ($attributes) {
                return $attributes['created_at'];
            },
        ];
    }
}
