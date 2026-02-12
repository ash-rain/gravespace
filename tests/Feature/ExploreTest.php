<?php

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExploreTest extends TestCase
{
    use RefreshDatabase;

    public function test_explore_page_loads(): void
    {
        $response = $this->get('/explore');

        $response->assertStatus(200);
    }

    public function test_explore_page_shows_public_published_memorials(): void
    {
        $user = User::factory()->create();
        $public = Memorial::factory()->for($user)->create([
            'first_name' => 'PublicAlbert',
            'last_name' => 'Einstein',
            'privacy' => 'public',
            'is_published' => true,
        ]);

        $response = $this->get('/explore');

        $response->assertStatus(200);
        $response->assertSee('PublicAlbert');
    }

    public function test_explore_page_hides_unpublished_memorials(): void
    {
        $user = User::factory()->create();
        $unpublished = Memorial::factory()->for($user)->create([
            'first_name' => 'UnpublishedPerson',
            'privacy' => 'public',
            'is_published' => false,
        ]);

        $response = $this->get('/explore');

        $response->assertStatus(200);
        $response->assertDontSee('UnpublishedPerson');
    }

    public function test_explore_page_hides_password_protected_memorials(): void
    {
        $user = User::factory()->create();
        $passwordProtected = Memorial::factory()->for($user)->create([
            'first_name' => 'ProtectedPerson',
            'privacy' => 'password',
            'is_published' => true,
        ]);

        $response = $this->get('/explore');

        $response->assertStatus(200);
        $response->assertDontSee('ProtectedPerson');
    }

    public function test_explore_page_hides_invite_only_memorials(): void
    {
        $user = User::factory()->create();
        $inviteOnly = Memorial::factory()->for($user)->create([
            'first_name' => 'InviteOnlyPerson',
            'privacy' => 'invite_only',
            'is_published' => true,
        ]);

        $response = $this->get('/explore');

        $response->assertStatus(200);
        $response->assertDontSee('InviteOnlyPerson');
    }

    public function test_explore_search_filters_by_first_name(): void
    {
        $user = User::factory()->create();
        Memorial::factory()->for($user)->create([
            'first_name' => 'Albert',
            'last_name' => 'Einstein',
            'privacy' => 'public',
            'is_published' => true,
        ]);
        Memorial::factory()->for($user)->create([
            'first_name' => 'Marie',
            'last_name' => 'Curie',
            'privacy' => 'public',
            'is_published' => true,
        ]);

        $response = $this->get('/explore?search=Albert');

        $response->assertStatus(200);
        $response->assertSee('Albert');
        $response->assertDontSee('Marie');
    }

    public function test_explore_search_filters_by_last_name(): void
    {
        $user = User::factory()->create();
        Memorial::factory()->for($user)->create([
            'first_name' => 'Albert',
            'last_name' => 'Einstein',
            'privacy' => 'public',
            'is_published' => true,
        ]);
        Memorial::factory()->for($user)->create([
            'first_name' => 'Marie',
            'last_name' => 'Curie',
            'privacy' => 'public',
            'is_published' => true,
        ]);

        $response = $this->get('/explore?search=Curie');

        $response->assertStatus(200);
        $response->assertSee('Marie');
        $response->assertDontSee('Albert');
    }

    public function test_explore_search_returns_no_results_for_nonexistent_query(): void
    {
        $user = User::factory()->create();
        Memorial::factory()->for($user)->create([
            'first_name' => 'Albert',
            'last_name' => 'Einstein',
            'privacy' => 'public',
            'is_published' => true,
        ]);

        $response = $this->get('/explore?search=Nonexistent12345');

        $response->assertStatus(200);
        $response->assertDontSee('Albert');
    }

    public function test_explore_search_does_not_return_private_memorials(): void
    {
        $user = User::factory()->create();
        Memorial::factory()->for($user)->create([
            'first_name' => 'HiddenAlbert',
            'last_name' => 'Secret',
            'privacy' => 'password',
            'is_published' => true,
        ]);

        $response = $this->get('/explore?search=HiddenAlbert');

        $response->assertStatus(200);
        $response->assertDontSee('HiddenAlbert');
    }

    public function test_explore_page_is_accessible_without_authentication(): void
    {
        $response = $this->get('/explore');

        $response->assertStatus(200);
    }

    public function test_explore_page_is_accessible_with_authentication(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/explore');

        $response->assertStatus(200);
    }
}
