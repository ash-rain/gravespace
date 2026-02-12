<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Memorial;
use App\Models\TimelineEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimelineEvent>
 */
class TimelineEventFactory extends Factory
{
    protected $model = TimelineEvent::class;

    private static array $lifeMilestones = [
        'Born',
        'First Day of School',
        'Graduated High School',
        'Started College',
        'Graduated College',
        'First Job',
        'Got Married',
        'First Child Born',
        'Career Achievement',
        'Retirement',
        'Anniversary Celebration',
        'Family Reunion',
        'Moved to New City',
        'Volunteered Abroad',
        'Published a Book',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'memorial_id' => Memorial::factory(),
            'title' => fake()->randomElement(self::$lifeMilestones),
            'description' => fake()->optional(0.8)->paragraph(),
            'event_date' => fake()->dateTimeBetween('-80 years', 'now'),
            'photo_id' => null,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the timeline event has an associated photo.
     */
    public function withPhoto(): static
    {
        return $this->state(fn (array $attributes) => [
            'photo_id' => \App\Models\Photo::factory(),
        ]);
    }

    /**
     * Set a specific milestone title.
     */
    public function milestone(string $title): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => $title,
        ]);
    }

    /**
     * Indicate that the event represents a birth.
     */
    public function birth(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => 'Born',
            'description' => 'Welcomed into the world.',
        ]);
    }

    /**
     * Indicate that the event represents a graduation.
     */
    public function graduation(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => 'Graduated',
            'description' => fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the event represents a marriage.
     */
    public function marriage(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => 'Got Married',
            'description' => 'Celebrated a beautiful union with loved ones.',
        ]);
    }
}
