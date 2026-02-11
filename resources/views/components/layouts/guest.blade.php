<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GraveSpace') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-primary text-text">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md flex items-center justify-between px-6 sm:px-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-accent text-3xl">&#x1F56F;</span>
                    <span class="font-serif text-2xl font-bold text-text">GraveSpace</span>
                </a>
                <x-language-switcher />
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-surface border border-border shadow-xl overflow-hidden sm:rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
