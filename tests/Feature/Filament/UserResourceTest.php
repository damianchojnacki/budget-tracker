<?php

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use App\Models\User;
use App\Notifications\InvitedToOrganization;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

test('renders list page', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    test()
        ->actingAs($user)
        ->get(UserResource::getUrl('index', tenant: $user->organization))
        ->assertSuccessful();
});

test('renders create page', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    test()
        ->actingAs($user)
        ->get(UserResource::getUrl('create', tenant: $user->organization))
        ->assertSuccessful();
});

test('renders update page', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    test()
        ->actingAs($user)
        ->get(UserResource::getUrl('edit', [
            'record' => User::factory()->create([
                'organization_id' => $user->organization->id,
            ]),
        ], tenant: $user->organization))
        ->assertSuccessful();
});

test('does render update page for model outside tenacy', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    test()
        ->actingAs($user)
        ->get(UserResource::getUrl('edit', [
            'record' => User::factory()->create([
                'organization_id' => null,
            ]),
        ], tenant: $user->organization))
        ->assertNotFound();
});

test('lists correct users', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    test()->actingAsTenant($user);

    $users = User::factory()->count(3)->create([
        'organization_id' => $user->organization->id,
    ]);

    $organization = Organization::factory()->create();

    $hidden = User::factory()->count(3)->create([
        'organization_id' => $organization->id,
    ]);

    Livewire::test(ListUsers::class)
        ->assertCanSeeTableRecords($users)
        ->assertCanNotSeeTableRecords($hidden);
});

test('creates user', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    test()->actingAsTenant($user);

    $data = User::factory()->make()->toArray();

    $data['password'] = 'password';
    $data['email_verified_at'] = true;

    Livewire::test(CreateUser::class)
        ->fillForm($data)
        ->call('create')
        ->assertHasNoFormErrors();

    $user = User::firstWhere('email', $data['email']);

    expect($user)->not->toBeNull()
        ->and($user->firstname)->toEqual($data['firstname'])
        ->and($user->lastname)->toEqual($data['lastname'])
        ->and($user->email)->toEqual($data['email'])
        ->and($user->organization->id)->toEqual($user->organization->id);
});

test('updates user', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    test()->actingAsTenant($user);

    $user = User::factory()->create([
        'organization_id' => $user->organization->id,
    ]);

    $data = User::factory()
        ->make()
        ->toArray();

    $data['email_verified_at'] = true;

    Livewire::test(EditUser::class, [
        'record' => $user->id,
    ])
        ->fillForm($data)
        ->call('save')
        ->assertHasNoFormErrors();

    $user = $user->fresh();

    expect($user->firstname)->toEqual($data['firstname'])
        ->and($user->lastname)->toEqual($data['lastname'])
        ->and($user->email)->toEqual($data['email'])
        ->and($user->organization->id)->toEqual($user->organization->id);
});

test('deletes user', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    test()->actingAsTenant($user);

    $user = User::factory()->create([
        'organization_id' => $user->organization->id,
    ]);

    Livewire::test(EditUser::class, [
        'record' => $user->id,
    ])->callAction(DeleteAction::class);

    test()->assertModelMissing($user);
});

test('invites user', function () {
    Notification::fake();

    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    test()->actingAsTenant($user);

    Livewire::test(ListUsers::class)
        ->callAction('invite', [
            'email' => $email = 'test@example.com',
        ]);

    Notification::assertSentOnDemand(InvitedToOrganization::class, function ($notification, $channels, $notifable) use ($email) {
        return $notification->invitation->email === $email && $notifable->routes['mail'] === $email;
    });
});

test('does not invites user if invitation already exists', function () {
    Notification::fake();

    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    test()->actingAsTenant($user);

    OrganizationInvitation::factory()
        ->recycle($user->organization)
        ->create([
            'email' => $email = 'test@example.com',
        ]);

    Livewire::test(ListUsers::class)
        ->callAction('invite', [
            'email' => $email,
        ])->assertNotified('User already exists');

    Notification::assertNothingSent();
});
