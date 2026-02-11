<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTributeRequest;
use App\Models\Memorial;
use App\Models\Tribute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TributeController extends Controller
{
    public function store(StoreTributeRequest $request, string $slug): RedirectResponse
    {
        $memorial = Memorial::where('slug', $slug)->firstOrFail();
        $data = $request->validated();

        $data['memorial_id'] = $memorial->id;
        $data['user_id'] = $request->user()?->id;
        $data['is_approved'] = false;

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('tributes', 'public');
        }

        Tribute::create($data);

        return back()->with('success', 'Your tribute has been submitted and is awaiting approval.');
    }

    public function approve(Request $request, Tribute $tribute): RedirectResponse
    {
        $this->authorize('approve', $tribute);

        $tribute->update(['is_approved' => true]);

        return back()->with('success', 'Tribute approved.');
    }

    public function reject(Request $request, Tribute $tribute): RedirectResponse
    {
        $this->authorize('approve', $tribute);

        $tribute->update(['is_approved' => false]);

        return back()->with('success', 'Tribute rejected.');
    }

    public function destroy(Request $request, Tribute $tribute): RedirectResponse
    {
        $this->authorize('delete', $tribute);

        $tribute->delete();

        return back()->with('success', 'Tribute deleted.');
    }
}
