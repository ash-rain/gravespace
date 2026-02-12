<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\Memorial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitation>
 */
class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'memorial_id' => Memorial::factory(),
            'invited_by' => User::factory(),
            'email' => fake()->unique()->safeEmail(),
            'role' => 'viewer',
            'token' => Invitation::generateToken(),
            'accepted_at' => null,
            'expires_at' => now()->addDays(7),
        ];
    }

    /**
     * Indicate that the invitation has been accepted.
     */
    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'accepted_at' => now(),
        ]);
    }

    /**
     * Indicate that the invitation is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'accepted_at' => null,
            'expires_at' => now()->addDays(7),
        ]);
    }

    /**
     * Indicate that the invitation has expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'accepted_at' => null,
            'expires_at' => now()->subDay(),
        ]);
    }

    /**
     * Indicate that the invitation is for an editor role.
     */
    public function editor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'editor',
        ]);
    }
}
