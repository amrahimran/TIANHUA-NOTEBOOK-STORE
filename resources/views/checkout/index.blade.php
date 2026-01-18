<x-app-layout>
    <main class="max-w-4xl mx-auto p-6 font-roboto">
        <h2 class="text-3xl font-bold text-[#49608a] mb-6">Checkout</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

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
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#49608a]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Address</label>
                <input type="text" name="address" value="{{ old('address') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#49608a]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">City</label>
                <input type="text" name="city" value="{{ old('city') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#49608a]" required>
            </div>

           <div>
    <label class="block text-gray-700 font-semibold mb-2">Payment Method</label>
    <select name="payment_method" required>
        <option value="cod" {{ old('payment_method') === 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
        <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Card</option>
    </select>
</div>

            <!-- DEMO CARD FIELDS (inserted here) -->
            <div id="card-fields" style="display:none; margin-top: 1rem;">
                <input type="text" name="card_number" placeholder="Card Number" maxlength="16" class="w-full border border-gray-300 rounded-xl px-4 py-2 mb-2 focus:ring-2 focus:ring-[#49608a]">
                <input type="text" name="expiry" placeholder="MM/YY" class="w-full border border-gray-300 rounded-xl px-4 py-2 mb-2 focus:ring-2 focus:ring-[#49608a]">
                <input type="text" name="cvv" placeholder="CVV" maxlength="3" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#49608a]">
            </div>

            <script>
            document.querySelector('[name="payment_method"]').addEventListener('change', function () {
                document.getElementById('card-fields').style.display =
                    this.value === 'card' ? 'block' : 'none';
            });
            </script>


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
