<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoiceMemory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'memorial_id',
        'user_id',
        'file_path',
        'title',
        'duration',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'duration' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    protected function title(): Attribute
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

    public function formattedDuration(): string
    {
        if ($this->duration === null) {
            return '0:00';
        }

        $minutes = intdiv($this->duration, 60);
        $seconds = $this->duration % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }
}
