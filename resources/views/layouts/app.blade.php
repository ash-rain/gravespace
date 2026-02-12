<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'GraveSpace') }} — GraveSpace</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700,800&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-primary text-text">
    <div class="min-h-screen flex flex-col">
        {{-- Navigation --}}
        <nav class="bg-surface border-b border-border" x-data="{ open: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-2">
                            <span class="text-accent text-2xl">&#x1F56F;</span>
                            <span class="font-serif text-xl font-bold text-text">GraveSpace</span>
                        </a>

                        <div class="hidden sm:flex sm:ml-10 sm:gap-8">
                            <a href="{{ route('dashboard.index') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('dashboard.index') ? 'text-accent border-b-2 border-accent' : 'text-text-muted hover:text-text' }}">
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('dashboard.memorials.index') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('dashboard.memorials.*') ? 'text-accent border-b-2 border-accent' : 'text-text-muted hover:text-text' }}">
                                {{ __('Memorials') }}
                            </a>
                            <a href="{{ route('dashboard.moderation') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('dashboard.moderation') ? 'text-accent border-b-2 border-accent' : 'text-text-muted hover:text-text' }}">
                                {{ __('Moderation') }}
                            </a>
                            <a href="{{ route('dashboard.billing') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('dashboard.billing*') ? 'text-accent border-b-2 border-accent' : 'text-text-muted hover:text-text' }}">
                                {{ __('Billing') }}
                            </a>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:gap-4">
                        <a href="{{ route('explore') }}"
                            class="text-sm text-text-muted hover:text-text">{{ __('Explore') }}</a>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-2 text-sm text-text-muted hover:text-text">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-48 bg-elevated border border-border rounded-lg shadow-xl z-50">
                                @if (Auth::user()->isAdmin())
                                    <a href="{{ url('/admin') }}"
                                        class="block px-4 py-2 text-sm text-accent hover:text-accent-hover hover:bg-surface">{{ __('Admin Panel') }}</a>
                                @endif
                                <a href="{{ route('dashboard.profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-text-muted hover:text-text hover:bg-surface">{{ __('Profile') }}</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-text-muted hover:text-text hover:bg-surface">{{ __('Log Out') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile hamburger --}}
                    <div class="flex items-center sm:hidden">
                        <button @click="open = !open" class="text-text-muted hover:text-text">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile nav --}}
            <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-surface border-t border-border">
                <div class="px-4 py-3 space-y-2">
                    <a href="{{ route('dashboard.index') }}"
                        class="block text-sm text-text-muted hover:text-text">{{ __('Dashboard') }}</a>
                    <a href="{{ route('dashboard.memorials.index') }}"
                        class="block text-sm text-text-muted hover:text-text">{{ __('Memorials') }}</a>
                    <a href="{{ route('dashboard.moderation') }}"
                        class="block text-sm text-text-muted hover:text-text">{{ __('Moderation') }}</a>
                    <a href="{{ route('dashboard.billing') }}"
                        class="block text-sm text-text-muted hover:text-text">{{ __('Billing') }}</a>
                    <a href="{{ route('dashboard.profile.edit') }}"
                        class="block text-sm text-text-muted hover:text-text">{{ __('Profile') }}</a>
                    @if (Auth::user()->isAdmin())
                        <a href="{{ url('/admin') }}"
                            class="block text-sm text-accent hover:text-accent-hover">{{ __('Admin Panel') }}</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block text-sm text-text-muted hover:text-text">{{ __('Log Out') }}</button>
                    </form>
                </div>
            </div>
        </nav>

        @isset($header)
            <header class="bg-surface border-b border-border">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-success/10 border border-success/30 text-success px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-danger/10 border border-danger/30 text-danger px-4 py-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>

</html>
