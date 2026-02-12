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
        $type = $this->reminder->type === 'birthday' ? 'birthday' : 'remembrance anniversary';

        return (new MailMessage)
            ->subject('Memorial Reminder: ' . $memorial->fullName())
            ->greeting('Memorial Reminder')
            ->line('Today marks the ' . $type . ' of ' . $memorial->fullName() . '.')
            ->action('Visit Memorial', url('/' . $memorial->slug))
            ->line('Take a moment to remember and honor their memory.');
    }
}
