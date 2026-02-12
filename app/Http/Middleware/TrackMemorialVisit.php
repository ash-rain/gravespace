<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Memorial;
use App\Models\MemorialVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackMemorialVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Track the visit after sending the response
        $param = $request->route('memorial') ?? $request->route('slug');
        if ($param) {
            $memorial = $param instanceof Memorial
                ? $param
                : Memorial::where('slug', $param)->first();

            if ($memorial) {
                MemorialVisit::create([
                    'memorial_id' => $memorial->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'referrer' => $request->header('referer'),
                ]);
            }
        }

        return $response;
    }
}
