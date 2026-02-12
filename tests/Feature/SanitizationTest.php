<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\TimelineEvent;
use App\Models\Tribute;
use App\Models\User;
use App\Models\VirtualGift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SanitizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_memorial_obituary_strips_html_tags(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create([
            'obituary' => '<script>alert("xss")</script>A wonderful person.',
        ]);

        $this->assertEquals('alert("xss")A wonderful person.', $memorial->obituary);
    }

    public function test_tribute_body_strips_html_tags(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $tribute = Tribute::factory()->for($memorial)->create([
            'body' => '<b>Bold</b> and <em>italic</em> text.',
        ]);

        $this->assertEquals('Bold and italic text.', $tribute->body);
    }

    public function test_timeline_event_description_strips_html_tags(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $event = TimelineEvent::factory()->create([
            'memorial_id' => $memorial->id,
            'description' => '<p>A paragraph</p><br><div>content</div>',
        ]);

        $this->assertEquals('A paragraphcontent', $event->description);
    }

    public function test_virtual_gift_message_strips_html_tags(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $gift = VirtualGift::factory()->create([
            'memorial_id' => $memorial->id,
            'message' => '<script>steal()</script>In loving memory',
        ]);

        $this->assertEquals('steal()In loving memory', $gift->message);
    }

    public function test_plain_text_preserved_without_modification(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create([
            'obituary' => 'A simple obituary with no HTML at all.',
        ]);

        $this->assertEquals('A simple obituary with no HTML at all.', $memorial->obituary);
    }

    public function test_null_values_handled_gracefully(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create([
            'obituary' => null,
        ]);

        $this->assertNull($memorial->obituary);
    }
}
