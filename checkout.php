<?php
require 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Set Stripe API key
\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

// IMPORTANT: Change 'stripe-php-app' to the actual name of your folder in htdocs
$baseUrl = 'http://localhost/stripe-php-app'; 

if (empty($_POST['price_id'])) {
    die("No product selected. Please go back to the products page.");
}

try {
    // Create the Checkout Session using Stripe SDK
    $checkout_session = \Stripe\Checkout\Session::create([
        'success_url' => $baseUrl . '/success.php',
        'cancel_url'  => $baseUrl . '/cancel.php',
        'mode'        => 'payment',
        'line_items'  => [
            [
                'price' => $_POST['price_id'],
                'quantity' => 1,
            ]
        ],
    ]);
    
    // Redirect to Stripe Checkout
    header("Location: " . $checkout_session->url);
    exit;

} catch (Exception $e) {
    die('Stripe Checkout Error: ' . $e->getMessage());
}