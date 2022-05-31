<?php

require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('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');
//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 //produccion
//sk_test_51ItcdaJc0kH60q11DD8ahmDpTA10QoNyGmOH0wDr5brxUK0sjOEQhWuC41lyUyour6S5WzDL3u4yE7r8MMw00m6300ca7r1kY4 //produccion
header('Content-Type: application/json');

try {
    // retrieve JSON from POST body
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);

    // Create a PaymentIntent with amount and currency
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $jsonObj->amount,
        'currency' => $jsonObj->currency,
        'payment_method_types' => [$jsonObj->payment_method]
    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret
    ];

    echo json_encode($output);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}