<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemorialRequest;
use App\Http\Requests\UpdateMemorialRequest;
use App\Models\Memorial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MemorialController extends Controller
{
    public function index(Request $request): View
    {
        $memorials = $request->user()
            ->memorials()
            ->withCount(['photos', 'tributes', 'virtualGifts'])
            ->latest()
            ->get();

        return view('dashboard.memorials.index', compact('memorials'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->user()->canCreateMemorial()) {
            return redirect()->route('pricing')
                ->with('error', 'Free accounts are limited to 1 memorial. Upgrade to Premium for unlimited memorials.');
        }

        return view('dashboard.memorials.create');
    }

    public function store(StoreMemorialRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['slug'] = Str::slug($data['first_name'].' '.$data['last_name'].' '.Str::random(4));

        if (isset($data['memorial_password'])) {
            $data['password_hash'] = Hash::make($data['memorial_password']);
            unset($data['memorial_password']);
        }

        if ($request->hasFile('cover_photo')) {
            $data['cover_photo'] = $request->file('cover_photo')->store('memorials/covers', 'public');
        }

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('memorials/profiles', 'public');
        }

        $memorial = Memorial::create($data);

        return redirect()->route('dashboard.memorials.edit', $memorial)
            ->with('success', 'Memorial created successfully.');
    }

    public function show(string $slug): View
    {
        $memorial = Memorial::where('slug', $slug)
            ->with(['photos', 'approvedTributes', 'virtualGifts', 'timelineEvents', 'user', 'familyLinks.relatedMemorial'])
            ->firstOrFail();

        return view('memorial.show', compact('memorial'));
    }

    public function edit(Request $request, Memorial $memorial): View
    {
        $this->authorize('update', $memorial);

        $memorial->load(['photos', 'videos', 'timelineEvents', 'tributes', 'managers']);

        return view('dashboard.memorials.edit', compact('memorial'));
    }

    public function update(UpdateMemorialRequest $request, Memorial $memorial): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['memorial_password'])) {
            $data['password_hash'] = Hash::make($data['memorial_password']);
            unset($data['memorial_password']);
        }

        if ($request->hasFile('cover_photo')) {
            $data['cover_photo'] = $request->file('cover_photo')->store('memorials/covers', 'public');
        }

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('memorials/profiles', 'public');
        }

        if (isset($data['slug']) && $data['slug'] !== $memorial->slug) {
            $data['slug'] = Str::slug($data['slug']);
        }

        $memorial->update($data);

        return redirect()->route('dashboard.memorials.edit', $memorial)
            ->with('success', 'Memorial updated successfully.');
    }

    public function destroy(Request $request, Memorial $memorial): RedirectResponse
    {
        $this->authorize('delete', $memorial);

        $memorial->delete();

        return redirect()->route('dashboard.memorials.index')
            ->with('success', 'Memorial deleted.');
    }

    public function gallery(string $slug): View
    {
        $memorial = Memorial::where('slug', $slug)->with('photos')->firstOrFail();

        return view('memorial.gallery', compact('memorial'));
    }

    public function timeline(string $slug): View
    {
        $memorial = Memorial::where('slug', $slug)->with('timelineEvents.photo')->firstOrFail();

        return view('memorial.timeline', compact('memorial'));
    }

    public function password(string $slug): View
    {
        $memorial = Memorial::where('slug', $slug)->firstOrFail();

        return view('memorial.password', compact('memorial'));
    }

    public function verifyPassword(Request $request, string $slug): RedirectResponse
    {
        $memorial = Memorial::where('slug', $slug)->firstOrFail();
        $request->validate(['password' => 'required|string']);

        if (Hash::check($request->password, $memorial->password_hash)) {
            session(["memorial_access.{$memorial->id}" => true]);

            return redirect()->route('memorial.show', $slug);
        }

        return back()->withErrors(['password' => 'Incorrect password.']);
    }
}
