<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Tribute;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TributeReceived extends Notification
{
    use Queueable;

    public function __construct(
        public Tribute $tribute,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $memorial = $this->tribute->memorial;

        return (new MailMessage)
            ->subject('New tribute for ' . $memorial->fullName())
            ->greeting('A new tribute has been submitted')
            ->line($this->tribute->authorDisplayName() . ' left a tribute for ' . $memorial->fullName() . '.')
            ->action('Review Tribute', route('dashboard.memorials.edit', $memorial))
            ->line('The tribute is awaiting your approval.');
    }
}
