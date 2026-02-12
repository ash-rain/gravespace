<?php

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemorialTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_public_memorial(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create([
            'privacy' => 'public',
            'is_published' => true,
        ]);

        $response = $this->get("/{$memorial->slug}");

        $response->assertStatus(200);
        $response->assertSee($memorial->first_name);
    }

    public function test_guest_can_view_unpublished_memorial_by_slug(): void
    {
        // The show route does not filter by is_published;
        // any memorial with a valid slug resolves via route model binding.
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create([
            'is_published' => false,
        ]);

        $response = $this->get("/{$memorial->slug}");

        $response->assertStatus(200);
    }

    public function test_nonexistent_slug_returns_404(): void
    {
        $response = $this->get('/this-slug-does-not-exist-9999');

        $response->assertStatus(404);
    }

    public function test_authenticated_user_can_access_create_memorial_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/memorials/create');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_store_memorial(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/dashboard/memorials', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1950-01-15',
            'date_of_death' => '2020-06-20',
            'obituary' => 'A wonderful person who touched many lives.',
            'privacy' => 'public',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('memorials', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_id' => $user->id,
        ]);
    }

    public function test_store_memorial_requires_first_and_last_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/dashboard/memorials', [
            'first_name' => '',
            'last_name' => '',
            'privacy' => 'public',
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name']);
    }

    public function test_store_memorial_requires_valid_privacy_value(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/dashboard/memorials', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'privacy' => 'invalid_value',
        ]);

        $response->assertSessionHasErrors('privacy');
    }

    public function test_store_memorial_validates_date_of_death_after_date_of_birth(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/dashboard/memorials', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '2000-06-15',
            'date_of_death' => '1990-01-01',
            'privacy' => 'public',
        ]);

        $response->assertSessionHasErrors('date_of_death');
    }

    public function test_user_can_edit_own_memorial(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/edit");

        $response->assertStatus(200);
    }

    public function test_user_cannot_edit_others_memorial(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/edit");

        $response->assertStatus(403);
    }

    public function test_user_can_update_own_memorial(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->put("/dashboard/memorials/{$memorial->slug}", [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'obituary' => 'Updated obituary text.',
            'privacy' => 'public',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('memorials', [
            'id' => $memorial->id,
            'first_name' => 'Jane',
            'last_name' => 'Smith',
        ]);
    }

    public function test_user_cannot_update_others_memorial(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->put("/dashboard/memorials/{$memorial->slug}", [
            'first_name' => 'Hijacked',
            'last_name' => 'Name',
            'privacy' => 'public',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_memorial(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete("/dashboard/memorials/{$memorial->slug}");

        $response->assertRedirect();
        $this->assertSoftDeleted('memorials', ['id' => $memorial->id]);
    }

    public function test_user_cannot_delete_others_memorial(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->delete("/dashboard/memorials/{$memorial->slug}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('memorials', ['id' => $memorial->id]);
    }

    public function test_free_user_cannot_create_more_than_one_memorial(): void
    {
        $user = User::factory()->create();
        Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get('/dashboard/memorials/create');

        $response->assertRedirect(route('pricing'));
    }

    public function test_free_user_cannot_store_second_memorial(): void
    {
        $user = User::factory()->create();
        Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->post('/dashboard/memorials', [
            'first_name' => 'Second',
            'last_name' => 'Memorial',
            'privacy' => 'public',
        ]);

        // StoreMemorialRequest authorize() returns false when canCreateMemorial() is false
        $response->assertStatus(403);
    }

    public function test_premium_user_can_create_multiple_memorials(): void
    {
        $user = User::factory()->create([
            'lifetime_premium_at' => now(),
        ]);
        Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get('/dashboard/memorials/create');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_create_memorial(): void
    {
        $response = $this->get('/dashboard/memorials/create');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_store_memorial(): void
    {
        $response = $this->post('/dashboard/memorials', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'privacy' => 'public',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_memorial_index_shows_user_memorials(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $otherUserMemorial = Memorial::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard/memorials');

        $response->assertStatus(200);
        $response->assertSee($memorial->first_name);
        $response->assertDontSee($otherUserMemorial->first_name);
    }

    public function test_memorial_show_page_displays_memorial_details(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create([
            'first_name' => 'Eleanor',
            'last_name' => 'Rigby',
            'obituary' => 'All the lonely people.',
        ]);

        $response = $this->get("/{$memorial->slug}");

        $response->assertStatus(200);
        $response->assertSee('Eleanor');
        $response->assertSee('Rigby');
    }

    public function test_password_protected_memorial_password_page_loads(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->passwordProtected()->create([
            'is_published' => true,
        ]);

        $response = $this->get("/{$memorial->slug}/password");

        $response->assertStatus(200);
    }

    public function test_memorial_gallery_page_loads(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->get("/{$memorial->slug}/gallery");

        $response->assertStatus(200);
    }

    public function test_memorial_timeline_page_loads(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $response = $this->get("/{$memorial->slug}/timeline");

        $response->assertStatus(200);
    }
}
