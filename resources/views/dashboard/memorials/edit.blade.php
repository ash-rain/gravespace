<x-layouts.app :title="__('Edit Memorial') . ' — ' . $memorial->fullName()">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <a href="{{ route('dashboard.memorials.index') }}"
                    class="inline-flex items-center gap-1 text-text-muted hover:text-accent text-sm transition-colors mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ __('Back to Memorials') }}
                </a>
                <h1 class="font-serif text-3xl font-bold text-text">{{ __('Edit Memorial') }}</h1>
                <p class="mt-2 text-text-muted text-sm">{{ $memorial->fullName() }}</p>
            </div>
            <div class="flex items-center gap-3">
                @if ($memorial->is_published)
                    <a href="{{ route('memorial.show', $memorial) }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-elevated border border-border text-text-muted text-sm font-medium rounded-xl hover:text-text transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        {{ __('View Memorial') }}
                    </a>
                @endif
            </div>
        </div>

        {{-- Validation Errors Summary --}}
        @if ($errors->any())
            <div class="mb-8 bg-red-500/10 border border-red-500/30 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-red-400 font-semibold text-sm">{{ __('Please correct the following errors:') }}</h3>
                </div>
                <ul class="list-disc list-inside text-red-400/80 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.memorials.update', $memorial) }}" enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Personal Information --}}
            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Personal Information') }}</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- First Name --}}
                    <div>
                        <label for="first_name"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('First Name') }} <span
                                class="text-red-400">*</span></label>
                        <input type="text" name="first_name" id="first_name"
                            value="{{ old('first_name', $memorial->first_name) }}" required
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
                        @error('first_name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label for="last_name"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Last Name') }} <span
                                class="text-red-400">*</span></label>
                        <input type="text" name="last_name" id="last_name"
                            value="{{ old('last_name', $memorial->last_name) }}" required
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
                        @error('last_name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Maiden Name --}}
                    <div>
                        <label for="maiden_name"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Maiden Name') }}</label>
                        <input type="text" name="maiden_name" id="maiden_name"
                            value="{{ old('maiden_name', $memorial->maiden_name) }}"
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
                        @error('maiden_name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="hidden sm:block"></div>

                    {{-- Date of Birth --}}
                    <div>
                        <label for="date_of_birth"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Date of Birth') }} <span
                                class="text-red-400">*</span></label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            value="{{ old('date_of_birth', $memorial->date_of_birth?->format('Y-m-d')) }}" required
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors [color-scheme:dark]">
                        @error('date_of_birth')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date of Death --}}
                    <div>
                        <label for="date_of_death"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Date of Death') }} <span
                                class="text-red-400">*</span></label>
                        <input type="date" name="date_of_death" id="date_of_death"
                            value="{{ old('date_of_death', $memorial->date_of_death?->format('Y-m-d')) }}" required
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors [color-scheme:dark]">
                        @error('date_of_death')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Place of Birth --}}
                    <div>
                        <label for="place_of_birth"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Place of Birth') }}</label>
                        <input type="text" name="place_of_birth" id="place_of_birth"
                            value="{{ old('place_of_birth', $memorial->place_of_birth) }}"
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                            placeholder="{{ __('City, State, Country') }}">
                        @error('place_of_birth')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Place of Death --}}
                    <div>
                        <label for="place_of_death"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Place of Death') }}</label>
                        <input type="text" name="place_of_death" id="place_of_death"
                            value="{{ old('place_of_death', $memorial->place_of_death) }}"
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                            placeholder="{{ __('City, State, Country') }}">
                        @error('place_of_death')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Obituary --}}
            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Obituary') }}</h2>

                <div>
                    <label for="obituary"
                        class="block text-sm font-medium text-text-muted mb-2">{{ __('Life Story & Obituary') }}</label>
                    <textarea name="obituary" id="obituary" rows="10"
                        class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors resize-y"
                        placeholder="{{ __('Share the story of their life...') }}">{{ old('obituary', $memorial->obituary) }}</textarea>
                    @error('obituary')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Photos --}}
            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Photos') }}</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Cover Photo --}}
                    <div>
                        <label for="cover_photo"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Cover Photo') }}</label>
                        @if ($memorial->cover_photo)
                            <div class="mb-3 relative rounded-xl overflow-hidden">
                                <img src="{{ Storage::url($memorial->cover_photo) }}"
                                    alt="{{ __('Current cover photo') }}"
                                    class="w-full h-32 object-cover rounded-xl">
                                <span
                                    class="absolute bottom-2 left-2 text-xs bg-primary/80 text-text-muted px-2 py-1 rounded-lg">{{ __('Current') }}</span>
                            </div>
                        @endif
                        <input type="file" name="cover_photo" id="cover_photo" accept="image/*"
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent/10 file:text-accent hover:file:bg-accent/20 focus:outline-none focus:border-accent transition-colors">
                        <p class="mt-2 text-xs text-text-muted">
                            {{ __('Upload a new image to replace the current one.') }}</p>
                        @error('cover_photo')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Profile Photo --}}
                    <div>
                        <label for="profile_photo"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Profile Photo') }}</label>
                        @if ($memorial->profile_photo)
                            <div class="mb-3 relative">
                                <img src="{{ Storage::url($memorial->profile_photo) }}"
                                    alt="{{ __('Current profile photo') }}"
                                    class="w-24 h-24 object-cover rounded-xl">
                                <span
                                    class="absolute bottom-1 left-1 text-xs bg-primary/80 text-text-muted px-2 py-0.5 rounded-lg">{{ __('Current') }}</span>
                            </div>
                        @endif
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent/10 file:text-accent hover:file:bg-accent/20 focus:outline-none focus:border-accent transition-colors">
                        <p class="mt-2 text-xs text-text-muted">
                            {{ __('Upload a new image to replace the current one.') }}</p>
                        @error('profile_photo')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Privacy Settings --}}
            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8" x-data="{ privacy: '{{ old('privacy', $memorial->privacy ?? 'public') }}' }">
                <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Privacy Settings') }}</h2>

                <div class="space-y-4">
                    <label
                        class="flex items-start gap-4 p-4 bg-elevated border border-border rounded-xl cursor-pointer hover:border-accent/30 transition-colors"
                        :class="{ 'border-accent/50 bg-accent/5': privacy === 'public' }">
                        <input type="radio" name="privacy" value="public" x-model="privacy"
                            class="mt-1 text-accent bg-elevated border-border focus:ring-accent focus:ring-offset-0">
                        <div>
                            <p class="text-text font-medium text-sm">{{ __('Public') }}</p>
                            <p class="text-text-muted text-xs mt-1">
                                {{ __('Anyone with the link can view this memorial.') }}</p>
                        </div>
                    </label>

                    <label
                        class="flex items-start gap-4 p-4 bg-elevated border border-border rounded-xl cursor-pointer hover:border-accent/30 transition-colors"
                        :class="{ 'border-accent/50 bg-accent/5': privacy === 'password' }">
                        <input type="radio" name="privacy" value="password" x-model="privacy"
                            class="mt-1 text-accent bg-elevated border-border focus:ring-accent focus:ring-offset-0">
                        <div>
                            <p class="text-text font-medium text-sm">{{ __('Password Protected') }}</p>
                            <p class="text-text-muted text-xs mt-1">
                                {{ __('Visitors must enter a password to view this memorial.') }}</p>
                        </div>
                    </label>

                    <label
                        class="flex items-start gap-4 p-4 bg-elevated border border-border rounded-xl cursor-pointer hover:border-accent/30 transition-colors"
                        :class="{ 'border-accent/50 bg-accent/5': privacy === 'invite_only' }">
                        <input type="radio" name="privacy" value="invite_only" x-model="privacy"
                            class="mt-1 text-accent bg-elevated border-border focus:ring-accent focus:ring-offset-0">
                        <div>
                            <p class="text-text font-medium text-sm">{{ __('Invite Only') }}</p>
                            <p class="text-text-muted text-xs mt-1">
                                {{ __('Only people you invite can view this memorial.') }}</p>
                        </div>
                    </label>

                    <div x-show="privacy === 'password'" x-transition class="ml-8">
                        <label for="memorial_password"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Memorial Password') }}</label>
                        <input type="text" name="memorial_password" id="memorial_password"
                            value="{{ old('memorial_password') }}"
                            class="w-full max-w-sm px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                            placeholder="{{ __('Enter a new password (leave empty to keep current)') }}">
                        @error('memorial_password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Location --}}
            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Cemetery / Resting Place') }}</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <label for="cemetery_name"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Cemetery Name') }}</label>
                        <input type="text" name="cemetery_name" id="cemetery_name"
                            value="{{ old('cemetery_name', $memorial->cemetery_name) }}"
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                            placeholder="{{ __('e.g., Greenwood Memorial Park') }}">
                        @error('cemetery_name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="cemetery_address"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Cemetery Address') }}</label>
                        <input type="text" name="cemetery_address" id="cemetery_address"
                            value="{{ old('cemetery_address', $memorial->cemetery_address) }}"
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                            placeholder="{{ __('Full address') }}">
                        @error('cemetery_address')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="latitude"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Latitude') }}</label>
                        <input type="number" step="any" name="latitude" id="latitude"
                            value="{{ old('latitude', $memorial->latitude) }}"
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                            placeholder="{{ __('e.g., 40.7128') }}">
                        @error('latitude')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="longitude"
                            class="block text-sm font-medium text-text-muted mb-2">{{ __('Longitude') }}</label>
                        <input type="number" step="any" name="longitude" id="longitude"
                            value="{{ old('longitude', $memorial->longitude) }}"
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                            placeholder="{{ __('e.g., -74.0060') }}">
                        @error('longitude')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Publish Toggle & Custom Slug --}}
            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Publishing') }}</h2>

                <div class="space-y-6">
                    {{-- Publish Toggle --}}
                    <div class="flex items-center justify-between" x-data="{ published: {{ $memorial->is_published ? 'true' : 'false' }} }">
                        <div>
                            <p class="text-text font-medium text-sm">{{ __('Published') }}</p>
                            <p class="text-text-muted text-xs mt-1">
                                {{ __('Make this memorial visible to the public.') }}</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" name="is_published" value="1" x-model="published"
                                class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-elevated border border-border rounded-full peer peer-checked:bg-accent/20 peer-checked:border-accent after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-text-muted after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full peer-checked:after:bg-accent">
                            </div>
                        </label>
                    </div>

                    {{-- Custom Slug (Premium Only) --}}
                    <div>
                        <label for="slug" class="block text-sm font-medium text-text-muted mb-2">
                            {{ __('Custom URL Slug') }}
                            @if (!Auth::user()->isPremium())
                                <span
                                    class="inline-flex items-center ml-2 px-2 py-0.5 bg-accent/10 text-accent text-xs rounded-lg">{{ __('Premium') }}</span>
                            @endif
                        </label>
                        <div class="flex items-center gap-2">
                            <span class="text-text-muted text-sm shrink-0">{{ url('/') }}/</span>
                            <input type="text" name="slug" id="slug"
                                value="{{ old('slug', $memorial->slug) }}"
                                {{ !Auth::user()->isPremium() ? 'disabled' : '' }}
                                class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                placeholder="{{ __('custom-memorial-url') }}">
                        </div>
                        @error('slug')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        @if (!Auth::user()->isPremium())
                            <p class="mt-2 text-xs text-text-muted">
                                {{ __('Upgrade to Premium to customize your memorial URL.') }}</p>
                        @endif
                    </div>

                    {{-- Generate QR Code (Premium Only) --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-text font-medium text-sm">
                                {{ __('QR Code') }}
                                @if (!Auth::user()->isPremium())
                                    <span
                                        class="inline-flex items-center ml-2 px-2 py-0.5 bg-accent/10 text-accent text-xs rounded-lg">{{ __('Premium') }}</span>
                                @endif
                            </p>
                            <p class="text-text-muted text-xs mt-1">
                                {{ __('Generate a QR code that links directly to this memorial.') }}</p>
                        </div>
                        @if (Auth::user()->isPremium())
                            <a href="{{ route('dashboard.memorials.qr', $memorial) }}"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-elevated border border-border text-text-muted text-sm font-medium rounded-xl hover:text-accent hover:border-accent/30 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                                {{ __('Generate QR Code') }}
                            </a>
                        @else
                            <a href="{{ route('dashboard.billing') }}"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-elevated border border-border text-text-muted text-sm font-medium rounded-xl opacity-60 hover:opacity-100 transition-opacity">
                                {{ __('Upgrade') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('dashboard.memorials.index') }}"
                    class="px-6 py-3 bg-elevated border border-border text-text-muted font-medium text-sm rounded-xl hover:text-text transition-colors">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                    class="px-8 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>

        {{-- Photo Gallery Management --}}
        <div class="mt-12 bg-surface border border-border rounded-xl p-6 sm:p-8">
            <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Photo Gallery') }}</h2>

            @if ($memorial->photos && $memorial->photos->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
                    @foreach ($memorial->photos as $photo)
                        <div class="relative group rounded-xl overflow-hidden aspect-square bg-elevated">
                            <img src="{{ Storage::url($photo->path) }}"
                                alt="{{ $photo->caption ?? __('Memorial photo') }}"
                                class="w-full h-full object-cover">
                            <div
                                class="absolute inset-0 bg-primary/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <form method="POST" action="{{ route('dashboard.photos.destroy', $photo) }}"
                                    onsubmit="return confirm('{{ __('Delete this photo?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 bg-red-500/20 border border-red-500/30 text-red-400 rounded-xl hover:bg-red-500/30 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-text-muted text-sm mb-6">{{ __('No photos in the gallery yet.') }}</p>
            @endif

            {{-- Upload More Photos --}}
            <form method="POST" action="{{ route('dashboard.memorials.photos.store', $memorial) }}"
                enctype="multipart/form-data" class="border-t border-border pt-6">
                @csrf
                <label for="photos"
                    class="block text-sm font-medium text-text-muted mb-2">{{ __('Add Photos to Gallery') }}</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                    <div class="flex-1 w-full">
                        <input type="file" name="photos[]" id="photos" accept="image/*" multiple
                            class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent/10 file:text-accent hover:file:bg-accent/20 focus:outline-none focus:border-accent transition-colors">
                        <p class="mt-2 text-xs text-text-muted">
                            {{ __('Select multiple images. JPG, PNG, or WebP.') }}</p>
                    </div>
                    <button type="submit"
                        class="px-6 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors shrink-0">
                        {{ __('Upload Photos') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Tributes Management --}}
        <div class="mt-8 bg-surface border border-border rounded-xl p-6 sm:p-8">
            <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Tributes') }}</h2>

            @if ($memorial->tributes && $memorial->tributes->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($memorial->tributes as $tribute)
                        <div class="bg-elevated border border-border rounded-xl p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span
                                            class="text-text font-medium text-sm">{{ $tribute->author_name }}</span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium
                                            {{ $tribute->is_approved ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400' }}">
                                            {{ $tribute->is_approved ? __('Approved') : __('Pending') }}
                                        </span>
                                        <span
                                            class="text-text-muted text-xs">{{ $tribute->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-text-muted text-sm leading-relaxed">{{ $tribute->message }}</p>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    @if (!$tribute->is_approved)
                                        <form method="POST"
                                            action="{{ route('dashboard.tributes.approve', $tribute) }}">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 bg-green-500/10 border border-green-500/30 text-green-400 rounded-xl hover:bg-green-500/20 transition-colors"
                                                title="{{ __('Approve') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('dashboard.tributes.reject', $tribute) }}">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 rounded-xl hover:bg-yellow-500/20 transition-colors"
                                                title="{{ __('Reject') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST"
                                        action="{{ route('dashboard.tributes.destroy', $tribute) }}"
                                        onsubmit="return confirm('{{ __('Delete this tribute?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl hover:bg-red-500/20 transition-colors"
                                            title="{{ __('Delete') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-text-muted text-sm">{{ __('No tributes have been submitted yet.') }}</p>
            @endif
        </div>

        {{-- Danger Zone --}}
        <div class="mt-8 bg-red-500/5 border border-red-500/20 rounded-xl p-6 sm:p-8">
            <h2 class="font-serif text-xl font-semibold text-red-400 mb-2">{{ __('Danger Zone') }}</h2>
            <p class="text-text-muted text-sm mb-6">
                {{ __('Once you delete a memorial, there is no going back. All photos, tributes, and data will be permanently removed.') }}
            </p>

            <form method="POST" action="{{ route('dashboard.memorials.destroy', $memorial) }}"
                onsubmit="return confirm('{{ __('Are you absolutely sure you want to delete this memorial? This action is irreversible.') }}')"
                x-data>
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-red-500/10 border border-red-500/30 text-red-400 font-semibold text-sm rounded-xl hover:bg-red-500/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    {{ __('Delete This Memorial') }}
                </button>
            </form>
        </div>

    </div>
</x-layouts.app>
