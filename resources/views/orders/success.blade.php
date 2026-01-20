<x-app-layout>
    <main class="max-w-4xl mx-auto p-6 font-roboto text-center">
        <div class="bg-white shadow-lg rounded-2xl p-8">
            <div class="text-green-500 text-6xl mb-4">✓</div>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Payment Successful!</h2>
            <p class="text-gray-600 mb-6">Thank you for your order. Your payment has been processed successfully.</p>
            
            <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                <h3 class="font-semibold text-gray-800 mb-3">Order Details:</h3>
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Amount:</strong> Rs. {{ number_format($order->total, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Status:</strong> <span class="text-green-600 font-semibold">{{ ucfirst($order->order_status) }}</span></p>
            </div>
            
            <a href="{{ route('home') }}" class="bg-[#49608a] text-white px-8 py-3 rounded-xl hover:bg-[#3a4e73] transition inline-block">
                Continue Shopping
            </a>
        </div>
    </main>
</x-app-layout>