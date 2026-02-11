<x-layouts.app :title="__('Dashboard')">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Welcome Section --}}
        <div class="mb-10">
            <h1 class="font-serif text-3xl font-bold text-text">
                {{ __('Welcome back, :name', ['name' => Auth::user()->name]) }}
            </h1>
            <p class="mt-2 text-text-muted text-sm">
                {{ __('Manage your memorials and keep memories alive.') }}
            </p>
        </div>

        {{-- Premium Status --}}
        <div class="mb-8">
            @if($isPremium)
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-accent/10 border border-accent/30 rounded-xl">
                    <svg class="w-5 h-5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-accent font-semibold text-sm">{{ __('Premium Member') }}</span>
                </div>
            @else
                <div class="bg-surface border border-border rounded-xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="font-serif text-lg font-semibold text-text">{{ __('Upgrade to Premium') }}</h3>
                        <p class="text-text-muted text-sm mt-1">{{ __('Unlock unlimited memorials, custom QR codes, custom slugs, and more.') }}</p>
                    </div>
                    <a href="{{ route('dashboard.billing') }}" class="inline-flex items-center justify-center px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors shrink-0">
                        {{ __('View Plans') }}
                    </a>
                </div>
            @endif
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            {{-- Total Memorials --}}
            <div class="bg-surface border border-border rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-text-muted text-sm">{{ __('Total Memorials') }}</p>
                        <p class="mt-2 text-3xl font-bold font-serif text-text">{{ $memorials->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-elevated rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Photos --}}
            <div class="bg-surface border border-border rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-text-muted text-sm">{{ __('Total Photos') }}</p>
                        <p class="mt-2 text-3xl font-bold font-serif text-text">{{ $memorials->sum('photos_count') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-elevated rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Pending Tributes --}}
            <div class="bg-surface border border-border rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-text-muted text-sm">{{ __('Pending Tributes') }}</p>
                        <p class="mt-2 text-3xl font-bold font-serif text-text">{{ $pendingTributes }}</p>
                    </div>
                    <div class="w-12 h-12 bg-elevated rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="mb-10">
            <h2 class="font-serif text-xl font-semibold text-text mb-4">{{ __('Quick Actions') }}</h2>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('dashboard.memorials.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Create Memorial') }}
                </a>
                <a href="{{ route('dashboard.billing') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-elevated border border-border text-text font-semibold text-sm rounded-xl hover:bg-surface transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    {{ __('View Billing') }}
                </a>
            </div>
        </div>

        {{-- Recent Memorials --}}
        <div>
            <h2 class="font-serif text-xl font-semibold text-text mb-4">{{ __('Recent Memorials') }}</h2>

            @if($memorials->isEmpty())
                <div class="bg-surface border border-border rounded-xl p-10 text-center">
                    <svg class="w-12 h-12 text-text-muted mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <p class="text-text-muted text-sm mb-4">{{ __('You have not created any memorials yet.') }}</p>
                    <a href="{{ route('dashboard.memorials.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                        {{ __('Create Your First Memorial') }}
                    </a>
                </div>
            @else
                <div class="bg-surface border border-border rounded-xl divide-y divide-border">
                    @foreach($memorials->take(5) as $memorial)
                        <div class="flex items-center justify-between p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-elevated rounded-xl overflow-hidden shrink-0">
                                    @if($memorial->profile_photo)
                                        <img src="{{ Storage::url($memorial->profile_photo) }}" alt="{{ $memorial->full_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-text font-semibold text-sm">{{ $memorial->full_name }}</h3>
                                    <p class="text-text-muted text-xs mt-0.5">
                                        {{ $memorial->date_of_birth?->format('M d, Y') }} &mdash; {{ $memorial->date_of_death?->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $memorial->is_published ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400' }}">
                                    {{ $memorial->is_published ? __('Published') : __('Draft') }}
                                </span>
                                <a href="{{ route('dashboard.memorials.edit', $memorial) }}" class="text-text-muted hover:text-accent transition-colors text-sm">
                                    {{ __('Edit') }}
                                </a>
                                @if($memorial->is_published)
                                    <a href="{{ route('memorial.show', $memorial) }}" class="text-text-muted hover:text-accent transition-colors text-sm" target="_blank">
                                        {{ __('View') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($memorials->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('dashboard.memorials.index') }}" class="text-accent hover:text-accent/80 text-sm font-medium transition-colors">
                            {{ __('View All Memorials') }} &rarr;
                        </a>
                    </div>
                @endif
            @endif
        </div>

    </div>
</x-layouts.app>
