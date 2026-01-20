<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class StripePaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Create a PaymentIntent with the order amount and currency
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // Convert to cents
                'currency' => 'lkr',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'customer_name' => $request->name,
                    'customer_email' => $request->email,
                ],
            ]);

            // Save order details temporarily (you can use session)
            session([
                'order_details' => [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'payment_method' => 'card',
                    'amount' => $request->amount,
                ]
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntentId' => $paymentIntent->id,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handlePaymentSuccess(Request $request)
    {
        // Verify payment with Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent);
            
            if ($paymentIntent->status === 'succeeded') {
                // Get cart from session
                $cart = session('cart', []);
                
                // Create order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'name' => session('order_details.name'),
                    'email' => session('order_details.email'),
                    'phone' => session('order_details.phone'),
                    'address' => session('order_details.address'),
                    'city' => session('order_details.city'),
                    'total' => session('order_details.amount'),
                    'payment_method' => 'card',
                    'payment_status' => 'paid',
                    'stripe_payment_id' => $paymentIntent->id,
                    'order_status' => 'processing',
                ]);

                // Save order items
                foreach ($cart as $productId => $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $productId,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }

                // Clear cart and session
                session()->forget(['cart', 'order_details']);

                return redirect()->route('order.success', ['order' => $order->id])
                    ->with('success', 'Payment successful! Your order has been placed.');
            }

            return redirect()->route('checkout.index')
                ->with('error', 'Payment failed. Please try again.');

        } catch (\Exception $e) {
            return redirect()->route('checkout.index')
                ->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }
}