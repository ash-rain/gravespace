<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Memorial;
use App\Models\Photo;
use App\Models\User;

class PhotoPolicy
{
    public function create(User $user, Memorial $memorial): bool
    {
        if ($user->id === $memorial->user_id) {
            return true;
        }

        return $memorial->managers()->where('user_id', $user->id)->whereIn('role', ['owner', 'editor'])->exists();
    }

    public function delete(User $user, Photo $photo): bool
    {
        $memorial = $photo->memorial;
        return $user->id === $memorial->user_id
            || $user->id === $photo->uploaded_by
            || $memorial->managers()->where('user_id', $user->id)->whereIn('role', ['owner', 'editor'])->exists();
    }
}
