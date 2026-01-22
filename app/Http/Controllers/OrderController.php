<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Models\User;




class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with(['items.product']) // eager load products for each order item
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Optional: transform for cleaner JSON
        $orders = $orders->map(function($order) {
            return [
                'id' => $order->id,
                'total' => $order->total,
                'status' => $order->status ?? 'Pending',
                'payment_method' => $order->payment_method,
                'city' => $order->city,
                'items' => $order->items->map(function($item) {
                    return [
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'product' => $item->product ? [
                            'name' => $item->product->name,
                            'image' => $item->product->image, // full URL or storage path
                        ] : null,
                    ];
                }),
            ];
        });

        return response()->json($orders);
    }


    // Place order from Flutter
    public function placeOrder(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'payment_method' => 'required|string|max:50',
            'total' => 'required|numeric',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|string', 
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Create the main order
        $order = Order::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'payment_method' => $request->payment_method,
            'total' => $request->total,
        ]);

        // Loop through cart items and save order_items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

                $admins = User::where('role', 'admin')->get();

                $messaging = Firebase::messaging();

                foreach ($admins as $admin) {
                    if ($admin->fcm_token) { // assuming you store FCM device tokens in a column fcm_token
                        try {
                            $messaging->send([
                                'token' => $admin->fcm_token,
                                'notification' => [
                                    'title' => 'New Order Received',
                                    'body' => "Order #{$order->id} from {$user->name} totaling Rs {$order->total}",
                                ],
                                'data' => [
                                    'order_id' => (string)$order->id,
                                    'user_id' => (string)$user->id,
                                ],
                            ]);
                        } catch (\Throwable $e) {
                            Log::error("FCM error: ".$e->getMessage());
                        }
                    }
                }

        return response()->json([
            'message' => 'Order placed successfully!',
            'order_id' => $order->id,
        ], 201);
    }


}
