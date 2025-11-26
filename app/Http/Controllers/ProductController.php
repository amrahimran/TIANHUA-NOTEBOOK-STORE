<?php

namespace App\Http\Controllers;

use Database\Seeders\ProductSeeder;
use Illuminate\Http\Request;
//use App\Models\Product;
use App\Models\Products;
use App\Models\Wishlist;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // public function index()
    // {
    //     // Fetch all products from database
    //     $products = Products::all();

    //     // Define categories
    //     $categories = [
    //         "Vintage Collection" => "vintage",
    //         "Journals" => "journal",
    //         "Cute Notebooks" => "cute",
    //         "Eastern Beauty" => "eastern",
    //     ];

    //     return view('home', compact('products', 'categories'));
    // }

    public function dashboard()
{
        $products = Products::all();

        $categories = [
            "Vintage Collection" => "vintage",
            "Journals" => "journal",
            "Cute Notebooks" => "cute",
            "Eastern Beauty" => "eastern",
        ];

        return view('dashboard', compact('products', 'categories'));
    }

    public function details($id)
    {
        $product = Products::find($id);

        if (!$product) {
            abort(404, 'Product not found');
        }

        

        return view('profile.product.details', compact('product'));
    }

    // public function show($id)
    // {
    //     // Find the product by its ID
    //     $product = Products::where('id', $id)->first();

    //     // If not found, return error view
    //     if (!$product) {
    //         return view('profile.product.details', ['product' => null]);
    //     }

    //     // Get current user's wishlist product IDs
    //     $wishlistProductIds = [];
    //     if (Auth::check()) {
    //         $wishlistProductIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
    //     }

    //     // Pass the product and wishlist info to the view
    //     return view('profile.product.details', compact('product', 'wishlistProductIds'));
    // }

    public function show($id)
    {
        // Fetch product from MySQL
        $product = Products::where('id', $id)->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        // Fetch reviews from MongoDB with user info
        try {
            $reviews = Review::where('product_id', $id)->get();

            // Manually attach users
            foreach ($reviews as $review) {
                $review->user = \App\Models\User::find($review->user_id);
            }
        } catch (\Exception $e) {
            $reviews = collect();
        }



        // Fetch current user's wishlist items
        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }

        return view('profile.product.details', compact('product', 'reviews', 'wishlistProductIds'));
    }



         public function index(Request $request)
        {   
            /** @var \Illuminate\Http\Request $request */
            $search = $request->input('search');

            $query = Products::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('color', 'like', "%{$search}%");
                    //->orWhere('description', 'like', "%{$search}%");
                    
                });
            }

            $products = $query->get();

            return view('products', compact('products'));
        }

        public function apiIndex(Request $request)
{
    $search = $request->input('search');

    $query = Products::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('color', 'like', "%{$search}%");
        });
    }

    $products = $query->get();

    return response()->json([
        'success' => true,
        'data' => $products
    ]);
}


// API: List all products
public function apiIndex2(Request $request)
{
    $search = $request->input('search');
    $query = Products::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('color', 'like', "%{$search}%");
        });
    }

    $products = $query->get();

    return response()->json([
        'success' => true,
        'data' => $products
    ]);
}

// API: Show single product
public function apiShow($id)
{
    $product = Products::where('id', $id)->first(); // string IDs
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }
    return response()->json([
        'success' => true,
        'data' => $product
    ]);
}




    

}
