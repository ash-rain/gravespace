<x-layouts.guest>
    <h2 class="font-serif text-2xl font-bold text-text text-center mb-6">{{ __('Create Account') }}</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-text-muted mb-2">{{ __('Name') }}</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
            @error('name')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email Address --}}
        <div class="mt-4">
            <label for="email" class="block text-sm font-medium text-text-muted mb-2">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
            @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-text-muted mb-2">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
            @error('password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-medium text-text-muted mb-2">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <div class="mt-6">
            <button type="submit" class="w-full px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                {{ __('Create Account') }}
            </button>
        </div>

        {{-- Login Link --}}
        <div class="mt-6 text-center">
            <span class="text-sm text-text-muted">{{ __('Already have an account?') }}</span>
            <a href="{{ route('login') }}" class="text-sm text-accent hover:text-accent/80 font-medium transition-colors ms-1">
                {{ __('Log in') }}
            </a>
        </div>
    </form>
</x-layouts.guest>
