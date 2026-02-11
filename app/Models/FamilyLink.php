<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'memorial_id',
        'related_memorial_id',
        'relationship',
    ];

    public function memorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class);
    }

    public function relatedMemorial(): BelongsTo
    {
        return $this->belongsTo(Memorial::class, 'related_memorial_id');
    }

    public function relationshipLabel(): string
    {
        return ucfirst($this->relationship);
    }
}
