<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Memorial;
use App\Models\Tribute;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tribute>
 */
class TributeFactory extends Factory
{
    protected $model = Tribute::class;

    private static array $tributeMessages = [
        'You will be forever in our hearts. Rest in peace.',
        'Your kindness and warmth touched so many lives. We miss you dearly.',
        'Gone from our sight, but never from our hearts.',
        'The world was a better place with you in it. We will always remember your smile.',
        'Thank you for the beautiful memories. You will never be forgotten.',
        'Your legacy of love continues to inspire us every day.',
        'We cherish every moment we shared with you. Until we meet again.',
        'A life so beautifully lived deserves to be beautifully remembered.',
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
            'author_name' => fake()->name(),
            'author_email' => fake()->safeEmail(),
            'user_id' => null,
            'body' => fake()->randomElement(self::$tributeMessages),
            'photo_path' => null,
            'is_approved' => false,
        ];
    }

    /**
     * Indicate that the tribute is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
        ]);
    }

    /**
     * Indicate that the tribute is pending approval.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
        ]);
    }

    /**
     * Indicate that the tribute was submitted by a registered user.
     */
    public function byUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::factory(),
            'author_name' => null,
            'author_email' => null,
        ]);
    }

    /**
     * Indicate that the tribute includes a photo.
     */
    public function withPhoto(): static
    {
        return $this->state(fn (array $attributes) => [
            'photo_path' => 'tributes/' . fake()->uuid() . '.jpg',
        ]);
    }

    /**
     * Indicate that the tribute was submitted anonymously.
     */
    public function anonymous(): static
    {
        return $this->state(fn (array $attributes) => [
            'author_name' => 'Anonymous',
            'author_email' => null,
            'user_id' => null,
        ]);
    }
}
