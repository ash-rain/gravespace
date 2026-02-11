<div>
    {{-- Success flash --}}
    @if(session()->has('tribute-success'))
        <div class="bg-success/10 border border-success/30 text-success px-4 py-3 rounded-lg text-sm mb-6">
            {{ session('tribute-success') }}
        </div>
    @endif

    {{-- Tributes list --}}
    <div class="space-y-4 mb-8">
        @forelse($tributes as $tribute)
            <div class="bg-surface border border-border rounded-xl p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="font-semibold text-text">{{ $tribute->authorDisplayName() }}</span>
                        <span class="text-text-muted text-sm ml-2">{{ $tribute->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <p class="text-text-muted mt-3 leading-relaxed">{{ $tribute->body }}</p>
                @if($tribute->photo_path)
                    <img src="{{ Storage::url($tribute->photo_path) }}" alt="" class="mt-4 rounded-lg max-h-48 object-cover">
                @endif
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-text-muted">{{ __('No tributes yet. Be the first to share a memory.') }}</p>
            </div>
        @endforelse
    </div>

    {{ $tributes->links() }}

    {{-- Submit tribute form --}}
    <div class="mt-8">
        @if(!$showForm)
            <button wire:click="$set('showForm', true)" class="w-full bg-surface border border-border hover:border-accent/50 text-text-muted hover:text-text rounded-xl px-6 py-4 text-sm transition-colors">
                {{ __('Leave a tribute...') }}
            </button>
        @else
            <div class="bg-surface border border-border rounded-xl p-6">
                <h4 class="font-serif text-lg font-semibold text-text mb-4">{{ __('Share a Memory') }}</h4>
                <form wire:submit="submitTribute">
                    @guest
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm text-text-muted mb-1">{{ __('Your Name') }} *</label>
                                <input type="text" wire:model="authorName" class="w-full bg-elevated border border-border text-text rounded-lg px-4 py-2 text-sm focus:border-accent focus:ring-accent">
                                @error('authorName') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-text-muted mb-1">{{ __('Email (optional)') }}</label>
                                <input type="email" wire:model="authorEmail" class="w-full bg-elevated border border-border text-text rounded-lg px-4 py-2 text-sm focus:border-accent focus:ring-accent">
                                @error('authorEmail') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endguest

                    <div class="mb-4">
                        <label class="block text-sm text-text-muted mb-1">{{ __('Your tribute') }} *</label>
                        <textarea wire:model="body" rows="4" class="w-full bg-elevated border border-border text-text rounded-lg px-4 py-3 text-sm focus:border-accent focus:ring-accent resize-none" placeholder="{{ __('Share a memory, story, or message...') }}"></textarea>
                        @error('body') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="button" wire:click="$set('showForm', false)" class="text-sm text-text-muted hover:text-text">{{ __('Cancel') }}</button>
                        <button type="submit" class="bg-accent hover:bg-accent-hover text-primary font-semibold px-6 py-2 rounded-lg text-sm transition-colors">
                            {{ __('Submit Tribute') }}
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
