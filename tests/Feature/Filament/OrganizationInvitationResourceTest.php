<?php

use App\Filament\Resources\OrganizationInvitationResource;
use App\Filament\Resources\OrganizationInvitationResource\Pages\ListOrganizationInvitations;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;

test('renders list page', function () {
    $user = User::factory()->create();

    test()
        ->actingAs($user)
        ->get(OrganizationInvitationResource::getUrl('index', tenant: $user->organization))
        ->assertSuccessful();
});

test('lists correct invitations', function () {
    $organization = Organization::factory()->create();
    test()->actingAs($organization->owner);
    Filament::setTenant($organization);

    $invitations = OrganizationInvitation::factory()
        ->recycle($organization)
        ->count(3)
        ->create();

    $hidden = OrganizationInvitation::factory()
        ->count(3)
        ->create();

    Livewire::test(ListOrganizationInvitations::class)
        ->assertCanSeeTableRecords($invitations)
        ->assertCanNotSeeTableRecords($hidden);
});
