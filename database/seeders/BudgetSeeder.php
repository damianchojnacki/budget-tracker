<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Currency;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = Currency::all();

        Organization::all()->each(function (Organization $organization) use ($currencies) {
            $organization->budgets()->saveMany(
                Budget::factory()
                    ->count(rand(0, 6))
                    ->recycle($currencies)
                    ->make()
            );
        });

        User::firstWhere('email', 'user@example.com')
            ->organization
            ->budgets()
            ->tap(fn ($budgets) => $budgets->delete())
            ->createMany([
                [
                    'name' => 'Główne',
                    'currency_id' => Currency::firstWhere('code', 'PLN')->id,
                    'amount' => 5000,
                    'color' => '#65a30d',
                    'icon' => 'fas-credit-card',
                ],
                [
                    'name' => 'Oszczędnościowe',
                    'currency_id' => Currency::firstWhere('code', 'PLN')->id,
                    'amount' => 10000,
                    'color' => '#9333ea',
                    'icon' => 'fas-piggy-bank',
                ],
                [
                    'name' => 'Zonda',
                    'currency_id' => Currency::firstWhere('code', 'BTC')->id,
                    'amount' => 0.002317,
                    'color' => '#6366f1',
                    'icon' => 'fab-bitcoin',
                ],
                [
                    'name' => 'Revolut',
                    'currency_id' => Currency::firstWhere('code', 'BTC')->id,
                    'amount' => 0.001134,
                    'color' => '#f8fafc',
                    'icon' => 'fab-bitcoin',
                ],
                [
                    'name' => 'Trading212',
                    'currency_id' => Currency::firstWhere('code', 'AAPL')->id,
                    'amount' => 1.5,
                    'color' => '#2563eb',
                    'icon' => 'fas-chart-line',
                ],
                [
                    'name' => 'Metals',
                    'currency_id' => Currency::firstWhere('name', 'Silver Bullion Coin 1oz')->id,
                    'amount' => 5,
                    'color' => '#AAAAAA',
                    'icon' => 'rpg-gold-bar',
                ],
            ]);
    }
}
