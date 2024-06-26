<?php

namespace Tests\Feature\Notifications;

use App\Models\OrganizationInvitation;
use App\Models\User;
use App\Notifications\InvitedToOrganization;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CarController
 */
class InvitedToOrganizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CurrencySeeder::class);
    }

    public function testRendersNotificationCorrectly(): void
    {
        $notification = new InvitedToOrganization(
            $invitation = OrganizationInvitation::factory()->create()
        );

        $user = User::factory()->create();

        $content = $notification->toMail($user)->render();

        $this->assertStringContainsString($invitation->organization->name, $content);
        $this->assertStringContainsString(route('organization-invitations.accept', ['invitation' => $invitation]), $content);
    }
}
