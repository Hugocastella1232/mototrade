<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        if (!$endpointSecret) {
            return response()->json(['error' => 'Webhook secret missing'], 500);
        }

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid payload or signature'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            if ($session->payment_status === 'paid') {
                $paymentIntentId = $session->payment_intent ?? null;
                $userId = $session->metadata->user_id ?? null;
                $listingId = $session->metadata->listing_id ?? null;
                $totalEur = isset($session->amount_total) ? intval($session->amount_total / 100) : null;

                if ($paymentIntentId && $totalEur !== null) {
                    Order::firstOrCreate(
                        ['payment_intent_id' => $paymentIntentId],
                        [
                            'user_id'          => $userId ?: null,
                            'listing_id'       => $listingId ?: null,
                            'status'           => 'paid',
                            'total_eur'        => $totalEur,
                            'payment_provider' => 'stripe',
                        ]
                    );
                }
            }
        }

        return response()->json(['received' => true]);
    }
}