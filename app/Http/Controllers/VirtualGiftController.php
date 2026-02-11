<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Memorial;
use App\Models\VirtualGift;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VirtualGiftController extends Controller
{
    public function store(Request $request, string $slug): RedirectResponse
    {
        $memorial = Memorial::where('slug', $slug)->firstOrFail();

        $request->validate([
            'type' => ['required', 'in:candle,flower,tree,wreath,star'],
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        VirtualGift::create([
            'memorial_id' => $memorial->id,
            'user_id' => $request->user()?->id,
            'type' => $request->type,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Your gift has been placed.');
    }
}
