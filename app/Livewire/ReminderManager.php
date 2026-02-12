<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Memorial;
use App\Models\Reminder;
use App\Services\ReminderService;
use Illuminate\View\View;
use Livewire\Component;

class ReminderManager extends Component
{
    public Memorial $memorial;

    public string $type = 'birthday';

    public bool $showForm = false;

    public function mount(Memorial $memorial): void
    {
        $this->memorial = $memorial;
    }

    public function addReminder(): void
    {
        $this->validate([
            'type' => ['required', 'in:birthday,death_anniversary,custom'],
        ]);

        $user = auth()->user();

        $existing = Reminder::where('user_id', $user->id)
            ->where('memorial_id', $this->memorial->id)
            ->where('type', $this->type)
            ->first();

        if ($existing) {
            $this->addError('type', __('You already have a reminder of this type for this memorial.'));

            return;
        }

        $service = app(ReminderService::class);
        $service->createReminder($user, $this->memorial, $this->type);

        $this->reset(['type', 'showForm']);
        $this->type = 'birthday';
    }

    public function toggleReminder(int $reminderId): void
    {
        $reminder = Reminder::where('id', $reminderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $reminder->update(['is_active' => ! $reminder->is_active]);
    }

    public function deleteReminder(int $reminderId): void
    {
        Reminder::where('id', $reminderId)
            ->where('user_id', auth()->id())
            ->delete();
    }

    public function render(): View
    {
        return view('livewire.reminder-manager', [
            'reminders' => Reminder::where('user_id', auth()->id())
                ->where('memorial_id', $this->memorial->id)
                ->orderBy('type')
                ->get(),
        ]);
    }
}
