<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    use RefreshDatabase;

    public function test_language_can_be_switched_to_french(): void
    {
        $response = $this->get('/language/fr');

        $response->assertRedirect();
        $response->assertCookie('locale', 'fr');
    }

    public function test_language_can_be_switched_to_german(): void
    {
        $response = $this->get('/language/de');

        $response->assertRedirect();
        $response->assertCookie('locale', 'de');
    }

    public function test_language_can_be_switched_to_bulgarian(): void
    {
        $response = $this->get('/language/bg');

        $response->assertRedirect();
        $response->assertCookie('locale', 'bg');
    }

    public function test_language_can_be_switched_to_english(): void
    {
        $response = $this->get('/language/en');

        $response->assertRedirect();
        $response->assertCookie('locale', 'en');
    }

    public function test_unsupported_language_returns_400(): void
    {
        $response = $this->get('/language/xx');

        $response->assertStatus(400);
    }

    public function test_unsupported_language_es_returns_400(): void
    {
        $response = $this->get('/language/es');

        $response->assertStatus(400);
    }

    public function test_home_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_pricing_page_loads(): void
    {
        $response = $this->get('/pricing');

        $response->assertStatus(200);
    }

    public function test_about_page_loads(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }

    public function test_explore_page_loads(): void
    {
        $response = $this->get('/explore');

        $response->assertStatus(200);
    }

    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_register_page_loads(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }
}
