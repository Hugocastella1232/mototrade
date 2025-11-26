<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];

        foreach ($carrito as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['title']
                    ],
                    'unit_amount' => $item['price_eur'] * 100
                ],
                'quantity' => $item['quantity']
            ];
        }

        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel')
        ]);

        session(['payment_intent' => $session->id]);
        return redirect($session->url);
    }

    public function success()
    {
        $carrito = session()->get('carrito', []);
        if (!empty($carrito)) {
            $total = collect($carrito)->sum(fn($item) => $item['price_eur'] * $item['quantity']);

            Order::create([
                'user_id' => auth()->id(),
                'listing_id' => array_key_first($carrito),
                'status' => 'paid',
                'total_eur' => $total,
                'payment_provider' => 'stripe',
                'payment_intent_id' => session('payment_intent')
            ]);

            session()->forget('carrito');
            session()->forget('payment_intent');
        }

        return view('payment.success');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
}