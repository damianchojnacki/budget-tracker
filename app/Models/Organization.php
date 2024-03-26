<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Organization extends Model
{
    use HasFactory;

    /**
     * Get the owner of the organization.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the default currency of the organization.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get all the organization's users including its owner.
     *
     * @return Collection<int, User>
     */
    public function allUsers(): Collection
    {
        /** @phpstan-ignore-next-line */
        return $this->users->merge([$this->owner]);
    }

    /**
     * Get all the users that belong to the organization.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all the budgets that belong to the organization.
     */
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    /**
     * Get all the currencies that belong to the organization.
     */
    public function currencies(): HasMany
    {
        return $this->hasMany(Currency::class);
    }

    /**
     * Determine if the given user belongs to the organization.
     */
    public function hasUser(User $user): bool
    {
        return $this->users->contains($user) || $user->ownsOrganization($this);
    }

    /**
     * Determine if the given email address belongs to a user on the organization.
     */
    public function hasUserWithEmail(string $email): bool
    {
        return $this->allUsers()->contains(function ($user) use ($email) {
            return $user->email === $email;
        });
    }

    /**
     * Get all the pending user invitations for the organization.
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(OrganizationInvitation::class);
    }

    /**
     * Remove the given user from the organization.
     */
    public function removeUser(User $user): void
    {
        $user->organization()->disassociate();
        $user->save();
    }

    /**
     * Purge all the organization's resources.
     */
    public function purge(): void
    {
        $this->owner()->where('organization_id', $this->id)
            ->update(['organization_id' => null]);

        $this->users()->where('organization_id', $this->id)
            ->update(['organization_id' => null]);

        $this->delete();
    }
}
