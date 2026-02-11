<section class="space-y-6">
    <header>
        <h2 class="font-serif text-xl font-semibold text-text">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 bg-danger text-white font-semibold text-sm rounded-xl hover:bg-danger/80 transition-colors">{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('dashboard.profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="font-serif text-lg font-semibold text-text">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-text-muted">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>

                <input id="password" name="password" type="password"
                    class="w-full sm:w-3/4 px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-6 py-3 bg-elevated border border-border text-text-muted font-semibold text-sm rounded-xl hover:text-text transition-colors">
                    {{ __('Cancel') }}
                </button>

                <button type="submit"
                    class="ms-3 px-6 py-3 bg-danger text-white font-semibold text-sm rounded-xl hover:bg-danger/80 transition-colors">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
