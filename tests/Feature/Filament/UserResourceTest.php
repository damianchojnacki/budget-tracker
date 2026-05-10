<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\User;
use App\Notifications\InvitedToOrganization;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

/**
 * @see UserResource
 */
class UserResourceTest extends FilamentTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user->update([
            'is_admin' => true,
        ]);
    }

    public function test_renders_list_page()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('index'))
            ->assertSuccessful();
    }

    public function test_renders_create_page()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('create'))
            ->assertSuccessful();
    }

    public function test_renders_update_page()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('edit', [
                'record' => User::factory()->create([
                    'organization_id' => $this->user->organization->id,
                ]),
            ]))
            ->assertSuccessful();
    }

    public function test_does_render_update_page_for_model_outside_tenacy()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('edit', [
                'record' => User::factory()->create([
                    'organization_id' => null,
                ]),
            ]))
            ->assertNotFound();
    }

    public function test_lists_correct_users()
    {
        $users = User::factory()->count(3)->create([
            'organization_id' => $this->user->organization->id,
        ]);

        $organization = Organization::factory()->create();

        $hidden = User::factory()->count(3)->create([
            'organization_id' => $organization->id,
        ]);

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users)
            ->assertCanNotSeeTableRecords($hidden);
    }

    public function test_creates_user()
    {
        $data = User::factory()->make()->toArray();

        $data['password'] = 'password';
        $data['email_verified_at'] = true;

        Livewire::test(CreateUser::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoFormErrors();

        $user = User::firstWhere('email', $data['email']);

        $this->assertNotNull($user);

        $this->assertEquals($data['firstname'], $user->firstname);
        $this->assertEquals($data['lastname'], $user->lastname);
        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals($this->user->organization->id, $user->organization->id);
    }

    public function test_updates_user()
    {
        $user = User::factory()->create([
            'organization_id' => $this->user->organization->id,
        ]);

        $data = User::factory()
            ->make()
            ->toArray();

        $data['email_verified_at'] = true;

        Livewire::test(EditUser::class, [
            'record' => $user->id,
        ])->fillForm($data)
            ->call('save')
            ->assertHasNoFormErrors();

        $user = $user->fresh();

        $this->assertEquals($data['firstname'], $user->firstname);
        $this->assertEquals($data['lastname'], $user->lastname);
        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals($this->user->organization->id, $user->organization->id);
    }

    public function test_deletes_user()
    {
        $user = User::factory()->create([
            'organization_id' => $this->user->organization->id,
        ]);

        Livewire::test(EditUser::class, [
            'record' => $user->id,
        ])->callAction(DeleteAction::class);

        $this->assertModelMissing($user);
    }

    public function test_invites_user()
    {
        Notification::fake();

        Livewire::test(ListUsers::class)
            ->callAction('invite', [
                'email' => $email = 'test@example.com',
            ]);

        Notification::assertSentOnDemand(InvitedToOrganization::class, function ($notification, $channels, $notifable) use ($email) {
            return $notification->invitation->email === $email && $notifable->routes['mail'] === $email;
        });
    }

    public function test_does_not_invites_user_if_invitation_already_exists()
    {
        Notification::fake();

        OrganizationInvitation::factory()
            ->recycle($this->user->organization)
            ->create([
                'email' => $email = 'test@example.com',
            ]);

        Livewire::test(ListUsers::class)
            ->callAction('invite', [
                'email' => $email,
            ])->assertNotified('User already exists');

        Notification::assertNothingSent();
    }
}
