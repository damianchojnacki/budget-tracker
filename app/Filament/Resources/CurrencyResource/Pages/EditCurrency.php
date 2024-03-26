<?php

namespace App\Filament\Resources\CurrencyResource\Pages;

use App\Filament\Resources\BudgetResource;
use App\Filament\Resources\CurrencyResource;
use App\Filament\Resources\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditCurrency extends EditRecord
{
    protected static string $resource = CurrencyResource::class;

    public function getTitle(): Htmlable | string
    {
        return __('Edit') . ' ' . __('Currency');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
