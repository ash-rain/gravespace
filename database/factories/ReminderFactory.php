<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Memorial;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reminder>
 */
class ReminderFactory extends Factory
{
    protected $model = Reminder::class;

    private static array $reminderTypes = [
        'birthday',
        'death_anniversary',
        'custom',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'memorial_id' => Memorial::factory(),
            'type' => fake()->randomElement(self::$reminderTypes),
            'notify_at' => fake()->dateTimeBetween('now', '+1 year'),
            'last_sent_at' => null,
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the reminder is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the reminder is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the reminder is due (notify_at is in the past).
     */
    public function due(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'notify_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the reminder has already been sent.
     */
    public function sent(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_sent_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the reminder is for a birthday.
     */
    public function birthday(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'birthday',
        ]);
    }

    /**
     * Indicate that the reminder is for a death anniversary.
     */
    public function deathAnniversary(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'death_anniversary',
        ]);
    }

    /**
     * Indicate that the reminder is a custom type.
     */
    public function custom(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'custom',
        ]);
    }
}
