<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PremiumRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_free_user_cannot_access_qr_page(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/qr");

        $response->assertRedirect(route('pricing'));
    }

    public function test_free_user_cannot_access_qr_download(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/qr/download");

        $response->assertRedirect(route('pricing'));
    }

    public function test_free_user_cannot_access_analytics(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/analytics");

        $response->assertRedirect(route('pricing'));
    }

    public function test_premium_user_can_access_qr_page(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/qr");

        $response->assertStatus(200);
    }

    public function test_premium_user_can_access_analytics(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/analytics");

        $response->assertStatus(200);
    }
}
