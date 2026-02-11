<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'GraveSpace — Honor Those Who Matter' }}</title>
        <meta name="description" content="{{ $description ?? 'Create beautiful, lasting memorial pages for your loved ones. A premium virtual memorial platform.' }}">

        {{-- OG Tags --}}
        <meta property="og:title" content="{{ $title ?? 'GraveSpace' }}">
        <meta property="og:description" content="{{ $description ?? 'Create beautiful, lasting memorial pages for your loved ones.' }}">
        <meta property="og:type" content="website">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-primary text-text">
        <div class="min-h-screen flex flex-col">
            {{-- Public Navigation --}}
            <nav class="bg-surface/80 backdrop-blur-md border-b border-border sticky top-0 z-50" x-data="{ open: false }">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <a href="{{ route('home') }}" class="flex items-center gap-2">
                                <span class="text-accent text-2xl">&#x1F56F;</span>
                                <span class="font-serif text-xl font-bold text-text">GraveSpace</span>
                            </a>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:gap-6">
                            <a href="{{ route('explore') }}" class="text-sm text-text-muted hover:text-text transition-colors">{{ __('Explore') }}</a>
                            <a href="{{ route('pricing') }}" class="text-sm text-text-muted hover:text-text transition-colors">{{ __('Pricing') }}</a>
                            <a href="{{ route('about') }}" class="text-sm text-text-muted hover:text-text transition-colors">{{ __('About') }}</a>
                            <x-language-switcher />
                            @auth
                                <a href="{{ route('dashboard.index') }}" class="text-sm bg-accent hover:bg-accent-hover text-primary font-semibold px-4 py-2 rounded-lg transition-colors">{{ __('Dashboard') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-text-muted hover:text-text transition-colors">{{ __('Sign In') }}</a>
                                <a href="{{ route('register') }}" class="text-sm bg-accent hover:bg-accent-hover text-primary font-semibold px-4 py-2 rounded-lg transition-colors">{{ __('Get Started') }}</a>
                            @endauth
                        </div>

                        <div class="flex items-center sm:hidden">
                            <button @click="open = !open" class="text-text-muted hover:text-text">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-surface border-t border-border">
                    <div class="px-4 py-3 space-y-2">
                        <a href="{{ route('explore') }}" class="block text-sm text-text-muted hover:text-text">{{ __('Explore') }}</a>
                        <a href="{{ route('pricing') }}" class="block text-sm text-text-muted hover:text-text">{{ __('Pricing') }}</a>
                        <a href="{{ route('about') }}" class="block text-sm text-text-muted hover:text-text">{{ __('About') }}</a>
                        @auth
                            <a href="{{ route('dashboard.index') }}" class="block text-sm text-accent">{{ __('Dashboard') }}</a>
                        @else
                            <a href="{{ route('login') }}" class="block text-sm text-text-muted hover:text-text">{{ __('Sign In') }}</a>
                            <a href="{{ route('register') }}" class="block text-sm text-accent">{{ __('Get Started') }}</a>
                        @endauth
                        <div class="pt-2 border-t border-border">
                            <x-language-switcher />
                        </div>
                    </div>
                </div>
            </nav>

            <main class="flex-1">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer class="bg-surface border-t border-border">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="md:col-span-2">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-accent text-xl">&#x1F56F;</span>
                                <span class="font-serif text-lg font-bold">GraveSpace</span>
                            </div>
                            <p class="text-text-muted text-sm max-w-md">{{ __('A premium virtual memorial platform. Create beautiful, lasting tributes for the people who shaped your life.') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-text mb-4">{{ __('Platform') }}</h4>
                            <ul class="space-y-2 text-sm text-text-muted">
                                <li><a href="{{ route('explore') }}" class="hover:text-text transition-colors">{{ __('Explore Memorials') }}</a></li>
                                <li><a href="{{ route('pricing') }}" class="hover:text-text transition-colors">{{ __('Pricing') }}</a></li>
                                <li><a href="{{ route('about') }}" class="hover:text-text transition-colors">{{ __('About') }}</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-text mb-4">{{ __('Account') }}</h4>
                            <ul class="space-y-2 text-sm text-text-muted">
                                @auth
                                    <li><a href="{{ route('dashboard.index') }}" class="hover:text-text transition-colors">{{ __('Dashboard') }}</a></li>
                                @else
                                    <li><a href="{{ route('login') }}" class="hover:text-text transition-colors">{{ __('Sign In') }}</a></li>
                                    <li><a href="{{ route('register') }}" class="hover:text-text transition-colors">{{ __('Create Account') }}</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-border mt-8 pt-8 text-center text-xs text-text-muted">
                        &copy; {{ date('Y') }} GraveSpace. {{ __('All rights reserved.') }}
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
