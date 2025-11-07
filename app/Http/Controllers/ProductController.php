<?php

namespace App\Http\Controllers;

use Database\Seeders\ProductSeeder;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Products;

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
        $products = \App\Models\Products::all();

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
        $product = \App\Models\Products::find($id);

        if (!$product) {
            abort(404, 'Product not found');
        }

        return view('profile.product.details', compact('product'));
    }

        public function show($id)
    {
        // Find the product by its ID
        $product = Products::where('id', $id)->first();

        // If not found, return error view
        if (!$product) {
            return view('profile.product.details', ['product' => null]);
        }

        // Pass the product to the view
        return view('profile.product.details', compact('product'));
    }


}
