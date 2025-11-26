<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block">Name</label>
                    <input type="text" name="id" class="w-full border rounded px-2 py-1" value="{{ old('id', $product->id ?? '') }}">
                </div>
               
                <div class="mb-4">
                    <label class="block">Name</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Category</label>
                    <input type="text" name="category" value="{{ $product->category }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Color</label>
                    <input type="text" name="color" value="{{ $product->color }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Quantity</label>
                    <input type="number" name="quantity" value="{{ $product->quantity }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Best Seller</label>
                    <select name="isBestSeller" class="w-full border rounded px-2 py-1">
                        <option value="0" @if(!$product->isBestSeller) selected @endif>No</option>
                        <option value="1" @if($product->isBestSeller) selected @endif>Yes</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block">Description</label>
                    <textarea name="description" class="w-full border rounded px-2 py-1">{{ $product->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block">Image</label>
                    <input type="file" name="image">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="mt-2 w-32">
                    @endif
                </div>

                <button type="submit" class="bg-[#49608a] text-white px-4 py-2 rounded hover:bg-[#3a4e73]">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
