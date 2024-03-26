<?php

namespace Tests\Feature\Filament;

use App\Models\Organization;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Tests\TestCase;

class FilamentTestCase extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $organization = Organization::factory()->create();

        $this->user = User::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $organization->update(['owner_id' => $this->user->id]);

        $this->actingAs($this->user);

        Filament::setTenant($this->user->organization);
    }
}
