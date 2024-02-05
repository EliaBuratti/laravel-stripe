<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout()
    {
        return view('checkoutForm');
    }

    public function session()
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => env('CASHIER_CURRENCY'),
                        'product_data' => [
                            'name' => 'Demo stripe payment',
                        ],
                        'unit_amount'  => 500, // in this case it costs 500 cent
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode' => 'payment', //payment for one time payment, subscription for payment programmed ex: Netflix subscription 
            'success_url' => route('success'),
            'cancel_url'  => route('checkout'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        return 'Payment completed!, thank you! <br> <a href="http://127.0.0.1:8000/">Go to home</a>';
    }
}
