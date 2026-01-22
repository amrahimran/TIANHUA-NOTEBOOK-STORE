<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get the cart from session
        $cart = session()->get('cart', []);

        // Calculate total
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('checkout.index', compact('cart', 'total'));
    }

    public function createPaymentIntent(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $amount = round($total * 100); // Amount in cents

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'lkr', // Assuming LKR based on "Rs." in view
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function placeOrder(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        // Get cart from session
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->withInput()->with('error', 'Your cart is empty!');
        }

        // Calculate total
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Save order
        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'payment_method' => $request->payment_method,
            'total' => $total,
            'status' => 'pending',
        ]);

        // Save order items and update stock
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            $product = Products::find($productId);
            if ($product) {
                $product->quantity = max(0, $product->quantity - $item['quantity']);
                $product->save();
            }
        }

        // Handle Card Payment
        if ($request->payment_method === 'card') {
            // In a real app, you might verify the payment_intent_id here
            // For now, we assume the frontend has successfully confirmed the payment
            $order->update(['status' => 'paid']);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('myorders')->with('success', 'Your order has been placed successfully!');
    }
}