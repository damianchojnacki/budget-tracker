<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = Organization::first();

        User::factory()
            ->recycle($organization)
            ->create([
                'firstname' => 'Test',
                'lastname' => 'User',
                'email' => 'user@example.com',
            ]);

        User::factory()
            ->recycle($organization)
            ->create([
                'firstname' => 'Test',
                'lastname' => 'Admin',
                'email' => 'admin@example.com',
                'is_admin' => true,
            ]);
    }
}
