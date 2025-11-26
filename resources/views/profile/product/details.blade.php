@section('title', 'Product Details | Tian Hua')
<x-app-layout>

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
                    <i id="wishlist-icon"
                        class="{{ in_array($product->id, $wishlistProductIds ?? []) ? 'fas' : 'far' }} fa-heart text-[#49608a] text-2xl cursor-pointer transition-all duration-200"
                        data-product-id="{{ $product->id }}">
                    </i>
                </div>
                <p class="mt-2">{{ $product->description }}</p>
                <p class="text-[#49608a] font-bold text-2xl mt-4">Rs.{{ $product->price }}</p>

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

                <!-- Product Color Options -->
                @if (strpos($product->id, 'C') !== false)
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-700">Color</h4>
                        <div 
                            class="flex space-x-4 mt-2" 
                            id="color-options"
                            data-product-id="{{ $product->id }}" 
                            data-current-color="{{ strtolower($product->color) }}">
                        </div>
                    </div>
                @endif

                <!-- Quantity -->
                <div class="mt-6 flex items-center">
                    <h4 class="text-lg font-semibold text-gray-700 mr-4">Quantity</h4>
                    <div class="flex items-center border rounded-lg shadow-sm overflow-hidden">
                        <button id="decrement" class="px-4 py-2 bg-[#49608a] text-white hover:bg-[#7dadc4] rounded-l-lg">-</button>
                        <input type="number" id="quantity" class="w-14 text-center px-1 py-1 bg-white border-none text-gray-600 font-semibold outline-none" value="1" min="1" readonly>
                        <button id="increment" class="px-4 py-2 bg-[#49608a] text-white hover:bg-[#7dadc4] rounded-r-lg">+</button>
                    </div>
                </div>

                <!-- Add to Cart -->
                <div class="mt-8">
                    <button class="button" id="addToCart" data-id="{{ $product->id }}" onclick="addToCart('{{ $product->id }}')">Add to Cart</button>
                </div>
            </div>
        </div>

        <hr class="my-6">

        <h3 class="text-xl font-semibold mb-4">Customer Reviews</h3>

        <!-- Existing Reviews -->
        @forelse($reviews as $review)
            <div class="mb-4 border-b pb-2">
                <div class="flex justify-between">
                    <strong>{{ $review->user->name ?? 'Unknown User' }}</strong>
                    <span class="text-yellow-500">⭐ {{ $review->rating }}/5</span>
                </div>
                <p>{{ $review->comment }}</p>

                @if(Auth::check() && Auth::id() == $review->user_id)
                    <form action="{{ route('reviews.destroy', $review->_id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 text-sm">Delete</button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-gray-600">No reviews yet. Be the first to review this product!</p>
        @endforelse

        <!-- Add Review Form -->
        @if(Auth::check())
            <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="mt-6">
                @csrf
                <div class="mb-3">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                    <select name="rating" id="rating" class="w-24 mt-1 border-gray-300 rounded-md">
                        @for($i=1; $i<=5; $i++)
                            <option value="{{ $i }}">{{ str_repeat('⭐', $i) }} {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                    <textarea name="comment" id="comment" rows="3" class="w-full border-gray-300 rounded-md" required></textarea>
                </div>

                <button type="submit" class="button">Submit Review</button>
            </form>
        @else
            <p class="text-gray-600 mt-4">Please <a href="/login" class="text-blue-600 underline">log in</a> to write a review.</p>
        @endif

    @else
        <p class="text-center text-lg text-red-500">Product not found or not available.</p>
    @endif
</main>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInput = document.getElementById('quantity');
        const incrementBtn = document.getElementById('increment');
        const decrementBtn = document.getElementById('decrement');

        incrementBtn.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });

        decrementBtn.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const wishlistIcon = document.getElementById('wishlist-icon');
        wishlistIcon.addEventListener('click', function () {
            const productId = this.dataset.productId;

            fetch(`/wishlist/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Toggle heart
                    if (wishlistIcon.classList.contains('far')) {
                        wishlistIcon.classList.remove('far');
                        wishlistIcon.classList.add('fas');
                    } else {
                        wishlistIcon.classList.remove('fas');
                        wishlistIcon.classList.add('far');
                    }
                }
            });
        });
    });


    document.addEventListener("DOMContentLoaded", () => {
    const colorOptionsContainer = document.getElementById("color-options");
    if (!colorOptionsContainer) return; // Exit if no color options on page

    const productId = colorOptionsContainer.dataset.productId;
    const currentColor = colorOptionsContainer.dataset.currentColor.toLowerCase();

    // Define the available colors and their suffix codes
    const specialColors = {
        pink: "PINK",
        blue: "BLUE",
        green: "GREEN",
        black: "BLACK"
    };

    // Map colors to visual Tailwind background colors
    function getColorCode(color) {
        switch(color) {
            case "pink": return "#f277a8";
            case "blue": return "#6fbae0";
            case "green": return "#6f966a";
            case "black": return "#000000";
            default: return "#fff";
        }
    }

    // Create a color button
    function createColorButton(color, isSelected) {
        const button = document.createElement("button");
        button.className = `w-8 h-8 rounded-full border cursor-pointer transition-all duration-200
            ${isSelected ? 'border-4 border-accent-color scale-110' : 'border-gray-300'}`;
        button.style.backgroundColor = getColorCode(color);
        button.dataset.color = color;

        // Click event to switch product color
        button.addEventListener("click", () => handleColorChange(color));

        return button;
    }

    // Handle color change
    function handleColorChange(selectedColor) {
        if (specialColors[selectedColor]) {
            const newColorCode = specialColors[selectedColor];
            let newId = productId;

            // Replace existing color suffix in product ID
            Object.values(specialColors).forEach(colorSuffix => {
                if (productId.endsWith(colorSuffix)) {
                    newId = productId.slice(0, productId.length - colorSuffix.length) + newColorCode;
                }
            });

            // Redirect to new product details URL
            window.location.href = `{{ url('product') }}/` + newId;
        }
    }

    // Render all color options
        function renderColorOptions(productId, currentColor) {
            if (productId.includes("C")) {
                Object.keys(specialColors).forEach(color => {
                    const button = createColorButton(color, color === currentColor);
                    colorOptionsContainer.appendChild(button);
                });
            } else {
                const button = createColorButton(currentColor, true);
                colorOptionsContainer.appendChild(button);
            }
        }

        renderColorOptions(productId, currentColor);
    });

        // size switching (A5 <-> B5)
    document.addEventListener('DOMContentLoaded', () => {
        const mediumBtn = document.getElementById('mediumbtn'); // B5
        const largeBtn = document.getElementById('largebtn');   // A5
        const currentProductId = "{{ $product->id }}";

        function switchProductSize(targetPrefix) {
            const newId = targetPrefix + currentProductId.substring(1); 
            window.location.href = `{{ url('product') }}/` + newId;
        }

        // B5 (M)
        mediumBtn.addEventListener('click', () => {
            if (currentProductId.charAt(0) !== 'M') {
                switchProductSize('M');
            }
        });

        // A5 (L)
        largeBtn.addEventListener('click', () => {
            if (currentProductId.charAt(0) !== 'L') {
                switchProductSize('L');
            }
        });
    });

    const addToCartBtn = document.getElementById('addToCart');
    addToCartBtn.addEventListener('click', function () {
        const productId = this.dataset.id;

        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('✅ Added to cart!');
            } else {
                alert('⚠️ ' + (data.error || 'Could not add to cart.'));
            }
        });
    });


    </script>

</x-app-layout>