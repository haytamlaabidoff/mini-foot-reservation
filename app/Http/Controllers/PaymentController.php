<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    // ==========================================
    // VERIFY QR PAYMENT
    // ==========================================
    public function verify($token)
    {
        $reservation = Reservation::where('qr_token', $token)
            ->firstOrFail();

        return view('payment.success', compact('reservation'));
    }

    // ==========================================
    // CHECKOUT PAGE
    // ==========================================
    public function checkout(Reservation $reservation)
    {
        return view('paymentmethode.checkout', [

            'reservation' => $reservation,

            'amount' => 200,

        ]);
    }

    // ==========================================
    // STRIPE SESSION
    // ==========================================
    public function session(Reservation $reservation)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([

            'payment_method_types' => ['card'],

            'line_items' => [[

                'price_data' => [

                    'currency' => 'mad',

                    'product_data' => [

                        'name' => 'Réservation Terrain #' . $reservation->id,

                    ],

                    // 200 DH
                    'unit_amount' => 20000,

                ],

                'quantity' => 1,

            ]],

            'mode' => 'payment',

            // ✅ FIX SUCCESS URL
            'success_url' => route(
                'payment.success'
            ) . '?reservation=' . $reservation->id,

            // ✅ FIX CANCEL URL
            'cancel_url' => route(
                'payment.cancel'
            ) . '?reservation=' . $reservation->id,

        ]);

        return redirect($session->url);
    }

    // ==========================================
    // SUCCESS
    // ==========================================
    public function success(Request $request)
    {
        $reservation = Reservation::find(
            $request->reservation
        );

        if ($reservation) {

            $reservation->update([

                'payment_status' => 'paid',

                'status' => 'confirmed',

            ]);
        }

        return redirect()
            ->route('reservations.index')
            ->with(
                'success',
                '✅ Paiement effectué avec succès'
            );
    }

    // ==========================================
    // CANCEL
    // ==========================================
    public function cancel(Request $request)
    {
        $reservation = Reservation::find(
            $request->reservation
        );

        if ($reservation) {

            $reservation->update([

                'payment_status' => 'cancelled',

            ]);
        }

        return redirect()
            ->route('reservations.index')
            ->with(
                'error',
                '❌ Paiement annulé'
            );
    }
}