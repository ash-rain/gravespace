<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Memorial;
use App\Models\User;
use Illuminate\Support\Str;

class MemorialService
{
    public function generateUniqueSlug(string $firstName, string $lastName): string
    {
        $base = Str::slug($firstName . ' ' . $lastName);
        $slug = $base;
        $counter = 1;

        while (Memorial::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function canUserUploadPhoto(User $user, Memorial $memorial): bool
    {
        $currentCount = $memorial->photos()->count();
        return $currentCount < $user->maxPhotosPerMemorial();
    }

    public function getMemorialStats(Memorial $memorial): array
    {
        return [
            'photos' => $memorial->photos()->count(),
            'videos' => $memorial->videos()->count(),
            'tributes' => $memorial->approvedTributes()->count(),
            'pending_tributes' => $memorial->tributes()->pending()->count(),
            'candles' => $memorial->virtualGifts()->where('type', 'candle')->count(),
            'gifts' => $memorial->virtualGifts()->count(),
        ];
    }
}
