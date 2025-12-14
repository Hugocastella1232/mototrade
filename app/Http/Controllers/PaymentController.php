<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $carrito = session('carrito');

        if (!$carrito || count($carrito) !== 1) {
            abort(400, 'El carrito debe tener exactamente una moto');
        }

        $item = array_values($carrito)[0];

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'mode' => 'payment',
            'payment_intent_data' => [
                'metadata' => [
                    'listing_id' => $item['id'],
                    'user_id' => auth()->id(),
                ],
            ],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['title'],
                    ],
                    'unit_amount' => $item['price_eur'] * 100,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        session()->forget('carrito');
        return view('payment.success');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
}