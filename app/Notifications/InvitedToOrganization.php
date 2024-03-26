<?php

namespace App\Notifications;

use App\Models\OrganizationInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class InvitedToOrganization extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public OrganizationInvitation $invitation)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->line(__('You have been invited to join the **:organization** organization.', [
                'organization' => $this->invitation->organization->name,
            ]))
            ->line(__('You may accept this invitation by clicking the button below:'))
            ->action(
                __('Accept Invitation'),
                URL::signedRoute('organization-invitations.accept', ['invitation' => $this->invitation])
            )
            ->line(__('If you did not expect to receive an invitation to this team, you may discard this email.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
