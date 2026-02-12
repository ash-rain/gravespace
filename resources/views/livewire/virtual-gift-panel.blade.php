<div>
    @if(session()->has('gift-success'))
        <div class="bg-success/10 border border-success/30 text-success px-4 py-3 rounded-lg text-sm mb-4">
            {{ session('gift-success') }}
        </div>
    @endif

    {{-- Skeleton loading state --}}
    <div wire:loading class="flex flex-wrap gap-3">
        @for($i = 0; $i < 5; $i++)
            <div class="h-10 w-24 bg-elevated animate-pulse rounded-xl"></div>
        @endfor
    </div>

    {{-- Gift counts display --}}
    <div wire:loading.remove class="flex flex-wrap gap-3 mb-6">
        @foreach($giftCounts as $type => $info)
            @if($info['count'] > 0)
                <div class="flex items-center gap-1.5 bg-surface border border-border rounded-full px-3 py-1.5 text-sm">
                    <span>{{ $info['emoji'] }}</span>
                    <span class="text-text-muted">{{ $info['count'] }}</span>
                </div>
            @endif
        @endforeach
    </div>

    {{-- Place a gift --}}
    @if(!$showForm)
        <button wire:click="$set('showForm', true)" class="bg-surface border border-border hover:border-accent/50 text-text-muted hover:text-text rounded-lg px-4 py-2 text-sm transition-colors">
            &#x1F56F; {{ __('Leave a virtual gift') }}
        </button>
    @else
        <div class="bg-surface border border-border rounded-xl p-5">
            <h4 class="font-semibold text-text text-sm mb-3">{{ __('Choose a gift') }}</h4>
            <form wire:submit="placeGift">
                <div class="flex gap-2 mb-4">
                    @foreach($giftCounts as $type => $info)
                        <button type="button" wire:click="$set('selectedType', '{{ $type }}')"
                            class="flex flex-col items-center gap-1 px-4 py-3 rounded-lg border transition-colors text-2xl
                            {{ $selectedType === $type ? 'border-accent bg-accent/10' : 'border-border hover:border-accent/50' }}">
                            <span>{{ $info['emoji'] }}</span>
                            <span class="text-xs text-text-muted">{{ __($info['label']) }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="mb-4">
                    <input type="text" wire:model="message" placeholder="{{ __('Add a message (optional)') }}" class="w-full bg-elevated border border-border text-text rounded-lg px-4 py-2 text-sm focus:border-accent focus:ring-accent">
                </div>

                <div class="flex items-center justify-between">
                    <button type="button" wire:click="$set('showForm', false)" class="text-sm text-text-muted hover:text-text">{{ __('Cancel') }}</button>
                    <button type="submit" class="bg-accent hover:bg-accent-hover text-primary font-semibold px-5 py-2 rounded-lg text-sm transition-colors">
                        {{ __('Place Gift') }}
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
