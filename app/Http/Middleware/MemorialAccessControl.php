<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Memorial;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MemorialAccessControl
{
    public function handle(Request $request, Closure $next): Response
    {
        $memorial = $request->route('memorial');

        if (! $memorial instanceof Memorial) {
            $memorial = Memorial::where('slug', $memorial)->firstOrFail();
        }

        if (! $memorial->is_published) {
            if (! $request->user() || ($request->user()->id !== $memorial->user_id && ! $memorial->managers->contains($request->user()))) {
                abort(404);
            }
        }

        if ($memorial->privacy === 'password') {
            if (! session("memorial_access.{$memorial->id}") && $request->user()?->id !== $memorial->user_id) {
                return redirect()->route('memorial.password', $memorial->slug);
            }
        }

        if ($memorial->privacy === 'invite_only') {
            if (! $request->user()) {
                abort(403, 'This memorial is private.');
            }
            if ($request->user()->id !== $memorial->user_id && ! $memorial->managers->contains($request->user())) {
                abort(403, 'You do not have access to this memorial.');
            }
        }

        return $next($request);
    }
}
