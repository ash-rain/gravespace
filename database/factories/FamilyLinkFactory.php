<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\FamilyLink;
use App\Models\Memorial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyLink>
 */
class FamilyLinkFactory extends Factory
{
    protected $model = FamilyLink::class;

    private static array $relationships = [
        'spouse',
        'parent',
        'child',
        'sibling',
        'grandparent',
        'grandchild',
        'aunt',
        'uncle',
        'cousin',
        'niece',
        'nephew',
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
            'related_memorial_id' => Memorial::factory(),
            'relationship' => fake()->randomElement(self::$relationships),
        ];
    }

    /**
     * Indicate that the relationship is a spouse.
     */
    public function spouse(): static
    {
        return $this->state(fn (array $attributes) => [
            'relationship' => 'spouse',
        ]);
    }

    /**
     * Indicate that the relationship is a parent.
     */
    public function parent(): static
    {
        return $this->state(fn (array $attributes) => [
            'relationship' => 'parent',
        ]);
    }

    /**
     * Indicate that the relationship is a child.
     */
    public function child(): static
    {
        return $this->state(fn (array $attributes) => [
            'relationship' => 'child',
        ]);
    }

    /**
     * Indicate that the relationship is a sibling.
     */
    public function sibling(): static
    {
        return $this->state(fn (array $attributes) => [
            'relationship' => 'sibling',
        ]);
    }

    /**
     * Indicate that the relationship is a grandparent.
     */
    public function grandparent(): static
    {
        return $this->state(fn (array $attributes) => [
            'relationship' => 'grandparent',
        ]);
    }
}
