<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PremiumFeaturesTest extends TestCase
{
    use RefreshDatabase;

    // ─── Memorial Themes ───────────────────────────────────────────────

    public function test_memorial_has_default_classic_theme(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $this->assertEquals('classic', $memorial->theme);
    }

    public function test_memorial_theme_classes_returns_correct_class(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create(['theme' => 'garden']);

        $this->assertEquals('memorial-theme-garden', $memorial->themeClasses());
    }

    public function test_memorial_classic_theme_returns_correct_class(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create(['theme' => 'classic']);

        $this->assertEquals('memorial-theme-classic', $memorial->themeClasses());
    }

    public function test_memorial_available_themes_returns_all_themes(): void
    {
        $themes = Memorial::availableThemes();

        $this->assertCount(5, $themes);
        $this->assertArrayHasKey('classic', $themes);
        $this->assertArrayHasKey('garden', $themes);
        $this->assertArrayHasKey('celestial', $themes);
        $this->assertArrayHasKey('ocean', $themes);
        $this->assertArrayHasKey('sunset', $themes);
    }

    public function test_premium_user_can_set_memorial_theme(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->put(route('dashboard.memorials.update', $memorial), [
            'first_name' => $memorial->first_name,
            'last_name' => $memorial->last_name,
            'privacy' => 'public',
            'theme' => 'celestial',
            'is_published' => true,
        ]);

        $response->assertRedirect();
        $this->assertEquals('celestial', $memorial->fresh()->theme);
    }

    public function test_free_user_can_only_use_classic_theme(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->canSelectTheme());
    }

    public function test_premium_user_can_select_theme(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);

        $this->assertTrue($user->canSelectTheme());
    }

    public function test_invalid_theme_rejected_by_validation(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->put(route('dashboard.memorials.update', $memorial), [
            'first_name' => $memorial->first_name,
            'last_name' => $memorial->last_name,
            'privacy' => 'public',
            'theme' => 'invalid-theme',
            'is_published' => true,
        ]);

        $response->assertSessionHasErrors('theme');
    }

    public function test_memorial_show_applies_theme_class(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create([
            'theme' => 'ocean',
            'privacy' => 'public',
            'is_published' => true,
        ]);

        $response = $this->get(route('memorial.show', $memorial));

        $response->assertStatus(200);
        $response->assertSee('memorial-theme-ocean');
    }

    // ─── Voice Memories ────────────────────────────────────────────────

    public function test_free_user_cannot_access_voice_memories_page(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/voice-memories");

        $response->assertRedirect(route('pricing'));
    }

    public function test_premium_user_can_access_voice_memories_page(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/voice-memories");

        $response->assertStatus(200);
    }

    public function test_free_user_cannot_upload_voice_memory(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->canUploadVoiceMemory());
    }

    public function test_premium_user_can_upload_voice_memory(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);

        $this->assertTrue($user->canUploadVoiceMemory());
    }

    public function test_voice_memory_title_is_sanitized(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $voiceMemory = $memorial->voiceMemories()->create([
            'user_id' => $user->id,
            'file_path' => 'memorials/voice-memories/test.mp3',
            'title' => '<script>alert("xss")</script>Dad\'s message',
            'sort_order' => 1,
        ]);

        $this->assertEquals('alert("xss")Dad\'s message', $voiceMemory->title);
    }

    public function test_voice_memory_formatted_duration(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $voiceMemory = $memorial->voiceMemories()->create([
            'user_id' => $user->id,
            'file_path' => 'memorials/voice-memories/test.mp3',
            'title' => 'Test',
            'duration' => 125,
            'sort_order' => 1,
        ]);

        $this->assertEquals('2:05', $voiceMemory->formattedDuration());
    }

    public function test_voice_memories_shown_on_memorial_page(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create([
            'privacy' => 'public',
            'is_published' => true,
        ]);

        $memorial->voiceMemories()->create([
            'user_id' => $user->id,
            'file_path' => 'memorials/voice-memories/test.mp3',
            'title' => 'A Special Recording',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('memorial.show', $memorial));

        $response->assertStatus(200);
        $response->assertSee('A Special Recording');
    }

    // ─── Memorial Export ───────────────────────────────────────────────

    public function test_free_user_cannot_access_export(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/export");

        $response->assertRedirect(route('pricing'));
    }

    public function test_premium_user_can_access_export(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get("/dashboard/memorials/{$memorial->slug}/export");

        $response->assertStatus(200);
    }

    public function test_free_user_cannot_export_memorial(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->canExportMemorial());
    }

    public function test_premium_user_can_export_memorial(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);

        $this->assertTrue($user->canExportMemorial());
    }

    public function test_export_page_shows_memorial_content(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create([
            'first_name' => 'Eleanor',
            'last_name' => 'Roosevelt',
            'obituary' => 'A remarkable life of service.',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard.memorials.export', $memorial));

        $response->assertStatus(200);
        $response->assertSee('Eleanor');
        $response->assertSee('Roosevelt');
        $response->assertSee('A remarkable life of service.');
    }

    // ─── Pricing Page ──────────────────────────────────────────────────

    public function test_pricing_page_shows_new_premium_features(): void
    {
        $response = $this->get(route('pricing'));

        $response->assertStatus(200);
        $response->assertSee('Voice memories');
        $response->assertSee('memorial themes');
        $response->assertSee('Export memorial as PDF');
    }
}
