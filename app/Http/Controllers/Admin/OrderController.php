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
        $orders = Order::orderBy('id', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Show form to edit an order
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    // Update an order
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'payment_method' => 'required|string|max:50',
            'total' => 'required|numeric',
            'status' => 'required|in:Pending,Completed',
        ]);

        $order->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'payment_method' => $request->payment_method,
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
