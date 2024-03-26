<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currency = Currency::firstWhere('code', 'PLN');

        User::factory()->count(3)->create([
            'organization_id' => null,
        ])->each(function (User $user) use ($currency) {
            $organization = Organization::factory()->create([
                'owner_id' => $user->id,
                'currency_id' => $currency->id,
            ]);

            $user->update([
                'organization_id' => $organization->id,
            ]);
        });
    }
}
