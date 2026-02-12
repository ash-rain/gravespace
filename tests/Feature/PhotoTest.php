<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_upload_photos(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->post(
            route('dashboard.memorials.photos.store', $memorial),
            ['photos' => [UploadedFile::fake()->image('photo.jpg')]]
        );

        $response->assertRedirect();
        $this->assertEquals(1, $memorial->photos()->count());
    }

    public function test_non_owner_cannot_upload_photos(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->post(
            route('dashboard.memorials.photos.store', $memorial),
            ['photos' => [UploadedFile::fake()->image('photo.jpg')]]
        );

        $response->assertStatus(403);
    }

    public function test_free_user_limited_to_5_photos(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        // Create 5 existing photos
        Photo::factory()->count(5)->create([
            'memorial_id' => $memorial->id,
            'uploaded_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->post(
            route('dashboard.memorials.photos.store', $memorial),
            ['photos' => [UploadedFile::fake()->image('photo6.jpg')]]
        );

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertEquals(5, $memorial->photos()->count());
    }

    public function test_premium_user_can_upload_more_than_5_photos(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        Photo::factory()->count(5)->create([
            'memorial_id' => $memorial->id,
            'uploaded_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->post(
            route('dashboard.memorials.photos.store', $memorial),
            ['photos' => [UploadedFile::fake()->image('photo6.jpg')]]
        );

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertEquals(6, $memorial->photos()->count());
    }

    public function test_owner_can_delete_photo(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $photo = Photo::factory()->create([
            'memorial_id' => $memorial->id,
            'uploaded_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete(route('dashboard.photos.destroy', $photo));

        $response->assertRedirect();
        $this->assertSoftDeleted('photos', ['id' => $photo->id]);
    }

    public function test_non_owner_cannot_delete_photo(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($otherUser)->create();
        $photo = Photo::factory()->create([
            'memorial_id' => $memorial->id,
            'uploaded_by' => $otherUser->id,
        ]);

        $response = $this->actingAs($user)->delete(route('dashboard.photos.destroy', $photo));

        $response->assertStatus(403);
    }

    public function test_photo_upload_validates_image_type(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->post(
            route('dashboard.memorials.photos.store', $memorial),
            ['photos' => [UploadedFile::fake()->create('document.pdf', 100, 'application/pdf')]]
        );

        $response->assertSessionHasErrors('photos.0');
    }

    public function test_guest_cannot_upload_photos(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->post(route('dashboard.memorials.photos.store', $memorial));

        $response->assertRedirect('/login');
    }
}
