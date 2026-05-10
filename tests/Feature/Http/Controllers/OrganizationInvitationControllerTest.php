<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\OrganizationInvitationController;
use App\Models\Organization;
use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

/**
 * @see OrganizationInvitationController
 */
class OrganizationInvitationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CurrencySeeder::class);
    }

    public function test_can_be_accepted()
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

    public function test_cannot_be_accepted_if_user_already_belongs_to_organization()
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

    public function test_cannot_be_accepted_if_user_has_different_email()
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
}
