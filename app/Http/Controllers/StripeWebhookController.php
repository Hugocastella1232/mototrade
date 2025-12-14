<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Listing;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('🔔 Stripe webhook HIT');

        $endpointSecret = config('services.stripe.webhook_secret');

        if (!$endpointSecret) {
            Log::error('❌ STRIPE_WEBHOOK_SECRET not set');
            return response('Webhook secret missing', 500);
        }

        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        if (!$sigHeader) {
            Log::error('❌ Stripe-Signature header missing');
            return response('Bad Request', 400);
        }

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (UnexpectedValueException $e) {
            Log::error('❌ Invalid payload', ['error' => $e->getMessage()]);
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            Log::error('❌ Invalid signature', [
                'error' => $e->getMessage(),
            ]);
            return response('Invalid signature', 400);
        }

        Log::info('✅ Stripe event received', [
            'type' => $event->type,
            'id'   => $event->id,
        ]);

        if ($event->type !== 'checkout.session.completed') {
            return response()->json(['ignored' => true]);
        }

        $session = $event->data->object;

        if ($session->payment_status !== 'paid') {
            Log::warning('⚠️ Checkout session not paid', [
                'status' => $session->payment_status,
            ]);
            return response()->json(['not_paid' => true]);
        }

        $listingId = $session->metadata->listing_id ?? null;
        $userId    = $session->metadata->user_id ?? null;

        if (!$listingId || !$userId) {
            Log::error('❌ Missing metadata', [
                'metadata' => $session->metadata,
            ]);
            return response()->json(['metadata_error' => true], 400);
        }

        $totalEur = $session->amount_total
            ? intval($session->amount_total / 100)
            : 0;

        $order = Order::firstOrCreate(
            ['payment_intent_id' => $session->id],
            [
                'user_id'          => $userId,
                'listing_id'       => $listingId,
                'status'           => 'paid',
                'total_eur'        => $totalEur,
                'payment_provider' => 'stripe',
            ]
        );

        Listing::where('id', $listingId)
            ->update(['status' => Listing::STATUS_SOLD]);

        Log::info('✅ Order created and listing marked as sold', [
            'order_id'   => $order->id,
            'listing_id' => $listingId,
        ]);

        return response()->json(['received' => true]);
    }
}