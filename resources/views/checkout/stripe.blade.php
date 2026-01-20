<x-app-layout>
    <main class="max-w-4xl mx-auto p-6 font-roboto">
        <h2 class="text-3xl font-bold text-[#49608a] mb-6">Card Payment</h2>

        <div class="bg-white shadow-lg rounded-2xl p-6 mb-6">
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Order Summary</h3>
                <p class="text-lg">Total: <span class="font-bold text-[#49608a]">Rs. {{ number_format($total, 2) }}</span></p>
            </div>

            <!-- Demo Card Instructions -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <h4 class="font-bold text-yellow-800 mb-2">💳 Test Card Details (For Demo):</h4>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li><strong>Card Number:</strong> 4242 4242 4242 4242</li>
                    <li><strong>Expiry Date:</strong> Any future date (e.g., 12/30)</li>
                    <li><strong>CVC:</strong> Any 3 digits (e.g., 123)</li>
                    <li><strong>ZIP:</strong> Any 5 digits</li>
                </ul>
                <p class="text-xs text-yellow-600 mt-2">This is a Stripe test environment. No real money will be charged.</p>
            </div>

            <!-- Stripe Payment Form -->
            <form id="payment-form">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Card Information</label>
                    <div id="card-element" class="border border-gray-300 rounded-xl p-3"></div>
                    <div id="card-errors" class="text-red-500 text-sm mt-2" role="alert"></div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <button type="submit" id="submit-button" 
                        class="bg-[#49608a] text-white px-8 py-3 rounded-xl hover:bg-[#3a4e73] transition shadow-md w-full disabled:opacity-50"
                        disabled>
                        <span id="button-text">Pay Rs. {{ number_format($total, 2) }}</span>
                        <div id="spinner" class="ml-2 inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    </button>
                </div>
            </form>
        </div>

        <!-- Stripe JS -->
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            const stripe = Stripe('{{ env("STRIPE_KEY") }}');
            const elements = stripe.elements();
            
            const cardElement = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#32325d',
                        '::placeholder': {
                            color: '#a0aec0',
                        },
                    },
                },
            });
            
            cardElement.mount('#card-element');
            
            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            const spinner = document.getElementById('spinner');
            
            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                
                // Disable button and show spinner
                submitButton.disabled = true;
                buttonText.textContent = 'Processing...';
                spinner.classList.remove('hidden');
                
                // Create payment intent
                const response = await fetch('{{ route("stripe.create-intent") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: {{ $total }},
                        name: '{{ $orderDetails["name"] }}',
                        email: '{{ $orderDetails["email"] }}',
                        phone: '{{ $orderDetails["phone"] }}',
                        address: '{{ $orderDetails["address"] }}',
                        city: '{{ $orderDetails["city"] }}'
                    })
                });
                
                const data = await response.json();
                
                if (data.error) {
                    document.getElementById('card-errors').textContent = data.error;
                    submitButton.disabled = false;
                    buttonText.textContent = 'Pay Rs. {{ number_format($total, 2) }}';
                    spinner.classList.add('hidden');
                    return;
                }
                
                // Confirm payment
                const {error, paymentIntent} = await stripe.confirmCardPayment(
                    data.clientSecret,
                    {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: '{{ $orderDetails["name"] }}',
                                email: '{{ $orderDetails["email"] }}',
                                phone: '{{ $orderDetails["phone"] }}',
                                address: {
                                    line1: '{{ $orderDetails["address"] }}',
                                    city: '{{ $orderDetails["city"] }}',
                                }
                            }
                        }
                    }
                );
                
                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    submitButton.disabled = false;
                    buttonText.textContent = 'Pay Rs. {{ number_format($total, 2) }}';
                    spinner.classList.add('hidden');
                } else if (paymentIntent.status === 'succeeded') {
                    // Redirect to success page
                    window.location.href = '{{ route("stripe.success") }}?payment_intent=' + paymentIntent.id;
                }
            });
        </script>a
    </main>
</x-app-layout>