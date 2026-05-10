<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'owner_id' => User::factory()->state(['organization_id' => null]),
            'currency_id' => Currency::factory(),
            'name' => fake()->unique()->company(),
        ];
    }
}
