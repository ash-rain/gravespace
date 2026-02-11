<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'memorial_id',
        'code',
        'generated_at',
        'downloaded_at',
    ];

    protected function casts(): array
    {
        return [
            'generated_at' => 'datetime',
            'downloaded_at' => 'datetime',
        ];
    }

    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }

    public static function generateCode(): string
    {
        do {
            $code = Str::upper(Str::random(8));
        } while (static::where('code', $code)->exists());

        return $code;
    }

    public function url(): string
    {
        return url('/qr/' . $this->code);
    }
}
