<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\BudgetResource;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateBudget extends CreateRecord
{
    protected static string $resource = BudgetResource::class;

    public function getTitle(): Htmlable|string
    {
        return __('Create').' '.__('Budget');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var Organization $organization */
        $organization = Filament::getTenant();

        $data['organization_id'] = $organization->id;

        return $data;
    }
}
