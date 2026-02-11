<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Memorial;
use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function store(Request $request, Memorial $memorial): RedirectResponse
    {
        $this->authorize('create', [Photo::class, $memorial]);

        $request->validate([
            'photos' => ['required', 'array', 'max:20'],
            'photos.*' => ['image', 'max:10240'],
        ]);

        $user = $request->user();
        $currentCount = $memorial->photos()->count();
        $maxAllowed = $user->maxPhotosPerMemorial();

        foreach ($request->file('photos') as $file) {
            if ($currentCount >= $maxAllowed) {
                return back()->with('error', 'Photo limit reached. Upgrade to Premium for unlimited photos.');
            }

            $path = $file->store('memorials/' . $memorial->id . '/photos', 'public');

            Photo::create([
                'memorial_id' => $memorial->id,
                'uploaded_by' => $user->id,
                'file_path' => $path,
                'sort_order' => $currentCount,
            ]);

            $currentCount++;
        }

        return back()->with('success', 'Photos uploaded successfully.');
    }

    public function update(Request $request, Photo $photo): RedirectResponse
    {
        $this->authorize('delete', $photo);

        $request->validate([
            'caption' => ['nullable', 'string', 'max:500'],
            'date_taken' => ['nullable', 'date'],
        ]);

        $photo->update($request->only('caption', 'date_taken'));

        return back()->with('success', 'Photo updated.');
    }

    public function destroy(Request $request, Photo $photo): RedirectResponse
    {
        $this->authorize('delete', $photo);

        $photo->delete();

        return back()->with('success', 'Photo deleted.');
    }
}
