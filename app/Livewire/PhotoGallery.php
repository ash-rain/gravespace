<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Memorial;
use App\Models\Photo;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class PhotoGallery extends Component
{
    use WithFileUploads;

    public Memorial $memorial;
    public bool $isOwner = false;
    public ?int $lightboxPhoto = null;
    public array $newPhotos = [];

    public function mount(Memorial $memorial): void
    {
        $this->memorial = $memorial;
        $this->isOwner = auth()->id() === $memorial->user_id;
    }

    public function openLightbox(int $photoId): void
    {
        $this->lightboxPhoto = $photoId;
    }

    public function closeLightbox(): void
    {
        $this->lightboxPhoto = null;
    }

    public function nextPhoto(): void
    {
        $photos = $this->memorial->photos;
        $currentIndex = $photos->search(fn ($p) => $p->id === $this->lightboxPhoto);
        $nextIndex = ($currentIndex + 1) % $photos->count();
        $this->lightboxPhoto = $photos[$nextIndex]->id;
    }

    public function previousPhoto(): void
    {
        $photos = $this->memorial->photos;
        $currentIndex = $photos->search(fn ($p) => $p->id === $this->lightboxPhoto);
        $prevIndex = ($currentIndex - 1 + $photos->count()) % $photos->count();
        $this->lightboxPhoto = $photos[$prevIndex]->id;
    }

    public function deletePhoto(int $photoId): void
    {
        if (! $this->isOwner) {
            return;
        }

        Photo::where('id', $photoId)->where('memorial_id', $this->memorial->id)->delete();
        $this->memorial->refresh();
    }

    public function render(): View
    {
        $photos = $this->memorial->photos;
        $currentPhoto = $this->lightboxPhoto ? $photos->firstWhere('id', $this->lightboxPhoto) : null;

        return view('livewire.photo-gallery', [
            'photos' => $photos,
            'currentPhoto' => $currentPhoto,
        ]);
    }
}
