<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\BudgetResource;
use App\Filament\Resources\UserResource;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListBudgets extends ListRecords
{
    protected static string $resource = BudgetResource::class;

    public function getTitle(): Htmlable | string
    {
        return __('Budgets');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
