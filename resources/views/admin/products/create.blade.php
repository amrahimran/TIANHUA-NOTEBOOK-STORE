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

            {{-- Display general errors --}}
            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="create-product-form">
                @csrf

                <div class="mb-4">
                    <label class="block">Product ID</label>
                    <input type="text" name="id" id="product-id" 
                        class="w-full border rounded px-2 py-1" 
                        value="{{ old('id') }}" required>
                    <p id="id-error" class="text-red-500 text-sm mt-1">
                        @error('id') {{ $message }} @enderror
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block">Name</label>
                    <input type="text" name="name" class="w-full border rounded px-2 py-1" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Category</label>
                    <input type="text" name="category" class="w-full border rounded px-2 py-1" value="{{ old('category') }}" required>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Color</label>
                    <input type="text" name="color" class="w-full border rounded px-2 py-1" value="{{ old('color') }}" required>
                    @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Price</label>
                    <input type="number" step="0.01" name="price" class="w-full border rounded px-2 py-1" value="{{ old('price') }}" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Quantity</label>
                    <input type="number" name="quantity" class="w-full border rounded px-2 py-1" value="{{ old('quantity') }}" required>
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Best Seller</label>
                    <select name="isBestSeller" class="w-full border rounded px-2 py-1">
                        <option value="0" {{ old('isBestSeller') == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('isBestSeller') == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                    @error('isBestSeller')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Description</label>
                    <textarea name="description" class="w-full border rounded px-2 py-1" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Image</label>
                    <input type="file" name="image">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Or Enter Image URL/Path</label>
                    <input type="text" name="image_url" class="w-full border rounded px-2 py-1" placeholder="https://example.com/image.jpg" value="{{ old('image_url') }}">
                </div>

                <button type="submit" class="bg-[#49608a] text-white px-4 py-2 rounded hover:bg-[#3a4e73]">Save</button>
            </form>
        </div>
    </div>

    {{-- Real-time Product ID check --}}
    <script>
        const productIdInput = document.getElementById('product-id');
        const idError = document.getElementById('id-error');

        productIdInput.addEventListener('input', function() {
            const id = this.value.trim();
            if (id.length === 0) {
                idError.textContent = '';
                return;
            }

            fetch(`/admin/products/check-id?id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if(data.exists) {
                        idError.textContent = 'This Product ID is already taken!';
                    } else {
                        idError.textContent = '';
                    }
                })
                .catch(() => {
                    idError.textContent = 'Error checking Product ID';
                });
        });
    </script>
</x-app-layout>
