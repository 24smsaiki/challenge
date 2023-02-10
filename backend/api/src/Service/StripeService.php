<?php

namespace App\Service;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
    public function getSessionId($order, $products_for_stripe)
    {
        $YOUR_DOMAIN = 'https://localhost';


        $products_for_stripe[] = [
            'price_data' => [
              'currency' => 'eur',
              'unit_amount' => ceil($order->getCarrier()->getFees() * 100),
              'product_data' => [
                'name' => $order->getCarrier()->getLabel(),
              ],
            ],
            'quantity' => 1
        ];

        Stripe::setApiKey($_ENV['STRIPE_SK_KEY']);
        $checkout_session = Session::create([
            'customer_email' => $order->getCustomer()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [
                $products_for_stripe
            ],
            'mode' => 'payment',
            'success_url' => 'http://localhost:3000' . '/order/payment/success/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/order/payment/fail/{CHECKOUT_SESSION_ID}',
        ]);

        return $checkout_session->id;
    }
}
