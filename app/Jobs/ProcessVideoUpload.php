<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Video;
use getID3;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessVideoUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Video $video,
    ) {}

    public function handle(): void
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($this->video->file_path)) {
            Log::warning("ProcessVideoUpload: file not found at {$this->video->file_path}");

            return;
        }

        $fullPath = $disk->path($this->video->file_path);

        $this->extractDuration($fullPath);
        $this->generatePlaceholderThumbnail();
    }

    private function extractDuration(string $fullPath): void
    {
        $getID3 = new getID3;
        $fileInfo = $getID3->analyze($fullPath);

        if (isset($fileInfo['playtime_seconds'])) {
            $this->video->update([
                'duration' => (int) round($fileInfo['playtime_seconds']),
            ]);
        }
    }

    private function generatePlaceholderThumbnail(): void
    {
        if ($this->video->thumbnail_path) {
            return;
        }

        $width = 320;
        $height = 180;
        $image = imagecreatetruecolor($width, $height);

        if ($image === false) {
            return;
        }

        $bgColor = imagecolorallocate($image, 18, 18, 30);
        $accentColor = imagecolorallocate($image, 201, 168, 76);

        if ($bgColor === false || $accentColor === false) {
            imagedestroy($image);

            return;
        }

        imagefill($image, 0, 0, $bgColor);

        // Draw a play triangle
        $centerX = (int) ($width / 2);
        $centerY = (int) ($height / 2);
        $points = [
            $centerX - 15, $centerY - 20,
            $centerX - 15, $centerY + 20,
            $centerX + 20, $centerY,
        ];
        imagefilledpolygon($image, $points, $accentColor);

        $thumbnailPath = 'videos/thumbnails/'.pathinfo($this->video->file_path, PATHINFO_FILENAME).'.jpg';
        $fullThumbnailPath = Storage::disk('public')->path($thumbnailPath);

        $dir = dirname($fullThumbnailPath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        imagejpeg($image, $fullThumbnailPath, 85);
        imagedestroy($image);

        $this->video->update(['thumbnail_path' => $thumbnailPath]);
    }
}
