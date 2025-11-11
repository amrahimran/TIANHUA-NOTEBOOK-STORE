<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class CartController extends Controller
{
    // 🛒 Add item to cart
    public function add($id)
    {
        $product = Products::where('id', $id)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Added to cart']);
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

    // 🔄 Update quantity
    public function updateQuantity(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }
}
