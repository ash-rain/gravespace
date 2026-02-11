<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Photo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessPhotoUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Photo $photo,
    ) {}

    public function handle(): void
    {
        // Future: Generate thumbnails, optimize images, extract EXIF data
        // For now, this is a placeholder for the queue pipeline
        if (! Storage::disk('public')->exists($this->photo->file_path)) {
            $this->photo->delete();
        }
    }
}
