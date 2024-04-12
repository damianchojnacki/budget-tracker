<?php

namespace App\Filament\Widgets;

use App\Models\BudgetHistory;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use NumberFormatter;

class BudgetOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        //        $earnings = $this->getEarnings();
        //
        //        $spendings = $this->getSpendings();

        $total = $this->getTotal();

        return [
            //            Stat::make('Month revenue', $month['current'])
            //                ->description($month['diff'])
            //                ->descriptionIcon($month['icon'])
            //                ->chart($month['data'])
            //                ->color($month['color']),
            //            Stat::make('Month revenue', $month['current'])
            //                ->description($month['diff'])
            //                ->descriptionIcon($month['icon'])
            //                ->chart($month['data'])
            //                ->color($month['color']),
            Stat::make(__('Total budget'), $total['current'])
                ->description($total['diff'])
                ->descriptionIcon($total['icon'])
                ->chart($total['data'])
                ->color($total['color']),
        ];
    }

    protected static function formatCurrency(float $value, string $currency = 'USD'): string
    {
        $result = NumberFormatter::create(app()->currentLocale(), NumberFormatter::CURRENCY)->formatCurrency($value, $currency);

        if(!$result) {
            return '';
        }

        return $result;
    }

    protected function getBudgetSum(): float
    {
        $organization = Auth::user()->organization;

        return $organization
            ->budgets()
            ->selectRaw('SUM(amount / (SELECT rate from currencies where id = currency_id) * (SELECT rate from currencies where code = ?)) as sum', [
                $organization->currency->code,
            ])
            ->first()
            ->sum;
    }

    protected function getBudgetSumHistory(?Carbon $before = null): float
    {
        $organization = Auth::user()->organization;

        return $organization
            ->budgets()
            ->join('budget_histories', 'budget_histories.budget_id', '=', 'budgets.id')
            ->where('budget_histories.created_at', '<', $before ?? now())
            ->selectRaw('DAY(budget_histories.created_at), SUM(budget_histories.amount / (SELECT rate from currencies where id = currency_id) * (SELECT rate from currencies where code = ?)) as sum', [
                $organization->currency->code,
            ])
            ->groupByRaw('DAY(budget_histories.created_at)')
            ->first()
            ->sum;
    }

    /**
     * @return int[]
     */
    protected function getTotalData(?Carbon $after = null, ?Carbon $before = null): array
    {
        $organization = Auth::user()->organization;

        return BudgetHistory::query()
            ->where('budget_histories.created_at', '>', $after ?? BudgetHistory::oldest()->first()?->created_at ?? now()->subMonth())
            ->where('budget_histories.created_at', '<', $before ?? now())
            ->whereHas('budget', fn ($query) => $query->where('organization_id', $organization->id))
            ->join('budgets', 'budgets.id', '=', 'budget_histories.budget_id')
            ->selectRaw('DAY(budget_histories.created_at), SUM(budget_histories.amount / (SELECT rate from currencies where id = budgets.currency_id) * (SELECT rate from currencies where code = ?)) as sum', [
                $organization->currency->code,
            ])
            ->groupByRaw('DAY(budget_histories.created_at)')
            ->pluck('sum')
            ->toArray();
    }

    protected function getDiffPercent(float $current, float $previous): float
    {
        if ($current == 0 || $previous == 0) {
            return 0;
        }

        if ($current < $previous) {
            return -round((1 - $current / $previous) * 100);
        }

        return round((1 - $previous / $current) * 100);
    }

    //    /**
    //     *  @return array{
    //     *     current: string,
    //     *     data: int[],
    //     *     diff: string|null,
    //     *     icon: string|null,
    //     *     color: string|null,
    //     *  }
    //     */
    //    protected function getEarnings(): array
    //    {
    //        $current = $this->getRevenueSum(now()->startOfMonth());
    //
    //        $previous = $this->getRevenueSum(now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth());
    //
    //        $diff = $this->getDiffPercent($current, $previous);
    //
    //        return [
    //            'current' => static::formatCurrency($current),
    //            'data' => $this->getRevenueData(now()->startOfMonth()),
    //            'diff' => $diff > 0 ? "{$diff}% increase" : ($diff < 0 ? "{$diff}% decrease" : null),
    //            'icon' => $diff > 0 ? 'heroicon-m-arrow-trending-up' : ($diff < 0 ? 'heroicon-m-arrow-trending-down' : null),
    //            'color' => $diff > 0 ? 'success' : ($diff < 0 ? 'danger' : null),
    //        ];
    //    }
    //
    //    /**
    //     *  @return array{
    //     *     current: string,
    //     *     data: int[],
    //     *     diff: string|null,
    //     *     icon: string|null,
    //     *     color: string|null,
    //     *  }
    //     */
    //    protected function getSpendings(): array
    //    {
    //        $current = $this->getRevenueSum(now()->startOfMonth());
    //
    //        $previous = $this->getRevenueSum(now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth());
    //
    //        $diff = $this->getDiffPercent($current, $previous);
    //
    //        return [
    //            'current' => static::formatCurrency($current),
    //            'data' => $this->getRevenueData(now()->startOfMonth()),
    //            'diff' => $diff > 0 ? "{$diff}% increase" : ($diff < 0 ? "{$diff}% decrease" : null),
    //            'icon' => $diff > 0 ? 'heroicon-m-arrow-trending-up' : ($diff < 0 ? 'heroicon-m-arrow-trending-down' : null),
    //            'color' => $diff > 0 ? 'success' : ($diff < 0 ? 'danger' : null),
    //        ];
    //    }

    /**
     *  @return array{
     *     current: string,
     *     data: int[],
     *     diff: string|null,
     *     icon: string|null,
     *     color: string|null,
     *  }
     */
    protected function getTotal(): array
    {
        $current = $this->getBudgetSum();

        $previous = $this->getBudgetSumHistory(now()->subMonth());

        $diff = $this->getDiffPercent($current, $previous);

        return [
            'current' => static::formatCurrency($current, Auth::user()->organization->currency->code),
            'data' => $this->getTotalData(now()->startOfMonth()),
            'diff' => $diff > 0 ? "{$diff}% ".__('increase') : ($diff < 0 ? "{$diff}% ".__('decrease') : null),
            'icon' => $diff > 0 ? 'heroicon-m-arrow-trending-up' : ($diff < 0 ? 'heroicon-m-arrow-trending-down' : null),
            'color' => $diff > 0 ? 'success' : ($diff < 0 ? 'danger' : null),
        ];
    }
}
