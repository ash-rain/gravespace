<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Jobs\ProcessVideoUpload;
use App\Models\Memorial;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VideoUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_premium_user_can_upload_video(): void
    {
        Queue::fake();
        Storage::fake('public');

        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->post(
            route('dashboard.memorials.videos.store', $memorial),
            [
                'video' => UploadedFile::fake()->create('test.mp4', 5000, 'video/mp4'),
                'caption' => 'A beautiful moment',
            ]
        );

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('videos', [
            'memorial_id' => $memorial->id,
            'uploaded_by' => $user->id,
            'caption' => 'A beautiful moment',
        ]);

        Queue::assertPushed(ProcessVideoUpload::class);
    }

    public function test_free_user_cannot_upload_video(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->post(
            route('dashboard.memorials.videos.store', $memorial),
            [
                'video' => UploadedFile::fake()->create('test.mp4', 5000, 'video/mp4'),
            ]
        );

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('videos', ['memorial_id' => $memorial->id]);
    }

    public function test_user_cannot_upload_video_to_others_memorial(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->post(
            route('dashboard.memorials.videos.store', $memorial),
            [
                'video' => UploadedFile::fake()->create('test.mp4', 5000, 'video/mp4'),
            ]
        );

        $response->assertStatus(403);
    }

    public function test_video_upload_validates_file_type(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['lifetime_premium_at' => now()]);
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->actingAs($user)->post(
            route('dashboard.memorials.videos.store', $memorial),
            [
                'video' => UploadedFile::fake()->create('test.txt', 100, 'text/plain'),
            ]
        );

        $response->assertSessionHasErrors('video');
    }

    public function test_owner_can_update_video_caption(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $video = Video::factory()->create([
            'memorial_id' => $memorial->id,
            'uploaded_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->patch(
            route('dashboard.videos.update', $video),
            ['caption' => 'Updated caption']
        );

        $response->assertRedirect();
        $this->assertDatabaseHas('videos', [
            'id' => $video->id,
            'caption' => 'Updated caption',
        ]);
    }

    public function test_owner_can_delete_video(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $video = Video::factory()->create([
            'memorial_id' => $memorial->id,
            'uploaded_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete(route('dashboard.videos.destroy', $video));

        $response->assertRedirect();
        $this->assertSoftDeleted('videos', ['id' => $video->id]);
    }

    public function test_non_owner_cannot_delete_video(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $memorial = Memorial::factory()->for($otherUser)->create();
        $video = Video::factory()->create([
            'memorial_id' => $memorial->id,
            'uploaded_by' => $otherUser->id,
        ]);

        $response = $this->actingAs($user)->delete(route('dashboard.videos.destroy', $video));

        $response->assertStatus(403);
    }

    public function test_guest_cannot_upload_video(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();

        $response = $this->post(route('dashboard.memorials.videos.store', $memorial));

        $response->assertRedirect('/login');
    }
}
