@section('title', 'My Orders | Tian Hua')

<x-app-layout>
    <main class="max-w-5xl mx-auto p-6 font-roboto">
        <h2 class="text-3xl font-bold text-[#49608a] mb-6">My Orders</h2>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($orders->isEmpty())
            <p class="text-gray-500 text-lg">You haven’t placed any orders yet.</p>
        @else
            @foreach($orders as $order)
                <div class="bg-white shadow-lg rounded-2xl p-6 mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Order #{{ $order->id }}</h3>
                    <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                    <p class="text-gray-600 mb-3">Payment: {{ $order->payment_method }}</p>

                    <div class="border-t border-gray-200 mt-3 pt-3">
                        <h4 class="font-semibold text-[#49608a] mb-2">Items:</h4>
                        <ul class="list-none text-gray-700">
                            @php
                                // Safely decode items to always have an array
                                $items = [];
                                if (is_iterable($order->items)) {
                                    $items = $order->items;
                                } elseif (!empty($order->items)) {
                                    $decoded = json_decode($order->items, true);
                                    $items = is_array($decoded) ? $decoded : [];
                                }
                            @endphp

                            @foreach($items as $item)
                                @php
                                    // Handle both array and object formats
                                    $product = isset($item['product']) ? (object)$item['product'] : $item->product ?? null;
                                    $quantity = $item['quantity'] ?? 1;
                                    $price = $item['price'] ?? 0;
                                @endphp

                                @if($product)
                                    <li class="flex items-center mb-3">
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-md mr-4 shadow-sm">
                                        <div>
                                            <p>{{ $product->name }} × {{ $quantity }} — Rs. {{ number_format($price, 2) }}</p>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="text-right mt-4">
                        <p class="text-xl font-semibold text-gray-800">
                            Total: Rs. {{ number_format($order->total, 2) }}
                        </p>
                    </div>
                </div>
            @endforeach
        @endif
    </main>
</x-app-layout>
