<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\TimelineBuilder;
use App\Models\Memorial;
use App\Models\TimelineEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TimelineTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_timeline_event(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(TimelineBuilder::class, ['memorial' => $memorial])
            ->set('showForm', true)
            ->set('title', 'Born')
            ->set('description', 'A joyful day.')
            ->set('eventDate', '1950-06-15')
            ->call('addEvent')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('timeline_events', [
            'memorial_id' => $memorial->id,
            'title' => 'Born',
            'description' => 'A joyful day.',
        ]);
    }

    public function test_event_requires_title(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(TimelineBuilder::class, ['memorial' => $memorial])
            ->set('showForm', true)
            ->set('title', '')
            ->call('addEvent')
            ->assertHasErrors('title');
    }

    public function test_can_edit_timeline_event(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $event = TimelineEvent::factory()->create([
            'memorial_id' => $memorial->id,
            'title' => 'Original Title',
        ]);

        Livewire::actingAs($user)
            ->test(TimelineBuilder::class, ['memorial' => $memorial])
            ->call('editEvent', $event->id)
            ->set('title', 'Updated Title')
            ->call('updateEvent')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('timeline_events', [
            'id' => $event->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_can_delete_timeline_event(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $event = TimelineEvent::factory()->create([
            'memorial_id' => $memorial->id,
        ]);

        Livewire::actingAs($user)
            ->test(TimelineBuilder::class, ['memorial' => $memorial])
            ->call('deleteEvent', $event->id);

        $this->assertSoftDeleted('timeline_events', ['id' => $event->id]);
    }

    public function test_timeline_page_loads(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();
        TimelineEvent::factory()->create(['memorial_id' => $memorial->id]);

        $response = $this->get("/{$memorial->slug}/timeline");

        $response->assertStatus(200);
    }
}
