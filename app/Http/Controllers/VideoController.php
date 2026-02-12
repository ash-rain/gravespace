<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\ProcessVideoUpload;
use App\Models\Memorial;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request, Memorial $memorial): RedirectResponse
    {
        $this->authorize('create', [Video::class, $memorial]);

        if (! $request->user()->isPremium()) {
            return back()->with('error', __('Video uploads require a Premium subscription.'));
        }

        $request->validate([
            'video' => ['required', 'file', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm', 'max:102400'],
            'caption' => ['nullable', 'string', 'max:500'],
        ]);

        $path = $request->file('video')->store('memorials/'.$memorial->id.'/videos', 'public');

        $video = Video::create([
            'memorial_id' => $memorial->id,
            'uploaded_by' => $request->user()->id,
            'file_path' => $path,
            'caption' => $request->input('caption'),
            'sort_order' => $memorial->videos()->count(),
        ]);

        ProcessVideoUpload::dispatch($video);

        return back()->with('success', __('Video uploaded successfully. Processing will complete shortly.'));
    }

    public function update(Request $request, Video $video): RedirectResponse
    {
        $this->authorize('delete', $video);

        $request->validate([
            'caption' => ['nullable', 'string', 'max:500'],
        ]);

        $video->update($request->only('caption'));

        return back()->with('success', __('Video updated.'));
    }

    public function destroy(Request $request, Video $video): RedirectResponse
    {
        $this->authorize('delete', $video);

        $video->delete();

        return back()->with('success', __('Video deleted.'));
    }
}
