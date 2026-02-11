<x-layouts.memorial>
    <x-slot:title>{{ __('Gallery') }} — {{ $memorial->fullName() }}</x-slot:title>
    <x-slot:description>{{ __('Photo gallery for :name', ['name' => $memorial->fullName()]) }}</x-slot:description>
    @if($memorial->cover_photo)
        <x-slot:ogImage>{{ Storage::url($memorial->cover_photo) }}</x-slot:ogImage>
    @endif

    {{-- Gallery Header --}}
    <section class="py-10 sm:py-14 border-b border-border">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('memorial.show', $memorial) }}" class="text-text-muted hover:text-text transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('memorial.show', $memorial) }}" class="text-sm text-text-muted hover:text-text transition-colors">
                    {{ $memorial->fullName() }}
                </a>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-text">
                {{ __('Photo Gallery') }}
            </h1>
            <p class="mt-2 text-text-muted">
                {{ __(':count photos', ['count' => $memorial->photos->count()]) }}
            </p>
        </div>
    </section>

    {{-- Photo Grid with Lightbox --}}
    <section class="py-10 sm:py-14" x-data="{ lightbox: false, currentPhoto: null, currentIndex: 0 }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($memorial->photos->count() > 0)
                {{-- Masonry-Style Grid --}}
                <div class="columns-1 sm:columns-2 lg:columns-3 gap-4 space-y-4">
                    @foreach($memorial->photos as $index => $photo)
                        <div
                            class="break-inside-avoid group cursor-pointer"
                            @click="lightbox = true; currentPhoto = '{{ Storage::url($photo->file_path) }}'; currentIndex = {{ $index }}"
                        >
                            <div class="relative bg-elevated rounded-xl overflow-hidden border border-border hover:border-accent/30 transition-all duration-300">
                                <img
                                    src="{{ Storage::url($photo->thumbnail_path ?? $photo->file_path) }}"
                                    alt="{{ $photo->caption ?? __('Photo of :name', ['name' => $memorial->fullName()]) }}"
                                    class="w-full h-auto object-cover group-hover:scale-[1.02] transition-transform duration-500"
                                    loading="lazy"
                                >
                                @if($photo->caption || $photo->date_taken)
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-primary/90 via-primary/50 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        @if($photo->caption)
                                            <p class="text-sm text-text">{{ $photo->caption }}</p>
                                        @endif
                                        @if($photo->date_taken)
                                            <p class="text-xs text-text-muted mt-1">{{ $photo->date_taken->format('M j, Y') }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Lightbox Modal --}}
                <div
                    x-show="lightbox"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @keydown.escape.window="lightbox = false"
                    class="fixed inset-0 z-50 flex items-center justify-center"
                    x-cloak
                >
                    {{-- Backdrop --}}
                    <div class="absolute inset-0 bg-primary/95 backdrop-blur-sm" @click="lightbox = false"></div>

                    {{-- Close Button --}}
                    <button @click="lightbox = false" class="absolute top-4 right-4 z-10 text-text-muted hover:text-text p-2 rounded-lg bg-surface/50 backdrop-blur-sm border border-border transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    {{-- Navigation Arrows --}}
                    @if($memorial->photos->count() > 1)
                        <button
                            @click="currentIndex = (currentIndex - 1 + {{ $memorial->photos->count() }}) % {{ $memorial->photos->count() }}; currentPhoto = [{{ $memorial->photos->map(fn($p) => "'" . Storage::url($p->file_path) . "'")->join(',') }}][currentIndex]"
                            class="absolute left-4 z-10 text-text-muted hover:text-text p-2 rounded-lg bg-surface/50 backdrop-blur-sm border border-border transition-colors"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button
                            @click="currentIndex = (currentIndex + 1) % {{ $memorial->photos->count() }}; currentPhoto = [{{ $memorial->photos->map(fn($p) => "'" . Storage::url($p->file_path) . "'")->join(',') }}][currentIndex]"
                            class="absolute right-4 z-10 text-text-muted hover:text-text p-2 rounded-lg bg-surface/50 backdrop-blur-sm border border-border transition-colors"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    @endif

                    {{-- Image --}}
                    <div class="relative z-0 max-w-5xl max-h-[85vh] mx-4">
                        <img :src="currentPhoto" alt="" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl">
                    </div>
                </div>
            @else
                <div class="text-center py-20">
                    <span class="text-5xl block mb-4">&#x1F4F7;</span>
                    <h3 class="font-serif text-xl font-semibold text-text mb-2">{{ __('No photos yet') }}</h3>
                    <p class="text-text-muted">{{ __('Photos will appear here once they are added to the memorial.') }}</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.memorial>
