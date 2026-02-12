<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Memorial;
use App\Models\User;
use App\Models\VirtualGift;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VirtualGift>
 */
class VirtualGiftFactory extends Factory
{
    protected $model = VirtualGift::class;

    private static array $giftMessages = [
        'candle' => [
            'Lighting a candle in your memory.',
            'May this candle shine as brightly as your spirit.',
            'A light to guide you on your journey.',
            'Forever in our hearts.',
        ],
        'flower' => [
            'A rose to remember you by.',
            'Flowers for a beautiful soul.',
            'In loving memory, with flowers from the heart.',
        ],
        'tree' => [
            'Planting a tree in your honor.',
            'May your memory grow as strong as this tree.',
            'Rooted in love, reaching toward heaven.',
        ],
        'wreath' => [
            'A wreath of remembrance for you.',
            'With love and deepest respect.',
            'Honoring your life with this wreath.',
        ],
        'star' => [
            'A star to light the sky in your name.',
            'You are our brightest star.',
            'Shining forever in our memories.',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['candle', 'flower', 'tree', 'wreath', 'star']);

        return [
            'memorial_id' => Memorial::factory(),
            'user_id' => User::factory(),
            'type' => $type,
            'message' => fake()->optional(0.8)->randomElement(self::$giftMessages[$type]),
        ];
    }

    /**
     * Indicate that the gift is a candle.
     */
    public function candle(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'candle',
            'message' => fake()->randomElement(self::$giftMessages['candle']),
        ]);
    }

    /**
     * Indicate that the gift is a flower.
     */
    public function flower(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'flower',
            'message' => fake()->randomElement(self::$giftMessages['flower']),
        ]);
    }

    /**
     * Indicate that the gift is a tree.
     */
    public function tree(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'tree',
            'message' => fake()->randomElement(self::$giftMessages['tree']),
        ]);
    }

    /**
     * Indicate that the gift is a wreath.
     */
    public function wreath(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'wreath',
            'message' => fake()->randomElement(self::$giftMessages['wreath']),
        ]);
    }

    /**
     * Indicate that the gift is a star.
     */
    public function star(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'star',
            'message' => fake()->randomElement(self::$giftMessages['star']),
        ]);
    }

    /**
     * Indicate that the gift has no message.
     */
    public function withoutMessage(): static
    {
        return $this->state(fn (array $attributes) => [
            'message' => null,
        ]);
    }
}
