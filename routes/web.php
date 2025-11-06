<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
