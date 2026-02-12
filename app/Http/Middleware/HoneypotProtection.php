<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HoneypotProtection
{
    public function handle(Request $request, Closure $next): Response
    {
        // If the honeypot field is filled, it's a bot
        if ($request->filled('website_url')) {
            abort(422);
        }

        return $next($request);
    }
}
