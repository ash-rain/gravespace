<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Memorial;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    protected $model = Video::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'memorial_id' => Memorial::factory(),
            'uploaded_by' => User::factory(),
            'file_path' => 'videos/' . fake()->uuid() . '.mp4',
            'thumbnail_path' => 'videos/thumbnails/' . fake()->uuid() . '.jpg',
            'caption' => fake()->optional(0.7)->sentence(),
            'duration' => fake()->numberBetween(5, 600),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the video has a caption.
     */
    public function withCaption(string $caption = null): static
    {
        return $this->state(fn (array $attributes) => [
            'caption' => $caption ?? fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the video is short (under 30 seconds).
     */
    public function short(): static
    {
        return $this->state(fn (array $attributes) => [
            'duration' => fake()->numberBetween(5, 30),
        ]);
    }

    /**
     * Indicate that the video is long (over 5 minutes).
     */
    public function long(): static
    {
        return $this->state(fn (array $attributes) => [
            'duration' => fake()->numberBetween(300, 3600),
        ]);
    }

    /**
     * Indicate that the video has no thumbnail.
     */
    public function withoutThumbnail(): static
    {
        return $this->state(fn (array $attributes) => [
            'thumbnail_path' => null,
        ]);
    }
}
