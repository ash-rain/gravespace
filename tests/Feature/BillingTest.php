<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_billing_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard.billing'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_billing_page(): void
    {
        $response = $this->get(route('dashboard.billing'));

        $response->assertRedirect('/login');
    }

    public function test_free_user_is_not_premium(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isPremium());
        $this->assertFalse($user->hasLifetimePremium());
    }

    public function test_lifetime_user_is_premium(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);

        $this->assertTrue($user->isPremium());
        $this->assertTrue($user->hasLifetimePremium());
    }

    public function test_free_user_limited_to_one_memorial(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($user->canCreateMemorial());

        $user->memorials()->create([
            'slug' => 'test-memorial-1234',
            'first_name' => 'Test',
            'last_name' => 'Person',
            'privacy' => 'public',
            'is_published' => false,
        ]);

        $this->assertFalse($user->canCreateMemorial());
    }

    public function test_premium_user_can_create_unlimited_memorials(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);

        $user->memorials()->create([
            'slug' => 'test-memorial-1234',
            'first_name' => 'Test',
            'last_name' => 'Person',
            'privacy' => 'public',
            'is_published' => false,
        ]);

        $this->assertTrue($user->canCreateMemorial());
    }

    public function test_free_user_max_photos_is_5(): void
    {
        $user = User::factory()->create();

        $this->assertEquals(5, $user->maxPhotosPerMemorial());
    }

    public function test_premium_user_unlimited_photos(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);

        $this->assertEquals(PHP_INT_MAX, $user->maxPhotosPerMemorial());
    }
}
