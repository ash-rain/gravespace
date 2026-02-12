<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Memorial;
use App\Models\Reminder;
use App\Models\User;
use App\Services\ReminderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ReminderServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_birthday_reminder_sets_correct_date(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create([
            'date_of_birth' => '1950-06-15',
        ]);

        $service = new ReminderService;
        $reminder = $service->createReminder($user, $memorial, 'birthday');

        $this->assertEquals('birthday', $reminder->type);
        $this->assertTrue($reminder->is_active);
        $this->assertEquals(6, $reminder->notify_at->month);
        $this->assertEquals(15, $reminder->notify_at->day);
    }

    public function test_create_death_anniversary_reminder_sets_correct_date(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create([
            'date_of_death' => '2020-03-10',
        ]);

        $service = new ReminderService;
        $reminder = $service->createReminder($user, $memorial, 'death_anniversary');

        $this->assertEquals('death_anniversary', $reminder->type);
        $this->assertEquals(3, $reminder->notify_at->month);
        $this->assertEquals(10, $reminder->notify_at->day);
    }

    public function test_process_due_reminders_sends_notifications(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        Reminder::factory()->due()->create([
            'user_id' => $user->id,
            'memorial_id' => $memorial->id,
        ]);

        $service = new ReminderService;
        $count = $service->processDueReminders();

        $this->assertEquals(1, $count);
        Notification::assertSentTo($user, \App\Notifications\ReminderDue::class);
    }

    public function test_process_due_reminders_advances_notify_at(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $reminder = Reminder::factory()->due()->create([
            'user_id' => $user->id,
            'memorial_id' => $memorial->id,
            'notify_at' => now()->subDay(),
        ]);

        $service = new ReminderService;
        $service->processDueReminders();

        $reminder->refresh();
        $this->assertTrue($reminder->notify_at->isFuture());
        $this->assertNotNull($reminder->last_sent_at);
    }

    public function test_inactive_reminders_not_processed(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        Reminder::factory()->inactive()->create([
            'user_id' => $user->id,
            'memorial_id' => $memorial->id,
            'notify_at' => now()->subDay(),
        ]);

        $service = new ReminderService;
        $count = $service->processDueReminders();

        $this->assertEquals(0, $count);
        Notification::assertNothingSent();
    }
}
