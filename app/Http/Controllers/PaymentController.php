<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Listing;
use App\Models\Order;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $carrito = session('carrito');

        if (!$carrito || count($carrito) !== 1) {
            abort(400);
        }

        $item = array_values($carrito)[0];

        $listing = Listing::findOrFail($item['id']);

        if ($listing->status !== Listing::STATUS_APPROVED) {
            abort(403);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'mode' => 'payment',
            'metadata' => [
                'listing_id' => $listing->id,
                'user_id' => auth()->id(),
            ],
            'payment_intent_data' => [
                'metadata' => [
                    'listing_id' => $listing->id,
                    'user_id' => auth()->id(),
                ],
            ],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $listing->title,
                    ],
                    'unit_amount' => $listing->price_eur * 100,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($request->get('session_id'));

        if ($session->payment_status !== 'paid') {
            abort(403);
        }

        $listing = Listing::findOrFail($session->metadata->listing_id);

        if ($listing->status !== Listing::STATUS_APPROVED) {
            abort(403);
        }

        Order::create([
            'user_id' => $session->metadata->user_id,
            'listing_id' => $listing->id,
            'total_eur' => $listing->price_eur,
            'status' => 'paid',
            'stripe_payment_intent' => $session->payment_intent,
        ]);

        $listing->status = Listing::STATUS_SOLD_PENDING;
        $listing->save();

        session()->forget('carrito');

        return view('payment.success');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
}