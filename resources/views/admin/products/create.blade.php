<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block">Name</label>
                    <input type="text" name="name" class="w-full border rounded px-2 py-1">
                </div>
                <div class="mb-4">
                    <label class="block">Price</label>
                    <input type="number" name="price" class="w-full border rounded px-2 py-1">
                </div>
                <div class="mb-4">
                    <label class="block">Description</label>
                    <textarea name="description" class="w-full border rounded px-2 py-1"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block">Image</label>
                    <input type="file" name="image">
                </div>
                <button type="submit" class="bg-[#49608a] text-white px-4 py-2 rounded hover:bg-[#3a4e73]">Save</button>
            </form>
        </div>
    </div>
</x-app-layout>
