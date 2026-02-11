<x-layouts.app :title="__('Create Memorial')">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('dashboard.memorials.index') }}" class="inline-flex items-center gap-1 text-text-muted hover:text-accent text-sm transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('Back to Memorials') }}
            </a>
            <h1 class="font-serif text-3xl font-bold text-text">{{ __('Create Memorial') }}</h1>
            <p class="mt-2 text-text-muted text-sm">{{ __('Honor and preserve the memory of your loved one.') }}</p>
        </div>

        {{-- Validation Errors Summary --}}
        @if($errors->any())
            <div class="mb-8 bg-red-500/10 border border-red-500/30 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-red-400 font-semibold text-sm">{{ __('Please correct the following errors:') }}</h3>
                </div>
                <ul class="list-disc list-inside text-red-400/80 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.memorials.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Personal Information --}}
            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Personal Information') }}</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- First Name --}}
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-text-muted mb-2">{{ __('First Name') }} <span class="text-red-400">*</span></label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                               class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
                        @error('first_name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-text-muted mb-2">{{ __('Last Name') }} <span class="text-red-400">*</span></label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                               class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
                        @error('last_name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Maiden Name --}}
                    <div>
                        <label for="maiden_name" class="block text-sm font-medium text-text-muted mb-2">{{ __('Maiden Name') }}</label>
                        <input type="text" name="maiden_name" id="maiden_name" value="{{ old('maiden_name') }}"
                               class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors">
                        @error('maiden_name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Spacer for grid alignment --}}
                    <div class="hidden sm:block"></div>

                    {{-- Date of Birth --}}
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-text-muted mb-2">{{ __('Date of Birth') }} <span class="text-red-400">*</span></label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required
                               class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors [color-scheme:dark]">
                        @error('date_of_birth')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date of Death --}}
                    <div>
                        <label for="date_of_death" class="block text-sm font-medium text-text-muted mb-2">{{ __('Date of Death') }} <span class="text-red-400">*</span></label>
                        <input type="date" name="date_of_death" id="date_of_death" value="{{ old('date_of_death') }}" required
                               class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors [color-scheme:dark]">
                        @error('date_of_death')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Place of Birth --}}
                    <div>
                        <label for="place_of_birth" class="block text-sm font-medium text-text-muted mb-2">{{ __('Place of Birth') }}</label>
                        <input type="text" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth') }}"
                               class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                               placeholder="{{ __('City, State, Country') }}">
                        @error('place_of_birth')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Place of Death --}}
                    <div>
                        <label for="place_of_death" class="block text-sm font-medium text-text-muted mb-2">{{ __('Place of Death') }}</label>
                        <input type="text" name="place_of_death" id="place_of_death" value="{{ old('place_of_death') }}"
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
                    <label for="obituary" class="block text-sm font-medium text-text-muted mb-2">{{ __('Life Story & Obituary') }}</label>
                    <textarea name="obituary" id="obituary" rows="10"
                              class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors resize-y"
                              placeholder="{{ __('Share the story of their life, their passions, accomplishments, and the legacy they leave behind...') }}">{{ old('obituary') }}</textarea>
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
                        <label for="cover_photo" class="block text-sm font-medium text-text-muted mb-2">{{ __('Cover Photo') }}</label>
                        <div class="relative">
                            <input type="file" name="cover_photo" id="cover_photo" accept="image/*"
                                   class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent/10 file:text-accent hover:file:bg-accent/20 focus:outline-none focus:border-accent transition-colors">
                        </div>
                        <p class="mt-2 text-xs text-text-muted">{{ __('Recommended: 1200x400px. JPG, PNG, or WebP.') }}</p>
                        @error('cover_photo')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Profile Photo --}}
                    <div>
                        <label for="profile_photo" class="block text-sm font-medium text-text-muted mb-2">{{ __('Profile Photo') }}</label>
                        <div class="relative">
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                                   class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent/10 file:text-accent hover:file:bg-accent/20 focus:outline-none focus:border-accent transition-colors">
                        </div>
                        <p class="mt-2 text-xs text-text-muted">{{ __('Recommended: 400x400px. JPG, PNG, or WebP.') }}</p>
                        @error('profile_photo')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Privacy Settings --}}
            <div class="bg-surface border border-border rounded-xl p-6 sm:p-8" x-data="{ privacy: '{{ old('privacy', 'public') }}' }">
                <h2 class="font-serif text-xl font-semibold text-text mb-6">{{ __('Privacy Settings') }}</h2>

                <div class="space-y-4">
                    {{-- Public --}}
                    <label class="flex items-start gap-4 p-4 bg-elevated border border-border rounded-xl cursor-pointer hover:border-accent/30 transition-colors" :class="{ 'border-accent/50 bg-accent/5': privacy === 'public' }">
                        <input type="radio" name="privacy" value="public" x-model="privacy"
                               class="mt-1 text-accent bg-elevated border-border focus:ring-accent focus:ring-offset-0">
                        <div>
                            <p class="text-text font-medium text-sm">{{ __('Public') }}</p>
                            <p class="text-text-muted text-xs mt-1">{{ __('Anyone with the link can view this memorial.') }}</p>
                        </div>
                    </label>

                    {{-- Password Protected --}}
                    <label class="flex items-start gap-4 p-4 bg-elevated border border-border rounded-xl cursor-pointer hover:border-accent/30 transition-colors" :class="{ 'border-accent/50 bg-accent/5': privacy === 'password' }">
                        <input type="radio" name="privacy" value="password" x-model="privacy"
                               class="mt-1 text-accent bg-elevated border-border focus:ring-accent focus:ring-offset-0">
                        <div>
                            <p class="text-text font-medium text-sm">{{ __('Password Protected') }}</p>
                            <p class="text-text-muted text-xs mt-1">{{ __('Visitors must enter a password to view this memorial.') }}</p>
                        </div>
                    </label>

                    {{-- Invite Only --}}
                    <label class="flex items-start gap-4 p-4 bg-elevated border border-border rounded-xl cursor-pointer hover:border-accent/30 transition-colors" :class="{ 'border-accent/50 bg-accent/5': privacy === 'invite_only' }">
                        <input type="radio" name="privacy" value="invite_only" x-model="privacy"
                               class="mt-1 text-accent bg-elevated border-border focus:ring-accent focus:ring-offset-0">
                        <div>
                            <p class="text-text font-medium text-sm">{{ __('Invite Only') }}</p>
                            <p class="text-text-muted text-xs mt-1">{{ __('Only people you invite can view this memorial.') }}</p>
                        </div>
                    </label>

                    {{-- Password Field (shown when password is selected) --}}
                    <div x-show="privacy === 'password'" x-transition class="ml-8">
                        <label for="memorial_password" class="block text-sm font-medium text-text-muted mb-2">{{ __('Memorial Password') }}</label>
                        <input type="text" name="memorial_password" id="memorial_password" value="{{ old('memorial_password') }}"
                               class="w-full max-w-sm px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                               placeholder="{{ __('Enter a password for visitors') }}">
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
                    {{-- Cemetery Name --}}
                    <div class="sm:col-span-2">
                        <label for="cemetery_name" class="block text-sm font-medium text-text-muted mb-2">{{ __('Cemetery Name') }}</label>
                        <input type="text" name="cemetery_name" id="cemetery_name" value="{{ old('cemetery_name') }}"
                               class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                               placeholder="{{ __('e.g., Greenwood Memorial Park') }}">
                        @error('cemetery_name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Cemetery Address --}}
                    <div class="sm:col-span-2">
                        <label for="cemetery_address" class="block text-sm font-medium text-text-muted mb-2">{{ __('Cemetery Address') }}</label>
                        <input type="text" name="cemetery_address" id="cemetery_address" value="{{ old('cemetery_address') }}"
                               class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                               placeholder="{{ __('Full address') }}">
                        @error('cemetery_address')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Latitude --}}
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-text-muted mb-2">{{ __('Latitude') }}</label>
                        <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude') }}"
                               class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                               placeholder="{{ __('e.g., 40.7128') }}">
                        @error('latitude')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Longitude --}}
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-text-muted mb-2">{{ __('Longitude') }}</label>
                        <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude') }}"
                               class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                               placeholder="{{ __('e.g., -74.0060') }}">
                        @error('longitude')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('dashboard.memorials.index') }}" class="px-6 py-3 bg-elevated border border-border text-text-muted font-medium text-sm rounded-xl hover:text-text transition-colors">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-8 py-3 bg-accent text-primary font-semibold text-sm rounded-xl hover:bg-accent/90 transition-colors">
                    {{ __('Create Memorial') }}
                </button>
            </div>
        </form>

    </div>
</x-layouts.app>
