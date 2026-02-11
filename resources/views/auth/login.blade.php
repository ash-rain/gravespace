<x-layouts.guest>
    {{-- Session Status --}}
    @if(session('status'))
        <div class="mb-4 text-sm text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <h2 class="font-serif text-2xl font-bold text-text text-center mb-6">{{ __('Welcome Back') }}</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email Address --}}
        <div>
            <label for="email" class="block text-sm font-medium text-text-muted mb-2">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
            @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-text-muted mb-2">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
            @error('password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-border bg-elevated text-accent focus:ring-accent focus:ring-offset-0">
                <span class="ms-2 text-sm text-text-muted">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-text-muted hover:text-accent transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <div class="mt-6">
            <button type="submit" class="w-full px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                {{ __('Log in') }}
            </button>
        </div>

        {{-- Register Link --}}
        <div class="mt-6 text-center">
            <span class="text-sm text-text-muted">{{ __("Don't have an account?") }}</span>
            <a href="{{ route('register') }}" class="text-sm text-accent hover:text-accent/80 font-medium transition-colors ms-1">
                {{ __('Create one') }}
            </a>
        </div>
    </form>
</x-layouts.guest>
