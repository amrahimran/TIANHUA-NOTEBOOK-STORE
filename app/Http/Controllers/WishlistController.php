<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Show wishlist
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->get();
        return view('profile.product.wishlist', compact('wishlists'));
    }

    // Add to wishlist
    public function add(Products $product)
    {
        $user = Auth::user();

        // Avoid duplicates
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
            ]);
        }

        return response()->json(['success' => true]);
    }

    // Remove item from wishlist
    public function remove($id)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->delete();

        return redirect()->route('wishlist.index')->with('success', 'Item removed successfully!');
    }
}
