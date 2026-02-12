<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-serif text-lg font-semibold text-text">{{ __('Reminders') }}</h3>
        @if (! $showForm)
            <button wire:click="$set('showForm', true)"
                class="inline-flex items-center gap-2 px-4 py-2 bg-elevated border border-border text-text-muted text-sm font-medium rounded-xl hover:text-accent hover:border-accent/30 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Add Reminder') }}
            </button>
        @endif
    </div>

    {{-- Reminder List --}}
    @if ($reminders->isNotEmpty())
        <div class="space-y-3 mb-6">
            @foreach ($reminders as $reminder)
                <div wire:key="reminder-{{ $reminder->id }}" class="flex items-center justify-between bg-elevated border border-border rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <button wire:click="toggleReminder({{ $reminder->id }})"
                            class="w-10 h-6 rounded-full transition-colors relative {{ $reminder->is_active ? 'bg-accent/20 border-accent' : 'bg-surface border-border' }} border"
                            title="{{ $reminder->is_active ? __('Disable') : __('Enable') }}">
                            <span class="absolute top-0.5 transition-transform w-5 h-5 rounded-full {{ $reminder->is_active ? 'translate-x-4 bg-accent' : 'translate-x-0.5 bg-text-muted' }}"></span>
                        </button>
                        <div>
                            <p class="text-text text-sm font-medium">
                                @if ($reminder->type === 'birthday')
                                    {{ __('Birthday Reminder') }}
                                @elseif ($reminder->type === 'death_anniversary')
                                    {{ __('Death Anniversary Reminder') }}
                                @else
                                    {{ __('Custom Reminder') }}
                                @endif
                            </p>
                            <p class="text-text-muted text-xs mt-0.5">
                                {{ __('Next') }}: {{ $reminder->notify_at->format('M j, Y') }}
                                @if (! $reminder->is_active)
                                    <span class="text-yellow-400">({{ __('Paused') }})</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <button wire:click="deleteReminder({{ $reminder->id }})"
                        wire:confirm="{{ __('Delete this reminder?') }}"
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
        <p class="text-text-muted text-sm mb-6">{{ __('No reminders set. Add one to get notified on important dates.') }}</p>
    @endif

    {{-- Add Reminder Form --}}
    @if ($showForm)
        <div class="bg-elevated border border-border rounded-xl p-5">
            <form wire:submit="addReminder">
                <div class="mb-4">
                    <label for="reminder_type" class="block text-sm font-medium text-text-muted mb-2">{{ __('Reminder Type') }}</label>
                    <select wire:model="type" id="reminder_type"
                        class="w-full px-4 py-3 bg-surface border border-border rounded-xl text-text focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors [color-scheme:dark]">
                        <option value="birthday">{{ __('Birthday') }}</option>
                        <option value="death_anniversary">{{ __('Death Anniversary') }}</option>
                        <option value="custom">{{ __('Custom (yearly)') }}</option>
                    </select>
                    @error('type')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="px-6 py-2.5 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                        {{ __('Add Reminder') }}
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
