<?php

namespace App\Filament\Resources\OrganizationInvitationResource\Pages;

use App\Filament\Resources\OrganizationInvitationResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListOrganizationInvitations extends ListRecords
{
    protected static string $resource = OrganizationInvitationResource::class;

    public function getTitle(): Htmlable|string
    {
        return __('Invitations');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
