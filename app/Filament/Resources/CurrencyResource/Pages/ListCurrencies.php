<?php

namespace App\Filament\Resources\CurrencyResource\Pages;

use App\Filament\Resources\BudgetResource;
use App\Filament\Resources\CurrencyResource;
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

class ListCurrencies extends ListRecords
{
    protected static string $resource = CurrencyResource::class;

    public function getTitle(): Htmlable | string
    {
        return __('Currencies');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
