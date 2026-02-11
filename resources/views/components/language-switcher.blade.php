@php
    $locales = [
        'en' => ['label' => 'English', 'flag' => '🇬🇧'],
        'fr' => ['label' => 'Français', 'flag' => '🇫🇷'],
        'de' => ['label' => 'Deutsch', 'flag' => '🇩🇪'],
        'bg' => ['label' => 'Български', 'flag' => '🇧🇬'],
    ];
    $current = app()->getLocale();
@endphp

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center gap-1.5 text-sm text-text-muted hover:text-text transition-colors">
        <span>{{ $locales[$current]['flag'] }}</span>
        <span class="uppercase text-xs font-medium">{{ $current }}</span>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </button>
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-40 bg-elevated border border-border rounded-lg shadow-xl z-50 py-1" style="display: none;">
        @foreach ($locales as $code => $locale)
            <a href="{{ route('language.switch', $code) }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ $code === $current ? 'text-accent' : 'text-text-muted hover:text-text' }} hover:bg-surface transition-colors">
                <span>{{ $locale['flag'] }}</span>
                <span>{{ $locale['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>
