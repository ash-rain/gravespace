<x-layouts.app :title="__('Billing')">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="font-serif text-3xl font-bold text-text">{{ __('Billing & Subscription') }}</h1>
            <p class="mt-2 text-text-muted text-sm">{{ __('Manage your plan and subscription details.') }}</p>
        </div>

        {{-- Current Plan Status --}}
        <div class="bg-surface border border-border rounded-xl p-6 sm:p-8 mb-8">
            <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Current Plan') }}</h2>

            @if($user->lifetime_premium)
                {{-- Lifetime Premium --}}
                <div class="flex items-center gap-4 p-6 bg-accent/5 border border-accent/20 rounded-xl">
                    <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7 text-accent" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-accent font-serif text-xl font-bold">{{ __('Lifetime Premium') }}</h3>
                        <p class="text-text-muted text-sm mt-1">{{ __('You have lifetime access to all premium features. Thank you for your support!') }}</p>
                    </div>
                </div>

            @elseif($isPremium)
                {{-- Active Subscription --}}
                <div class="flex items-center gap-4 p-6 bg-accent/5 border border-accent/20 rounded-xl mb-6">
                    <div class="w-14 h-14 bg-accent/10 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7 text-accent" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-accent font-serif text-xl font-bold">{{ __('Premium') }}</h3>
                        <p class="text-text-muted text-sm mt-1">{{ __('You have access to all premium features.') }}</p>
                    </div>
                </div>

                {{-- Manage Subscription --}}
                <a href="{{ route('dashboard.billing.portal') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-elevated border border-border text-text font-semibold text-sm rounded-xl hover:bg-surface hover:border-accent/30 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ __('Manage Subscription') }}
                </a>

            @else
                {{-- Free Plan --}}
                <div class="flex items-center gap-4 p-6 bg-elevated border border-border rounded-xl mb-8">
                    <div class="w-14 h-14 bg-surface rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-text font-serif text-xl font-bold">{{ __('Free Plan') }}</h3>
                        <p class="text-text-muted text-sm mt-1">{{ __('You are on the free plan with limited features.') }}</p>
                    </div>
                </div>

                {{-- Upgrade Options --}}
                <h3 class="font-serif text-lg font-semibold text-text mb-6">{{ __('Upgrade to Premium') }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Monthly Plan --}}
                    <div class="bg-elevated border border-border rounded-xl p-6 hover:border-accent/30 transition-colors">
                        <div class="mb-4">
                            <h4 class="font-serif text-lg font-bold text-text">{{ __('Monthly') }}</h4>
                            <div class="flex items-baseline gap-1 mt-2">
                                <span class="text-3xl font-bold font-serif text-accent">$9</span>
                                <span class="text-text-muted text-sm">/ {{ __('month') }}</span>
                            </div>
                        </div>

                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center gap-2 text-text-muted text-sm">
                                <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Unlimited memorials') }}
                            </li>
                            <li class="flex items-center gap-2 text-text-muted text-sm">
                                <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Custom QR codes') }}
                            </li>
                            <li class="flex items-center gap-2 text-text-muted text-sm">
                                <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Custom memorial URLs') }}
                            </li>
                            <li class="flex items-center gap-2 text-text-muted text-sm">
                                <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Priority support') }}
                            </li>
                        </ul>

                        <form method="POST" action="{{ route('dashboard.checkout') }}">
                            @csrf
                            <input type="hidden" name="plan" value="monthly">
                            <button type="submit" class="w-full px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                                {{ __('Subscribe Monthly') }}
                            </button>
                        </form>
                    </div>

                    {{-- Yearly Plan --}}
                    <div class="bg-elevated border-2 border-accent/40 rounded-xl p-6 relative">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                            <span class="inline-flex items-center px-3 py-1 bg-accent text-primary text-xs font-bold rounded-full">
                                {{ __('Best Value') }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <h4 class="font-serif text-lg font-bold text-text">{{ __('Yearly') }}</h4>
                            <div class="flex items-baseline gap-1 mt-2">
                                <span class="text-3xl font-bold font-serif text-accent">$79</span>
                                <span class="text-text-muted text-sm">/ {{ __('year') }}</span>
                            </div>
                            <p class="text-accent/70 text-xs mt-1">{{ __('Save over 25% compared to monthly') }}</p>
                        </div>

                        <ul class="space-y-3 mb-6">
                            <li class="flex items-center gap-2 text-text-muted text-sm">
                                <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Everything in Monthly') }}
                            </li>
                            <li class="flex items-center gap-2 text-text-muted text-sm">
                                <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Unlimited photo storage') }}
                            </li>
                            <li class="flex items-center gap-2 text-text-muted text-sm">
                                <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Advanced analytics') }}
                            </li>
                            <li class="flex items-center gap-2 text-text-muted text-sm">
                                <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('25% savings') }}
                            </li>
                        </ul>

                        <form method="POST" action="{{ route('dashboard.checkout') }}">
                            @csrf
                            <input type="hidden" name="plan" value="yearly">
                            <button type="submit" class="w-full px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                                {{ __('Subscribe Yearly') }}
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Lifetime Option --}}
                <div class="mt-6 bg-elevated border border-border rounded-xl p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h4 class="font-serif text-lg font-bold text-text">{{ __('Lifetime Premium') }}</h4>
                            <p class="text-text-muted text-sm mt-1">{{ __('One-time payment. Access premium features forever.') }}</p>
                            <div class="flex items-baseline gap-1 mt-2">
                                <span class="text-2xl font-bold font-serif text-accent">$249</span>
                                <span class="text-text-muted text-sm">{{ __('one time') }}</span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('dashboard.checkout') }}">
                            @csrf
                            <input type="hidden" name="plan" value="lifetime">
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors shrink-0">
                                {{ __('Buy Lifetime') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        {{-- Feature Comparison (shown for all users) --}}
        <div class="bg-surface border border-border rounded-xl p-6 sm:p-8">
            <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Feature Comparison') }}</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-border">
                            <th class="text-left text-text-muted font-medium py-3 pr-4">{{ __('Feature') }}</th>
                            <th class="text-center text-text-muted font-medium py-3 px-4">{{ __('Free') }}</th>
                            <th class="text-center text-accent font-medium py-3 pl-4">{{ __('Premium') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        <tr>
                            <td class="py-3 pr-4 text-text">{{ __('Memorials') }}</td>
                            <td class="py-3 px-4 text-center text-text-muted">{{ __('1') }}</td>
                            <td class="py-3 pl-4 text-center text-accent">{{ __('Unlimited') }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4 text-text">{{ __('Photos per memorial') }}</td>
                            <td class="py-3 px-4 text-center text-text-muted">{{ __('10') }}</td>
                            <td class="py-3 pl-4 text-center text-accent">{{ __('Unlimited') }}</td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4 text-text">{{ __('Custom QR codes') }}</td>
                            <td class="py-3 px-4 text-center text-text-muted">&mdash;</td>
                            <td class="py-3 pl-4 text-center">
                                <svg class="w-5 h-5 text-accent mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4 text-text">{{ __('Custom URL slugs') }}</td>
                            <td class="py-3 px-4 text-center text-text-muted">&mdash;</td>
                            <td class="py-3 pl-4 text-center">
                                <svg class="w-5 h-5 text-accent mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3 pr-4 text-text">{{ __('Priority support') }}</td>
                            <td class="py-3 px-4 text-center text-text-muted">&mdash;</td>
                            <td class="py-3 pl-4 text-center">
                                <svg class="w-5 h-5 text-accent mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.app>
