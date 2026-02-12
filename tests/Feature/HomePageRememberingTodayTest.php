<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Memorial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageRememberingTodayTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_memorial_born_today(): void
    {
        $memorial = Memorial::factory()->public()->create([
            'first_name' => 'Elena',
            'last_name' => 'Petrova',
            'date_of_birth' => now()->subYears(80)->format('Y-m-d'),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Elena Petrova');
        $response->assertSee(__('Born on This Day'));
    }

    public function test_home_page_shows_memorial_died_today(): void
    {
        $memorial = Memorial::factory()->public()->create([
            'first_name' => 'Marcus',
            'last_name' => 'Wright',
            'date_of_birth' => now()->subYears(70)->format('Y-m-d'),
            'date_of_death' => now()->subYears(2)->format('Y-m-d'),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Marcus Wright');
        $response->assertSee(__('In Memoriam'));
    }

    public function test_home_page_hides_section_when_no_memorials_match_today(): void
    {
        Memorial::factory()->public()->create([
            'date_of_birth' => now()->subDays(5)->subYears(80)->format('Y-m-d'),
            'date_of_death' => now()->subDays(10)->subYears(2)->format('Y-m-d'),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee(__('Remembering Today'));
    }

    public function test_home_page_excludes_unpublished_memorials(): void
    {
        Memorial::factory()->draft()->create([
            'first_name' => 'Hidden',
            'last_name' => 'Person',
            'date_of_birth' => now()->subYears(80)->format('Y-m-d'),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Hidden Person');
    }

    public function test_home_page_excludes_private_memorials(): void
    {
        Memorial::factory()->create([
            'first_name' => 'Private',
            'last_name' => 'Person',
            'privacy' => 'invite_only',
            'is_published' => true,
            'date_of_birth' => now()->subYears(80)->format('Y-m-d'),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Private Person');
    }
}
