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

class OptimizePhoto implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Photo $photo) {}

    public function handle(): void
    {
        $disk = Storage::disk('public');
        $path = $this->photo->file_path;

        if (!$disk->exists($path)) {
            return;
        }

        $fullPath = $disk->path($path);
        $info = getimagesize($fullPath);
        if (!$info) {
            return;
        }

        $mime = $info['mime'];
        $image = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($fullPath),
            'image/png' => imagecreatefrompng($fullPath),
            'image/gif' => imagecreatefromgif($fullPath),
            'image/webp' => imagecreatefromwebp($fullPath),
            default => null,
        };

        if (!$image) {
            return;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        // Generate thumbnail (400px max dimension)
        $thumbPath = $this->generateThumbnail($image, $width, $height, $path, $disk);
        if ($thumbPath) {
            $this->photo->update(['thumbnail_path' => $thumbPath]);
        }

        // Resize original if too large (max 2000px)
        if ($width > 2000 || $height > 2000) {
            $this->resizeImage($image, $width, $height, 2000, $fullPath, $mime);
        }

        imagedestroy($image);
    }

    private function generateThumbnail($image, int $width, int $height, string $originalPath, $disk): ?string
    {
        $maxDim = 400;
        $ratio = min($maxDim / $width, $maxDim / $height);

        if ($ratio >= 1) {
            // Image is already small enough, use original as thumbnail
            return null;
        }

        $newWidth = (int) round($width * $ratio);
        $newHeight = (int) round($height * $ratio);

        $thumb = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);

        imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $pathInfo = pathinfo($originalPath);
        $thumbPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
        $thumbFullPath = $disk->path($thumbPath);

        // Ensure directory exists
        $dir = dirname($thumbFullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $ext = strtolower($pathInfo['extension'] ?? 'jpg');
        match ($ext) {
            'png' => imagepng($thumb, $thumbFullPath, 8),
            'gif' => imagegif($thumb, $thumbFullPath),
            'webp' => imagewebp($thumb, $thumbFullPath, 80),
            default => imagejpeg($thumb, $thumbFullPath, 80),
        };

        imagedestroy($thumb);

        return $thumbPath;
    }

    private function resizeImage($image, int $width, int $height, int $maxDim, string $fullPath, string $mime): void
    {
        $ratio = min($maxDim / $width, $maxDim / $height);
        $newWidth = (int) round($width * $ratio);
        $newHeight = (int) round($height * $ratio);

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        match ($mime) {
            'image/png' => imagepng($resized, $fullPath, 8),
            'image/gif' => imagegif($resized, $fullPath),
            'image/webp' => imagewebp($resized, $fullPath, 85),
            default => imagejpeg($resized, $fullPath, 85),
        };

        imagedestroy($resized);
    }
}
