<?php

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\Tribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TributeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_tribute(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/tributes", [
            'author_name' => 'Jane Visitor',
            'author_email' => 'jane@example.com',
            'body' => 'What a wonderful person they were.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tributes', [
            'memorial_id' => $memorial->id,
            'author_name' => 'Jane Visitor',
            'author_email' => 'jane@example.com',
            'body' => 'What a wonderful person they were.',
            'is_approved' => false,
        ]);
    }

    public function test_authenticated_user_can_submit_tribute(): void
    {
        $owner = User::factory()->create();
        $visitor = User::factory()->create();
        $memorial = Memorial::factory()->for($owner)->public()->create();

        $response = $this->actingAs($visitor)->post("/{$memorial->slug}/tributes", [
            'body' => 'A tribute from a logged-in user.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tributes', [
            'memorial_id' => $memorial->id,
            'user_id' => $visitor->id,
            'body' => 'A tribute from a logged-in user.',
            'is_approved' => false,
        ]);
    }

    public function test_tribute_requires_body(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/tributes", [
            'author_name' => 'Jane',
            'body' => '',
        ]);

        $response->assertSessionHasErrors('body');
    }

    public function test_guest_tribute_requires_author_name(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/tributes", [
            'author_name' => '',
            'body' => 'A tribute without an author name.',
        ]);

        $response->assertSessionHasErrors('author_name');
    }

    public function test_tribute_body_has_max_length(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/tributes", [
            'author_name' => 'Jane',
            'body' => str_repeat('x', 5001),
        ]);

        $response->assertSessionHasErrors('body');
    }

    public function test_tribute_is_created_as_unapproved(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $this->post("/{$memorial->slug}/tributes", [
            'author_name' => 'Jane Visitor',
            'body' => 'Rest in peace.',
        ]);

        $tribute = Tribute::where('memorial_id', $memorial->id)->first();
        $this->assertNotNull($tribute);
        $this->assertFalse($tribute->is_approved);
    }

    public function test_owner_can_approve_tribute(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $tribute = Tribute::factory()->for($memorial)->create(['is_approved' => false]);

        $response = $this->actingAs($user)->post("/dashboard/tributes/{$tribute->id}/approve");

        $response->assertRedirect();
        $this->assertDatabaseHas('tributes', [
            'id' => $tribute->id,
            'is_approved' => true,
        ]);
    }

    public function test_non_owner_cannot_approve_tribute(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $tribute = Tribute::factory()->for($memorial)->create(['is_approved' => false]);

        $response = $this->actingAs($otherUser)->post("/dashboard/tributes/{$tribute->id}/approve");

        $response->assertStatus(403);
        $this->assertDatabaseHas('tributes', [
            'id' => $tribute->id,
            'is_approved' => false,
        ]);
    }

    public function test_guest_cannot_approve_tribute(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $tribute = Tribute::factory()->for($memorial)->create(['is_approved' => false]);

        $response = $this->post("/dashboard/tributes/{$tribute->id}/approve");

        $response->assertRedirect('/login');
    }

    public function test_owner_can_reject_tribute(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $tribute = Tribute::factory()->for($memorial)->create(['is_approved' => true]);

        $response = $this->actingAs($user)->post("/dashboard/tributes/{$tribute->id}/reject");

        $response->assertRedirect();
        $this->assertDatabaseHas('tributes', [
            'id' => $tribute->id,
            'is_approved' => false,
        ]);
    }

    public function test_owner_can_delete_tribute(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $tribute = Tribute::factory()->for($memorial)->create();

        $response = $this->actingAs($user)->delete("/dashboard/tributes/{$tribute->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('tributes', ['id' => $tribute->id]);
    }

    public function test_non_owner_cannot_delete_tribute(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $tribute = Tribute::factory()->for($memorial)->create();

        $response = $this->actingAs($otherUser)->delete("/dashboard/tributes/{$tribute->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('tributes', ['id' => $tribute->id]);
    }

    public function test_tribute_author_can_delete_own_tribute(): void
    {
        $owner = User::factory()->create();
        $tributeAuthor = User::factory()->create();
        $memorial = Memorial::factory()->for($owner)->create();
        $tribute = Tribute::factory()->for($memorial)->create([
            'user_id' => $tributeAuthor->id,
        ]);

        $response = $this->actingAs($tributeAuthor)->delete("/dashboard/tributes/{$tribute->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('tributes', ['id' => $tribute->id]);
    }

    public function test_guest_cannot_delete_tribute(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $tribute = Tribute::factory()->for($memorial)->create();

        $response = $this->delete("/dashboard/tributes/{$tribute->id}");

        $response->assertRedirect('/login');
    }

    public function test_tribute_to_nonexistent_memorial_returns_404(): void
    {
        $response = $this->post('/nonexistent-slug-12345/tributes', [
            'author_name' => 'Jane',
            'body' => 'This should fail.',
        ]);

        $response->assertStatus(404);
    }

    public function test_honeypot_rejects_bot_submissions(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->post("/{$memorial->slug}/tributes", [
            'author_name' => 'Bot User',
            'body' => 'I am a bot.',
            'website_url' => 'https://spam.example.com',
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('tributes', [
            'memorial_id' => $memorial->id,
            'author_name' => 'Bot User',
        ]);
    }
}
