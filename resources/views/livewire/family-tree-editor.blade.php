<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-serif text-lg font-semibold text-text">{{ __('Family Connections') }}</h3>
        @if (! $showForm)
            <button wire:click="$set('showForm', true)"
                class="inline-flex items-center gap-2 px-4 py-2 bg-elevated border border-border text-text-muted text-sm font-medium rounded-xl hover:text-accent hover:border-accent/30 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Add Connection') }}
            </button>
        @endif
    </div>

    {{-- Existing Links --}}
    @if ($links->isNotEmpty())
        <div class="space-y-3 mb-6">
            @foreach ($links as $link)
                <div wire:key="family-link-{{ $link->id }}" class="flex items-center justify-between bg-elevated border border-border rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-surface rounded-full overflow-hidden shrink-0 flex items-center justify-center">
                            @if ($link->relatedMemorial?->profile_photo)
                                <img src="{{ Storage::url($link->relatedMemorial->profile_photo) }}"
                                    alt="{{ $link->relatedMemorial->fullName() }}"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="text-text-muted/40">&#x1F56F;</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-text text-sm font-medium">{{ $link->relatedMemorial?->fullName() }}</p>
                            <p class="text-text-muted text-xs mt-0.5">{{ $link->relationshipLabel() }}</p>
                        </div>
                    </div>
                    <button wire:click="removeLink({{ $link->id }})"
                        wire:confirm="{{ __('Remove this family connection?') }}"
                        class="p-2 text-red-400 hover:bg-red-500/10 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-text-muted text-sm mb-6">{{ __('No family connections yet. Link related memorials together.') }}</p>
    @endif

    {{-- Add Connection Form --}}
    @if ($showForm)
        <div class="bg-elevated border border-border rounded-xl p-5">
            <form wire:submit="addLink">
                {{-- Search Memorial --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-text-muted mb-2">{{ __('Search Your Memorials') }}</label>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        class="w-full px-4 py-3 bg-surface border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                        placeholder="{{ __('Type a name to search...') }}">

                    @if ($availableMemorials->isNotEmpty())
                        <div class="mt-2 bg-surface border border-border rounded-xl max-h-48 overflow-y-auto">
                            @foreach ($availableMemorials as $availableMemorial)
                                <button type="button" wire:key="available-{{ $availableMemorial->id }}"
                                    wire:click="$set('selectedMemorialId', {{ $availableMemorial->id }})"
                                    class="w-full text-left px-4 py-3 text-sm hover:bg-elevated transition-colors flex items-center gap-3 {{ $selectedMemorialId === $availableMemorial->id ? 'bg-accent/10 text-accent' : 'text-text' }}">
                                    <span>{{ $availableMemorial->fullName() }}</span>
                                    <span class="text-text-muted text-xs">{{ $availableMemorial->lifeDates() }}</span>
                                </button>
                            @endforeach
                        </div>
                    @elseif (strlen($search) >= 2)
                        <p class="mt-2 text-text-muted text-xs">{{ __('No matching memorials found.') }}</p>
                    @endif

                    @error('selectedMemorialId')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Relationship Type --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-text-muted mb-2">{{ __('Relationship') }}</label>
                    <select wire:model="relationship"
                        class="w-full px-4 py-3 bg-surface border border-border rounded-xl text-text focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors [color-scheme:dark]">
                        <option value="spouse">{{ __('Spouse') }}</option>
                        <option value="parent">{{ __('Parent') }}</option>
                        <option value="child">{{ __('Child') }}</option>
                        <option value="sibling">{{ __('Sibling') }}</option>
                        <option value="grandparent">{{ __('Grandparent') }}</option>
                        <option value="grandchild">{{ __('Grandchild') }}</option>
                        <option value="aunt">{{ __('Aunt') }}</option>
                        <option value="uncle">{{ __('Uncle') }}</option>
                        <option value="cousin">{{ __('Cousin') }}</option>
                        <option value="niece">{{ __('Niece') }}</option>
                        <option value="nephew">{{ __('Nephew') }}</option>
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="px-6 py-2.5 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                        {{ __('Add Connection') }}
                    </button>
                    <button type="button" wire:click="$set('showForm', false)"
                        class="px-6 py-2.5 bg-elevated border border-border text-text-muted font-medium text-sm rounded-xl hover:text-text transition-colors">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
