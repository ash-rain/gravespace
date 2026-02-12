<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Memorial;
use App\Models\QrCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QrCode>
 */
class QrCodeFactory extends Factory
{
    protected $model = QrCode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'memorial_id' => Memorial::factory(),
            'code' => Str::upper(Str::random(8)),
            'generated_at' => now(),
            'downloaded_at' => null,
        ];
    }

    /**
     * Indicate that the QR code has been downloaded.
     */
    public function downloaded(): static
    {
        return $this->state(fn (array $attributes) => [
            'downloaded_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the QR code has not been downloaded.
     */
    public function notDownloaded(): static
    {
        return $this->state(fn (array $attributes) => [
            'downloaded_at' => null,
        ]);
    }

    /**
     * Indicate that the QR code was generated recently.
     */
    public function recentlyGenerated(): static
    {
        return $this->state(fn (array $attributes) => [
            'generated_at' => fake()->dateTimeBetween('-1 day', 'now'),
        ]);
    }
}
