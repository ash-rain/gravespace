<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\Tribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_moderation_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard.moderation'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_moderation_page(): void
    {
        $response = $this->get(route('dashboard.moderation'));

        $response->assertRedirect('/login');
    }

    public function test_moderation_shows_only_own_memorials_tributes(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $memorial = Memorial::factory()->for($user)->create();
        $otherMemorial = Memorial::factory()->for($otherUser)->create();

        $ownTribute = Tribute::factory()->for($memorial)->pending()->create(['author_name' => 'Own Visitor']);
        $otherTribute = Tribute::factory()->for($otherMemorial)->pending()->create(['author_name' => 'Other Visitor']);

        $response = $this->actingAs($user)->get(route('dashboard.moderation'));

        $response->assertStatus(200);
        $response->assertSee('Own Visitor');
        $response->assertDontSee('Other Visitor');
    }

    public function test_moderation_can_filter_by_memorial(): void
    {
        $user = User::factory()->create();
        $memorial1 = Memorial::factory()->for($user)->create();
        $memorial2 = Memorial::factory()->for($user)->create();

        $tribute1 = Tribute::factory()->for($memorial1)->pending()->create(['author_name' => 'Visitor One']);
        $tribute2 = Tribute::factory()->for($memorial2)->pending()->create(['author_name' => 'Visitor Two']);

        $response = $this->actingAs($user)->get(route('dashboard.moderation', ['memorial_id' => $memorial1->id]));

        $response->assertStatus(200);
        $response->assertSee('Visitor One');
        $response->assertDontSee('Visitor Two');
    }

    public function test_moderation_shows_empty_state_when_no_pending_tributes(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard.moderation'));

        $response->assertStatus(200);
        $response->assertSee(__('No pending tributes. All caught up!'));
    }
}
