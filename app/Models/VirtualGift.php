<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VirtualGift extends Model
{
    use HasFactory;

    protected $fillable = [
        'memorial_id',
        'user_id',
        'type',
        'message',
    ];

    protected function message(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value !== null ? strip_tags($value) : null,
        );
    }

    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function emoji(): string
    {
        return match ($this->type) {
            'candle' => "\u{1F56F}",
            'flower' => "\u{1F339}",
            'tree' => "\u{1F333}",
            'wreath' => "\u{1FAB7}",
            'star' => "\u{2B50}",
            default => "\u{1F56F}",
        };
    }
}
