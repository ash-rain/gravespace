<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Access Denied — GraveSpace</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-primary text-text">
        <div class="min-h-screen flex flex-col">
            {{-- Header --}}
            <header class="bg-surface/80 backdrop-blur-md border-b border-border">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center h-16">
                        <a href="/" class="flex items-center gap-2">
                            <span class="text-accent text-2xl">&#x1F56F;</span>
                            <span class="font-serif text-xl font-bold text-text">GraveSpace</span>
                        </a>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-lg mx-auto animate-fade-in">
                    {{-- Lock icon --}}
                    <div class="mb-8">
                        <span class="text-7xl sm:text-8xl leading-none inline-block">&#x1F512;</span>
                    </div>

                    {{-- Error code --}}
                    <p class="text-accent font-semibold text-sm tracking-widest uppercase mb-3">Error 403</p>

                    {{-- Heading --}}
                    <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-text mb-4">
                        Access Denied
                    </h1>

                    {{-- Message --}}
                    <p class="text-text-muted text-lg leading-relaxed mb-10 max-w-md mx-auto">
                        You don't have permission to view this page.
                    </p>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="javascript:history.back()"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-text bg-surface hover:bg-elevated border border-border rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Go Back
                        </a>
                        <a href="/"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-all duration-200 shadow-lg shadow-accent/20 hover:shadow-accent/30">
                            Return Home
                        </a>
                    </div>
                </div>
            </main>

            {{-- Footer --}}
            <footer class="border-t border-border py-6">
                <div class="text-center text-xs text-text-muted">
                    &copy; {{ date('Y') }} GraveSpace. All rights reserved.
                </div>
            </footer>
        </div>
    </body>
</html>
