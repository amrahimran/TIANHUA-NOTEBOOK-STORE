<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Products
        </h2>
    </x-slot>

    <x-nav-link :href="route('admin.dashboard')" class="ml-8 mt-4">
        Back To Dashboard
    </x-nav-link>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('admin.products.create') }}" class="bg-[#49608a] text-white px-4 py-2 rounded hover:bg-[#3a4e73]">Add Product</a>

            <table class="min-w-full bg-white shadow rounded">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Category</th>
                        <th class="px-4 py-2">Color</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Best Seller</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td class="border px-4 py-2">{{ $product->id }}</td>
                        <td class="border px-4 py-2">{{ $product->name }}</td>
                        <td class="border px-4 py-2">{{ $product->category }}</td>
                        <td class="border px-4 py-2">{{ $product->color }}</td>
                        <td class="border px-4 py-2">Rs. {{ number_format($product->price, 2) }}</td>
                        <td class="border px-4 py-2">{{ $product->quantity }}</td>
                        <td class="border px-4 py-2">{{ $product->isBestSeller ? 'Yes' : 'No' }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this product?')" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
