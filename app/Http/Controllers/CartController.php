<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    
    public function add(Request $request, $id)
    {
        // Always use logged-in user ID
        $user_id = Auth::id();
        $product = Products::where('id', $id)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        $cart = session()->get('cart', []);

        // Get quantity from request, default to 1
        $quantity = intval($request->quantity ?? 1);

        if (isset($cart[$id])) {
            // If already in cart, add the requested quantity
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Added to cart', 'cart' => $cart]);
    }


    // Show cart page
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('profile.product.cart', compact('cart'));
    }

    // Remove item
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed successfully!');
    }

    // Update quantity
    public function updateQuantity(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Convert quantity to integer to avoid string issues
            $cart[$id]['quantity'] = intval($request->quantity);
            session()->put('cart', $cart);
        }

        // Return JSON response for AJAX
        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function addToUserCart(Request $request, $userId, $productId)
{
    // Prevent User A from editing User B's cart
    if (Auth::id() != $userId) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Validate data
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

        // Add to cart
        $cart = Cart::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $productId
            ],
            [
                'quantity' => $request->quantity
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'data' => $cart
        ]);
    }


}
