<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AcceptOrganizationInvitationRequest;
use App\Models\OrganizationInvitation;
use Filament\Pages\Dashboard;
use Illuminate\Http\RedirectResponse;

class OrganizationInvitationController extends Controller
{
    /**
     * Accept organization invitation.
     */
    public function accept(AcceptOrganizationInvitationRequest $request, OrganizationInvitation $invitation): RedirectResponse
    {
        $request->user()->update([
            'organization_id' => $invitation->organization->id,
        ]);

        $invitation->delete();

        return redirect()->to(Dashboard::getUrl(tenant: $invitation->organization));
    }
}
