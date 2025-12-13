<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío.');
        }

        $item = reset($carrito);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['title'],
                    ],
                    'unit_amount' => $item['price_eur'] * 100,
                ],
                'quantity' => $item['quantity'],
            ]],
            'metadata' => [
                'listing_id' => $item['id'],
                'user_id' => auth()->id(),
            ],
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