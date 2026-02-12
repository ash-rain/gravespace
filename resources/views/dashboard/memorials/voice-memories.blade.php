<x-layouts.app :title="__('Voice Memories') . ' — ' . $memorial->fullName()">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <a href="{{ route('dashboard.memorials.edit', $memorial) }}"
                    class="inline-flex items-center gap-1 text-text-muted hover:text-accent text-sm transition-colors mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ __('Back to Memorial') }}
                </a>
                <h1 class="font-serif text-3xl font-bold text-text">{{ __('Voice Memories') }}</h1>
                <p class="mt-2 text-text-muted text-sm">{{ $memorial->fullName() }}</p>
            </div>
        </div>

        {{-- Upload Form --}}
        <div class="bg-surface border border-border rounded-xl p-6 sm:p-8 mb-8">
            <h2 class="font-serif text-xl font-semibold text-text mb-4">{{ __('Upload Voice Memory') }}</h2>
            <p class="text-text-muted text-sm mb-6">{{ __('Upload an audio recording — a personal message, a favorite song, or a cherished voicemail.') }}</p>

            <form method="POST" action="{{ route('dashboard.memorials.voice-memories.store', $memorial) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-text-muted mb-2">{{ __('Title') }} <span class="text-red-400">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-colors"
                        placeholder="{{ __('e.g., Dad\'s favorite joke') }}">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="audio_file" class="block text-sm font-medium text-text-muted mb-2">{{ __('Audio File') }} <span class="text-red-400">*</span></label>
                    <input type="file" name="audio_file" id="audio_file" accept="audio/mp3,audio/wav,audio/ogg,audio/m4a,audio/aac,.mp3,.wav,.ogg,.m4a,.aac" required
                        class="w-full px-4 py-3 bg-elevated border border-border rounded-xl text-text file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent/10 file:text-accent hover:file:bg-accent/20 focus:outline-none focus:border-accent transition-colors">
                    <p class="mt-2 text-xs text-text-muted">{{ __('Supported formats: MP3, WAV, OGG, M4A, AAC. Max 20MB.') }}</p>
                    @error('audio_file')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold bg-accent hover:bg-accent-hover text-primary rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    {{ __('Upload Voice Memory') }}
                </button>
            </form>
        </div>

        {{-- Existing Voice Memories --}}
        @if ($voiceMemories->count() > 0)
            <div class="space-y-4">
                <h2 class="font-serif text-xl font-semibold text-text">{{ __('Uploaded Recordings') }}</h2>
                @foreach ($voiceMemories as $voice)
                    <div class="bg-surface border border-border rounded-xl p-5 flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-text font-medium text-sm truncate">{{ $voice->title }}</p>
                                <p class="text-text-muted text-xs">{{ __('Uploaded by') }} {{ $voice->user->name }} · {{ $voice->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <audio controls preload="none" class="h-8">
                                <source src="{{ Storage::url($voice->file_path) }}" type="audio/mpeg">
                            </audio>
                            <form method="POST" action="{{ route('dashboard.voice-memories.destroy', $voice) }}" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-text-muted hover:text-red-400 transition-colors" title="{{ __('Delete') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-surface border border-border rounded-xl">
                <svg class="w-12 h-12 text-text-muted/30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
                <p class="text-text-muted">{{ __('No voice memories yet. Upload the first one above.') }}</p>
            </div>
        @endif

        {{-- Success Flash --}}
        @if (session('success'))
            <div class="fixed bottom-6 right-6 z-50 bg-elevated border border-accent/50 text-text px-6 py-4 rounded-xl shadow-2xl max-w-sm"
                x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
                <div class="flex items-start gap-3">
                    <span class="text-accent text-lg">&#x1F56F;</span>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
