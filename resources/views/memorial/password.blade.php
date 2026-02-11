<x-layouts.memorial>
    <x-slot:title>{{ __('Password Required') }} — GraveSpace</x-slot:title>
    <x-slot:description>{{ __('This memorial is password protected.') }}</x-slot:description>

    <section class="py-20 sm:py-32">
        <div class="max-w-md mx-auto px-4 sm:px-6">
            <div class="bg-surface border border-border rounded-2xl p-8 sm:p-10 shadow-xl">
                {{-- Icon --}}
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-accent/10 border border-accent/20 rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>

                {{-- Heading --}}
                <div class="text-center mb-8">
                    <h1 class="font-serif text-2xl font-bold text-text">
                        {{ __('This Memorial is Private') }}
                    </h1>
                    <p class="mt-2 text-sm text-text-muted">
                        {{ __('Please enter the password to view this memorial page.') }}
                    </p>
                </div>

                {{-- Password Form --}}
                <form method="POST" action="{{ route('memorial.password.verify', $memorial->slug) }}">
                    @csrf

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-text-muted mb-2">{{ __('Password') }}</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            autofocus
                            class="w-full bg-elevated border border-border rounded-xl px-4 py-3 text-text placeholder:text-text-muted/50 focus:outline-none focus:border-accent/50 focus:ring-1 focus:ring-accent/50 transition-colors"
                            placeholder="{{ __('Enter memorial password') }}"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full px-6 py-3 text-sm font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-colors duration-200 shadow-lg shadow-accent/20">
                        {{ __('View Memorial') }}
                    </button>
                </form>

                {{-- Back link --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-text-muted hover:text-text transition-colors">
                        &larr; {{ __('Back to GraveSpace') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.memorial>
