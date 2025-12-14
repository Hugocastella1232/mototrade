<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Listing;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        $event = Webhook::constructEvent(
            $payload,
            $sigHeader,
            $endpointSecret
        );

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            if ($session->payment_status === 'paid') {
                $listingId = $session->metadata->listing_id ?? null;
                $userId    = $session->metadata->user_id ?? null;
                $totalEur  = $session->amount_total
                    ? intval($session->amount_total / 100)
                    : null;

                Order::firstOrCreate(
                    ['payment_intent_id' => $session->id],
                    [
                        'user_id'          => $userId,
                        'listing_id'       => $listingId,
                        'status'           => 'paid',
                        'total_eur'        => $totalEur,
                        'payment_provider' => 'stripe',
                    ]
                );

                if ($listingId) {
                    Listing::where('id', $listingId)
                        ->update(['status' => Listing::STATUS_SOLD]);
                }
            }
        }

        return response()->json(['received' => true]);
    }
}