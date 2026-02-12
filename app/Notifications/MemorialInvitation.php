<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemorialInvitation extends Notification
{
    use Queueable;

    public function __construct(
        public Memorial $memorial,
        public User $inviter,
        public string $role = 'viewer',
        public ?string $token = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $actionUrl = $this->token
            ? route('invitation.accept', $this->token)
            : url('/'.$this->memorial->slug);

        return (new MailMessage)
            ->subject(__('You\'re invited to manage a memorial on GraveSpace'))
            ->greeting(__('Memorial Invitation'))
            ->line(__(':name has invited you to :role the memorial for :memorial.', [
                'name' => $this->inviter->name,
                'role' => $this->role,
                'memorial' => $this->memorial->fullName(),
            ]))
            ->action(__('Accept Invitation'), $actionUrl)
            ->line(__('This invitation expires in 7 days.'));
    }
}
