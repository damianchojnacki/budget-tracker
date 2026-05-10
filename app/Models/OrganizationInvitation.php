<?php

namespace App\Models;

use App\Notifications\InvitedToOrganization;
use Database\Factories\OrganizationInvitationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Notification;

class OrganizationInvitation extends Model
{
    /** @use HasFactory<OrganizationInvitationFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Organization, $this>
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function sendNotification(): void
    {
        Notification::route('mail', $this->email)
            ->notify(new InvitedToOrganization($this));
    }
}
