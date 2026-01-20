@section('title', 'Products | Tian Hua')

<x-app-layout>
    {{-- Notification Container --}}
    <div id="notification-container" class="fixed top-4 right-4 z-50 max-w-md"></div>

    <div class="px-4 md:px-10 lg:px-14 pt-10">
        {{-- Search Bar --}}
        <form action="{{ route('profile.products.index') }}" method="GET" class="flex justify-center mb-6">
            <div class="bg-white flex items-center px-3 rounded-full w-full max-w-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <button type="submit" class="text-[#49608a] text-xl mr-2">
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

        {{-- Filter Bar --}}
        <div class="flex justify-start mb-8">
            <form action="{{ route('profile.products.index') }}" method="GET" class="flex items-center gap-3 bg-white shadow-md rounded-full px-4 py-2 w-fit hover:shadow-lg transition-shadow duration-300">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <span class="text-sm font-medium text-gray-700 whitespace-nowrap">
                    Sort by Price:
                </span>
                <select 
                    name="sort"
                    onchange="this.form.submit()"
                    class="border-gray-300 rounded-full text-sm px-4 py-2 pr-8 focus:ring-[#49608a] focus:border-[#49608a] cursor-pointer"
                >
                    <option value="">All</option>
                    <option value="low_high" {{ request('sort') === 'low_high' ? 'selected' : '' }}>
                        Price ↑
                    </option>
                    <option value="high_low" {{ request('sort') === 'high_low' ? 'selected' : '' }}>
                        Price ↓
                    </option>
                </select>
            </form>
        </div>

        {{-- Products Grid --}}
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($products as $product)
                    <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 h-full flex flex-col">
                        {{-- Product Image --}}
                        <div class="relative overflow-hidden h-56 flex-shrink-0">
                            <img src="{{ asset($product->image) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            
                            {{-- Category Badge --}}
                            <div class="absolute top-4 left-4">
                                <span class="bg-[#49608a] text-white text-xs font-bold px-3 py-1 rounded-full">
                                    {{ ucfirst($product->category) }}
                                </span>
                            </div>
                            
                            {{-- Quick Actions --}}
                            <div class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button class="w-10 h-10 bg-white rounded-full shadow flex items-center justify-center hover:bg-gray-50 transition-colors duration-200 add-to-cart-btn"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        title="Add to cart">
                                    <i class="fas fa-shopping-cart text-gray-600 hover:text-[#49608a]"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Product Info --}}
                        <div class="p-6 flex flex-col flex-grow">
                            <a href="{{ route('product.show', $product->id) }}" class="block flex-grow">
                                <h3 class="font-semibold text-gray-900 text-lg mb-2 group-hover:text-[#49608a] transition-colors duration-300 line-clamp-1">{{ $product->name }}</h3>
                                <div class="mb-4 min-h-[48px]">
                                    <p class="text-gray-600 text-sm line-clamp-2">{{ $product->description }}</p>
                                </div>
                            </a>
                            
                            <div class="mt-auto">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-2xl font-bold text-[#49608a]">Rs. {{ number_format($product->price, 2) }}</p>
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
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
                <i class="fas fa-search text-gray-300 text-6xl mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">No products found</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    @if(request('search'))
                        No products match your search "{{ request('search') }}". Try different keywords.
                    @else
                        There are currently no products available in this category.
                    @endif
                </p>
                @if(request('search') || request('sort'))
                    <a href="{{ route('profile.products.index') }}" 
                       class="inline-flex items-center bg-[#49608a] text-white font-semibold px-8 py-3 rounded-lg hover:bg-[#3a4e73] transition-colors duration-300 shadow hover:shadow-md">
                        <i class="fas fa-times mr-2"></i>
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>

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

        // Add to Cart Functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add to cart buttons
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const productId = this.dataset.productId;
                    const productName = this.dataset.productName || 'Product';
                    const icon = this.querySelector('i');
                    
                    // Add loading state
                    const originalClass = icon.className;
                    icon.className = 'fas fa-spinner fa-spin text-gray-600';
                    
                    fetch(`/cart/add/${productId}?quantity=1`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        // Restore cart icon with success color
                        icon.classList.remove('fa-spinner', 'fa-spin');
                        icon.classList.add('fa-shopping-cart', 'text-[#49608a]');
                        
                        if (data.success) {
                            showNotification(`${productName} added to cart!`, 'success');
                            
                            // Revert to original color after 2 seconds
                            setTimeout(() => {
                                icon.classList.remove('text-[#49608a]');
                                icon.classList.add('text-gray-600');
                            }, 2000);
                        } else {
                            showNotification(data.error || 'Could not add to cart', 'error');
                            // Reset to original state
                            icon.className = originalClass;
                        }
                    })
                    .catch(error => {
                        // Reset to original state
                        icon.className = originalClass;
                        showNotification('Network error. Please try again.', 'error');
                    });
                });
            });
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
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>