<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderDue extends Notification
{
    use Queueable;

    public function __construct(
        public Reminder $reminder,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $memorial = $this->reminder->memorial;
        $type = str_replace('_', ' ', $this->reminder->type);

        return (new MailMessage)
            ->subject('Remembering ' . $memorial->fullName())
            ->greeting("Today marks a special day")
            ->line("This is a gentle reminder about {$memorial->fullName()}'s {$type}.")
            ->action('Visit Memorial', route('memorial.show', $memorial->slug))
            ->line('Take a moment to remember and honor their memory.');
    }
}
