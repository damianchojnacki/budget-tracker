<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the user.
     */
    public function view(User $user, User $record): bool
    {
        return $user->organization?->id === $record->organization?->id;
    }

    /**
     * Determine whether the user can view the user.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the user.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the user.
     */
    public function update(User $user, User $record): bool
    {
        return $user->id === $record->id;
    }

    /**
     * Determine whether the user can view the user.
     */
    public function delete(User $user, User $record): bool
    {
        return $user->id === $record->id;
    }
}
