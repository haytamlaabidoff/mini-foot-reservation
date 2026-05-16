<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;



class PaymentcardController extends Controller
{
public function checkout(Reservation $reservation)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $price = $reservation->terrain->price_per_hour;

        $session = Session::create([

            'payment_method_types' => ['card'],

            'line_items' => [[

                'price_data' => [

                    'currency' => 'mad',

                    'product_data' => [
                        'name' => 'Reservation Terrain',
                    ],

                    'unit_amount' => $price * 100,
                ],

                'quantity' => 1,
            ]],

            'mode' => 'payment',

            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',

            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        return "Paiement réussi ✅";
    }

    public function cancel()
    {
        return "Paiement annulé ❌";
    }}


