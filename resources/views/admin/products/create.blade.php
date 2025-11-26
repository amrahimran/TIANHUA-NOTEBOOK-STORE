<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Product
        </h2>
    </x-slot>

    <x-nav-link :href="route('admin.products.index')" class="ml-8 mt-4">
        Back To Products Dashboard
    </x-nav-link>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block">Product ID</label>
                    <input type="text" name="id" class="w-full border rounded px-2 py-1" value="{{ old('id', $product->id ?? '') }}">

                </div>

                <div class="mb-4">
                    <label class="block">Name</label>
                    <input type="text" name="name" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Category</label>
                    <input type="text" name="category" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Color</label>
                    <input type="text" name="color" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Price</label>
                    <input type="number" step="0.01" name="price" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Quantity</label>
                    <input type="number" name="quantity" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Best Seller</label>
                    <select name="isBestSeller" class="w-full border rounded px-2 py-1">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block">Description</label>
                    <textarea name="description" class="w-full border rounded px-2 py-1"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block">Image</label>
                    <input type="file" name="image">
                </div>

                <div class="mb-4">
                    <label class="block">Or Enter Image URL/Path</label>
                    <input type="text" name="image_url" class="w-full border rounded px-2 py-1" placeholder="https://example.com/image.jpg">
                </div>

                <button type="submit" class="bg-[#49608a] text-white px-4 py-2 rounded hover:bg-[#3a4e73]">Save</button>
            </form>
        </div>
    </div>
</x-app-layout>
