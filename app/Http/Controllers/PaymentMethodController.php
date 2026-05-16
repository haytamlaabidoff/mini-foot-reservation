<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
class PaymentMethodController extends Controller
{
 public function checkout(Request $request)
    {
        return view('paymentmethode.checkout', [
            'amount' => 200,
        ]);
    }

    public function session(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([

            'payment_method_types' => ['card'],

            'line_items' => [[
                'price_data' => [
                    'currency' => 'mad',
                    'product_data' => [
                        'name' => 'Réservation Terrain',
                    ],
                    'unit_amount' => 20000,
                ],
                'quantity' => 1,
            ]],

            'mode' => 'payment',

            'success_url' => route('payment.success'),

            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        return "✅ Paiement réussi";
    }

    public function cancel()
    {
        return "❌ Paiement annulé";
    }
    }
