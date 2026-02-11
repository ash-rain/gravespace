<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function storePhoto(UploadedFile $file, int $memorialId): string
    {
        return $file->store("memorials/{$memorialId}/photos", 'public');
    }

    public function storeVideo(UploadedFile $file, int $memorialId): string
    {
        return $file->store("memorials/{$memorialId}/videos", 'public');
    }

    public function storeCoverPhoto(UploadedFile $file): string
    {
        return $file->store('memorials/covers', 'public');
    }

    public function storeProfilePhoto(UploadedFile $file): string
    {
        return $file->store('memorials/profiles', 'public');
    }

    public function deleteFile(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
