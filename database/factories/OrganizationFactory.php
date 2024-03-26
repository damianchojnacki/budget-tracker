<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'currency_id' => Currency::inRandomOrder()->first()->id,
            'name' => $this->faker->unique()->company(),
        ];
    }
}
