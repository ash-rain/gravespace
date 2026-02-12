<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Memorial;
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

    public function analytics(Request $request, Memorial $memorial): View
    {
        $this->authorize('update', $memorial);

        // Total views
        $totalViews = $memorial->visits()->count();

        // Unique visitors (by IP)
        $uniqueVisitors = $memorial->visits()->distinct('ip_address')->count('ip_address');

        // Views in the last 30 days, grouped by date
        $dailyViews = $memorial->visits()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('views', 'date')
            ->toArray();

        // Fill in missing dates with 0
        $chartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartData[$date] = $dailyViews[$date] ?? 0;
        }

        // Counts
        $tributeCount = $memorial->tributes()->count();
        $giftCount = $memorial->virtualGifts()->count();
        $photoCount = $memorial->photos()->count();

        return view('dashboard.memorials.analytics', compact(
            'memorial', 'totalViews', 'uniqueVisitors', 'chartData',
            'tributeCount', 'giftCount', 'photoCount'
        ));
    }
}
