<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\ReminderManager;
use App\Models\Memorial;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_birthday_reminder(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create([
            'date_of_birth' => '1950-06-15',
        ]);

        Livewire::actingAs($user)
            ->test(ReminderManager::class, ['memorial' => $memorial])
            ->set('showForm', true)
            ->set('type', 'birthday')
            ->call('addReminder')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('reminders', [
            'user_id' => $user->id,
            'memorial_id' => $memorial->id,
            'type' => 'birthday',
            'is_active' => true,
        ]);
    }

    public function test_user_can_create_death_anniversary_reminder(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create([
            'date_of_death' => '2020-03-10',
        ]);

        Livewire::actingAs($user)
            ->test(ReminderManager::class, ['memorial' => $memorial])
            ->set('showForm', true)
            ->set('type', 'death_anniversary')
            ->call('addReminder')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('reminders', [
            'user_id' => $user->id,
            'memorial_id' => $memorial->id,
            'type' => 'death_anniversary',
        ]);
    }

    public function test_user_cannot_create_duplicate_reminder(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        Reminder::factory()->create([
            'user_id' => $user->id,
            'memorial_id' => $memorial->id,
            'type' => 'birthday',
        ]);

        Livewire::actingAs($user)
            ->test(ReminderManager::class, ['memorial' => $memorial])
            ->set('showForm', true)
            ->set('type', 'birthday')
            ->call('addReminder')
            ->assertHasErrors('type');
    }

    public function test_user_can_toggle_reminder(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $reminder = Reminder::factory()->active()->create([
            'user_id' => $user->id,
            'memorial_id' => $memorial->id,
        ]);

        Livewire::actingAs($user)
            ->test(ReminderManager::class, ['memorial' => $memorial])
            ->call('toggleReminder', $reminder->id);

        $this->assertDatabaseHas('reminders', [
            'id' => $reminder->id,
            'is_active' => false,
        ]);
    }

    public function test_user_can_delete_reminder(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $reminder = Reminder::factory()->create([
            'user_id' => $user->id,
            'memorial_id' => $memorial->id,
        ]);

        Livewire::actingAs($user)
            ->test(ReminderManager::class, ['memorial' => $memorial])
            ->call('deleteReminder', $reminder->id);

        $this->assertDatabaseMissing('reminders', ['id' => $reminder->id]);
    }

    public function test_user_cannot_toggle_others_reminder(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $reminder = Reminder::factory()->create([
            'user_id' => $otherUser->id,
            'memorial_id' => $memorial->id,
        ]);

        Livewire::actingAs($user)
            ->test(ReminderManager::class, ['memorial' => $memorial])
            ->call('toggleReminder', $reminder->id);
    }
}
