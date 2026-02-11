<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $memorials = $user->memorials()->withCount(['photos', 'tributes', 'virtualGifts'])->latest()->get();
        $pendingTributes = 0;

        foreach ($memorials as $memorial) {
            $pendingTributes += $memorial->tributes()->pending()->count();
        }

        return view('dashboard.index', [
            'memorials' => $memorials,
            'pendingTributes' => $pendingTributes,
            'isPremium' => $user->isPremium(),
        ]);
    }
}
