<x-layouts.app :title="__('My Memorials')">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="font-serif text-3xl font-bold text-text">{{ __('My Memorials') }}</h1>
                <p class="mt-1 text-text-muted text-sm">{{ __('Manage and organize all your memorials.') }}</p>
            </div>

            <a href="{{ route('dashboard.memorials.create') }}"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Create New Memorial') }}
            </a>
        </div>

        {{-- Memorials Grid --}}
        @if ($memorials->isEmpty())
            <div class="bg-surface border border-border rounded-xl p-16 text-center">
                <svg class="w-16 h-16 text-text-muted mx-auto mb-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="font-serif text-xl font-semibold text-text mb-2">{{ __('No memorials yet') }}</h3>
                <p class="text-text-muted text-sm mb-6 max-w-md mx-auto">
                    {{ __('Create your first memorial to honor and preserve the memory of a loved one.') }}</p>
                <a href="{{ route('dashboard.memorials.create') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                    {{ __('Create Your First Memorial') }}
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($memorials as $memorial)
                    <div
                        class="bg-surface border border-border rounded-xl overflow-hidden group hover:border-accent/30 transition-colors">
                        {{-- Cover Photo --}}
                        <div class="relative h-40 bg-elevated overflow-hidden">
                            @if ($memorial->cover_photo)
                                <img src="{{ Storage::url($memorial->cover_photo) }}" alt="{{ $memorial->fullName() }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-text-muted/30" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Status Badge --}}
                            <div class="absolute top-3 right-3">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium backdrop-blur-sm {{ $memorial->is_published ? 'bg-green-500/20 text-green-300 border border-green-500/30' : 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' }}">
                                    {{ $memorial->is_published ? __('Published') : __('Draft') }}
                                </span>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5">
                            <h3 class="font-serif text-lg font-semibold text-text truncate">{{ $memorial->fullName() }}
                            </h3>
                            <p class="text-text-muted text-sm mt-1">
                                {{ $memorial->date_of_birth?->format('M d, Y') }} &mdash;
                                {{ $memorial->date_of_death?->format('M d, Y') }}
                            </p>

                            {{-- Counts --}}
                            <div class="flex items-center gap-4 mt-4 text-xs text-text-muted">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $memorial->photos_count ?? 0 }} {{ __('photos') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    {{ $memorial->tributes_count ?? 0 }} {{ __('tributes') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                    </svg>
                                    {{ $memorial->gifts_count ?? 0 }} {{ __('gifts') }}
                                </span>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-3 mt-5 pt-5 border-t border-border">
                                <a href="{{ route('dashboard.memorials.edit', $memorial) }}"
                                    class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-elevated border border-border text-text text-sm font-medium rounded-xl hover:bg-accent/10 hover:border-accent/30 hover:text-accent transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ __('Edit') }}
                                </a>
                                @if ($memorial->is_published)
                                    <a href="{{ route('memorial.show', $memorial) }}" target="_blank"
                                        class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-elevated border border-border text-text-muted text-sm font-medium rounded-xl hover:text-text transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        {{ __('View') }}
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('dashboard.memorials.destroy', $memorial) }}"
                                    onsubmit="return confirm('{{ __('Are you sure you want to delete this memorial? This action cannot be undone.') }}')"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center p-2.5 bg-elevated border border-border text-text-muted rounded-xl hover:text-red-400 hover:border-red-400/30 hover:bg-red-400/10 transition-colors">
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
        @endif

    </div>
</x-layouts.app>
