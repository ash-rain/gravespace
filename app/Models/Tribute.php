<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'memorial_id',
        'author_name',
        'author_email',
        'user_id',
        'body',
        'photo_path',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    protected function body(): Attribute
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

    public function authorDisplayName(): string
    {
        return $this->user?->name ?? $this->author_name ?? 'Anonymous';
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }
}
