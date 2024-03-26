<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrganizationInvitationController
 */
class OrganizationInvitationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCanBeAccepted()
    {
        $organization = Organization::factory()->create();

        $user = User::factory()->create([
            'organization_id' => null,
        ]);

        $invitation = $organization->invitations()->create([
            'email' => $user->email,
        ]);

        $url = URL::signedRoute('organization-invitations.accept', ['invitation' => $invitation]);

        $this->actingAs($user)
            ->put($url)
            ->assertSuccessful();

        $this->assertEquals($organization->id, $user->fresh()->organization->id);
        $this->assertModelMissing($invitation);
    }

    public function testCannotBeAcceptedIfUserAlreadyBelongsToOrganization()
    {
        $organization = Organization::factory()->create();

        $user = User::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $invitation = $organization->invitations()->create([
            'email' => $user->email,
        ]);

        $url = URL::signedRoute('organization-invitations.accept', ['invitation' => $invitation]);

        $this->actingAs($user)
            ->put($url)
            ->assertInvalid('email');
    }

    public function testCannotBeAcceptedIfUserHasDifferentEmail()
    {
        $organization = Organization::factory()->create();

        $user = User::factory()->create([
            'organization_id' => null,
        ]);

        $invitation = $organization->invitations()->create([
            'email' => 'anotheruser@example.com',
        ]);

        $url = URL::signedRoute('organization-invitations.accept', ['invitation' => $invitation]);

        $this->actingAs($user)
            ->put($url)
            ->assertForbidden();
    }

    public function testCanBeCanceled()
    {
        $owner = User::factory()->create();

        $organization = Organization::factory()->recycle($owner)->create();

        $invitation = $organization->invitations()->save(
            OrganizationInvitation::factory()->recycle($organization)->make()
        );

        $this->actingAs($owner)
            ->delete(route('organization-invitations.cancel', ['invitation' => $invitation]))
            ->assertSuccessful();

        $this->assertModelMissing($invitation);
    }

    public function testCanBeCanceledOnlyByOrganizationOwner()
    {
        $organization = Organization::factory()->create();

        $user = User::factory()->create();

        $invitation = $organization->invitations()->save(
            OrganizationInvitation::factory()->recycle($organization)->make()
        );

        $this->actingAs($user)
            ->delete(route('organization-invitations.cancel', ['invitation' => $invitation]))
            ->assertForbidden();
    }
}
