<?php

namespace App\Models;

use App\Models\Traits\HasOrganization;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasTenants, MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasOrganization, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /** @return Collection<int, Organization> */
    public function getTenants(Panel $panel): Collection
    {
        if ($this->isAdmin()) {
            return Organization::all();
        }

        return $this->organization()->get();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        /** @phpstan-ignore-next-line  */
        return $this->belongsToOrganization($tenant) || $this->isAdmin();
    }
}
