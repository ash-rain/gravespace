<x-layouts.app :title="__('Export Memorial') . ' — ' . $memorial->fullName()">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <a href="{{ route('dashboard.memorials.edit', $memorial) }}"
                    class="inline-flex items-center gap-1 text-text-muted hover:text-accent text-sm transition-colors mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ __('Back to Memorial') }}
                </a>
                <h1 class="font-serif text-3xl font-bold text-text">{{ __('Export Memorial') }}</h1>
                <p class="mt-2 text-text-muted text-sm">{{ __('Print or save a beautiful keepsake of this memorial.') }}</p>
            </div>
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-colors duration-200 no-print">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>
                {{ __('Print / Save as PDF') }}
            </button>
        </div>

        {{-- Export Preview --}}
        <div class="bg-white text-gray-900 rounded-2xl overflow-hidden shadow-lg print:shadow-none print:rounded-none">

            {{-- Cover Section --}}
            <div class="relative bg-gray-100 py-16 px-8 text-center">
                @if ($memorial->profile_photo)
                    <img src="{{ Storage::url($memorial->profile_photo) }}" alt="{{ $memorial->fullName() }}"
                        class="w-28 h-28 rounded-full border-4 border-white object-cover shadow-lg mx-auto mb-6">
                @endif
                <h1 class="font-serif text-4xl font-bold text-gray-900">{{ $memorial->fullName() }}</h1>
                <p class="mt-2 text-lg text-gray-600">{{ $memorial->lifeDates() }}</p>
                @if ($memorial->place_of_birth || $memorial->place_of_death)
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $memorial->place_of_birth }}
                        @if ($memorial->place_of_birth && $memorial->place_of_death) — @endif
                        {{ $memorial->place_of_death }}
                    </p>
                @endif
            </div>

            <div class="p-8 space-y-10">
                {{-- Obituary --}}
                @if ($memorial->obituary)
                    <div>
                        <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">{{ __('Obituary') }}</h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($memorial->obituary)) !!}
                        </div>
                    </div>
                @endif

                {{-- Timeline --}}
                @if ($memorial->timelineEvents->count() > 0)
                    <div>
                        <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">{{ __('Life Timeline') }}</h2>
                        <div class="space-y-4">
                            @foreach ($memorial->timelineEvents as $event)
                                <div class="flex gap-4">
                                    <div class="text-sm font-medium text-gray-500 w-28 shrink-0">
                                        {{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('M j, Y') : '' }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $event->title }}</p>
                                        @if ($event->description)
                                            <p class="text-gray-600 text-sm mt-1">{{ $event->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Photos --}}
                @if ($memorial->photos->count() > 0)
                    <div>
                        <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">{{ __('Photos') }}</h2>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($memorial->photos->take(12) as $photo)
                                <div class="aspect-square rounded-lg overflow-hidden bg-gray-100">
                                    <img src="{{ Storage::url($photo->thumbnail_path ?? $photo->file_path) }}"
                                        alt="{{ $photo->caption ?? '' }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Tributes --}}
                @if ($memorial->approvedTributes->count() > 0)
                    <div>
                        <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">{{ __('Tributes & Memories') }}</h2>
                        <div class="space-y-4">
                            @foreach ($memorial->approvedTributes->take(20) as $tribute)
                                <div class="border-l-2 border-gray-300 pl-4">
                                    <p class="text-gray-700 text-sm italic">"{{ $tribute->body }}"</p>
                                    <p class="text-gray-500 text-xs mt-1">— {{ $tribute->authorDisplayName() }}, {{ $tribute->created_at->format('M j, Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Virtual Gifts Summary --}}
                @php
                    $giftCounts = $memorial->virtualGifts->groupBy('type')->map->count();
                @endphp
                @if ($memorial->virtualGifts->count() > 0)
                    <div>
                        <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">{{ __('Virtual Gifts Received') }}</h2>
                        <div class="flex flex-wrap gap-6">
                            @foreach (['candle' => '🕯️', 'flower' => '🌹', 'tree' => '🌳', 'wreath' => '🫷', 'star' => '⭐'] as $type => $emoji)
                                @if ($giftCounts->get($type, 0) > 0)
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <span class="text-xl">{{ $emoji }}</span>
                                        <span class="text-sm">{{ $giftCounts->get($type) }} {{ __($type . 's') }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Cemetery Info --}}
                @if ($memorial->cemetery_name || $memorial->cemetery_address)
                    <div>
                        <h2 class="font-serif text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">{{ __('Resting Place') }}</h2>
                        @if ($memorial->cemetery_name)
                            <p class="font-medium text-gray-900">{{ $memorial->cemetery_name }}</p>
                        @endif
                        @if ($memorial->cemetery_address)
                            <p class="text-gray-600 text-sm mt-1">{{ $memorial->cemetery_address }}</p>
                        @endif
                    </div>
                @endif

                {{-- Footer --}}
                <div class="text-center border-t border-gray-200 pt-6">
                    <p class="text-gray-400 text-xs">{{ __('Memorial preserved on GraveSpace.com') }}</p>
                    <p class="text-gray-400 text-xs mt-1">{{ url()->route('memorial.show', $memorial) }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
