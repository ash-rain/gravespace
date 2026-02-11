<?php

declare(strict_types=1);

namespace App\Http\Controllers\Webhook;

use App\Models\User;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Stripe\Checkout\Session;

class StripeWebhookController extends WebhookController
{
    public function handleCheckoutSessionCompleted(array $payload): void
    {
        $session = $payload['data']['object'];

        if (($session['mode'] ?? '') === 'payment') {
            $user = User::where('stripe_id', $session['customer'])->first();

            if ($user) {
                $user->update(['lifetime_premium_at' => now()]);
            }
        }
    }
}
