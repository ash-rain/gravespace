<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Memorial;
use App\Models\VoiceMemory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VoiceMemoryController extends Controller
{
    public function index(Request $request, Memorial $memorial): View
    {
        $this->authorize('update', $memorial);

        $voiceMemories = $memorial->voiceMemories()->with('user')->get();

        return view('dashboard.memorials.voice-memories', compact('memorial', 'voiceMemories'));
    }

    public function store(Request $request, Memorial $memorial): RedirectResponse
    {
        $this->authorize('update', $memorial);

        if (! $request->user()->canUploadVoiceMemory()) {
            return redirect()->route('pricing')
                ->with('error', 'Voice memories are a premium feature. Upgrade to unlock.');
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'audio_file' => ['required', 'file', 'mimes:mp3,wav,ogg,m4a,aac', 'max:20480'],
        ]);

        $path = $request->file('audio_file')->store('memorials/voice-memories', 'public');

        $maxSortOrder = $memorial->voiceMemories()->max('sort_order') ?? 0;

        $memorial->voiceMemories()->create([
            'user_id' => $request->user()->id,
            'file_path' => $path,
            'title' => $request->input('title'),
            'sort_order' => $maxSortOrder + 1,
        ]);

        return redirect()->route('dashboard.memorials.voice-memories.index', $memorial)
            ->with('success', 'Voice memory uploaded successfully.');
    }

    public function destroy(Request $request, VoiceMemory $voiceMemory): RedirectResponse
    {
        $memorial = $voiceMemory->memorial;
        $this->authorize('update', $memorial);

        $voiceMemory->delete();

        return redirect()->route('dashboard.memorials.voice-memories.index', $memorial)
            ->with('success', 'Voice memory removed.');
    }
}
