<x-app-layout>
    {{-- Notification Container --}}
    <div id="notification-container" class="fixed top-4 right-4 z-50 max-w-md"></div>

    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 py-6 lg:py-10">
            <div class="relative h-[500px] lg:h-[600px] rounded-3xl overflow-hidden shadow-2xl group">
                {{-- Hero Images Container --}}
                <div id="heroCarousel" class="relative w-full h-full">
                    @php
                        $slides = [
                            ['image' => 'images/heroslides/slide1.png', 'title' => 'Premium Quality', 'subtitle' => 'Shop the finest products'],
                            ['image' => 'images/heroslides/slide2.png', 'title' => 'Latest Collections', 'subtitle' => 'Discover new arrivals'],
                            ['image' => 'images/heroslides/slide3.png', 'title' => 'Exclusive Offers', 'subtitle' => 'Limited time deals'],
                            ['image' => 'images/heroslides/slide4.png', 'title' => 'Free Shipping', 'subtitle' => 'On all orders'],
                        ];
                    @endphp
                    
                    @foreach($slides as $index => $slide)
                        <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                             data-index="{{ $index }}">
                            <img src="{{ asset($slide['image']) }}" 
                                 alt="{{ $slide['title'] }}"
                                 class="w-full h-full object-cover object-center">
                            <div class="absolute inset-0 bg-gradient-to-l from-black/40 to-transparent"></div>
                            <div class="absolute right-12 lg:right-20 top-1/2 transform -translate-y-1/2 text-white max-w-lg text-right">
                                <h1 class="text-4xl lg:text-6xl font-bold mb-4 animate-fade-in-up">{{ $slide['title'] }}</h1>
                                <p class="text-xl lg:text-2xl mb-8 text-gray-200 animate-fade-in-up animation-delay-200">{{ $slide['subtitle'] }}</p>
                                <a href="{{ route('profile.products.index') }}" 
                                   class="inline-flex items-center bg-white text-gray-900 font-semibold px-8 py-4 rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl animate-fade-in-up animation-delay-400 ml-auto">
                                    <span>Shop Now</span>
                                    <i class="fas fa-arrow-right ml-3"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Carousel Controls --}}
                <button id="prevSlide" 
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-all duration-300 group-hover:opacity-100 opacity-0 lg:opacity-100">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="nextSlide" 
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-all duration-300 group-hover:opacity-100 opacity-0 lg:opacity-100">
                    <i class="fas fa-chevron-right"></i>
                </button>

                {{-- Carousel Indicators --}}
                <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3">
                    @foreach($slides as $index => $slide)
                        <button class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-300 {{ $index === 0 ? '!bg-white w-8' : '' }}"
                                data-index="{{ $index }}"></button>
                    @endforeach
                </div>
            </div>

            {{-- Stats Bar --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-[#49608a]/10 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-shipping-fast text-[#49608a] text-xl"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">Free</p>
                            <p class="text-gray-600">Shipping</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-[#49608a]/10 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-shield-alt text-[#49608a] text-xl"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">Secure</p>
                            <p class="text-gray-600">Payment</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-[#49608a]/10 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-headset text-[#49608a] text-xl"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">24/7</p>
                            <p class="text-gray-600">Support</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-[#49608a]/10 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-undo-alt text-[#49608a] text-xl"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">Easy</p>
                            <p class="text-gray-600">Returns</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Best Sellers Section --}}
    <section class="max-w-[1600px] mx-auto px-4 lg:px-8 py-12 lg:py-16">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">Best Sellers</h2>
                <p class="text-gray-600">Most loved products by our customers</p>
            </div>
        </div>

        <div class="relative">
            <div class="flex gap-6 lg:gap-8 overflow-x-auto pb-6 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 px-2" id="bestSellersSlider">
                @foreach ($products as $product)
                    @if ($product->isBestSeller == 1)
                        <div class="flex-shrink-0 w-[280px] lg:w-[320px]">
                            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 h-full flex flex-col">
                                {{-- Product Image --}}
                                <div class="relative overflow-hidden h-48 lg:h-56 flex-shrink-0">
                                    <img src="{{ asset($product->image) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform duration-500">
                                    
                                    {{-- Best Seller Badge --}}
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                            Best Seller
                                        </span>
                                    </div>
                                    
                                    {{-- Quick Actions --}}
                                    <div class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        {{-- <button class="w-10 h-10 bg-white rounded-full shadow flex items-center justify-center hover:bg-gray-50 transition-colors duration-200 quick-wishlist"
                                                data-product-id="{{ $product->id }}"
                                                title="Add to wishlist">
                                            <i class="far fa-heart text-gray-600 hover:text-red-500"></i>
                                        </button> --}}
                                        <button class="w-10 h-10 bg-white rounded-full shadow flex items-center justify-center hover:bg-gray-50 transition-colors duration-200 quick-cart"
                                                data-product-id="{{ $product->id }}"
                                                title="Add to cart">
                                            <i class="fas fa-shopping-cart text-gray-600 hover:text-[#49608a]"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Product Info --}}
                                <div class="p-6 flex flex-col flex-grow">
                                    <a href="{{ route('product.show', $product->id) }}" class="block flex-grow">
                                        <h3 class="font-semibold text-gray-900 text-lg mb-2 group-hover:text-[#49608a] transition-colors duration-300 line-clamp-1">{{ $product->name }}</h3>
                                        <div class="mb-4 min-h-[40px]">
                                            <p class="text-gray-600 text-sm line-clamp-2">{{ $product->description }}</p>
                                        </div>
                                    </a>
                                    
                                    <div class="mt-auto">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-xl font-bold text-[#49608a]">Rs. {{ number_format($product->price, 2) }}</p>
                                                <div class="flex items-center mt-1">
                                                    <div class="text-yellow-400 text-sm">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half-alt"></i>
                                                    </div>
                                                    <span class="text-gray-500 text-sm ml-2">(4.5)</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('product.show', $product->id) }}" 
                                               class="bg-[#49608a] text-white px-5 py-2.5 rounded-lg hover:bg-[#3a4e73] transition-colors duration-300 font-medium shadow hover:shadow-md whitespace-nowrap">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- Categories Sections (Horizontal Scroll) --}}
    @foreach ($categories as $sectionName => $cat)
        <section class="max-w-[1600px] mx-auto px-4 lg:px-8 py-12 lg:py-16 {{ $loop->index % 2 == 0 ? 'bg-gray-50' : '' }}">
            <div class="mb-10">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">{{ $sectionName }}</h2>
                <p class="text-gray-600">Browse our {{ strtolower($sectionName) }} collection</p>
            </div>

            <div class="flex gap-6 lg:gap-8 overflow-x-auto pb-6 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 px-2">
                @php
                    $categoryProducts = $products->filter(function($product) use ($cat) {
                        return str_contains($product->category, $cat) && strtoupper(substr($product->id, 0, 1)) === 'L';
                    });
                @endphp
                
                @foreach ($categoryProducts as $product)
                    <div class="flex-shrink-0 w-[280px] lg:w-[320px]">
                        <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 h-full flex flex-col">
                            {{-- Product Image --}}
                            <div class="relative overflow-hidden h-48 lg:h-56 flex-shrink-0">
                                <img src="{{ asset($product->image) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform duration-500">
                                
                                {{-- Category Badge --}}
                                <div class="absolute top-4 left-4">
                                    <span class="bg-[#49608a] text-white text-xs font-bold px-3 py-1 rounded-full">
                                        {{ ucfirst($product->category) }}
                                    </span>
                                </div>
                                
                                {{-- Quick Actions --}}
                                <div class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="w-10 h-10 bg-white rounded-full shadow flex items-center justify-center hover:bg-gray-50 transition-colors duration-200 quick-wishlist"
                                            data-product-id="{{ $product->id }}"
                                            title="Add to wishlist">
                                        <i class="far fa-heart text-gray-600 hover:text-red-500"></i>
                                    </button>
                                    <button class="w-10 h-10 bg-white rounded-full shadow flex items-center justify-center hover:bg-gray-50 transition-colors duration-200 quick-cart"
                                            data-product-id="{{ $product->id }}"
                                            title="Add to cart">
                                        <i class="fas fa-shopping-cart text-gray-600 hover:text-[#49608a]"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Product Info --}}
                            <div class="p-6 flex flex-col flex-grow">
                                <a href="{{ route('product.show', $product->id) }}" class="block flex-grow">
                                    <h3 class="font-semibold text-gray-900 text-lg mb-2 group-hover:text-[#49608a] transition-colors duration-300 line-clamp-1">{{ $product->name }}</h3>
                                    <div class="mb-4 min-h-[40px]">
                                        <p class="text-gray-600 text-sm line-clamp-2">{{ $product->description }}</p>
                                    </div>
                                </a>
                                
                                <div class="mt-auto">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xl font-bold text-[#49608a]">Rs. {{ number_format($product->price, 2) }}</p>
                                            @if($product->isBestSeller)
                                                <span class="inline-block bg-red-50 text-red-600 text-xs font-medium px-2 py-1 rounded mt-1">Best Seller</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('product.show', $product->id) }}" 
                                           class="bg-gradient-to-r from-[#49608a] to-[#3a4e73] text-white px-5 py-2.5 rounded-lg hover:opacity-90 transition-all duration-300 font-medium shadow hover:shadow-md whitespace-nowrap">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach

    {{-- Newsletter Section --}}
    <section class="max-w-[1600px] mx-auto px-4 lg:px-8 py-16">
        <div class="bg-gradient-to-r from-[#49608a] to-[#3a4e73] rounded-3xl p-8 lg:p-12 text-center text-white">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">Stay Updated</h2>
                <p class="text-gray-200 mb-8">Subscribe to our newsletter and get 10% off your first order</p>
                
                <form class="flex flex-col lg:flex-row gap-4 max-w-md mx-auto">
                    <input type="email" 
                           placeholder="Enter your email" 
                           class="flex-1 px-6 py-4 rounded-full text-gray-900 focus:outline-none focus:ring-2 focus:ring-white/50">
                    <button type="submit" 
                            class="bg-white text-[#49608a] font-semibold px-8 py-4 rounded-full hover:bg-gray-100 transition-colors duration-300 shadow-lg hover:shadow-xl">
                        Subscribe
                    </button>
                </form>
                
                <p class="text-gray-300 text-sm mt-6">By subscribing, you agree to our Privacy Policy and consent to receive updates.</p>
            </div>
        </div>
    </section>

    {{-- Admin Dashboard Button --}}
    @if (Auth::check() && Auth::user()->isAdmin)
        <a href="{{ route('admin.dashboard') }}" 
           class="fixed bottom-8 right-8 z-40 bg-gradient-to-r from-[#49608a] to-[#3a4e73] text-white px-6 py-4 rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 group">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-cog text-white text-lg"></i>
                </div>
                <div class="text-left">
                    <p class="font-bold text-sm">Admin</p>
                    <p class="text-xs opacity-90">Dashboard</p>
                </div>
                <i class="fas fa-arrow-right ml-4 group-hover:translate-x-2 transition-transform duration-300"></i>
            </div>
        </a>
    @endif

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

        // Hero Carousel
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.hero-slide');
            const indicators = document.querySelectorAll('.carousel-indicator');
            let currentSlide = 0;
            let autoSlideInterval;

            function showSlide(index) {
                slides.forEach(slide => {
                    slide.classList.remove('opacity-100');
                    slide.classList.add('opacity-0');
                });
                
                indicators.forEach(indicator => {
                    indicator.classList.remove('!bg-white', 'w-8');
                    indicator.classList.add('bg-white/50', 'w-3');
                });
                
                slides[index].classList.remove('opacity-0');
                slides[index].classList.add('opacity-100');
                indicators[index].classList.remove('bg-white/50', 'w-3');
                indicators[index].classList.add('!bg-white', 'w-8');
                
                currentSlide = index;
            }

            function nextSlide() {
                let next = currentSlide + 1;
                if (next >= slides.length) next = 0;
                showSlide(next);
            }

            function prevSlide() {
                let prev = currentSlide - 1;
                if (prev < 0) prev = slides.length - 1;
                showSlide(prev);
            }

            function startAutoSlide() {
                autoSlideInterval = setInterval(nextSlide, 5000);
            }

            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }

            // Event Listeners
            document.getElementById('nextSlide').addEventListener('click', () => {
                stopAutoSlide();
                nextSlide();
                startAutoSlide();
            });

            document.getElementById('prevSlide').addEventListener('click', () => {
                stopAutoSlide();
                prevSlide();
                startAutoSlide();
            });

            indicators.forEach(indicator => {
                indicator.addEventListener('click', () => {
                    const index = parseInt(indicator.dataset.index);
                    stopAutoSlide();
                    showSlide(index);
                    startAutoSlide();
                });
            });

            document.querySelector('.group').addEventListener('mouseenter', stopAutoSlide);
            document.querySelector('.group').addEventListener('mouseleave', startAutoSlide);

            startAutoSlide();

            // ========== FIXED: Wishlist Functionality ==========
            document.querySelectorAll('.quick-wishlist').forEach(button => {
                button.addEventListener('click', async function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const productId = this.dataset.productId;
                    const icon = this.querySelector('i');
                    
                    // Check current state - always starts as empty heart (far)
                    const isCurrentlyEmpty = icon.classList.contains('far');
                    
                    // Add loading state
                    const originalClasses = icon.className;
                    icon.className = 'fas fa-spinner fa-spin text-gray-600';
                    
                    try {
                        const response = await fetch(`/wishlist/add/${productId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            // Toggle the icon based on response
                            if (isCurrentlyEmpty) {
                                // Was empty, now should be filled (added to wishlist)
                                icon.className = 'fas fa-heart text-red-500';
                                showNotification('Added to wishlist!', 'success');
                            } else {
                                // Was filled, now should be empty (removed from wishlist)
                                icon.className = 'far fa-heart text-gray-600 hover:text-red-500';
                                showNotification('Removed from wishlist', 'info');
                            }
                        } else {
                            // Show error and reset to original state
                            icon.className = originalClasses;
                            showNotification(data.error || 'Operation failed', 'error');
                        }
                    } catch (error) {
                        icon.className = originalClasses;
                        showNotification('Network error. Please try again.', 'error');
                    }
                });
            });

            // ========== Cart Functionality ==========
            document.querySelectorAll('.quick-cart').forEach(button => {
                button.addEventListener('click', async function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const productId = this.dataset.productId;
                    const icon = this.querySelector('i');
                    
                    // Add loading state
                    const originalClasses = icon.className;
                    icon.className = 'fas fa-spinner fa-spin text-gray-600';
                    
                    try {
                        const response = await fetch(`/cart/add/${productId}?quantity=1`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            // Show success with color change
                            icon.className = 'fas fa-shopping-cart text-[#49608a]';
                            showNotification('Added to cart!', 'success');
                            
                            // Revert to original color after 2 seconds
                            setTimeout(() => {
                                icon.className = originalClasses;
                            }, 2000);
                        } else {
                            icon.className = originalClasses;
                            showNotification(data.error || 'Could not add to cart', 'error');
                        }
                    } catch (error) {
                        icon.className = originalClasses;
                        showNotification('Network error. Please try again.', 'error');
                    }
                });
            });

            // Optional: Check wishlist status on page load
            // This would require an API endpoint to check multiple products
            // checkWishlistStatus();
        });

        // ========== OPTIONAL: Function to check wishlist status ==========
        // Uncomment and implement if you have an endpoint to check multiple products
        /*
        async function checkWishlistStatus() {
            const productIds = Array.from(document.querySelectorAll('.quick-wishlist'))
                .map(btn => btn.dataset.productId);
            
            if (productIds.length === 0) return;
            
            try {
                const response = await fetch('/wishlist/check-multiple', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_ids: productIds })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update heart icons based on which products are in wishlist
                    document.querySelectorAll('.quick-wishlist').forEach(button => {
                        const productId = button.dataset.productId;
                        const icon = button.querySelector('i');
                        
                        if (data.wishlist_ids.includes(productId)) {
                            icon.className = 'fas fa-heart text-red-500';
                        } else {
                            icon.className = 'far fa-heart text-gray-600 hover:text-red-500';
                        }
                    });
                }
            } catch (error) {
                console.error('Failed to check wishlist status:', error);
            }
        }
        */

        // Add CSS animations
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
            @keyframes fade-in-up {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-slide-in {
                animation: slide-in 0.3s ease-out;
            }
            .animate-fade-in-up {
                animation: fade-in-up 0.8s ease-out forwards;
            }
            .animation-delay-200 {
                animation-delay: 0.2s;
                opacity: 0;
            }
            .animation-delay-400 {
                animation-delay: 0.4s;
                opacity: 0;
            }
            .line-clamp-1 {
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .scrollbar-thin::-webkit-scrollbar {
                height: 6px;
            }
            .scrollbar-thin::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }
            .scrollbar-thin::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 10px;
            }
            .scrollbar-thin::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>