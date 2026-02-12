<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Memorial;
use App\Models\Photo;
use App\Models\Tribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_soft_deleted_memorial_excluded_from_queries(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();

        $memorial->delete();

        $this->assertSoftDeleted('memorials', ['id' => $memorial->id]);
        $this->assertDatabaseHas('memorials', ['id' => $memorial->id]);
        $this->assertNull(Memorial::find($memorial->id));
    }

    public function test_soft_deleted_memorial_returns_404_on_public_view(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->public()->create();
        $slug = $memorial->slug;

        $memorial->delete();

        $response = $this->get("/{$slug}");
        $response->assertStatus(404);
    }

    public function test_soft_deleted_tribute_excluded_from_queries(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $tribute = Tribute::factory()->for($memorial)->approved()->create();

        $tribute->delete();

        $this->assertSoftDeleted('tributes', ['id' => $tribute->id]);
        $this->assertNull(Tribute::find($tribute->id));
    }

    public function test_soft_deleted_photo_excluded_from_queries(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $photo = Photo::factory()->create([
            'memorial_id' => $memorial->id,
            'uploaded_by' => $user->id,
        ]);

        $photo->delete();

        $this->assertSoftDeleted('photos', ['id' => $photo->id]);
        $this->assertNull(Photo::find($photo->id));
    }

    public function test_soft_deleted_records_not_counted_in_relationships(): void
    {
        $user = User::factory()->create();
        $memorial = Memorial::factory()->for($user)->create();
        $tribute1 = Tribute::factory()->for($memorial)->approved()->create();
        $tribute2 = Tribute::factory()->for($memorial)->approved()->create();

        $this->assertEquals(2, $memorial->tributes()->count());

        $tribute1->delete();

        $memorial->refresh();
        $this->assertEquals(1, $memorial->tributes()->count());
    }
}
