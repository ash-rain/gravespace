<div>
    {{-- Timeline display --}}
    <div class="relative">
        {{-- Vertical line --}}
        @if($events->count() > 0)
            <div class="absolute left-6 top-0 bottom-0 w-px bg-border"></div>
        @endif

        <div class="space-y-8">
            @forelse($events as $event)
                <div class="relative flex gap-6 pl-12">
                    {{-- Dot --}}
                    <div class="absolute left-4 top-2 w-5 h-5 rounded-full bg-accent border-4 border-primary"></div>

                    <div class="flex-1 bg-surface border border-border rounded-xl p-5 group">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-semibold text-text">{{ $event->title }}</h4>
                                @if($event->event_date)
                                    <p class="text-accent text-sm mt-1">{{ $event->event_date->format('F j, Y') }}</p>
                                @endif
                            </div>
                            @if($isOwner ?? false)
                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="editEvent({{ $event->id }})" class="text-text-muted hover:text-accent text-sm">{{ __('Edit') }}</button>
                                    <button wire:click="deleteEvent({{ $event->id }})" wire:confirm="{{ __('Delete this event?') }}" class="text-text-muted hover:text-danger text-sm">{{ __('Delete') }}</button>
                                </div>
                            @endif
                        </div>
                        @if($event->description)
                            <p class="text-text-muted mt-3 text-sm leading-relaxed">{{ $event->description }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-text-muted">{{ __('No timeline events yet.') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Add event form (for owners in dashboard) --}}
    @if($isOwner ?? false)
        <div class="mt-8">
            @if(!$showForm)
                <button wire:click="$set('showForm', true)" class="bg-surface border border-border hover:border-accent/50 text-text-muted hover:text-text rounded-lg px-4 py-2 text-sm transition-colors">
                    + {{ __('Add Timeline Event') }}
                </button>
            @else
                <div class="bg-surface border border-border rounded-xl p-5">
                    <h4 class="font-semibold text-text text-sm mb-4">{{ $editingId ? __('Edit Event') : __('Add Event') }}</h4>
                    <form wire:submit="{{ $editingId ? 'updateEvent' : 'addEvent' }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm text-text-muted mb-1">{{ __('Title') }} *</label>
                                <input type="text" wire:model="title" class="w-full bg-elevated border border-border text-text rounded-lg px-4 py-2 text-sm focus:border-accent focus:ring-accent">
                                @error('title') <span class="text-danger text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-text-muted mb-1">{{ __('Date') }}</label>
                                <input type="date" wire:model="eventDate" class="w-full bg-elevated border border-border text-text rounded-lg px-4 py-2 text-sm focus:border-accent focus:ring-accent">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm text-text-muted mb-1">{{ __('Description') }}</label>
                            <textarea wire:model="description" rows="3" class="w-full bg-elevated border border-border text-text rounded-lg px-4 py-3 text-sm focus:border-accent focus:ring-accent resize-none"></textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="button" wire:click="$set('showForm', false)" class="text-sm text-text-muted hover:text-text">{{ __('Cancel') }}</button>
                            <button type="submit" class="bg-accent hover:bg-accent-hover text-primary font-semibold px-5 py-2 rounded-lg text-sm transition-colors">
                                {{ $editingId ? __('Update Event') : __('Add Event') }}
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    @endif
</div>
