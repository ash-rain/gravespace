<x-layouts.app :title="__('Profile')">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="font-serif text-3xl font-bold text-text">{{ __('Profile') }}</h1>
            <p class="mt-2 text-text-muted text-sm">{{ __('Manage your account settings.') }}</p>
        </div>

        <div class="space-y-8">
            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
