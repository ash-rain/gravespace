<x-layouts.public>
    <x-slot:title>{{ __('GraveSpace — Honor Those Who Matter') }}</x-slot:title>
    <x-slot:description>{{ __('Create beautiful, lasting memorial pages for your loved ones. A premium virtual memorial platform for preserving memories forever.') }}</x-slot:description>

    {{-- Hero Section --}}
    <section class="relative overflow-hidden">
        {{-- Radial gold glow effect --}}
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none" aria-hidden="true">
            <div class="w-[800px] h-[800px] rounded-full bg-accent/[0.07] blur-[120px]"></div>
        </div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(201,168,76,0.08)_0%,transparent_70%)] pointer-events-none" aria-hidden="true"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32 lg:py-40">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="font-serif text-4xl sm:text-5xl lg:text-7xl font-bold text-text leading-tight tracking-tight">
                    {{ __('Honor Those') }}<br>
                    <span class="text-accent">{{ __('Who Matter') }}</span>
                </h1>
                <p class="mt-6 sm:mt-8 text-lg sm:text-xl text-text-muted max-w-2xl mx-auto leading-relaxed">
                    {{ __('Create beautiful, lasting memorial pages for the people who shaped your life. Share memories, light candles, and keep their legacy alive forever.') }}
                </p>
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-all duration-200 shadow-lg shadow-accent/20 hover:shadow-accent/30">
                        {{ __('Get Started Free') }}
                    </a>
                    <a href="{{ route('explore') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-text bg-surface hover:bg-elevated border border-border rounded-lg transition-all duration-200">
                        {{ __('Explore Memorials') }}
                    </a>
                </div>
                <p class="mt-4 text-sm text-text-muted">
                    {{ __('No credit card required. Create your first memorial in minutes.') }}
                </p>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="relative py-24 sm:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-text">
                    {{ __('A Lasting Tribute') }}
                </h2>
                <p class="mt-4 text-lg text-text-muted">
                    {{ __('Everything you need to create a meaningful and beautiful memorial.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-surface border border-border rounded-2xl p-8 hover:border-accent/30 transition-colors duration-300">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-semibold text-text mb-3">
                        {{ __('Beautiful Memorials') }}
                    </h3>
                    <p class="text-text-muted leading-relaxed">
                        {{ __('Create stunning memorial pages with photos, timelines, and rich obituaries. Every detail is presented with elegance and care.') }}
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-surface border border-border rounded-2xl p-8 hover:border-accent/30 transition-colors duration-300">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-semibold text-text mb-3">
                        {{ __('Share & Remember') }}
                    </h3>
                    <p class="text-text-muted leading-relaxed">
                        {{ __('Invite family and friends to contribute memories, photos, and heartfelt tributes. Light virtual candles and leave flowers.') }}
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-surface border border-border rounded-2xl p-8 hover:border-accent/30 transition-colors duration-300">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-semibold text-text mb-3">
                        {{ __('Forever Preserved') }}
                    </h3>
                    <p class="text-text-muted leading-relaxed">
                        {{ __('Memorials are preserved indefinitely with secure cloud storage. Generate QR codes for gravestones to connect physical and digital tributes.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-24 sm:py-32 bg-surface/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-text">
                    {{ __('How It Works') }}
                </h2>
                <p class="mt-4 text-lg text-text-muted">
                    {{ __('Create a memorial in just a few steps.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="w-16 h-16 bg-accent/10 border border-accent/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="font-serif text-2xl font-bold text-accent">1</span>
                    </div>
                    <h3 class="font-serif text-lg font-semibold text-text mb-2">{{ __('Create an Account') }}</h3>
                    <p class="text-text-muted">{{ __('Sign up for free and start building your memorial page in minutes.') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-accent/10 border border-accent/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="font-serif text-2xl font-bold text-accent">2</span>
                    </div>
                    <h3 class="font-serif text-lg font-semibold text-text mb-2">{{ __('Tell Their Story') }}</h3>
                    <p class="text-text-muted">{{ __('Add photos, write an obituary, create a timeline of their life milestones.') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-accent/10 border border-accent/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="font-serif text-2xl font-bold text-accent">3</span>
                    </div>
                    <h3 class="font-serif text-lg font-semibold text-text mb-2">{{ __('Share With Loved Ones') }}</h3>
                    <p class="text-text-muted">{{ __('Share the memorial link or QR code. Visitors can leave tributes and light candles.') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Social Proof / Stats Section --}}
    <section class="py-24 sm:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-surface border border-border rounded-3xl p-12 sm:p-16 text-center">
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-text mb-4">
                    {{ __('Trusted by Families Worldwide') }}
                </h2>
                <p class="text-lg text-text-muted max-w-2xl mx-auto mb-12">
                    {{ __('Thousands of families have chosen GraveSpace to honor and preserve the memory of their loved ones.') }}
                </p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <div class="font-serif text-3xl sm:text-4xl font-bold text-accent">5,000+</div>
                        <div class="mt-2 text-sm text-text-muted">{{ __('Memorials Created') }}</div>
                    </div>
                    <div>
                        <div class="font-serif text-3xl sm:text-4xl font-bold text-accent">50,000+</div>
                        <div class="mt-2 text-sm text-text-muted">{{ __('Candles Lit') }}</div>
                    </div>
                    <div>
                        <div class="font-serif text-3xl sm:text-4xl font-bold text-accent">25,000+</div>
                        <div class="mt-2 text-sm text-text-muted">{{ __('Tributes Written') }}</div>
                    </div>
                    <div>
                        <div class="font-serif text-3xl sm:text-4xl font-bold text-accent">100,000+</div>
                        <div class="mt-2 text-sm text-text-muted">{{ __('Photos Preserved') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Bottom CTA --}}
    <section class="relative py-24 sm:py-32 overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom,rgba(201,168,76,0.06)_0%,transparent_60%)] pointer-events-none" aria-hidden="true"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-text">
                {{ __('Every Life Deserves') }}<br>
                <span class="text-accent">{{ __('To Be Remembered') }}</span>
            </h2>
            <p class="mt-6 text-lg text-text-muted max-w-2xl mx-auto">
                {{ __('Start preserving precious memories today. Create a free memorial and give your loved one the tribute they deserve.') }}
            </p>
            <div class="mt-10">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-10 py-4 text-lg font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-all duration-200 shadow-lg shadow-accent/20 hover:shadow-accent/30">
                    {{ __('Create a Free Memorial') }}
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>
