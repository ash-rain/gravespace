<div>
    {{-- Photo grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
        @forelse($photos as $photo)
            <div class="group relative aspect-square rounded-lg overflow-hidden cursor-pointer" wire:click="openLightbox({{ $photo->id }})">
                <img src="{{ Storage::url($photo->file_path) }}" alt="{{ $photo->caption ?? '' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                @if($photo->caption)
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <p class="text-white text-xs truncate">{{ $photo->caption }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-text-muted">{{ __('No photos have been added yet.') }}</p>
            </div>
        @endforelse
    </div>

    {{-- Lightbox modal --}}
    @if($currentPhoto)
        <div class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center" wire:click.self="closeLightbox">
            <button wire:click="closeLightbox" class="absolute top-4 right-4 text-white/60 hover:text-white text-2xl z-10">&times;</button>

            <button wire:click="previousPhoto" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/60 hover:text-white p-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <div class="max-w-5xl max-h-[85vh] mx-16">
                <img src="{{ Storage::url($currentPhoto->file_path) }}" alt="{{ $currentPhoto->caption ?? '' }}" class="max-w-full max-h-[85vh] object-contain rounded-lg">
                @if($currentPhoto->caption)
                    <p class="text-white/80 text-center text-sm mt-4">{{ $currentPhoto->caption }}</p>
                @endif
            </div>

            <button wire:click="nextPhoto" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/60 hover:text-white p-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    @endif
</div>
