<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimelineEvent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'memorial_id',
        'title',
        'description',
        'event_date',
        'photo_id',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'sort_order' => 'integer',
        ];
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value !== null ? strip_tags($value) : null,
        );
    }

    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class);
    }
}
