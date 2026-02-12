<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">

        <title>{{ $title ?? 'Memorial' }} — GraveSpace</title>
        <meta name="description" content="{{ $description ?? '' }}">

        {{-- OG Tags for social sharing --}}
        <meta property="og:title" content="{{ $title ?? 'Memorial — GraveSpace' }}">
        <meta property="og:description" content="{{ $description ?? '' }}">
        <meta property="og:type" content="profile">
        @isset($ogImage)
            <meta property="og:image" content="{{ $ogImage }}">
        @endisset

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700,800&display=swap" rel="stylesheet" />

        @stack('head')

        <script>
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.add('light');
            }
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-primary text-text {{ $themeClass ?? '' }}">
        <div class="min-h-screen flex flex-col">
            {{-- Minimal nav for memorial pages --}}
            <nav class="bg-surface/60 backdrop-blur-md border-b border-border/50 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-14">
                        <div class="flex items-center">
                            <a href="{{ route('home') }}" class="flex items-center gap-2">
                                <span class="text-accent">&#x1F56F;</span>
                                <span class="font-serif text-lg font-bold text-text">GraveSpace</span>
                            </a>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-language-switcher />
                            <x-theme-toggle />
                            @auth
                                <a href="{{ route('dashboard.index') }}" class="text-sm text-text-muted hover:text-text">{{ __('Dashboard') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-text-muted hover:text-text">{{ __('Sign In') }}</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="bg-surface border-t border-border py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <a href="{{ route('home') }}" class="text-text-muted hover:text-text text-sm">
                        &#x1F56F; {{ __('Create a memorial on GraveSpace') }}
                    </a>
                </div>
            </footer>
        </div>

        @livewireScripts
        <x-cookie-consent />
    </body>
</html>
