<?php

namespace Database\Factories;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
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
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'amount' => $this->faker->randomFloat(2, -1000, 1000),
            'created_at' => now()->subDays(rand(0, 90)),
            'updated_at' => function ($attributes) {
                return $attributes['created_at'];
            },
        ];
    }
}
