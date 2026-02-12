<?php

declare(strict_types=1);

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Billable, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'lifetime_premium_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    public function memorials(): HasMany
    {
        return $this->hasMany(Memorial::class);
    }

    public function tributes(): HasMany
    {
        return $this->hasMany(Tribute::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function hasLifetimePremium(): bool
    {
        return $this->lifetime_premium_at !== null;
    }

    public function isPremium(): bool
    {
        return $this->hasLifetimePremium() || $this->subscribed('default');
    }

    public function canCreateMemorial(): bool
    {
        if ($this->isPremium()) {
            return true;
        }

        return $this->memorials()->count() < 1;
    }

    public function maxPhotosPerMemorial(): int
    {
        return $this->isPremium() ? PHP_INT_MAX : 5;
    }
}
