<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): Htmlable | string
    {
        return __('Create') . ' ' . __('User');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var Organization $organization */
        $organization = Filament::getTenant();

        $data['organization_id'] = $organization->id;

        return $data;
    }
}
