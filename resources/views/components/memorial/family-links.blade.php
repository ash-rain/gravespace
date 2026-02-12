@props(['familyLinks'])

<section class="py-10 sm:py-14">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-serif text-2xl font-bold text-text mb-6">{{ __('Family Connections') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($familyLinks as $link)
                @if ($link->relatedMemorial)
                    <a href="{{ route('memorial.show', $link->relatedMemorial) }}"
                        class="bg-surface border border-border rounded-xl p-4 hover:border-accent/30 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-elevated rounded-full overflow-hidden shrink-0 flex items-center justify-center">
                                @if ($link->relatedMemorial->profile_photo)
                                    <img src="{{ Storage::url($link->relatedMemorial->profile_photo) }}"
                                        alt="{{ $link->relatedMemorial->fullName() }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <span class="text-text-muted/40 text-lg">&#x1F56F;</span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-text font-medium text-sm group-hover:text-accent transition-colors truncate">
                                    {{ $link->relatedMemorial->fullName() }}
                                </p>
                                <p class="text-text-muted text-xs mt-0.5">{{ $link->relationshipLabel() }}</p>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>
