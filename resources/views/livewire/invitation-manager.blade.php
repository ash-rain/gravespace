<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-serif text-lg font-semibold text-text">{{ __('Managers & Invitations') }}</h3>
        @if (! $showForm)
            <button wire:click="$set('showForm', true)"
                class="inline-flex items-center gap-2 px-4 py-2 bg-elevated border border-border text-text-muted text-sm font-medium rounded-xl hover:text-accent hover:border-accent/30 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Invite') }}
            </button>
        @endif
    </div>

    {{-- Current Managers --}}
    @if ($managers->isNotEmpty())
        <div class="mb-6">
            <p class="text-text-muted text-xs uppercase tracking-wider mb-3">{{ __('Current Managers') }}</p>
            <div class="space-y-3">
                @foreach ($managers as $manager)
                    <div wire:key="manager-{{ $manager->id }}" class="flex items-center justify-between bg-elevated border border-border rounded-xl p-4">
                        <div>
                            <p class="text-text text-sm font-medium">{{ $manager->name }}</p>
                            <p class="text-text-muted text-xs mt-0.5">{{ $manager->email }} &middot; {{ ucfirst($manager->pivot->role) }}</p>
                        </div>
                        @if ($manager->id !== $memorial->user_id)
                            <button wire:click="removeManager({{ $manager->id }})"
                                wire:confirm="{{ __('Remove this manager?') }}"
                                class="p-2 text-red-400 hover:bg-red-500/10 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @else
                            <span class="text-accent text-xs font-medium">{{ __('Owner') }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Pending Invitations --}}
    @if ($pendingInvitations->isNotEmpty())
        <div class="mb-6">
            <p class="text-text-muted text-xs uppercase tracking-wider mb-3">{{ __('Pending Invitations') }}</p>
            <div class="space-y-3">
                @foreach ($pendingInvitations as $invitation)
                    <div wire:key="invitation-{{ $invitation->id }}" class="flex items-center justify-between bg-elevated border border-border rounded-xl p-4">
                        <div>
                            <p class="text-text text-sm font-medium">{{ $invitation->email }}</p>
                            <p class="text-text-muted text-xs mt-0.5">
                                {{ ucfirst($invitation->role) }} &middot;
                                {{ __('Expires') }} {{ $invitation->expires_at->diffForHumans() }}
                            </p>
                        </div>
                        <button wire:click="revokeInvitation({{ $invitation->id }})"
                            class="px-3 py-1.5 text-xs text-red-400 bg-red-500/10 border border-red-500/30 rounded-lg hover:bg-red-500/20 transition-colors">
                            {{ __('Revoke') }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Invite Form --}}
    @if ($showForm)
        <div class="bg-elevated border border-border rounded-xl p-5">
            <form wire:submit="sendInvitation">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-text-muted mb-2">{{ __('Email Address') }}</label>
                        <input type="email" wire:model="email"
                            class="w-full px-4 py-3 bg-surface border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                            placeholder="{{ __('person@example.com') }}">
                        @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-muted mb-2">{{ __('Role') }}</label>
                        <select wire:model="role"
                            class="w-full px-4 py-3 bg-surface border border-border rounded-xl text-text focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors [color-scheme:dark]">
                            <option value="viewer">{{ __('Viewer') }}</option>
                            <option value="editor">{{ __('Editor') }}</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="px-6 py-2.5 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                        {{ __('Send Invitation') }}
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
