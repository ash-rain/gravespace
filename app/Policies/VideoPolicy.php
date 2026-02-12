<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Memorial;
use App\Models\User;
use App\Models\Video;

class VideoPolicy
{
    public function create(User $user, Memorial $memorial): bool
    {
        if ($user->id === $memorial->user_id) {
            return true;
        }

        return $memorial->managers()->where('user_id', $user->id)->whereIn('role', ['owner', 'editor'])->exists();
    }

    public function delete(User $user, Video $video): bool
    {
        $memorial = $video->memorial;

        return $user->id === $memorial->user_id
            || $user->id === $video->uploaded_by
            || $memorial->managers()->where('user_id', $user->id)->whereIn('role', ['owner', 'editor'])->exists();
    }
}
