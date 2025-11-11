<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Show all orders
    public function index()
    {
        $orders = Order::all(); // Or paginate: Order::paginate(10)
        return view('admin.orders.index', compact('orders'));
    }

    // Show form to create an order (optional)
    public function create()
    {
        return view('admin.orders.create');
    }

    // Store a new order (optional)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total' => 'required|numeric',
            'status' => 'required|string',
        ]);

        Order::create($request->all());

        return redirect()->route('admin.orders.index')->with('success', 'Order added successfully!');
    }

    // Show form to edit an order
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    // Update an order
    public function update(Request $request, Order $order)
    {
        // Validate input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'total' => 'required|numeric',
            'status' => 'required|in:Pending,Completed', // only allow these two
        ]);

        // Update the order
        $order->update([
            'name' => $request->customer_name,
            'total' => $request->total,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully!');
    }


    // Delete an order
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully!');
    }
}

