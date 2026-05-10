<?php

namespace Database\Factories;

use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
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
            'name' => fake()->word(),
            'description' => fake()->paragraph(),
            'amount' => fake()->randomFloat(2, -1000, 1000),
            'created_at' => now()->subDays(rand(0, 90)),
            'updated_at' => fn (array $attributes) => $attributes['created_at'],
        ];
    }
}
