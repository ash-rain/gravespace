<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Memorial;
use App\Models\Reminder;
use App\Models\User;
use App\Notifications\ReminderDue;

class ReminderService
{
    public function createReminder(User $user, Memorial $memorial, string $type): Reminder
    {
        $notifyAt = match ($type) {
            'birthday' => $memorial->date_of_birth?->copy()->year(now()->year)->addYear(),
            'death_anniversary' => $memorial->date_of_death?->copy()->year(now()->year)->addYear(),
            default => now()->addYear(),
        };

        return Reminder::create([
            'user_id' => $user->id,
            'memorial_id' => $memorial->id,
            'type' => $type,
            'notify_at' => $notifyAt,
            'is_active' => true,
        ]);
    }

    public function processDueReminders(): int
    {
        $count = 0;
        $reminders = Reminder::due()->with(['user', 'memorial'])->get();

        foreach ($reminders as $reminder) {
            $reminder->user->notify(new ReminderDue($reminder));
            $reminder->update([
                'last_sent_at' => now(),
                'notify_at' => $reminder->notify_at->addYear(),
            ]);
            $count++;
        }

        return $count;
    }
}
