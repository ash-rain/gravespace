<?php

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VirtualGiftTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_leave_candle(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/gifts", [
            'type' => 'candle',
            'message' => 'Rest in peace.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('virtual_gifts', [
            'memorial_id' => $memorial->id,
            'type' => 'candle',
            'message' => 'Rest in peace.',
            'user_id' => null,
        ]);
    }

    public function test_authenticated_user_can_leave_gift(): void
    {
        $owner = User::factory()->create();
        $visitor = User::factory()->create();
        $memorial = Memorial::factory()->for($owner)->public()->create();

        $response = $this->actingAs($visitor)->post("/{$memorial->slug}/gifts", [
            'type' => 'flower',
            'message' => 'Beautiful flowers for you.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('virtual_gifts', [
            'memorial_id' => $memorial->id,
            'type' => 'flower',
            'user_id' => $visitor->id,
        ]);
    }

    public function test_gift_requires_valid_type(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/gifts", [
            'type' => 'invalid_type',
        ]);

        $response->assertSessionHasErrors('type');
    }

    public function test_gift_requires_type(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/gifts", []);

        $response->assertSessionHasErrors('type');
    }

    public function test_all_gift_types_are_accepted(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        foreach (['candle', 'flower', 'tree', 'wreath', 'star'] as $type) {
            $response = $this->post("/{$memorial->slug}/gifts", [
                'type' => $type,
            ]);

            $response->assertRedirect();
            $this->assertDatabaseHas('virtual_gifts', [
                'memorial_id' => $memorial->id,
                'type' => $type,
            ]);
        }
    }

    public function test_gift_message_is_optional(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/gifts", [
            'type' => 'flower',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('virtual_gifts', [
            'memorial_id' => $memorial->id,
            'type' => 'flower',
            'message' => null,
        ]);
    }

    public function test_gift_message_max_length(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/gifts", [
            'type' => 'candle',
            'message' => str_repeat('x', 501),
        ]);

        $response->assertSessionHasErrors('message');
    }

    public function test_gift_to_nonexistent_memorial_returns_404(): void
    {
        $response = $this->post('/nonexistent-slug-99999/gifts', [
            'type' => 'candle',
        ]);

        $response->assertStatus(404);
    }

    public function test_honeypot_rejects_bot_gift_submissions(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/gifts", [
            'type' => 'candle',
            'message' => 'Spam gift.',
            'website_url' => 'https://spam.example.com',
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('virtual_gifts', [
            'memorial_id' => $memorial->id,
        ]);
    }

    public function test_gift_stores_with_correct_session_flash(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/gifts", [
            'type' => 'star',
            'message' => 'You are our brightest star.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Your gift has been placed.');
    }
}
