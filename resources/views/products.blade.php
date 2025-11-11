@section('title', 'Products | Tian Hua')

<x-app-layout>

    <div class="px-4 md:px-10 lg:px-14 pt-10">
        {{-- Search Bar --}}
        <form action="{{ route('products.index') }}" method="GET" class="flex justify-center mb-8">
            <div class="bg-white flex items-center px-3 rounded-full w-full max-w-lg shadow-md">
                <button type="submit" class="text-accent-color text-xl mr-2">
                    <i class="fas fa-search"></i>
                </button>
                <input 
                    type="text"
                    name="search"
                    placeholder="Search products..."
                    value="{{ request('search') }}"
                    class="bg-transparent w-full px-4 py-2 focus:outline-none border-none mr-2"
                />
            </div>
        </form>

        {{-- Products Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-14">
            @forelse ($products as $product)
                <div
                    class="bg-white shadow-lg shadow-gray-200 rounded-lg overflow-hidden transform transition-transform duration-300 ease-in-out hover:scale-110 hover:shadow-xl">
                    <img
                        src="{{ asset($product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-[250px] lg:h-[280px] object-cover"
                    >
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-gray-600 mt-2 mb-2 h-[48px] overflow-hidden">{{ $product->description }}</p>
                        <p class="text-accent-color font-bold mb-2">Rs. {{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('product.show', $product->id) }}">
                            <button class="button px-4 py-2 rounded mt-2 w-full">View Details</button>
                        </a>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500 text-lg">No products found.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

