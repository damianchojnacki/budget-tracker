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
            $precision = $budget->currency->precision;
            $multiplier = 10 ** $precision;

            Transaction::factory()
                ->recycle($budget)
                ->count(rand(10, 100))
                ->create([
                    'amount' => fn () => rand(
                        (int) round($budget->amount * -$multiplier),
                        (int) round($budget->amount * $multiplier),
                    ) / $multiplier,
                ]);
        });
    }
}
