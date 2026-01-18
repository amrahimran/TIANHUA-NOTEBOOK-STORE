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

        // Clear cart for COD or after redirecting
        if ($request->payment_method !== 'card') {
            session()->forget('cart');
        }

        // Handle Demo Card Payment
        if ($request->payment_method === 'card') {
            // Validate demo card inputs
            $request->validate([
                'card_number' => ['required', 'regex:/^[0-9 ]{16,19}$/'],
                'expiry'      => ['required', 'date_format:m/y'],
                'cvv'         => ['required', 'digits:3'],
            ]);

            // Simulate processing
            sleep(1);

            // Update order status
            $order->update(['status' => 'paid']);

            session()->forget('cart');

            // return redirect()->route('payment.success')->with('success', 'Payment successful (Demo Mode)');
            return redirect()->route('myorders')->with('success', 'Payment successful');

        }


        // COD
        return redirect()->route('myorders')->with('success', 'Your order has been placed successfully!');
    }
}