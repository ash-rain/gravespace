<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Memorial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemorialExportController extends Controller
{
    public function show(Request $request, Memorial $memorial): View
    {
        $this->authorize('update', $memorial);

        $memorial->load([
            'photos',
            'timelineEvents',
            'approvedTributes',
            'virtualGifts',
            'familyLinks.relatedMemorial',
            'voiceMemories',
        ]);

        return view('dashboard.memorials.export', compact('memorial'));
    }
}
