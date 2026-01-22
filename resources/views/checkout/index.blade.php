<x-app-layout>
    <main class="max-w-4xl mx-auto p-6 font-roboto">
        <h2 class="text-3xl font-bold text-[#49608a] mb-6">Checkout</h2>

        {{-- Show error/success messages --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- CART SUMMARY --}}
        <div class="bg-white shadow-lg rounded-2xl p-6 mb-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Your Order</h3>
            @if(!empty($cart))
                <div class="space-y-3">
                    @foreach($cart as $productId => $item)
                        <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                            <div class="flex items-center gap-3">
                                @if(!empty($item['image']))
                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-14 h-14 object-cover rounded">
                                @else
                                    <div class="w-14 h-14 bg-gray-200 rounded flex items-center justify-center text-gray-500 text-sm">No Image</div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-700">{{ $item['name'] }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                </div>
                            </div>
                            <p class="text-gray-800 font-semibold">
                                Rs. {{ number_format($item['price'] * $item['quantity'], 2) }}
                            </p>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between items-center mt-4 border-t border-gray-200 pt-2">
                    <p class="font-bold text-gray-800">Total</p>
                    <p class="font-bold text-[#49608a] text-xl">Rs. {{ number_format($total, 2) }}</p>
                </div>
            @else
                <p class="text-gray-500">Your cart is empty.</p>
            @endif
        </div>

        {{-- CHECKOUT FORM --}}
        <form action="{{ route('checkout.placeOrder') }}" method="POST" class="bg-white shadow-lg rounded-2xl p-6 space-y-4" id="checkout-form">
            @csrf

            {{-- Personal Details --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#49608a] focus:border-transparent transition" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#49608a] focus:border-transparent transition" required>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Phone Number *</label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#49608a] focus:border-transparent transition" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Address *</label>
                <input type="text" name="address" value="{{ old('address') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#49608a] focus:border-transparent transition" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">City *</label>
                <input type="text" name="city" value="{{ old('city') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#49608a] focus:border-transparent transition" required>
            </div>

            {{-- Payment Method --}}
            <div class="pt-4 border-t border-gray-200">
                <label class="block text-gray-700 font-semibold mb-3">Payment Method *</label>
                <select name="payment_method" id="payment_method" 
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#49608a] focus:border-transparent transition" required>
                    <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>Select Payment Method</option>
                    <option value="cod" {{ old('payment_method') === 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                    <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                </select>
            </div>

            {{-- Card Fields (Stripe) --}}
            <div id="card-fields" class="hidden space-y-4 p-4 bg-gray-50 rounded-xl border border-gray-200 mt-4">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <h4 class="font-bold text-yellow-800 mb-2">💳 Pay with Stripe:</h4>
                    <!-- <ul class="text-sm text-yellow-700 space-y-1">
                        <li><strong>Card Number:</strong> 4242 4242 4242 4242</li>
                        <li><strong>Expiry Date:</strong> Any future date</li>
                        <li><strong>CVC:</strong> Any 3 digits</li>
                        <li><strong>ZIP:</strong> Any 5 digits</li>
                    </ul> -->
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Card Information</label>
                    <div id="card-element" class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white">
                        <!-- Stripe Element will be inserted here -->
                    </div>
                    <div id="card-errors" class="text-red-500 text-sm mt-1 hidden" role="alert"></div>
                </div>
            </div>

            {{-- Order Summary & Submit --}}
            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <p class="text-lg font-medium text-gray-800">Order Total</p>
                        <p class="text-sm text-gray-500">Including all taxes</p>
                    </div>
                    <p class="text-2xl font-bold text-[#49608a]">Rs. {{ number_format($total, 2) }}</p>
                </div>
                
                <button type="submit" id="submit-btn" 
                    class="w-full bg-[#49608a] text-white px-8 py-4 rounded-xl hover:bg-[#3a4e73] transition-all duration-300 shadow-md hover:shadow-lg font-semibold text-lg">
                    Place Order
                </button>
                
                <p class="text-center text-gray-500 text-sm mt-4">
                    By placing your order, you agree to our Terms of Service and Privacy Policy
                </p>
            </div>
        </form>
    </main>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Initialize Stripe
        const stripe = Stripe('{{ env("STRIPE_KEY") }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    fontFamily: '"Roboto", sans-serif',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
        });
        cardElement.mount('#card-element');

        // Handle real-time validation errors
        cardElement.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
                displayError.classList.remove('hidden');
            } else {
                displayError.textContent = '';
                displayError.classList.add('hidden');
            }
        });

        // Show/hide card fields based on payment method
        const paymentMethodSelect = document.getElementById('payment_method');
        const cardFields = document.getElementById('card-fields');
        
        function toggleCardFields() {
            if (paymentMethodSelect.value === 'card') {
                cardFields.classList.remove('hidden');
                cardFields.classList.add('block');
            } else {
                cardFields.classList.remove('block');
                cardFields.classList.add('hidden');
            }
        }

        paymentMethodSelect.addEventListener('change', toggleCardFields);
        
        // Initial check
        if (paymentMethodSelect.value === 'card') {
            toggleCardFields();
        }

        // Form submission
        const form = document.getElementById('checkout-form');
        const submitBtn = document.getElementById('submit-btn');

        form.addEventListener('submit', async function(e) {
            const paymentMethod = document.getElementById('payment_method').value;
            
            if (paymentMethod === 'card') {
                e.preventDefault();
                
                // Disable button and show loading state
                submitBtn.disabled = true;
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing Payment...</span>';

                try {
                    // 1. Create Payment Intent
                    const response = await fetch('{{ route("stripe.create-intent") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    });
                    
                    const data = await response.json();
                    
                    if (data.error) {
                        throw new Error(data.error);
                    }

                    // 2. Confirm Card Payment
                    const { paymentIntent, error } = await stripe.confirmCardPayment(data.clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: document.querySelector('input[name="name"]').value,
                                email: document.querySelector('input[name="email"]').value,
                                phone: document.querySelector('input[name="phone"]').value,
                                address: {
                                    line1: document.querySelector('input[name="address"]').value,
                                    city: document.querySelector('input[name="city"]').value,
                                }
                            }
                        }
                    });

                    if (error) {
                        throw new Error(error.message);
                    }

                    if (paymentIntent.status === 'succeeded') {
                        // 3. Submit form to backend to create order
                        // We can append the payment intent ID if needed
                        const hiddenInput = document.createElement('input');
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'payment_intent_id');
                        hiddenInput.setAttribute('value', paymentIntent.id);
                        form.appendChild(hiddenInput);
                        
                        form.submit();
                    }

                } catch (error) {
                    console.error(error);
                    const displayError = document.getElementById('card-errors');
                    displayError.textContent = error.message;
                    displayError.classList.remove('hidden');
                    
                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            }
        });
    </script>
</x-app-layout>