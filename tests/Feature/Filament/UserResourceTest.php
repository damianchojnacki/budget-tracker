<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\CreateBudget;
use App\Filament\Resources\UserResource\Pages\EditBudget;
use App\Filament\Resources\UserResource\Pages\ListBudgets;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\User;
use App\Notifications\InvitedToOrganization;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

/**
 * @see \App\Filament\Resources\UserResource
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

    public function testRendersListPage()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('index'))
            ->assertSuccessful();
    }

    public function testRendersCreatePage()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('create'))
            ->assertSuccessful();
    }

    public function testRendersUpdatePage()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('edit', [
                'record' => User::factory()->create([
                    'organization_id' => $this->user->organization->id,
                ]),
            ]))
            ->assertSuccessful();
    }

    public function testDoesRenderUpdatePageForModelOutsideTenacy()
    {
        $this->actingAs($this->user)
            ->get(UserResource::getUrl('edit', [
                'record' => User::factory()->create([
                    'organization_id' => null,
                ]),
            ]))
            ->assertNotFound();
    }

    public function testListsCorrectUsers()
    {
        $users = User::factory()->count(3)->create([
            'organization_id' => $this->user->organization->id,
        ]);

        $organization = Organization::factory()->create();

        $hidden = User::factory()->count(3)->create([
            'organization_id' => $organization->id,
        ]);

        Livewire::test(ListBudgets::class)
            ->assertCanSeeTableRecords($users)
            ->assertCanNotSeeTableRecords($hidden);
    }

    public function testCreatesUser()
    {
        $data = User::factory()->make()->toArray();

        $data['password'] = 'password';
        $data['email_verified_at'] = true;

        Livewire::test(CreateBudget::class)
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

    public function testUpdatesUser()
    {
        $user = User::factory()->create([
            'organization_id' => $this->user->organization->id,
        ]);

        $data = User::factory()
            ->make()
            ->toArray();

        $data['email_verified_at'] = true;

        Livewire::test(EditBudget::class, [
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

    public function testDeletesUser()
    {
        $user = User::factory()->create([
            'organization_id' => $this->user->organization->id,
        ]);

        Livewire::test(EditBudget::class, [
            'record' => $user->id,
        ])->callAction(DeleteAction::class);

        $this->assertModelMissing($user);
    }

    public function testInvitesUser()
    {
        Notification::fake();

        Livewire::test(ListBudgets::class)
            ->callAction('invite', [
                'email' => $email = 'test@example.com',
            ]);

        Notification::assertSentOnDemand(InvitedToOrganization::class, function ($notification, $channels, $notifable) use ($email) {
            return $notification->invitation->email === $email && $notifable->routes['mail'] === $email;
        });
    }

    public function testDoesNotInvitesUserIfInvitationAlreadyExists()
    {
        Notification::fake();

        OrganizationInvitation::factory()
            ->recycle($this->user->organization)
            ->create([
                'email' => $email = 'test@example.com',
            ]);

        Livewire::test(ListBudgets::class)
            ->callAction('invite', [
                'email' => $email,
            ])->assertNotified('User already exists');

        Notification::assertNothingSent();
    }
}
