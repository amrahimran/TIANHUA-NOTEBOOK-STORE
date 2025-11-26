<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:255|unique:products',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'color' => 'nullable|string|max:100',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'isBestSeller' => 'required|boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        $product = new Products();
        $product->id = $request->id;
        $product->name = $request->name;
        $product->category = $request->category;
        $product->color = $request->color;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->isBestSeller = $request->isBestSeller;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        } elseif ($request->image_url) {
            $product->image = $request->image_url;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $request->validate([
            'id' => 'required|string|max:255|unique:products,id,' . $product->id . ',id',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'color' => 'nullable|string|max:100',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'isBestSeller' => 'required|boolean',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        $product->id = $request->id;
        $product->name = $request->name;
        $product->category = $request->category;
        $product->color = $request->color;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->isBestSeller = $request->isBestSeller;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
