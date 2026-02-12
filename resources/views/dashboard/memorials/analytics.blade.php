<x-layouts.app>
    <x-slot:title>{{ __('Analytics') }} — {{ $memorial->fullName() }}</x-slot:title>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('dashboard.memorials.edit', $memorial) }}" class="text-sm text-accent hover:text-accent-hover">&larr; {{ __('Back to Memorial') }}</a>
        </div>

        <h1 class="font-serif text-2xl font-bold text-text mb-8">{{ __('Analytics for :name', ['name' => $memorial->fullName()]) }}</h1>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
            <div class="bg-surface border border-border rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-accent">{{ number_format($totalViews) }}</p>
                <p class="text-xs text-text-muted mt-1">{{ __('Total Views') }}</p>
            </div>
            <div class="bg-surface border border-border rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-text">{{ number_format($uniqueVisitors) }}</p>
                <p class="text-xs text-text-muted mt-1">{{ __('Unique Visitors') }}</p>
            </div>
            <div class="bg-surface border border-border rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-text">{{ number_format($tributeCount) }}</p>
                <p class="text-xs text-text-muted mt-1">{{ __('Tributes') }}</p>
            </div>
            <div class="bg-surface border border-border rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-text">{{ number_format($giftCount) }}</p>
                <p class="text-xs text-text-muted mt-1">{{ __('Virtual Gifts') }}</p>
            </div>
        </div>

        {{-- Views Chart (last 30 days) --}}
        <div class="bg-surface border border-border rounded-2xl p-6">
            <h2 class="font-serif text-lg font-bold text-text mb-4">{{ __('Views — Last 30 Days') }}</h2>
            <div class="h-48" x-data="{
                chartData: {{ json_encode(array_values($chartData)) }},
                labels: {{ json_encode(array_map(fn($d) => \Carbon\Carbon::parse($d)->format('M j'), array_keys($chartData))) }},
                get maxVal() { return Math.max(...this.chartData, 1) }
            }">
                <div class="flex items-end justify-between h-full gap-px">
                    <template x-for="(value, index) in chartData" :key="index">
                        <div class="flex-1 flex flex-col items-center justify-end h-full group relative">
                            <div
                                class="w-full bg-accent/60 hover:bg-accent rounded-t transition-colors min-h-[2px]"
                                :style="'height: ' + (value / maxVal * 100) + '%'"
                            ></div>
                            <div class="absolute -top-8 bg-elevated border border-border px-2 py-1 rounded text-xs text-text opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-10">
                                <span x-text="labels[index]"></span>: <span x-text="value" class="text-accent"></span>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="flex justify-between mt-2 text-xs text-text-muted">
                    <span x-text="labels[0]"></span>
                    <span x-text="labels[labels.length - 1]"></span>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
