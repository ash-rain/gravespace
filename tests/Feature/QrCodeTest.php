<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\QrCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_premium_user_can_view_qr_page(): void
    {
        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('dashboard.memorials.qr', $memorial));

        $response->assertStatus(200);
    }

    public function test_free_user_cannot_view_qr_page(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('dashboard.memorials.qr', $memorial));

        $response->assertRedirect(route('pricing'));
    }

    public function test_qr_redirect_works(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();
        $qrCode = QrCode::factory()->create(['memorial_id' => $memorial->id]);

        $response = $this->get("/qr/{$qrCode->code}");

        $response->assertRedirect(route('memorial.show', $memorial->slug));
    }

    public function test_qr_redirect_with_invalid_code_returns_404(): void
    {
        $response = $this->get('/qr/INVALID123');

        $response->assertStatus(404);
    }

    public function test_premium_user_can_download_qr(): void
    {
        if (! extension_loaded('imagick')) {
            $this->markTestSkipped('Imagick extension is required for QR PNG generation.');
        }

        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();
        QrCode::factory()->create(['memorial_id' => $memorial->id]);

        $response = $this->actingAs($user)->get(route('dashboard.memorials.qr.download', $memorial));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/png');
    }
}
