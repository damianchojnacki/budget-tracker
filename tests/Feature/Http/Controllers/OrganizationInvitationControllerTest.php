<?php

use App\Models\Organization;
use App\Models\User;
use Filament\Pages\Dashboard;
use Illuminate\Support\Facades\URL;

test('can be accepted', function (): void {
    $organization = Organization::factory()->create();

    $user = User::factory()->create([
        'organization_id' => null,
    ]);

    $invitation = $organization->invitations()->create([
        'email' => $user->email,
    ]);

    $url = URL::signedRoute('organization-invitations.accept', ['invitation' => $invitation]);

    test()
        ->actingAs($user)
        ->put($url)
        ->assertRedirect(Dashboard::getUrl(tenant: $organization));

    expect($user->fresh()->organization->is($organization))->toBeTrue();

    test()->assertModelMissing($invitation);
});

test('cannot be accepted if user already belongs to organization', function (): void {
    $organization = Organization::factory()->create();

    $user = User::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $invitation = $organization->invitations()->create([
        'email' => $user->email,
    ]);

    $url = URL::signedRoute('organization-invitations.accept', ['invitation' => $invitation]);

    test()
        ->actingAs($user)
        ->put($url)
        ->assertInvalid('email');
});

test('cannot be accepted if user has different email', function (): void {
    $organization = Organization::factory()->create();

    $user = User::factory()->create([
        'organization_id' => null,
    ]);

    $invitation = $organization->invitations()->create([
        'email' => 'anotheruser@example.com',
    ]);

    $url = URL::signedRoute('organization-invitations.accept', ['invitation' => $invitation]);

    test()
        ->actingAs($user)
        ->put($url)
        ->assertForbidden();
});
