<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Memorial;
use App\Models\User;

class MemorialPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(?User $user, Memorial $memorial): bool
    {
        if ($memorial->isPublic()) {
            return true;
        }

        if (! $user) {
            return false;
        }

        return $user->id === $memorial->user_id
            || $memorial->managers->contains($user);
    }

    public function create(User $user): bool
    {
        return $user->canCreateMemorial();
    }

    public function update(User $user, Memorial $memorial): bool
    {
        if ($user->id === $memorial->user_id) {
            return true;
        }

        $manager = $memorial->managers->find($user);
        return $manager && in_array($manager->pivot->role, ['owner', 'editor']);
    }

    public function delete(User $user, Memorial $memorial): bool
    {
        return $user->id === $memorial->user_id;
    }
}
