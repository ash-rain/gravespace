<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Memorial>
 */
class MemorialFactory extends Factory
{
    protected $model = Memorial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $dateOfBirth = fake()->dateTimeBetween('-100 years', '-20 years');
        $dateOfDeath = fake()->dateTimeBetween($dateOfBirth, 'now');

        return [
            'user_id' => User::factory(),
            'slug' => Str::slug($firstName . '-' . $lastName . '-' . fake()->unique()->numerify('####')),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'maiden_name' => fake()->optional(0.3)->lastName(),
            'date_of_birth' => $dateOfBirth,
            'date_of_death' => $dateOfDeath,
            'place_of_birth' => fake()->city() . ', ' . fake()->state(),
            'place_of_death' => fake()->city() . ', ' . fake()->state(),
            'obituary' => fake()->paragraphs(3, true),
            'cover_photo' => null,
            'profile_photo' => null,
            'privacy' => 'public',
            'password_hash' => null,
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'cemetery_name' => fake()->optional(0.7)->company() . ' Cemetery',
            'cemetery_address' => fake()->optional(0.7)->address(),
            'is_published' => true,
        ];
    }

    /**
     * Indicate that the memorial is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    /**
     * Indicate that the memorial is a draft (unpublished).
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }

    /**
     * Indicate that the memorial is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'privacy' => 'public',
            'is_published' => true,
        ]);
    }

    /**
     * Indicate that the memorial is password-protected.
     */
    public function passwordProtected(): static
    {
        return $this->state(fn (array $attributes) => [
            'privacy' => 'password',
            'password_hash' => bcrypt('memorial-password'),
        ]);
    }

    /**
     * Indicate that the memorial is invite-only.
     */
    public function inviteOnly(): static
    {
        return $this->state(fn (array $attributes) => [
            'privacy' => 'invite',
        ]);
    }

    /**
     * Indicate that the memorial has no cemetery information.
     */
    public function withoutCemetery(): static
    {
        return $this->state(fn (array $attributes) => [
            'latitude' => null,
            'longitude' => null,
            'cemetery_name' => null,
            'cemetery_address' => null,
        ]);
    }
}
