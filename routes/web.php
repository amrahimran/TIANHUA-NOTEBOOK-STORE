<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\SocialiteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
});

Route::get('product/details/{id}', [ProductController::class, 'product.details'])->name('details');

//Route::get('/profile/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/profile/products', [ProductController::class, 'index'])
    ->name('profile.products.index');


Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');


Route::get('/profile/myorders', function () {
    $orders = Order::where('user_id', Auth::id())->get(); // fetch orders for logged-in user
    return view('myorders', compact('orders'));
})->name('myorders')->middleware('auth');

// Route::get('/profile/about', function () {
//     return view('profile.about');
// })->name('about');

Route::get('/profile/about', [App\Http\Controllers\AboutUsController::class, 'index'])->name('about');



Route::get('/profile/contact', function () {
    return view('profile.contact');
})->name('contact');

// Handle contact form submission
Route::post('/profile/contact', [ContactController::class, 'submit'])->name('contact.submit');



Route::middleware(['auth'])->group(function () {
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// Cart Page

Route::get('/profile/products/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');



Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
});

//Orders/checkout routes

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

Route::get('/myorders', [OrderController::class, 'index'])->name('myorders');

//admin routes with middleware.

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Middleware\AdminMiddleware;


Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // CRUD for products
    Route::resource('admin/products', AdminProductController::class, ['as' => 'admin']);

    // CRUD for orders
    Route::resource('admin/orders', AdminOrderController::class, ['as' => 'admin']);
});


Route::post('product/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');
Route::delete('review/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
Route::get('product/{id}', [ProductController::class, 'show'])->name('product.show');


Route::get('/csrf-token', function () {
    return ['csrf_token' => csrf_token()];
});


use Illuminate\Support\Facades\Http;
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::post('/stripe/create-intent', [CheckoutController::class, 'createPaymentIntent'])->name('stripe.create-intent');

Route::get('/payment/success', function () {
    return 'Payment completed successfully! (sandbox demo)';
})->name('payment.success');

Route::get('/payment/cancel', function () {
    return 'Payment was cancelled.';
})->name('payment.cancel');

Route::post('/payment/notify', function () {
    Log::info(request()->all());
    return response('OK', 200);
})->name('payment.notify');