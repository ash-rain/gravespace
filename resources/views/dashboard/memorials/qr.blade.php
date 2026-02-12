<x-layouts.app>
    <x-slot:title>{{ __('QR Code') }} — {{ $memorial->fullName() }}</x-slot:title>

    <div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('dashboard.memorials.edit', $memorial) }}" class="text-sm text-accent hover:text-accent-hover">&larr; {{ __('Back to Memorial') }}</a>
        </div>

        <div class="bg-surface border border-border rounded-2xl p-8 text-center">
            <h1 class="font-serif text-2xl font-bold text-text mb-2">{{ __('QR Code') }}</h1>
            <p class="text-text-muted text-sm mb-6">{{ __('Scan this code to visit the memorial for :name', ['name' => $memorial->fullName()]) }}</p>

            <div class="inline-block bg-white p-6 rounded-xl mb-6">
                {!! $qrSvg !!}
            </div>

            <div class="space-y-3">
                <p class="text-xs text-text-muted">{{ __('Code') }}: <span class="font-mono text-accent">{{ $qrCode->code }}</span></p>
                <p class="text-xs text-text-muted">{{ __('URL') }}: <span class="text-text">{{ $qrCode->url() }}</span></p>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('dashboard.memorials.qr.download', $memorial) }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    {{ __('Download PNG') }}
                </a>
                <button onclick="window.print()" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold border border-border text-text-muted hover:text-text rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    {{ __('Print') }}
                </button>
            </div>
        </div>
    </div>
</x-layouts.app>
