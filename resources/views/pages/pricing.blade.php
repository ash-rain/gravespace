<x-layouts.public>
    <x-slot:title>{{ __('Pricing') }} — GraveSpace</x-slot:title>
    <x-slot:description>{{ __('Choose the right plan for your memorial. Start free or go premium for unlimited features.') }}</x-slot:description>

    {{-- Page Header --}}
    <section class="py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="font-serif text-4xl sm:text-5xl font-bold text-text">
                    {{ __('Simple, Honest') }} <span class="text-accent">{{ __('Pricing') }}</span>
                </h1>
                <p class="mt-4 text-lg text-text-muted">
                    {{ __('Start for free. Upgrade when you need more. No hidden fees, no surprises.') }}
                </p>
            </div>

            {{-- Pricing Toggle --}}
            <div class="flex items-center justify-center gap-3 mt-10" x-data="{ annual: false }">
                <span class="text-sm" :class="annual ? 'text-text-muted' : 'text-text font-medium'">{{ __('Monthly') }}</span>
                <button @click="annual = !annual; $dispatch('pricing-toggle', annual)" class="relative w-12 h-6 bg-elevated border border-border rounded-full transition-colors" :class="annual && 'bg-accent/20 border-accent/30'">
                    <span class="absolute top-0.5 left-0.5 w-5 h-5 bg-text rounded-full transition-transform duration-200" :class="annual && 'translate-x-6'"></span>
                </button>
                <span class="text-sm" :class="annual ? 'text-text font-medium' : 'text-text-muted'">{{ __('One-time') }}</span>
            </div>

            {{-- Pricing Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 max-w-6xl mx-auto">

                {{-- Free Tier --}}
                <div class="bg-surface/80 backdrop-blur-sm border border-border rounded-2xl p-8 flex flex-col">
                    <div class="mb-6">
                        <h3 class="font-serif text-xl font-semibold text-text">{{ __('Starter') }}</h3>
                        <p class="text-sm text-text-muted mt-1">{{ __('Perfect for a single tribute') }}</p>
                    </div>
                    <div class="mb-8">
                        <span class="font-serif text-4xl font-bold text-text">{{ __('Free') }}</span>
                        <span class="text-text-muted text-sm ml-1">{{ __('forever') }}</span>
                    </div>
                    <ul class="space-y-3 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('1 memorial page') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Up to 5 photos') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Basic obituary editor') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Public guest book') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Virtual candles & flowers') }}
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full text-center px-6 py-3 text-sm font-semibold text-text bg-elevated hover:bg-border/50 border border-border rounded-lg transition-colors duration-200">
                        {{ __('Get Started Free') }}
                    </a>
                </div>

                {{-- Premium Tier (Highlighted) --}}
                <div class="relative bg-surface/80 backdrop-blur-sm border-2 border-accent rounded-2xl p-8 flex flex-col shadow-lg shadow-accent/10" x-data="{ annual: false }" @pricing-toggle.window="annual = $event.detail">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2">
                        <span class="bg-accent text-primary text-xs font-bold px-4 py-1 rounded-full uppercase tracking-wide">{{ __('Most Popular') }}</span>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-serif text-xl font-semibold text-accent">{{ __('Premium') }}</h3>
                        <p class="text-sm text-text-muted mt-1">{{ __('For families who want more') }}</p>
                    </div>
                    <div class="mb-8">
                        <div x-show="!annual">
                            <span class="font-serif text-4xl font-bold text-text">$7.99</span>
                            <span class="text-text-muted text-sm ml-1">/ {{ __('month') }}</span>
                        </div>
                        <div x-show="annual" x-cloak>
                            <span class="font-serif text-4xl font-bold text-text">$79</span>
                            <span class="text-text-muted text-sm ml-1">{{ __('one-time') }}</span>
                        </div>
                    </div>
                    <ul class="space-y-3 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>{{ __('Unlimited') }}</strong> {{ __('memorial pages') }}</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>{{ __('Unlimited') }}</strong> {{ __('photos & videos') }}</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Life timeline feature') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Privacy controls & password protection') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Printable QR codes for gravestones') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Custom memorial slug / URL') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Family tree & relationship links') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Voice memories & audio tributes') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Beautiful memorial themes') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Export memorial as PDF keepsake') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Priority support') }}
                        </li>
                    </ul>
                    @auth
                        <form method="POST" action="{{ route('dashboard.checkout') }}">
                            @csrf
                            <input type="hidden" name="plan" :value="annual ? 'lifetime' : 'monthly'">
                            <button type="submit" class="block w-full text-center px-6 py-3 text-sm font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-colors duration-200 shadow-lg shadow-accent/20">
                                {{ __('Upgrade to Premium') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="block w-full text-center px-6 py-3 text-sm font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-colors duration-200 shadow-lg shadow-accent/20">
                            {{ __('Get Started with Premium') }}
                        </a>
                    @endauth
                </div>

                {{-- Concierge Tier --}}
                <div class="bg-surface/80 backdrop-blur-sm border border-border rounded-2xl p-8 flex flex-col">
                    <div class="mb-6">
                        <h3 class="font-serif text-xl font-semibold text-text">{{ __('Concierge') }}</h3>
                        <p class="text-sm text-text-muted mt-1">{{ __('We handle everything for you') }}</p>
                    </div>
                    <div class="mb-8">
                        <span class="font-serif text-4xl font-bold text-text">$299</span>
                        <span class="text-text-muted text-sm ml-1">{{ __('one-time') }}</span>
                    </div>
                    <ul class="space-y-3 mb-8 flex-1">
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong class="text-text">{{ __('Everything in Premium') }}</strong></span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Professional memorial setup') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Photo scanning & digitization') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Obituary writing assistance') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Timeline curation by our team') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Engraved QR plaque shipped to you') }}
                        </li>
                        <li class="flex items-start gap-3 text-sm text-text-muted">
                            <svg class="w-5 h-5 text-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ __('Dedicated support representative') }}
                        </li>
                    </ul>
                    @auth
                        <form method="POST" action="{{ route('dashboard.checkout') }}">
                            @csrf
                            <input type="hidden" name="plan" value="concierge">
                            <button type="submit" class="block w-full text-center px-6 py-3 text-sm font-semibold text-text bg-elevated hover:bg-border/50 border border-border rounded-lg transition-colors duration-200">
                                {{ __('Choose Concierge') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="block w-full text-center px-6 py-3 text-sm font-semibold text-text bg-elevated hover:bg-border/50 border border-border rounded-lg transition-colors duration-200">
                            {{ __('Choose Concierge') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-24 sm:py-32 bg-surface/50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-serif text-3xl font-bold text-text text-center mb-12">
                {{ __('Frequently Asked Questions') }}
            </h2>
            <div class="space-y-4" x-data="{ open: null }">
                <div class="border border-border rounded-xl">
                    <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between px-6 py-4 text-left">
                        <span class="text-sm font-medium text-text">{{ __('How long are memorials preserved?') }}</span>
                        <svg class="w-5 h-5 text-text-muted transition-transform" :class="open === 1 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === 1" x-collapse x-cloak class="px-6 pb-4">
                        <p class="text-sm text-text-muted">{{ __('All memorials are preserved indefinitely. Whether you are on a free or paid plan, we are committed to keeping your loved one\'s memorial accessible forever.') }}</p>
                    </div>
                </div>
                <div class="border border-border rounded-xl">
                    <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between px-6 py-4 text-left">
                        <span class="text-sm font-medium text-text">{{ __('Can I upgrade from Free to Premium later?') }}</span>
                        <svg class="w-5 h-5 text-text-muted transition-transform" :class="open === 2 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === 2" x-collapse x-cloak class="px-6 pb-4">
                        <p class="text-sm text-text-muted">{{ __('Absolutely. You can upgrade at any time from your dashboard. All your existing memorial content will be preserved and you will instantly unlock all premium features.') }}</p>
                    </div>
                </div>
                <div class="border border-border rounded-xl">
                    <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between px-6 py-4 text-left">
                        <span class="text-sm font-medium text-text">{{ __('What is the QR code for gravestones?') }}</span>
                        <svg class="w-5 h-5 text-text-muted transition-transform" :class="open === 3 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === 3" x-collapse x-cloak class="px-6 pb-4">
                        <p class="text-sm text-text-muted">{{ __('Premium members can generate a unique QR code that links to the memorial page. Print it, engrave it on a plaque, or attach it to a headstone so visitors can scan it with their phone.') }}</p>
                    </div>
                </div>
                <div class="border border-border rounded-xl">
                    <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between px-6 py-4 text-left">
                        <span class="text-sm font-medium text-text">{{ __('Is my payment secure?') }}</span>
                        <svg class="w-5 h-5 text-text-muted transition-transform" :class="open === 4 && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open === 4" x-collapse x-cloak class="px-6 pb-4">
                        <p class="text-sm text-text-muted">{{ __('All payments are processed securely through Stripe. We never store your credit card information on our servers.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Flash error for redirect from memorial creation limit --}}
    @if(session('error'))
        <div class="fixed bottom-6 right-6 z-50 bg-elevated border border-accent/50 text-text px-6 py-4 rounded-xl shadow-2xl max-w-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition>
            <div class="flex items-start gap-3">
                <span class="text-accent text-lg">&#x1F56F;</span>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif
</x-layouts.public>
