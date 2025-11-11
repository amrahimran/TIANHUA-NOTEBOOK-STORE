<x-app-layout>
    <main class="max-w-4xl mx-auto p-6 font-roboto">
        <h2 class="text-3xl font-bold text-[#49608a] mb-6">Checkout</h2>

        <form action="{{ route('checkout.placeOrder') }}" method="POST" class="bg-white shadow-lg rounded-2xl p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold">Full Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#49608a]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#49608a]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Phone</label>
                <input type="text" name="phone" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#49608a]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Address</label>
                <input type="text" name="address" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#49608a]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">City</label>
                <input type="text" name="city" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#49608a]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Payment Method</label>
                <select name="payment_method" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#49608a]" required>
                    <option value="">Select Payment Method</option>
                    <option value="Cash on Delivery">Cash on Delivery</option>
                </select>
            </div>

            <div class="border-t border-gray-200 pt-4 text-right">
                <p class="text-lg font-medium text-gray-800 mb-4">
                    Total: <span class="text-[#49608a] font-semibold">Rs. {{ number_format($total, 2) }}</span>
                </p>
                <button type="submit" class="bg-[#49608a] text-white px-8 py-3 rounded-xl hover:bg-[#3a4e73] transition shadow-md">
                    Buy Now
                </button>
            </div>
        </form>
    </main>
</x-app-layout>
