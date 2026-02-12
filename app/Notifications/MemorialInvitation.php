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
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('You\'re invited to view a memorial on GraveSpace')
            ->greeting('Memorial Invitation')
            ->line('You have been invited to view the memorial for ' . $this->memorial->fullName() . '.')
            ->action('View Memorial', url('/' . $this->memorial->slug))
            ->line('This is a private memorial shared with you by the family.');
    }
}
