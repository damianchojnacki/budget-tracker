<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\BudgetResource;
use App\Filament\Resources\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditBudget extends EditRecord
{
    protected static string $resource = BudgetResource::class;

    public function getTitle(): Htmlable | string
    {
        return __('Edit') . ' ' . __('Budget');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
