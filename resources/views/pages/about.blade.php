<x-layouts.public>
    <x-slot:title>{{ __('About') }} — GraveSpace</x-slot:title>
    <x-slot:description>{{ __('Learn about GraveSpace and our mission to preserve the memory of loved ones through beautiful, lasting digital memorials.') }}</x-slot:description>

    {{-- Hero --}}
    <section class="relative py-20 sm:py-28 overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(201,168,76,0.05)_0%,transparent_60%)] pointer-events-none" aria-hidden="true"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-serif text-4xl sm:text-5xl font-bold text-text">
                {{ __('Preserving Memories,') }}<br>
                <span class="text-accent">{{ __('Honoring Lives') }}</span>
            </h1>
            <p class="mt-6 text-lg text-text-muted max-w-2xl mx-auto leading-relaxed">
                {{ __('GraveSpace was created with a simple, deeply human belief: every life deserves to be remembered. We build tools that help families preserve and share the stories of those they love.') }}
            </p>
        </div>
    </section>

    {{-- Mission --}}
    <section class="py-20 sm:py-24 bg-surface/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="font-serif text-3xl font-bold text-text mb-6">
                        {{ __('Our Mission') }}
                    </h2>
                    <div class="space-y-4 text-text-muted leading-relaxed">
                        <p>
                            {{ __('In a world that moves quickly, the memories of those we have lost can fade all too fast. Old photographs are tucked away in boxes. Stories live only in the minds of those who knew them. And with each passing year, the details grow softer.') }}
                        </p>
                        <p>
                            {{ __('GraveSpace exists to change that. We provide a dignified, beautiful space where families can gather their memories in one place: photographs, life stories, timelines, and heartfelt tributes from loved ones near and far.') }}
                        </p>
                        <p>
                            {{ __('Whether it is a grandparent whose wisdom still guides you, a parent whose love shaped who you are, or a friend taken too soon, their story deserves a lasting home.') }}
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-elevated border border-border rounded-2xl p-10">
                        <blockquote class="font-serif text-xl text-text leading-relaxed italic">
                            {{ __('"Those we love don\'t go away, they walk beside us every day. Unseen, unheard, but always near; still loved, still missed, and very dear."') }}
                        </blockquote>
                        <p class="mt-4 text-sm text-text-muted">{{ __('-- Anonymous') }}</p>
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-accent/5 rounded-full blur-2xl" aria-hidden="true"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="py-20 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-serif text-3xl font-bold text-text">
                    {{ __('What We Believe') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-surface border border-border rounded-2xl p-8">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-semibold text-text mb-3">{{ __('Dignity & Respect') }}</h3>
                    <p class="text-text-muted leading-relaxed">
                        {{ __('Every memorial is treated with the reverence it deserves. Our design choices reflect the gravity and beauty of honoring a life well lived.') }}
                    </p>
                </div>

                <div class="bg-surface border border-border rounded-2xl p-8">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-semibold text-text mb-3">{{ __('Privacy & Trust') }}</h3>
                    <p class="text-text-muted leading-relaxed">
                        {{ __('Your memories are sacred. We offer robust privacy controls and never monetize your data. You decide who sees what, always.') }}
                    </p>
                </div>

                <div class="bg-surface border border-border rounded-2xl p-8">
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-semibold text-text mb-3">{{ __('Permanence') }}</h3>
                    <p class="text-text-muted leading-relaxed">
                        {{ __('Memorials are not temporary. We are committed to preserving your tributes indefinitely so future generations can connect with their heritage.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- The Team Ethos --}}
    <section class="py-20 sm:py-24 bg-surface/50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="font-serif text-3xl font-bold text-text mb-6">
                    {{ __('Built With Care') }}
                </h2>
                <div class="space-y-4 text-text-muted leading-relaxed max-w-2xl mx-auto">
                    <p>
                        {{ __('GraveSpace is built by a small, dedicated team that understands the weight of loss and the importance of remembrance. We have personally experienced the comfort that comes from having a place to revisit cherished memories.') }}
                    </p>
                    <p>
                        {{ __('Every feature we build, every design decision we make, is guided by empathy and a deep respect for the families who trust us with their most precious memories.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative py-20 sm:py-28 overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom,rgba(201,168,76,0.06)_0%,transparent_60%)] pointer-events-none" aria-hidden="true"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-text">
                {{ __('Honor Someone You Love') }}
            </h2>
            <p class="mt-4 text-lg text-text-muted max-w-xl mx-auto">
                {{ __('Create a free memorial and begin preserving the memories that matter most.') }}
            </p>
            <div class="mt-8">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-all duration-200 shadow-lg shadow-accent/20">
                    {{ __('Get Started Free') }}
                </a>
            </div>
        </div>
    </section>
</x-layouts.public>
