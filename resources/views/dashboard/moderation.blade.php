<x-layouts.app :title="__('Moderation')">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="font-serif text-3xl font-bold text-text">{{ __('Moderation') }}</h1>
                <p class="mt-2 text-text-muted text-sm">{{ __('Review and manage pending tributes across all your memorials.') }}</p>
            </div>
        </div>

        {{-- Filter by Memorial --}}
        @if ($memorials->count() > 1)
            <div class="mb-8">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('dashboard.moderation') }}"
                        class="px-4 py-2 text-sm rounded-xl border transition-colors {{ !$memorialFilter ? 'bg-accent/10 border-accent/50 text-accent' : 'bg-elevated border-border text-text-muted hover:border-accent/30' }}">
                        {{ __('All') }} ({{ $pendingTributes->count() }})
                    </a>
                    @foreach ($memorials as $memorial)
                        @if ($memorial->tributes_count > 0)
                            <a href="{{ route('dashboard.moderation', ['memorial_id' => $memorial->id]) }}"
                                class="px-4 py-2 text-sm rounded-xl border transition-colors {{ $memorialFilter == $memorial->id ? 'bg-accent/10 border-accent/50 text-accent' : 'bg-elevated border-border text-text-muted hover:border-accent/30' }}">
                                {{ $memorial->fullName() }} ({{ $memorial->tributes_count }})
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Pending Tributes --}}
        @if ($pendingTributes->isNotEmpty())
            <div class="space-y-4">
                @foreach ($pendingTributes as $tribute)
                    <div class="bg-surface border border-border rounded-xl p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-text font-medium text-sm">{{ $tribute->authorDisplayName() }}</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium bg-yellow-500/10 text-yellow-400">
                                        {{ __('Pending') }}
                                    </span>
                                    <span class="text-text-muted text-xs">{{ $tribute->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-text-muted text-sm leading-relaxed mb-2">{{ $tribute->body }}</p>
                                <p class="text-text-muted/60 text-xs">
                                    {{ __('Memorial') }}: <a href="{{ route('dashboard.memorials.edit', $tribute->memorial) }}" class="text-accent hover:text-accent/80">{{ $tribute->memorial->fullName() }}</a>
                                </p>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <form method="POST" action="{{ route('dashboard.tributes.approve', $tribute) }}">
                                    @csrf
                                    <button type="submit"
                                        class="p-2 bg-green-500/10 border border-green-500/30 text-green-400 rounded-xl hover:bg-green-500/20 transition-colors"
                                        title="{{ __('Approve') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('dashboard.tributes.reject', $tribute) }}">
                                    @csrf
                                    <button type="submit"
                                        class="p-2 bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 rounded-xl hover:bg-yellow-500/20 transition-colors"
                                        title="{{ __('Reject') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('dashboard.tributes.destroy', $tribute) }}"
                                    onsubmit="return confirm('{{ __('Delete this tribute?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl hover:bg-red-500/20 transition-colors"
                                        title="{{ __('Delete') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-surface border border-border rounded-xl p-10 text-center">
                <svg class="w-12 h-12 text-text-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-text-muted text-sm">{{ __('No pending tributes. All caught up!') }}</p>
            </div>
        @endif

    </div>
</x-layouts.app>
