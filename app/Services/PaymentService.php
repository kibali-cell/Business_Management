<?php
namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPaymentIntent($amount, $currency = 'usd')
    {
        return PaymentIntent::create([
            'amount' => $amount * 100, // Convert to cents
            'currency' => $currency,
        ]);
    }
}