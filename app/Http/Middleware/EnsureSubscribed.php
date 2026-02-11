<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscribed
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isPremium()) {
            return redirect()->route('pricing')
                ->with('message', 'This feature requires a Premium subscription.');
        }

        return $next($request);
    }
}
