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

test('renders list page', function (): void {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    test()
        ->actingAs($user)
        ->get(UserResource::getUrl('index', tenant: $user->organization))
        ->assertSuccessful();
});

test('renders create page', function (): void {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    test()
        ->actingAs($user)
        ->get(UserResource::getUrl('create', tenant: $user->organization))
        ->assertSuccessful();
});

test('renders update page', function (): void {
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

test('does render update page for model outside tenacy', function (): void {
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

test('lists correct users', function (): void {
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

test('creates user', function (): void {
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

    $record = User::firstWhere('email', $data['email']);

    expect($record)->not->toBeNull()
        ->and($record->firstname)->toEqual($data['firstname'])
        ->and($record->lastname)->toEqual($data['lastname'])
        ->and($record->email)->toEqual($data['email'])
        ->and($record->organization->id)->toEqual($user->organization->id);
});

test('updates user', function (): void {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    test()->actingAsTenant($user);

    $record = User::factory()->create([
        'organization_id' => $user->organization->id,
    ]);

    $data = User::factory()
        ->make()
        ->toArray();

    $data['email_verified_at'] = true;

    Livewire::test(EditUser::class, [
        'record' => $record->getRouteKey(),
    ])
        ->fillForm($data)
        ->call('save')
        ->assertHasNoFormErrors();

    $record = $record->refresh();

    expect($record->firstname)->toEqual($data['firstname'])
        ->and($record->lastname)->toEqual($data['lastname'])
        ->and($record->email)->toEqual($data['email']);
});

test('deletes user', function (): void {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    test()->actingAsTenant($user);

    $record = User::factory()->create([
        'organization_id' => $user->organization->id,
    ]);

    Livewire::test(EditUser::class, [
        'record' => $record->getRouteKey(),
    ])->callAction(DeleteAction::class);

    test()->assertModelMissing($record);
});

test('invites user', function (): void {
    Notification::fake();

    $user = User::factory()->create([
        'is_admin' => true,
    ]);
    test()->actingAsTenant($user);

    Livewire::test(ListUsers::class)
        ->callAction('invite', [
            'email' => $email = 'test@example.com',
        ]);

    Notification::assertSentOnDemand(InvitedToOrganization::class, fn ($notification, $channels, $notifable): bool => $notification->invitation->email === $email && $notifable->routes['mail'] === $email);
});

test('does not invites user if invitation already exists', function (): void {
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
