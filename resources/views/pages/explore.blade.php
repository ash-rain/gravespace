<x-layouts.public>
    <x-slot:title>{{ __('Explore Memorials') }} — GraveSpace</x-slot:title>
    <x-slot:description>{{ __('Browse public memorials and honor the lives of those who have passed. Light a candle, leave a tribute.') }}</x-slot:description>

    {{-- Page Header & Search --}}
    <section class="py-12 sm:py-16 border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-text">
                    {{ __('Explore Memorials') }}
                </h1>
                <p class="mt-3 text-text-muted">
                    {{ __('Browse public memorials and pay your respects to those who have passed.') }}
                </p>
            </div>

            {{-- Search Bar --}}
            <div class="max-w-xl mx-auto mt-8">
                <form method="GET" action="{{ route('explore') }}" class="relative">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="{{ __('Search by name...') }}"
                            class="w-full pl-12 pr-4 py-3 bg-surface border border-border rounded-xl text-text placeholder:text-text-muted/60 focus:outline-none focus:border-accent/50 focus:ring-1 focus:ring-accent/50 transition-colors"
                        >
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- Memorial Grid --}}
    <section class="py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($memorials->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($memorials as $memorial)
                        <a href="{{ route('memorial.show', $memorial) }}" class="group bg-surface border border-border rounded-2xl overflow-hidden hover:border-accent/30 transition-all duration-300 hover:shadow-lg hover:shadow-accent/5">
                            {{-- Cover Photo --}}
                            <div class="relative aspect-[4/3] bg-elevated overflow-hidden">
                                @if($memorial->cover_photo)
                                    <img
                                        src="{{ Storage::url($memorial->cover_photo) }}"
                                        alt="{{ $memorial->fullName() }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-4xl text-text-muted/30">&#x1F56F;</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent"></div>

                                {{-- Profile Photo Overlay --}}
                                @if($memorial->profile_photo)
                                    <div class="absolute bottom-3 left-3">
                                        <img
                                            src="{{ Storage::url($memorial->profile_photo) }}"
                                            alt=""
                                            class="w-12 h-12 rounded-full border-2 border-surface object-cover shadow-lg"
                                        >
                                    </div>
                                @endif
                            </div>

                            {{-- Card Body --}}
                            <div class="p-4">
                                <h3 class="font-serif text-lg font-semibold text-text group-hover:text-accent transition-colors truncate">
                                    {{ $memorial->fullName() }}
                                </h3>
                                <p class="text-sm text-text-muted mt-1">
                                    {{ $memorial->lifeDates() }}
                                </p>

                                {{-- Stats --}}
                                <div class="flex items-center gap-4 mt-3 pt-3 border-t border-border">
                                    <span class="flex items-center gap-1.5 text-xs text-text-muted" title="{{ __('Candles') }}">
                                        <span>&#x1F56F;</span>
                                        {{ $memorial->virtual_gifts_count ?? 0 }}
                                    </span>
                                    <span class="flex items-center gap-1.5 text-xs text-text-muted" title="{{ __('Tributes') }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                        {{ $memorial->approved_tributes_count ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $memorials->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <span class="text-5xl block mb-4">&#x1F56F;</span>
                    <h3 class="font-serif text-xl font-semibold text-text mb-2">
                        @if(request('search'))
                            {{ __('No memorials found') }}
                        @else
                            {{ __('No public memorials yet') }}
                        @endif
                    </h3>
                    <p class="text-text-muted max-w-md mx-auto">
                        @if(request('search'))
                            {{ __('Try a different search term or browse all memorials.') }}
                        @else
                            {{ __('Be the first to create a memorial and honor someone you love.') }}
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('explore') }}" class="inline-flex items-center mt-6 text-sm text-accent hover:text-accent-hover transition-colors">
                            {{ __('Clear search') }}
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center mt-6 px-6 py-2.5 text-sm font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-colors">
                            {{ __('Create a Memorial') }}
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
