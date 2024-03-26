<?php

namespace App\Policies;

use App\Models\Currency;
use App\Models\User;

class CurrencyPolicy
{
    /**
     * Determine whether the user can view the currency.
     */
    public function view(User $user, Currency $currency): bool
    {
        return !$currency->organization || $user->organization?->id === $currency->organization?->id;
    }

    /**
     * Determine whether the user can view the currency.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the currency.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the currency.
     */
    public function update(User $user, Currency $currency): bool
    {
        return !$currency->organization || $user->organization?->id === $currency->organization?->id;
    }

    /**
     * Determine whether the user can view the currency.
     */
    public function delete(User $user, Currency $currency): bool
    {
        return !$currency->organization || $user->organization?->id === $currency->organization?->id;
    }
}
