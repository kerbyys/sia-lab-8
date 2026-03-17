# Stripe PHP App

A simple PHP application that integrates with Stripe for payment processing.

## Features

- Display products from Stripe
- Create checkout sessions
- Handle success and cancel pages

## Setup

1. Clone or download the repository
2. Install dependencies: `composer install`
3. Copy `.env.example` to `.env` and fill in your Stripe keys
4. Start a PHP server: `php -S localhost:8000`
5. Visit `http://localhost:8000/Product.php`

## Environment Variables

- `STRIPE_PUBLISHABLE_KEY`: Your Stripe publishable key
- `STRIPE_SECRET_KEY`: Your Stripe secret key

## Files

- `Product.php`: Displays available products
- `checkout.php`: Creates Stripe checkout session
- `success.php`: Success page after payment
- `cancel.php`: Cancel page if payment is cancelled

## Security

- Never commit `.env` file to version control
- Use test keys for development
- Validate all inputs