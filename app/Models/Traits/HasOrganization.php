<?php

namespace App\Models\Traits;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasOrganization
{
    use HasRelationships;

    /** @return BelongsTo<Organization, $this> */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /** @return HasOne<Organization, $this> */
    public function ownedOrganization(): HasOne
    {
        return $this->hasOne(Organization::class, 'owner_id');
    }

    /**
     * Determine if the user owns the given team.
     */
    public function ownsOrganization(?Organization $organization = null): bool
    {
        if (!$organization) {
            return false;
        }

        return $this->id == $organization->owner_id;
    }

    /**
     * Determine if the user belongs to the given team.
     */
    public function belongsToOrganization(?Organization $organization = null): bool
    {
        if (!$organization) {
            return false;
        }
        if ($this->ownsOrganization($organization)) {
            return true;
        }

        return $this->organization_id == $organization->id;
    }
}
