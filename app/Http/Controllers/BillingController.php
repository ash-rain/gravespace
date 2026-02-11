<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function index(Request $request): View
    {
        return view('dashboard.billing.index', [
            'user' => $request->user(),
            'isPremium' => $request->user()->isPremium(),
        ]);
    }

    public function checkout(Request $request): mixed
    {
        $request->validate([
            'plan' => ['required', 'in:monthly,lifetime'],
        ]);

        $user = $request->user();

        if ($request->plan === 'monthly') {
            return $user->newSubscription('default', config('services.stripe.monthly_price_id'))
                ->checkout([
                    'success_url' => route('dashboard.billing') . '?success=1',
                    'cancel_url' => route('pricing'),
                ]);
        }

        return $user->checkout(config('services.stripe.lifetime_price_id'), [
            'success_url' => route('dashboard.billing') . '?success=1',
            'cancel_url' => route('pricing'),
            'mode' => 'payment',
        ]);
    }

    public function portal(Request $request): RedirectResponse
    {
        return $request->user()->redirectToBillingPortal(route('dashboard.billing'));
    }
}
