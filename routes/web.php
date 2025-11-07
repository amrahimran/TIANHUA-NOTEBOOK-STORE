<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ProductController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
});

Route::get('product/details/{id}', [ProductController::class, 'product.details'])->name('details');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });


// Route::get('/profile/dashboard', function () {
//     return view('dashboard');
// })->name('home');

Route::get('/profile/products', function () {
    return view('products');
})->name('products');

Route::get('/profile/myorders', function () {
    return view('myorders');
})->name('myorders');

Route::get('/profile/about', function () {
    return view('profile.about');
})->name('about');

Route::get('/profile/contact', function () {
    return view('contact');
})->name('contact');

// Wishlist Page
Route::get('/profile/products/wishlist', function () {
    return view('profile.products.wishlist');
})->name('wishlist');

// Cart Page
Route::get('/profile/products/cart', function () {
    return view('profile.products.cart');
})->name('cart');



