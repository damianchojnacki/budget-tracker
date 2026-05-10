<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganizationInvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'organization_id' => null,
            'email' => 'invited@example.com',
        ]);

        $currency = Currency::first();

        OrganizationInvitation::factory()
            ->for(Organization::factory()->recycle($currency))
            ->create([
                'email' => $user->email,
            ]);
    }
}
