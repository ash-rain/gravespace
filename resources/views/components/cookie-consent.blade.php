{{-- GDPR Cookie Consent Banner --}}
<div
    x-data="{ show: !localStorage.getItem('cookie_consent') }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-0 inset-x-0 z-50 p-4 sm:p-6"
    x-cloak
>
    <div class="max-w-4xl mx-auto bg-surface border border-border rounded-2xl p-4 sm:p-6 shadow-2xl">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="flex-1">
                <p class="text-sm text-text-muted">
                    {{ __('We use cookies to enhance your experience. By continuing to visit this site, you agree to our use of cookies.') }}
                    <a href="#" class="text-accent hover:text-accent-hover underline">{{ __('Learn more') }}</a>
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <button
                    @click="localStorage.setItem('cookie_consent', 'declined'); show = false"
                    class="px-4 py-2 text-sm text-text-muted hover:text-text border border-border rounded-lg transition-colors"
                >
                    {{ __('Decline') }}
                </button>
                <button
                    @click="localStorage.setItem('cookie_consent', 'accepted'); show = false"
                    class="px-4 py-2 text-sm font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-colors"
                >
                    {{ __('Accept') }}
                </button>
            </div>
        </div>
    </div>
</div>
