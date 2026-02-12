<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function accept(Request $request, string $token): RedirectResponse
    {
        $invitation = Invitation::where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        if ($invitation->isExpired()) {
            return redirect()->route('dashboard.index')
                ->with('error', __('This invitation has expired.'));
        }

        $user = $request->user();

        $invitation->update(['accepted_at' => now()]);

        $memorial = $invitation->memorial;

        if (! $memorial->managers()->where('user_id', $user->id)->exists()) {
            $memorial->managers()->attach($user->id, ['role' => $invitation->role]);
        }

        return redirect()->route('dashboard.memorials.edit', $memorial)
            ->with('success', __('Invitation accepted. You now have :role access to this memorial.', ['role' => $invitation->role]));
    }
}
