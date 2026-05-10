<?php

namespace Tests;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    public function actingAsTenant(User $user): static
    {
        $this->actingAs($user);
        Filament::setTenant($user->organization);

        return $this;
    }
}
