<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class BudgetHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Budget::with('transactions')->get()->each(function (Budget $budget) {
            $budget->transactions->each(function (Transaction $transaction) use ($budget) {
                $budget->history()->create([
                    'amount' => $budget->amount += $transaction->amount,
                    'created_at' => $transaction->created_at,
                    'updated_at' => $transaction->updated_at,
                ]);
            });
        });
    }
}
