<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_premium_owner_can_access_analytics(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('dashboard.memorials.analytics', $memorial));

        $response->assertStatus(200);
    }

    public function test_free_user_cannot_access_analytics(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('dashboard.memorials.analytics', $memorial));

        $response->assertRedirect(route('pricing'));
    }

    public function test_non_owner_cannot_access_analytics(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->get(route('dashboard.memorials.analytics', $memorial));

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_analytics(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->get(route('dashboard.memorials.analytics', $memorial));

        $response->assertRedirect('/login');
    }

    public function test_memorial_visit_tracked(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $this->get("/{$memorial->slug}");

        $this->assertDatabaseHas('memorial_visits', [
            'memorial_id' => $memorial->id,
        ]);
    }
}
