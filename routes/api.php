<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\AdminMiddleware; // <-- Add this

// --------------------
// PUBLIC ROUTES
// --------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Anyone can GET products
Route::get('/products', [ProductController::class, 'apiIndex2']);
Route::get('/products/{id}', [ProductController::class, 'apiShow']);

// --------------------
// USER PROTECTED ROUTES
// --------------------
Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Reviews
    Route::post('/products/{id}/review', [ReviewController::class, 'store']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    // Wishlist
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add']);
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove']);

    // Cart
    Route::post('/cart/add/{id}', [CartController::class, 'add']);
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity']);
    Route::post('/cart/remove/{id}', [CartController::class, 'remove']);
    Route::get('/cart', [CartController::class, 'index']);

    // Orders
    Route::post('/checkout/place-order', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'index']);
});

// --------------------
// ADMIN PROTECTED ROUTES
// --------------------
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);

    Route::apiResource('/admin/products', AdminProductController::class);
    Route::apiResource('/admin/orders', AdminOrderController::class);
});
