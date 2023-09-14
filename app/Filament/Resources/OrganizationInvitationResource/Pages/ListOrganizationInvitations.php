<?php

namespace App\Filament\Resources\OrganizationInvitationResource\Pages;

use App\Filament\Resources\OrganizationInvitationResource;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationInvitations extends ListRecords
{
    protected static string $resource = OrganizationInvitationResource::class;

    protected static ?string $title = 'Invitations';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
