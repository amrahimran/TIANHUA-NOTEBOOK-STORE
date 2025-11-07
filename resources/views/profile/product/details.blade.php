{{-- @extends('layouts.app') --}}
<x-app-layout>
{{-- 
@section('title', 'Product Details | Tian Hua')

@section('content') --}}
<main class="max-w-7xl mx-auto p-6 font-roboto">
    @if ($product)
        <h2 class="subheading">{{ $product->name }}</h2>
        <div class="flex flex-wrap md:flex-nowrap">
            <!-- Product Image -->
            <div class="w-full md:w-11/20 pr-6">
                <div id="imageContainer" class="overflow-hidden">
                    <img id="productImage" src="{{ asset($product->image) }}" alt="Product Image" class="rounded shadow mb-4">
                </div>
            </div>

            <!-- Product Info -->
            <div class="w-full md:w-9/20">
                <div class="flex justify-between items-center">
                    <h3 class="text-3xl font-bold mt-4">{{ $product->name }}</h3>
                    <i id="wishlist-icon" class="far fa-heart text-accent-color text-2xl cursor-pointer"></i>
                </div>
                <p class="mt-2">{{ $product->description }}</p>
                <p class="text-blue-theme font-bold text-2xl mt-4">Rs.{{ $product->price }}</p>

                <!-- Size Options -->
                @if (strtolower($product->category) !== 'other')
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-700">Size</h4>
                        <div class="flex space-x-4 mt-2">
                            <button id="mediumbtn" class="button">B5</button>
                            <button id="largebtn" class="button">A5</button>
                        </div>
                    </div>
                @endif

                <!-- Color Options -->
                @if (strpos($product->id, 'C') !== false)
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-700">Color</h4>
                        <div 
                            class="flex space-x-4 mt-2" 
                            id="color-options"
                            data-product-id="{{ $product->id }}" 
                            data-current-color="{{ strtolower($product->color) }}">
                            <!-- Colors will be injected dynamically -->
                        </div>
                    </div>
                @endif

                <!-- Quantity -->
                <div class="mt-6 flex items-center">
                    <h4 class="text-lg font-semibold text-gray-700 mr-4">Quantity</h4>
                    <div class="flex items-center border rounded-lg shadow-sm overflow-hidden">
                        <button id="decrement" class="px-4 py-2 bg-blue-theme text-white hover:bg-accent-color transition-colors duration-200 ease-in-out rounded-l-lg">-</button>
                        <input type="number" id="quantity" class="w-14 text-center px-2 py-1 bg-white border-t border-b text-gray-600 font-semibold focus:outline-none" value="1" min="1" readonly>
                        <button id="increment" class="px-4 py-2 bg-blue-theme text-white hover:bg-accent-color transition-colors duration-200 ease-in-out rounded-r-lg">+</button>
                    </div>
                </div>

                <!-- Add to Cart -->
                <div class="mt-8">
                    <button class="button" id="addToCart" data-id="{{ $product->id }}">Add to Cart</button>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-lg text-red-500">Product not found or not available.</p>
    @endif
</main>
{{-- @endsection --}}

</x-app-layout>
