<x-app-layout>
    <main class="max-w-7xl mx-auto p-6 font-roboto">

        <h2 class="text-3xl font-bold text-[#49608a] mb-6">My Cart</h2>

        @if(empty($cart))
            <p class="text-lg text-gray-500">Your cart is empty.</p>
            <a href="{{ url('/profile/products') }}" class="mt-6 inline-block bg-[#49608a] text-white px-6 py-3 rounded-xl shadow-md hover:bg-[#3a4e73] transition">
                Continue Shopping
            </a>
        @else
            <div class="bg-white shadow-lg rounded-2xl p-6">
                <div class="divide-y divide-gray-200">
                    @foreach($cart as $id => $item)
                        <div class="flex flex-wrap md:flex-nowrap py-4 items-center">
                            <img src="{{ asset($item['image']) }}" 
                                 alt="{{ $item['name'] }}" 
                                 class="w-24 h-24 object-cover rounded-md shadow-md">

                            <div class="md:ml-6 flex-1">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $item['name'] }}</h3>
                                <p class="text-[#49608a] font-medium mt-1">
                                    Rs. {{ number_format($item['price'], 2) }}
                                </p>

                                <div class="flex items-center mt-3">
                                    <label class="text-gray-600 mr-3">Qty:</label>
                                    <input type="number" min="1" value="{{ $item['quantity'] }}"
                                           class="w-16 text-center border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-[#49608a]"
                                           onchange="updateCartQuantity('{{ $id }}', this.value)">
                                </div>
                            </div>

                            <div class="mt-4 md:mt-0">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total -->
                @php
                    $total = 0;
                    foreach($cart as $item) {
                        $total += $item['price'] * $item['quantity'];
                    }
                @endphp

                <div class="mt-6 text-right">
                    <h3 class="text-2xl font-semibold text-gray-800">
                        Total: Rs. {{ number_format($total, 2) }}
                    </h3>
                    {{-- <button class="mt-4 bg-[#49608a] text-white px-8 py-3 rounded-xl hover:bg-[#3a4e73] transition shadow-md">
                        Checkout
                    </button> --}}
                    <a href="{{ route('checkout') }}"
                    class="mt-4 inline-block bg-[#49608a] text-white px-8 py-3 rounded-xl hover:bg-[#3a4e73] transition shadow-md">
                        Checkout
                    </a>
                </div>
            </div>
        @endif
    </main>

    <script>
        function updateCartQuantity(id, quantity) {
            fetch(`/cart/update/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ quantity })
            }).then(response => {
                if (response.ok) location.reload();
            });
        }
    </script>
</x-app-layout>
