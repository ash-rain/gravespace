<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Memorial extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    public const THEME_CLASSIC = 'classic';
    public const THEME_GARDEN = 'garden';
    public const THEME_CELESTIAL = 'celestial';
    public const THEME_OCEAN = 'ocean';
    public const THEME_SUNSET = 'sunset';

    public const THEMES = [
        self::THEME_CLASSIC,
        self::THEME_GARDEN,
        self::THEME_CELESTIAL,
        self::THEME_OCEAN,
        self::THEME_SUNSET,
    ];

    protected $fillable = [
        'user_id',
        'slug',
        'first_name',
        'last_name',
        'maiden_name',
        'date_of_birth',
        'date_of_death',
        'place_of_birth',
        'place_of_death',
        'obituary',
        'cover_photo',
        'profile_photo',
        'privacy',
        'password_hash',
        'latitude',
        'longitude',
        'cemetery_name',
        'cemetery_address',
        'is_published',
        'theme',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'date_of_death' => 'date',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_published' => 'boolean',
        ];
    }

    protected function obituary(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value !== null ? strip_tags($value) : null,
        );
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(\App\Models\Invitation::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'memorial_managers')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->orderBy('sort_order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class)->orderBy('sort_order');
    }

    public function timelineEvents(): HasMany
    {
        return $this->hasMany(TimelineEvent::class)->orderBy('event_date');
    }

    public function tributes(): HasMany
    {
        return $this->hasMany(Tribute::class)->latest();
    }

    public function approvedTributes(): HasMany
    {
        return $this->hasMany(Tribute::class)->where('is_approved', true)->latest();
    }

    public function virtualGifts(): HasMany
    {
        return $this->hasMany(VirtualGift::class)->latest();
    }

    public function familyLinks(): HasMany
    {
        return $this->hasMany(FamilyLink::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(MemorialVisit::class);
    }

    public function qrCode(): HasOne
    {
        return $this->hasOne(QrCode::class);
    }

    public function voiceMemories(): HasMany
    {
        return $this->hasMany(VoiceMemory::class)->orderBy('sort_order');
    }

    public static function availableThemes(): array
    {
        return [
            self::THEME_CLASSIC => ['name' => 'Classic', 'icon' => '🕯️', 'description' => 'Elegant dark theme with gold accents'],
            self::THEME_GARDEN => ['name' => 'Garden', 'icon' => '🌿', 'description' => 'Soft greens and natural tones'],
            self::THEME_CELESTIAL => ['name' => 'Celestial', 'icon' => '✨', 'description' => 'Deep blues with starlit accents'],
            self::THEME_OCEAN => ['name' => 'Ocean', 'icon' => '🌊', 'description' => 'Calm ocean blues and teals'],
            self::THEME_SUNSET => ['name' => 'Sunset', 'icon' => '🌅', 'description' => 'Warm amber and rose tones'],
        ];
    }

    public function themeClasses(): string
    {
        return match ($this->theme) {
            self::THEME_GARDEN => 'memorial-theme-garden',
            self::THEME_CELESTIAL => 'memorial-theme-celestial',
            self::THEME_OCEAN => 'memorial-theme-ocean',
            self::THEME_SUNSET => 'memorial-theme-sunset',
            default => 'memorial-theme-classic',
        };
    }

    public function fullName(): string
    {
        $name = $this->first_name.' '.$this->last_name;
        if ($this->maiden_name) {
            $name .= ' (née '.$this->maiden_name.')';
        }

        return $name;
    }

    public function lifeDates(): string
    {
        $birth = $this->date_of_birth?->format('M j, Y') ?? '?';
        $death = $this->date_of_death?->format('M j, Y') ?? '?';

        return $birth.' — '.$death;
    }

    public function isPublic(): bool
    {
        return $this->privacy === 'public' && $this->is_published;
    }

    public function candleCount(): int
    {
        return $this->virtualGifts()->where('type', 'candle')->count();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePubliclyVisible($query)
    {
        return $query->published()->where('privacy', 'public');
    }

    public function toSearchableArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'maiden_name' => $this->maiden_name,
            'obituary' => $this->obituary,
            'cemetery_name' => $this->cemetery_name,
            'place_of_birth' => $this->place_of_birth,
            'place_of_death' => $this->place_of_death,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->is_published && $this->privacy === 'public';
    }
}
