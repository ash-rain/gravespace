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
            ->subject('You have been invited to a memorial on GraveSpace')
            ->greeting('Memorial Invitation')
            ->line($this->inviter->name . ' has invited you to help manage the memorial for ' . $this->memorial->fullName() . '.')
            ->action('View Memorial', route('memorial.show', $this->memorial->slug))
            ->line('Thank you for being part of keeping their memory alive.');
    }
}
