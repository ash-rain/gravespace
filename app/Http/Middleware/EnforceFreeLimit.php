<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceFreeLimit
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->canCreateMemorial()) {
            return redirect()->route('dashboard.memorials.index')
                ->with('error', 'Free accounts are limited to 1 memorial. Upgrade to Premium for unlimited memorials.');
        }

        return $next($request);
    }
}
