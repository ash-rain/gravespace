<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemorialVisit extends Model
{
    protected $fillable = [
        'memorial_id',
        'ip_address',
        'user_agent',
        'referrer',
    ];

    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }
}
