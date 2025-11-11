<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        $productsCount = Products::count();
        $ordersCount = Order::count();

        return view('admin.dashboard', compact('productsCount', 'ordersCount'));
    }
}
