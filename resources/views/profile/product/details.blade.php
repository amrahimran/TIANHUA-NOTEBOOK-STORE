@section('title', 'Product Details | Tian Hua')
<x-app-layout>

    <main class="max-w-7xl mx-auto p-4 md:p-6 font-roboto">
        @if ($product)
            {{-- Success/Error Notification Container --}}
            <div id="notification-container" class="fixed top-4 right-4 z-50 max-w-md"></div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Image Section -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="relative">
                        <div id="imageContainer" class="overflow-hidden rounded-xl">
                            <img id="productImage" 
                                 src="{{ asset($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-auto object-cover rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                        </div>
                        
                        {{-- Wishlist Icon --}}
                        <button id="wishlist-icon"
                            class="absolute top-4 right-4 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110"
                            data-product-id="{{ $product->id }}"
                            aria-label="Add to wishlist">
                            <i class="{{ in_array($product->id, $wishlistProductIds ?? []) ? 'fas' : 'far' }} fa-heart text-[#49608a] text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Info Section -->
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
                    {{-- Product Header --}}
                    <div class="border-b border-gray-100 pb-6 mb-6">
                        <div class="flex justify-between items-start">
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $product->name }}</h1>
                        </div>
                        
                        {{-- Category Badge --}}
                        <div class="mt-2">
                            <span class="inline-block px-3 py-1 text-sm font-semibold bg-gray-100 text-gray-800 rounded-full">
                                {{ ucfirst($product->category) }}
                            </span>
                        </div>
                        
                        {{-- Price --}}
                        <div class="mt-4">
                            <p class="text-4xl font-bold text-[#49608a]">Rs. {{ number_format($product->price, 2) }}</p>
                            <p class="text-gray-500 text-sm mt-1">Inclusive of all taxes</p>
                        </div>
                    </div>

                    {{-- Product Description --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    {{-- Size Options --}}
                    @if (strtolower($product->category) !== 'other')
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-ruler-combined text-[#49608a] mr-2"></i>
                                Size Options
                            </h4>
                            <div class="flex space-x-4">
                                <button id="mediumbtn" 
                                    class="px-6 py-3 rounded-lg border-2 {{ $product->id[0] === 'M' ? 'border-[#49608a] bg-[#49608a] text-white' : 'border-gray-300 text-gray-700 hover:border-[#49608a] hover:text-[#49608a]' }} 
                                           transition-all duration-300 font-medium shadow-sm hover:shadow-md">
                                    B5
                                </button>
                                <button id="largebtn" 
                                    class="px-6 py-3 rounded-lg border-2 {{ $product->id[0] === 'L' ? 'border-[#49608a] bg-[#49608a] text-white' : 'border-gray-300 text-gray-700 hover:border-[#49608a] hover:text-[#49608a]' }} 
                                           transition-all duration-300 font-medium shadow-sm hover:shadow-md">
                                    A5
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- Product Color Options --}}
                    @if (strpos($product->id, 'C') !== false)
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-palette text-[#49608a] mr-2"></i>
                                Available Colors
                            </h4>
                            <div class="flex space-x-4" 
                                 id="color-options"
                                 data-product-id="{{ $product->id }}" 
                                 data-current-color="{{ strtolower($product->color) }}">
                            </div>
                            <p class="text-gray-600 text-sm mt-3">Click on a color to view that variant</p>
                        </div>
                    @endif

                    {{-- Quantity Selector --}}
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-sort-amount-up text-[#49608a] mr-2"></i>
                            Quantity
                        </h4>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden shadow-sm">
                                <button id="decrement" 
                                        class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors duration-200">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" 
                                       id="quantity" 
                                       class="w-20 text-center px-4 py-3 bg-white text-gray-900 font-semibold text-lg border-x border-gray-300 outline-none"
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->quantity ?? 10 }}"
                                       readonly>
                                <button id="increment" 
                                        class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors duration-200">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <span class="text-gray-600 text-sm">
                                {{ $product->quantity ?? 10 }} items available
                            </span>
                        </div>
                    </div>

                    {{-- Add to Cart Button --}}
                    <div class="mt-10">
                        <button id="addToCart" 
                                data-id="{{ $product->id }}"
                                class="w-full bg-gradient-to-r from-[#49608a] to-[#3a4e73] text-white text-lg font-semibold py-4 px-6 rounded-xl 
                                       shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 
                                       flex items-center justify-center space-x-3">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Add to Cart</span>
                        </button>
                        
                        {{-- Additional Info --}}
                        <div class="mt-6 grid grid-cols-2 gap-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-truck text-[#49608a] mr-2"></i>
                                <span>Free Shipping</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt text-[#49608a] mr-2"></i>
                                <span>Secure Payment</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reviews Section --}}
            <div class="mt-12 bg-white rounded-2xl shadow-lg p-6 md:p-8">
                <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        Customer Reviews
                        <span class="text-lg font-normal text-gray-600 ml-2">({{ $reviews->count() }})</span>
                    </h3>
                    
                    @if(Auth::check())
                        <button id="reviewToggleBtn" 
                                class="bg-[#49608a] text-white px-6 py-2 rounded-lg hover:bg-[#3a4e73] transition-colors duration-300">
                            <i class="fas fa-plus mr-2"></i>Write a Review
                        </button>
                    @endif
                </div>

                {{-- Add Review Form (Initially Hidden) --}}
                @if(Auth::check())
                    <form id="reviewForm" 
                          action="{{ route('reviews.store', $product->id) }}" 
                          method="POST" 
                          class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200 hidden">
                        @csrf
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Write Your Review</h4>
                        
                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Your Rating</label>
                            <div class="flex space-x-1">
                                @for($i=1; $i<=5; $i++)
                                    <button type="button" 
                                            data-rating="{{ $i }}"
                                            class="rating-star text-2xl text-gray-300 hover:text-yellow-400 transition-colors duration-200">
                                        <i class="far fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="selectedRating" value="5" required>
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Your Comment</label>
                            <textarea name="comment" 
                                      id="comment" 
                                      rows="4" 
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#49608a] focus:ring focus:ring-[#49608a] focus:ring-opacity-50 transition"
                                      placeholder="Share your experience with this product..."
                                      required></textarea>
                        </div>

                        <div class="flex space-x-3">
                            <button type="submit" 
                                    class="bg-[#49608a] text-white px-6 py-3 rounded-lg hover:bg-[#3a4e73] transition-colors duration-300">
                                Submit Review
                            </button>
                            <button type="button" 
                                    id="cancelReviewBtn"
                                    class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors duration-300">
                                Cancel
                            </button>
                        </div>
                    </form>
                @endif

                {{-- Existing Reviews --}}
                @forelse($reviews as $review)
                    <div class="mb-6 pb-6 border-b border-gray-100 last:border-0">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-[#49608a] to-[#3a4e73] rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr($review->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <strong class="text-gray-900">{{ $review->user->name ?? 'Anonymous User' }}</strong>
                                    <p class="text-gray-500 text-sm">{{ $review->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="text-yellow-500 mr-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-gray-700 font-semibold">{{ $review->rating }}/5</span>
                            </div>
                        </div>
                        <p class="text-gray-700 leading-relaxed pl-13">{{ $review->comment }}</p>
                        
                        @if(Auth::check() && Auth::id() == $review->user_id)
                            <div class="mt-3 pl-13">
                                <form action="{{ route('reviews.destroy', $review->_id) }}" method="POST" 
                                      class="inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 text-sm font-medium transition-colors duration-200">
                                        <i class="fas fa-trash-alt mr-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i class="fas fa-comments text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-600 text-lg mb-2">No reviews yet</p>
                        <p class="text-gray-500">Be the first to review this product!</p>
                    </div>
                @endforelse

                @if(!Auth::check())
                    <div class="text-center py-8 border-t border-gray-100">
                        <p class="text-gray-600">
                            <a href="/login" class="text-[#49608a] hover:text-[#3a4e73] font-semibold transition-colors duration-200">
                                <i class="fas fa-sign-in-alt mr-2"></i>Log in
                            </a> to write a review
                        </p>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-20">
                <i class="fas fa-exclamation-triangle text-red-500 text-5xl mb-4"></i>
                <p class="text-xl text-gray-700">Product not found or not available.</p>
                <a href="{{ route('products.index') }}" 
                   class="mt-4 inline-block text-[#49608a] hover:text-[#3a4e73] font-semibold transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Products
                </a>
            </div>
        @endif
    </main>

    <script>
        // Notification System
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            
            const icons = {
                success: '✅',
                error: '❌',
                warning: '⚠️',
                info: 'ℹ️'
            };
            
            const colors = {
                success: 'bg-green-100 border-green-400 text-green-800',
                error: 'bg-red-100 border-red-400 text-red-800',
                warning: 'bg-yellow-100 border-yellow-400 text-yellow-800',
                info: 'bg-blue-100 border-blue-400 text-blue-800'
            };
            
            notification.className = `mb-3 p-4 rounded-lg border ${colors[type]} shadow-lg transform transition-all duration-300 animate-slide-in`;
            notification.innerHTML = `
                <div class="flex items-start">
                    <span class="text-xl mr-3">${icons[type]}</span>
                    <div class="flex-1">
                        <p class="font-medium">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Auto-remove after 4 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.transform = 'translateX(100%)';
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 300);
                }
            }, 4000);
        }

        // Quantity Management
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInput = document.getElementById('quantity');
            const incrementBtn = document.getElementById('increment');
            const decrementBtn = document.getElementById('decrement');

            incrementBtn.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                const max = parseInt(quantityInput.max) || 10;
                if (currentValue < max) {
                    quantityInput.value = currentValue + 1;
                    quantityInput.dispatchEvent(new Event('change'));
                } else {
                    showNotification('Maximum quantity reached', 'warning');
                }
            });

            decrementBtn.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                    quantityInput.dispatchEvent(new Event('change'));
                }
            });
        });

        // Wishlist Toggle with Notification
        document.addEventListener('DOMContentLoaded', function () {
            const wishlistIcon = document.getElementById('wishlist-icon');
            wishlistIcon.addEventListener('click', function (e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                const isCurrentlyInWishlist = wishlistIcon.querySelector('i').classList.contains('fas');
                
                // Add loading state
                const icon = wishlistIcon.querySelector('i');
                icon.classList.add('fa-spinner', 'fa-spin');
                icon.classList.remove('fa-heart', 'fas', 'far');
                
                fetch(`/wishlist/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).then(res => res.json())
                .then(data => {
                    // Restore heart icon
                    icon.classList.remove('fa-spinner', 'fa-spin');
                    
                    if (data.success) {
                        if (isCurrentlyInWishlist) {
                            icon.classList.remove('fas');
                            icon.classList.add('far', 'fa-heart');
                            showNotification('Removed from wishlist', 'info');
                        } else {
                            icon.classList.remove('far');
                            icon.classList.add('fas', 'fa-heart');
                            showNotification('Added to wishlist!', 'success');
                        }
                    } else {
                        showNotification(data.error || 'Operation failed', 'error');
                        // Reset to original state
                        icon.classList.add(isCurrentlyInWishlist ? 'fas' : 'far', 'fa-heart');
                    }
                })
                .catch(error => {
                    icon.classList.remove('fa-spinner', 'fa-spin');
                    icon.classList.add(isCurrentlyInWishlist ? 'fas' : 'far', 'fa-heart');
                    showNotification('Network error. Please try again.', 'error');
                });
            });
        });

        // Color Options
        document.addEventListener("DOMContentLoaded", () => {
            const colorOptionsContainer = document.getElementById("color-options");
            if (!colorOptionsContainer) return;

            const productId = colorOptionsContainer.dataset.productId;
            const currentColor = colorOptionsContainer.dataset.currentColor.toLowerCase();

            const specialColors = {
                pink: "PINK",
                blue: "BLUE",
                green: "GREEN",
                black: "BLACK"
            };

            const colorNames = {
                pink: "Rose Pink",
                blue: "Sky Blue",
                green: "Forest Green",
                black: "Jet Black"
            };

            function getColorCode(color) {
                switch(color) {
                    case "pink": return "#f277a8";
                    case "blue": return "#6fbae0";
                    case "green": return "#6f966a";
                    case "black": return "#000000";
                    default: return "#fff";
                }
            }

            function createColorButton(color, isSelected) {
                const button = document.createElement("button");
                button.className = `flex flex-col items-center transition-all duration-300 group`;
                button.dataset.color = color;
                button.title = colorNames[color] || color;

                const colorCircle = document.createElement("div");
                colorCircle.className = `w-12 h-12 rounded-full border-2 shadow-sm mb-2 transition-all duration-300 
                    ${isSelected ? 'border-[#49608a] scale-110 ring-2 ring-[#49608a] ring-opacity-30' : 'border-gray-300 group-hover:border-[#49608a] group-hover:scale-105'}`;
                colorCircle.style.backgroundColor = getColorCode(color);

                const colorLabel = document.createElement("span");
                colorLabel.className = `text-xs font-medium ${isSelected ? 'text-[#49608a]' : 'text-gray-600 group-hover:text-[#49608a]'}`;
                colorLabel.textContent = colorNames[color] || color.charAt(0).toUpperCase() + color.slice(1);

                button.appendChild(colorCircle);
                button.appendChild(colorLabel);

                button.addEventListener("click", () => handleColorChange(color));
                return button;
            }

            function handleColorChange(selectedColor) {
                showNotification(`Loading ${colorNames[selectedColor]} variant...`, 'info');
                if (specialColors[selectedColor]) {
                    const newColorCode = specialColors[selectedColor];
                    let newId = productId;

                    Object.values(specialColors).forEach(colorSuffix => {
                        if (productId.endsWith(colorSuffix)) {
                            newId = productId.slice(0, productId.length - colorSuffix.length) + newColorCode;
                        }
                    });

                    setTimeout(() => {
                        window.location.href = `{{ url('product') }}/` + newId;
                    }, 500);
                }
            }

            if (productId.includes("C")) {
                Object.keys(specialColors).forEach(color => {
                    const button = createColorButton(color, color === currentColor);
                    colorOptionsContainer.appendChild(button);
                });
            } else {
                const button = createColorButton(currentColor, true);
                colorOptionsContainer.appendChild(button);
            }
        });

        // Size Switching
        document.addEventListener('DOMContentLoaded', () => {
            const mediumBtn = document.getElementById('mediumbtn');
            const largeBtn = document.getElementById('largebtn');
            if (!mediumBtn || !largeBtn) return;

            const currentProductId = "{{ $product->id }}";

            function switchProductSize(targetPrefix) {
                showNotification('Loading size variant...', 'info');
                const newId = targetPrefix + currentProductId.substring(1); 
                setTimeout(() => {
                    window.location.href = `{{ url('product') }}/` + newId;
                }, 500);
            }

            if (mediumBtn) {
                mediumBtn.addEventListener('click', () => {
                    if (currentProductId.charAt(0) !== 'M') {
                        switchProductSize('M');
                    }
                });
            }

            if (largeBtn) {
                largeBtn.addEventListener('click', () => {
                    if (currentProductId.charAt(0) !== 'L') {
                        switchProductSize('L');
                    }
                });
            }
        });

        // Add to Cart with Notification
        document.addEventListener('DOMContentLoaded', function () {
            const addToCartBtn = document.getElementById('addToCart');
            addToCartBtn.addEventListener('click', function () {
                const productId = this.dataset.id;
                const quantity = document.getElementById('quantity').value;

                // Add loading state
                const originalContent = addToCartBtn.innerHTML;
                addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding...';
                addToCartBtn.disabled = true;

                fetch(`/cart/add/${productId}?quantity=${quantity}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    // Restore button
                    setTimeout(() => {
                        addToCartBtn.innerHTML = originalContent;
                        addToCartBtn.disabled = false;
                    }, 1000);

                    if (data.success) {
                        showNotification(`Added ${quantity} item(s) to cart!`, 'success');
                        // Optional: Update cart counter if you have one
                        if (typeof updateCartCount === 'function') {
                            updateCartCount();
                        }
                    } else {
                        showNotification(data.error || 'Could not add to cart', 'error');
                    }
                })
                .catch(error => {
                    setTimeout(() => {
                        addToCartBtn.innerHTML = originalContent;
                        addToCartBtn.disabled = false;
                    }, 1000);
                    showNotification('Network error. Please try again.', 'error');
                });
            });
        });

        // Review Form Toggle
        document.addEventListener('DOMContentLoaded', function () {
            const reviewToggleBtn = document.getElementById('reviewToggleBtn');
            const reviewForm = document.getElementById('reviewForm');
            const cancelReviewBtn = document.getElementById('cancelReviewBtn');
            const ratingStars = document.querySelectorAll('.rating-star');
            const selectedRatingInput = document.getElementById('selectedRating');

            if (reviewToggleBtn && reviewForm) {
                reviewToggleBtn.addEventListener('click', function () {
                    reviewForm.classList.toggle('hidden');
                    if (!reviewForm.classList.contains('hidden')) {
                        reviewForm.scrollIntoView({ behavior: 'smooth' });
                    }
                });

                if (cancelReviewBtn) {
                    cancelReviewBtn.addEventListener('click', function () {
                        reviewForm.classList.add('hidden');
                    });
                }
            }

            // Star Rating Selection
            if (ratingStars) {
                ratingStars.forEach(star => {
                    star.addEventListener('click', function () {
                        const rating = this.dataset.rating;
                        selectedRatingInput.value = rating;
                        
                        // Update star display
                        ratingStars.forEach((s, index) => {
                            const icon = s.querySelector('i');
                            if (index < rating) {
                                icon.classList.remove('far');
                                icon.classList.add('fas', 'text-yellow-500');
                            } else {
                                icon.classList.remove('fas', 'text-yellow-500');
                                icon.classList.add('far', 'text-gray-300');
                            }
                        });
                    });
                });
            }
        });

        // Add CSS for slide-in animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slide-in {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            .animate-slide-in {
                animation: slide-in 0.3s ease-out;
            }
        `;
        document.head.appendChild(style);
    </script>

</x-app-layout>