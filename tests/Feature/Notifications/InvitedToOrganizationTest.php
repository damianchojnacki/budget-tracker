<?php

use App\Models\OrganizationInvitation;
use App\Models\User;
use App\Notifications\InvitedToOrganization;

test('renders notification correctly', function (): void {
    $notification = new InvitedToOrganization(
        $invitation = OrganizationInvitation::factory()->create()
    );

    $user = User::factory()->create();

    $content = $notification->toMail($user)->render()->toHtml();

    expect($content)->toContain($invitation->organization->name)
        ->and($content)->toContain(route('organization-invitations.accept', ['invitation' => $invitation]));
});
