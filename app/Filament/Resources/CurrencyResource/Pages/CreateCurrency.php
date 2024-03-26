<?php

namespace App\Filament\Resources\CurrencyResource\Pages;

use App\Filament\Resources\CurrencyResource;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateCurrency extends CreateRecord
{
    protected static string $resource = CurrencyResource::class;

    public function getTitle(): Htmlable|string
    {
        return __('Create').' '.__('Currency');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var Organization $organization */
        $organization = Filament::getTenant();

        $data['organization_id'] = $organization->id;

        return $data;
    }
}
