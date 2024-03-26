<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CurrencySeeder::class,
            OrganizationSeeder::class,
            UserSeeder::class,
            OrganizationInvitationSeeder::class,
            BudgetSeeder::class,
            TransactionSeeder::class,
            BudgetHistorySeeder::class,
        ]);
    }
}
