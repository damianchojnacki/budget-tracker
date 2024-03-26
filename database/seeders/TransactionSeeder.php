<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Budget::all()->each(function (Budget $budget) {
            Transaction::factory()
                ->recycle($budget)
                ->count(rand(10, 100))
                ->create([
                    'amount' => rand(round($budget->amount * -100000), round($budget->amount * 100000)) / 1000000,
                ]);
        });
    }
}
