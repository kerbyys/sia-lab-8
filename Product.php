<?php
require 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Set Stripe API key
\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$prices = [];

try {
    // Fetch prices and expand the product data using Stripe SDK
    $prices = \Stripe\Price::all([
        'active' => true,
        'limit' => 20,
        'expand' => ['data.product']
    ]);
} catch (Exception $e) {
    die('Error fetching products: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stripe PHP App - Products</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background-color: #f4f4f9; }
        .product-grid { display: flex; flex-wrap: wrap; gap: 20px; }
        .product-card { background: white; border: 1px solid #ddd; padding: 20px; width: 220px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .buy-btn { background-color: #635bff; color: white; padding: 10px; border: none; cursor: pointer; width: 100%; border-radius: 4px; font-weight: bold; margin-top: 10px; }
        .buy-btn:hover { background-color: #4b45c6; }
    </style>
</head>
<body>
    <h1>Products Page</h1>
    <div class="product-grid">
        <?php foreach ($prices->data as $price): ?>
            <div class="product-card">
                <h3><?php echo htmlspecialchars($price->product->name); ?></h3>
                <p>Price: $<?php echo number_format($price->unit_amount / 100, 2); ?></p>
                
                <form method="POST" action="checkout.php">
                    <input type="hidden" name="price_id" value="<?php echo $price->id; ?>">
                    <button type="submit" class="buy-btn">Click Buy</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
