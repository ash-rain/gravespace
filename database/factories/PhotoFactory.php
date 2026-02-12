<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Memorial;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    protected $model = Photo::class;

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
            'file_path' => 'photos/' . fake()->uuid() . '.jpg',
            'thumbnail_path' => 'photos/thumbnails/' . fake()->uuid() . '.jpg',
            'caption' => fake()->optional(0.7)->sentence(),
            'date_taken' => fake()->optional(0.5)->dateTimeBetween('-50 years', 'now'),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the photo has a caption.
     */
    public function withCaption(string $caption = null): static
    {
        return $this->state(fn (array $attributes) => [
            'caption' => $caption ?? fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the photo has a specific date taken.
     */
    public function takenOn(string $date): static
    {
        return $this->state(fn (array $attributes) => [
            'date_taken' => $date,
        ]);
    }

    /**
     * Indicate that the photo has no thumbnail.
     */
    public function withoutThumbnail(): static
    {
        return $this->state(fn (array $attributes) => [
            'thumbnail_path' => null,
        ]);
    }
}
