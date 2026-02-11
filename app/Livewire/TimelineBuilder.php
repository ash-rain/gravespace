<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Memorial;
use App\Models\TimelineEvent;
use Illuminate\View\View;
use Livewire\Component;

class TimelineBuilder extends Component
{
    public Memorial $memorial;
    public string $title = '';
    public string $description = '';
    public ?string $eventDate = null;
    public bool $showForm = false;
    public ?int $editingId = null;

    public function mount(Memorial $memorial): void
    {
        $this->memorial = $memorial;
    }

    public function addEvent(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'eventDate' => ['nullable', 'date'],
        ]);

        TimelineEvent::create([
            'memorial_id' => $this->memorial->id,
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->eventDate,
            'sort_order' => $this->memorial->timelineEvents()->count(),
        ]);

        $this->reset(['title', 'description', 'eventDate', 'showForm']);
        $this->memorial->refresh();
    }

    public function editEvent(int $eventId): void
    {
        $event = TimelineEvent::findOrFail($eventId);
        $this->editingId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description ?? '';
        $this->eventDate = $event->event_date?->format('Y-m-d');
        $this->showForm = true;
    }

    public function updateEvent(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'eventDate' => ['nullable', 'date'],
        ]);

        $event = TimelineEvent::findOrFail($this->editingId);
        $event->update([
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->eventDate,
        ]);

        $this->reset(['title', 'description', 'eventDate', 'showForm', 'editingId']);
        $this->memorial->refresh();
    }

    public function deleteEvent(int $eventId): void
    {
        TimelineEvent::where('id', $eventId)->where('memorial_id', $this->memorial->id)->delete();
        $this->memorial->refresh();
    }

    public function render(): View
    {
        return view('livewire.timeline-builder', [
            'events' => $this->memorial->timelineEvents()->orderBy('event_date')->get(),
        ]);
    }
}
