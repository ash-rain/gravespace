<x-layouts.memorial :themeClass="$memorial->themeClasses()">
    <x-slot:title>{{ $memorial->fullName() }}</x-slot:title>
    <x-slot:description>{{ Str::limit(strip_tags($memorial->obituary), 160) }}</x-slot:description>
    @if ($memorial->cover_photo)
        <x-slot:ogImage>{{ Storage::url($memorial->cover_photo) }}</x-slot:ogImage>
    @endif

    @push('head')
        <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@@type": "Person",
        "name": "{{ $memorial->fullName() }}",
        "givenName": "{{ $memorial->first_name }}",
        "familyName": "{{ $memorial->last_name }}",
        @if($memorial->date_of_birth)
        "birthDate": "{{ $memorial->date_of_birth->format('Y-m-d') }}",
        @endif
        @if($memorial->date_of_death)
        "deathDate": "{{ $memorial->date_of_death->format('Y-m-d') }}",
        @endif
        @if($memorial->place_of_birth)
        "birthPlace": "{{ $memorial->place_of_birth }}",
        @endif
        @if($memorial->place_of_death)
        "deathPlace": "{{ $memorial->place_of_death }}",
        @endif
        @if($memorial->profile_photo)
        "image": "{{ Storage::url($memorial->profile_photo) }}",
        @endif
        "url": "{{ route('memorial.show', $memorial) }}"
    }
    </script>
    @endpush

    <article>
        {{-- Print-only header --}}
        <div class="print-only text-center mb-8">
            <p class="text-sm text-gray-500">Memorial from GraveSpace.com</p>
            <hr class="my-4 border-gray-300">
        </div>

        {{-- Cover Photo Section --}}
        <section class="relative">
            <div class="relative h-64 sm:h-80 md:h-96 lg:h-[28rem] bg-elevated overflow-hidden">
                @if ($memorial->cover_photo)
                    <img src="{{ Storage::url($memorial->cover_photo) }}"
                        alt="{{ __('Cover photo of :name', ['name' => $memorial->fullName()]) }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-elevated to-surface"></div>
                @endif
                {{-- Gradient overlay at bottom --}}
                <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/40 to-transparent"></div>
            </div>

            {{-- Profile Photo & Name Overlay --}}
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 sm:-mt-28 z-10">
                <div class="flex flex-col sm:flex-row items-center sm:items-end gap-4 sm:gap-6">
                    {{-- Profile Photo --}}
                    <div class="shrink-0">
                        @if ($memorial->profile_photo)
                            <img src="{{ Storage::url($memorial->profile_photo) }}" alt="{{ $memorial->fullName() }}"
                                class="w-32 h-32 sm:w-36 sm:h-36 rounded-full border-4 border-primary object-cover shadow-2xl">
                        @else
                            <div
                                class="w-32 h-32 sm:w-36 sm:h-36 rounded-full border-4 border-primary bg-elevated flex items-center justify-center shadow-2xl">
                                <span class="text-4xl text-text-muted/40">&#x1F56F;</span>
                            </div>
                        @endif
                    </div>

                    {{-- Name & Life Dates --}}
                    <div class="text-center sm:text-left pb-2">
                        <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-accent leading-tight">
                            {{ $memorial->fullName() }}
                        </h1>
                        <p class="mt-1 text-lg text-text-muted">
                            {{ $memorial->lifeDates() }}
                        </p>
                        @if ($memorial->place_of_birth || $memorial->place_of_death)
                            <p class="mt-1 text-sm text-text-muted/70">
                                @if ($memorial->place_of_birth)
                                    {{ $memorial->place_of_birth }}
                                @endif
                                @if ($memorial->place_of_birth && $memorial->place_of_death)
                                    &mdash;
                                @endif
                                @if ($memorial->place_of_death)
                                    {{ $memorial->place_of_death }}
                                @endif
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- Virtual Gifts Summary --}}
        <section class="py-8 border-b border-border">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-6">
                    @php
                        $giftCounts = $memorial->virtualGifts->groupBy('type')->map->count();
                    @endphp
                    <div class="flex items-center gap-2 text-text-muted">
                        <span class="text-xl" title="{{ __('Candles') }}">&#x1F56F;</span>
                        <span class="text-sm font-medium">{{ $giftCounts->get('candle', 0) }}
                            {{ __('candles') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-text-muted">
                        <span class="text-xl" title="{{ __('Flowers') }}">&#x1F339;</span>
                        <span class="text-sm font-medium">{{ $giftCounts->get('flower', 0) }}
                            {{ __('flowers') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-text-muted">
                        <span class="text-xl" title="{{ __('Trees') }}">&#x1F333;</span>
                        <span class="text-sm font-medium">{{ $giftCounts->get('tree', 0) }} {{ __('trees') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-text-muted">
                        <span class="text-xl" title="{{ __('Stars') }}">&#x2B50;</span>
                        <span class="text-sm font-medium">{{ $giftCounts->get('star', 0) }} {{ __('stars') }}</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Sub-Navigation --}}
        <section class="border-b border-border bg-surface/30">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-3">
                    <nav class="flex items-center gap-6 overflow-x-auto text-sm">
                        <a href="{{ route('memorial.show', $memorial) }}"
                            class="text-accent font-medium whitespace-nowrap">{{ __('Memorial') }}</a>
                        @if ($memorial->photos->count() > 0)
                            <a href="{{ route('memorial.gallery', $memorial->slug) }}"
                                class="text-text-muted hover:text-text whitespace-nowrap transition-colors">{{ __('Gallery') }}
                                ({{ $memorial->photos->count() }})</a>
                        @endif
                        @if ($memorial->timelineEvents->count() > 0)
                            <a href="{{ route('memorial.timeline', $memorial->slug) }}"
                                class="text-text-muted hover:text-text whitespace-nowrap transition-colors">{{ __('Timeline') }}</a>
                        @endif
                        <button onclick="window.print()"
                            class="ml-auto text-text-muted hover:text-text whitespace-nowrap transition-colors no-print flex items-center gap-1.5"
                            title="{{ __('Print Memorial') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                            </svg>
                            <span class="text-sm">{{ __('Print') }}</span>
                        </button>
                    </nav>
                    <x-social-share :url="route('memorial.show', $memorial)" :title="$memorial->fullName() . ' — GraveSpace'" />
                </div>
            </div>
        </section>

        {{-- Obituary --}}
        @if ($memorial->obituary)
            <section class="py-10 sm:py-14">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="font-serif text-2xl font-bold text-text mb-6">{{ __('Obituary') }}</h2>
                    <div class="prose prose-invert prose-lg max-w-none text-text-muted leading-relaxed">
                        {!! nl2br(e($memorial->obituary)) !!}
                    </div>
                </div>
            </section>
        @endif

        {{-- Photo Gallery Preview --}}
        @if ($memorial->photos->count() > 0)
            <section class="py-10 sm:py-14 bg-surface/30">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-serif text-2xl font-bold text-text">{{ __('Photos') }}</h2>
                        @if ($memorial->photos->count() > 6)
                            <a href="{{ route('memorial.gallery', $memorial->slug) }}"
                                class="text-sm text-accent hover:text-accent-hover transition-colors">
                                {{ __('View all :count photos', ['count' => $memorial->photos->count()]) }} &rarr;
                            </a>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($memorial->photos->take(6) as $photo)
                            <div class="relative aspect-square bg-elevated rounded-xl overflow-hidden group">
                                <img src="{{ Storage::url($photo->thumbnail_path ?? $photo->file_path) }}"
                                    alt="{{ $photo->caption ?? __('Photo of :name', ['name' => $memorial->fullName()]) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @if ($photo->caption)
                                    <div
                                        class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-primary/80 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <p class="text-xs text-text truncate">{{ $photo->caption }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Family Connections --}}
        @if ($memorial->familyLinks && $memorial->familyLinks->count() > 0)
            <x-memorial.family-links :familyLinks="$memorial->familyLinks" />
        @endif

        {{-- Voice Memories --}}
        @if ($memorial->voiceMemories && $memorial->voiceMemories->count() > 0)
            <section class="py-10 sm:py-14">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="font-serif text-2xl font-bold text-text mb-6">{{ __('Voice Memories') }}</h2>
                    <div class="space-y-4">
                        @foreach ($memorial->voiceMemories as $voice)
                            <div class="bg-surface border border-border rounded-xl p-5 flex flex-col sm:flex-row sm:items-center gap-4">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-text font-medium text-sm truncate">{{ $voice->title }}</p>
                                        <p class="text-text-muted text-xs">{{ __('Shared by') }} {{ $voice->user->name }}</p>
                                    </div>
                                </div>
                                <audio controls preload="none" class="h-8 shrink-0">
                                    <source src="{{ Storage::url($voice->file_path) }}" type="audio/mpeg">
                                </audio>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Leave a Virtual Gift --}}
        <section class="py-10 sm:py-14" x-data="{ selectedGift: 'candle', message: '', submitted: false }">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-serif text-2xl font-bold text-text mb-6">{{ __('Leave a Virtual Gift') }}</h2>
                <div class="bg-surface border border-border rounded-2xl p-6 sm:p-8">
                    <form method="POST" action="{{ route('memorial.gifts.store', $memorial->slug) }}">
                        @csrf
                        <x-honeypot />
                        <input type="hidden" name="type" :value="selectedGift">

                        {{-- Gift Type Selector --}}
                        <div class="flex flex-wrap gap-3 mb-6">
                            <button type="button" @click="selectedGift = 'candle'"
                                class="flex items-center gap-2 px-4 py-2.5 rounded-xl border text-sm transition-all duration-200"
                                :class="selectedGift === 'candle' ? 'bg-accent/10 border-accent/50 text-accent' :
                                    'bg-elevated border-border text-text-muted hover:border-accent/30'">
                                <span class="text-lg">&#x1F56F;</span> {{ __('Candle') }}
                            </button>
                            <button type="button" @click="selectedGift = 'flower'"
                                class="flex items-center gap-2 px-4 py-2.5 rounded-xl border text-sm transition-all duration-200"
                                :class="selectedGift === 'flower' ? 'bg-accent/10 border-accent/50 text-accent' :
                                    'bg-elevated border-border text-text-muted hover:border-accent/30'">
                                <span class="text-lg">&#x1F339;</span> {{ __('Flower') }}
                            </button>
                            <button type="button" @click="selectedGift = 'tree'"
                                class="flex items-center gap-2 px-4 py-2.5 rounded-xl border text-sm transition-all duration-200"
                                :class="selectedGift === 'tree' ? 'bg-accent/10 border-accent/50 text-accent' :
                                    'bg-elevated border-border text-text-muted hover:border-accent/30'">
                                <span class="text-lg">&#x1F333;</span> {{ __('Tree') }}
                            </button>
                            <button type="button" @click="selectedGift = 'wreath'"
                                class="flex items-center gap-2 px-4 py-2.5 rounded-xl border text-sm transition-all duration-200"
                                :class="selectedGift === 'wreath' ? 'bg-accent/10 border-accent/50 text-accent' :
                                    'bg-elevated border-border text-text-muted hover:border-accent/30'">
                                <span class="text-lg">&#x1FAB7;</span> {{ __('Wreath') }}
                            </button>
                            <button type="button" @click="selectedGift = 'star'"
                                class="flex items-center gap-2 px-4 py-2.5 rounded-xl border text-sm transition-all duration-200"
                                :class="selectedGift === 'star' ? 'bg-accent/10 border-accent/50 text-accent' :
                                    'bg-elevated border-border text-text-muted hover:border-accent/30'">
                                <span class="text-lg">&#x2B50;</span> {{ __('Star') }}
                            </button>
                        </div>

                        {{-- Optional Message --}}
                        <div class="mb-6">
                            <label for="gift_message"
                                class="block text-sm font-medium text-text-muted mb-2">{{ __('Message (optional)') }}</label>
                            <textarea id="gift_message" name="message" rows="2" maxlength="500"
                                placeholder="{{ __('In loving memory...') }}"
                                class="w-full bg-elevated border border-border rounded-xl px-4 py-3 text-text placeholder:text-text-muted/50 focus:outline-none focus:border-accent/50 focus:ring-1 focus:ring-accent/50 text-sm resize-none transition-colors"></textarea>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-colors duration-200">
                            {{ __('Leave Gift') }}
                        </button>
                    </form>

                    @if ($errors->any())
                        <div class="mt-4 text-sm text-red-400">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Tributes / Guest Book --}}
        <section class="py-10 sm:py-14 bg-surface/30">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-serif text-2xl font-bold text-text mb-8">{{ __('Tributes & Memories') }}</h2>

                {{-- Leave a Tribute Form --}}
                <div class="bg-surface border border-border rounded-2xl p-6 sm:p-8 mb-10">
                    <h3 class="font-serif text-lg font-semibold text-text mb-4">{{ __('Share a Memory') }}</h3>
                    <form method="POST" action="{{ route('memorial.tributes.store', $memorial->slug) }}">
                        @csrf
                        <x-honeypot />

                        @guest
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="author_name"
                                        class="block text-sm font-medium text-text-muted mb-1.5">{{ __('Your Name') }}</label>
                                    <input type="text" id="author_name" name="author_name"
                                        value="{{ old('author_name') }}" required
                                        class="w-full bg-elevated border border-border rounded-xl px-4 py-2.5 text-text placeholder:text-text-muted/50 focus:outline-none focus:border-accent/50 focus:ring-1 focus:ring-accent/50 text-sm transition-colors"
                                        placeholder="{{ __('John Doe') }}">
                                </div>
                                <div>
                                    <label for="author_email"
                                        class="block text-sm font-medium text-text-muted mb-1.5">{{ __('Email (private)') }}</label>
                                    <input type="email" id="author_email" name="author_email"
                                        value="{{ old('author_email') }}"
                                        class="w-full bg-elevated border border-border rounded-xl px-4 py-2.5 text-text placeholder:text-text-muted/50 focus:outline-none focus:border-accent/50 focus:ring-1 focus:ring-accent/50 text-sm transition-colors"
                                        placeholder="{{ __('optional') }}">
                                </div>
                            </div>
                        @endguest

                        <div class="mb-4">
                            <label for="tribute_body"
                                class="block text-sm font-medium text-text-muted mb-1.5">{{ __('Your Tribute') }}</label>
                            <textarea id="tribute_body" name="body" rows="4" required
                                class="w-full bg-elevated border border-border rounded-xl px-4 py-3 text-text placeholder:text-text-muted/50 focus:outline-none focus:border-accent/50 focus:ring-1 focus:ring-accent/50 text-sm resize-none transition-colors"
                                placeholder="{{ __('Share a memory, a story, or a message...') }}">{{ old('body') }}</textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-colors duration-200">
                                {{ __('Submit Tribute') }}
                            </button>
                            <p class="text-xs text-text-muted">{{ __('Tributes are reviewed before publishing.') }}
                            </p>
                        </div>
                    </form>
                </div>

                {{-- Approved Tributes --}}
                @if ($memorial->approvedTributes->count() > 0)
                    <div class="space-y-6">
                        @foreach ($memorial->approvedTributes as $tribute)
                            <div class="bg-surface border border-border rounded-xl p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <p class="text-sm font-medium text-text">{{ $tribute->authorDisplayName() }}
                                        </p>
                                        <p class="text-xs text-text-muted">{{ $tribute->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <p class="text-text-muted leading-relaxed text-sm">
                                    {{ $tribute->body }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-text-muted">{{ __('No tributes yet. Be the first to share a memory.') }}</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Cemetery / Location Info --}}
        @if ($memorial->cemetery_name || $memorial->cemetery_address)
            <section class="py-10 sm:py-14">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="font-serif text-2xl font-bold text-text mb-4">{{ __('Resting Place') }}</h2>
                    <div class="bg-surface border border-border rounded-2xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                @if ($memorial->cemetery_name)
                                    <p class="font-medium text-text">{{ $memorial->cemetery_name }}</p>
                                @endif
                                @if ($memorial->cemetery_address)
                                    <p class="text-sm text-text-muted mt-1">{{ $memorial->cemetery_address }}</p>
                                @endif
                            </div>
                        </div>

                        <x-memorial.map
                            :latitude="$memorial->latitude"
                            :longitude="$memorial->longitude"
                            :name="$memorial->cemetery_name ?? $memorial->fullName()"
                        />
                    </div>
                </div>
            </section>
        @endif
    </article>

    {{-- Success Flash --}}
    @if (session('success'))
        <div class="fixed bottom-6 right-6 z-50 bg-elevated border border-accent/50 text-text px-6 py-4 rounded-xl shadow-2xl max-w-sm"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
            <div class="flex items-start gap-3">
                <span class="text-accent text-lg">&#x1F56F;</span>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif
</x-layouts.memorial>
