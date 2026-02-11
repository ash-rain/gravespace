<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Memorial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExploreController extends Controller
{
    public function index(Request $request): View
    {
        $query = Memorial::publiclyVisible()->with('user')->withCount(['virtualGifts', 'approvedTributes']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('obituary', 'like', "%{$search}%");
            });
        }

        $memorials = $query->latest()->paginate(12);

        return view('pages.explore', compact('memorials'));
    }
}
