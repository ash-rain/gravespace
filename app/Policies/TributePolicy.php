<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Memorial;
use App\Models\Tribute;
use App\Models\User;

class TributePolicy
{
    public function create(?User $user): bool
    {
        return true;
    }

    public function approve(User $user, Tribute $tribute): bool
    {
        $memorial = $tribute->memorial;
        return $user->id === $memorial->user_id
            || $memorial->managers()->where('user_id', $user->id)->whereIn('role', ['owner', 'editor'])->exists();
    }

    public function delete(User $user, Tribute $tribute): bool
    {
        $memorial = $tribute->memorial;
        return $user->id === $memorial->user_id
            || $user->id === $tribute->user_id
            || $memorial->managers()->where('user_id', $user->id)->whereIn('role', ['owner', 'editor'])->exists();
    }
}
