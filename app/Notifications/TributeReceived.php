<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Tribute;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

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
        return (new MailMessage)
            ->subject('New Tribute on ' . $this->tribute->memorial->fullName())
            ->greeting('A new tribute has been shared')
            ->line($this->tribute->authorDisplayName() . ' left a tribute on the memorial for ' . $this->tribute->memorial->fullName() . '.')
            ->line('"' . Str::limit($this->tribute->body, 200) . '"')
            ->action('Review Tribute', url('/dashboard/memorials/' . $this->tribute->memorial->id . '/edit'))
            ->line('Tributes require your approval before they are visible to visitors.');
    }
}
