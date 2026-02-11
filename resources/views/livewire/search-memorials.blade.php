<div>
    {{-- Search input --}}
    <div class="mb-8">
        <div class="relative max-w-xl mx-auto">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ __('Search memorials...') }}" class="w-full bg-surface border border-border text-text rounded-xl pl-12 pr-4 py-3 text-sm focus:border-accent focus:ring-accent placeholder-text-muted">
        </div>
    </div>

    {{-- Memorial cards grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($memorials as $memorial)
            <a href="{{ route('memorial.show', $memorial->slug) }}" class="group block bg-surface border border-border rounded-xl overflow-hidden hover:border-accent/30 transition-colors">
                {{-- Cover image --}}
                <div class="aspect-[16/9] bg-elevated relative overflow-hidden">
                    @if($memorial->cover_photo)
                        <img src="{{ Storage::url($memorial->cover_photo) }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-4xl text-text-muted/30">&#x1F56F;</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    {{-- Profile photo --}}
                    @if($memorial->profile_photo)
                        <div class="absolute bottom-3 left-4">
                            <img src="{{ Storage::url($memorial->profile_photo) }}" alt="" class="w-12 h-12 rounded-full border-2 border-accent/50 object-cover">
                        </div>
                    @endif
                </div>

                <div class="p-4">
                    <h3 class="font-serif text-lg font-semibold text-text group-hover:text-accent transition-colors">{{ $memorial->fullName() }}</h3>
                    <p class="text-text-muted text-sm mt-1">{{ $memorial->lifeDates() }}</p>

                    <div class="flex items-center gap-4 mt-3 text-xs text-text-muted">
                        @if($memorial->virtual_gifts_count > 0)
                            <span>&#x1F56F; {{ $memorial->virtual_gifts_count }}</span>
                        @endif
                        @if($memorial->approved_tributes_count > 0)
                            <span>&#x1F4AC; {{ $memorial->approved_tributes_count }}</span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-16">
                <span class="text-5xl">&#x1F56F;</span>
                <p class="text-text-muted mt-4">{{ __('No memorials found.') }}</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $memorials->links() }}
    </div>
</div>
