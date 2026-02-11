<x-layouts.memorial>
    <x-slot:title>{{ __('Timeline') }} — {{ $memorial->fullName() }}</x-slot:title>
    <x-slot:description>{{ __('Life timeline for :name', ['name' => $memorial->fullName()]) }}</x-slot:description>
    @if($memorial->cover_photo)
        <x-slot:ogImage>{{ Storage::url($memorial->cover_photo) }}</x-slot:ogImage>
    @endif

    {{-- Timeline Header --}}
    <section class="py-10 sm:py-14 border-b border-border">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('memorial.show', $memorial) }}" class="text-text-muted hover:text-text transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('memorial.show', $memorial) }}" class="text-sm text-text-muted hover:text-text transition-colors">
                    {{ $memorial->fullName() }}
                </a>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-text">
                {{ __('Life Timeline') }}
            </h1>
            <p class="mt-2 text-text-muted">
                {{ __('The story of :name\'s life, one moment at a time.', ['name' => $memorial->first_name]) }}
            </p>
        </div>
    </section>

    {{-- Timeline --}}
    <section class="py-10 sm:py-14">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($memorial->timelineEvents->count() > 0)
                <div class="relative">
                    {{-- Vertical Line --}}
                    <div class="absolute left-4 sm:left-1/2 sm:-translate-x-px top-0 bottom-0 w-px bg-border" aria-hidden="true"></div>

                    <div class="space-y-12">
                        @foreach($memorial->timelineEvents as $index => $event)
                            @php
                                $isLeft = $index % 2 === 0;
                            @endphp
                            <div class="relative flex items-start gap-6 sm:gap-0">
                                {{-- Timeline Dot --}}
                                <div class="absolute left-4 sm:left-1/2 -translate-x-1/2 z-10">
                                    <div class="w-3 h-3 rounded-full bg-accent border-2 border-primary shadow-lg shadow-accent/20"></div>
                                </div>

                                {{-- Content Card - Mobile: always right; Desktop: alternating --}}
                                <div class="ml-12 sm:ml-0 sm:w-1/2 {{ $isLeft ? 'sm:pr-12' : 'sm:pl-12 sm:ml-auto' }}">
                                    <div class="bg-surface border border-border rounded-xl p-6 hover:border-accent/20 transition-colors duration-300">
                                        {{-- Date Badge --}}
                                        @if($event->event_date)
                                            <span class="inline-block text-xs font-medium text-accent bg-accent/10 px-3 py-1 rounded-full mb-3">
                                                {{ $event->event_date->format('M j, Y') }}
                                            </span>
                                        @endif

                                        {{-- Event Title --}}
                                        <h3 class="font-serif text-lg font-semibold text-text mb-2">
                                            {{ $event->title }}
                                        </h3>

                                        {{-- Event Photo --}}
                                        @if($event->photo)
                                            <div class="mb-3 rounded-lg overflow-hidden">
                                                <img
                                                    src="{{ Storage::url($event->photo->thumbnail_path ?? $event->photo->file_path) }}"
                                                    alt="{{ $event->title }}"
                                                    class="w-full h-48 object-cover"
                                                    loading="lazy"
                                                >
                                            </div>
                                        @endif

                                        {{-- Event Description --}}
                                        @if($event->description)
                                            <p class="text-sm text-text-muted leading-relaxed">
                                                {{ $event->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Birth marker at start --}}
                    @if($memorial->date_of_birth)
                        <div class="relative flex items-center mt-12">
                            <div class="absolute left-4 sm:left-1/2 -translate-x-1/2 z-10">
                                <div class="w-4 h-4 rounded-full bg-accent/30 border-2 border-accent"></div>
                            </div>
                            <div class="ml-12 sm:ml-0 sm:w-1/2 sm:pl-12 sm:ml-auto">
                                <p class="text-sm text-text-muted italic">
                                    {{ __(':name\'s story continues through the memories shared by those who loved them.', ['name' => $memorial->first_name]) }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-20">
                    <svg class="w-12 h-12 text-text-muted/30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="font-serif text-xl font-semibold text-text mb-2">{{ __('No timeline events yet') }}</h3>
                    <p class="text-text-muted max-w-md mx-auto">
                        {{ __('Life events and milestones will appear here once they are added to the memorial.') }}
                    </p>
                    <a href="{{ route('memorial.show', $memorial) }}" class="inline-flex items-center mt-6 text-sm text-accent hover:text-accent-hover transition-colors">
                        &larr; {{ __('Back to memorial') }}
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.memorial>
