<x-app-layout>
    
    <div class="max-w-[1500px] mx-auto mt-0 mb-6">
        <div class="max-h-[600px] relative overflow-hidden">
            <img id="heroImage"
                class="hero-image w-full max-h-[600px] object-cover transition-opacity duration-700 ease-in-out opacity-100"
                src="{{ asset('images/heroslides/slide1.png') }}"
                alt="slide image">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const heroImage = document.getElementById('heroImage');
            const images = [
                "{{ asset('images/heroslides/slide1.png') }}",
                "{{ asset('images/heroslides/slide2.png') }}",
                "{{ asset('images/heroslides/slide3.png') }}",
                "{{ asset('images/heroslides/slide4.png') }}"
            ];

            let index = 0;

            setInterval(() => {
                // Fade out
                heroImage.classList.add('opacity-0');

                setTimeout(() => {
                    // Change image after fade-out
                    index = (index + 1) % images.length;
                    heroImage.src = images[index];

                    // Fade in
                    heroImage.classList.remove('opacity-0');
                }, 500); // half of transition duration for smooth fade
            }, 3000); //  3 seconds interval
        });
    </script>


    {{-- Best Sellers --}}
    <section class="max-w-[1500px] mx-auto p-4 mb-10">
        <h2 class="subheading">Best-Sellers</h2>
        <div class="flex gap-14 overflow-x-auto scrollbar-hide flex-nowrap px-2">
            @foreach ($products as $product)
                @if ($product->isBestSeller == 1)
                    <a href="{{ route('product.show', $product->id) }}" class="block">
                        <div class="w-[250px] md:w-[370px] h-[430px] mb-2 flex-shrink-0 bg-white shadow-lg shadow-gray-200 rounded-lg overflow-hidden transform transition-transform duration-300 ease-in-out hover:scale-110 hover:shadow-xl">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-[120px] lg:h-[200px] object-contain">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                                <p class="text-gray-600 mt-2 mb-2 h-[48px] overflow-hidden">{{ $product->description }}</p>
                                <p class="text-accent-color font-bold mb-2">Rs. {{ number_format($product->price, 2) }}</p>
                                <button class="button text-white px-4 py-2 rounded mt-2 w-full">View Details</button>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </section>


    {{-- Categories --}}
    @foreach ($categories as $sectionName => $cat)
        <section class="max-w-[1500px] mx-auto p-4 mb-10">
            <h2 class="subheading">{{ $sectionName }}</h2>
            <div class="flex gap-14 overflow-x-auto flex-nowrap px-2 scrollbar-hide">
                @foreach ($products as $product)
                    @if (str_contains($product->category, $cat) && strtoupper(substr($product->id, 0, 1)) === 'L')
                        <a href="{{ route('product.show', $product->id) }}" class="block">
                        <div class="w-[250px] md:w-[370px] h-[430px] mb-2 flex-shrink-0 bg-white shadow-lg shadow-gray-200 rounded-lg overflow-hidden transform transition-transform duration-300 ease-in-out hover:scale-110 hover:shadow-xl">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-[120px] lg:h-[200px] object-contain">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                                <p class="text-gray-600 mt-2 mb-2 h-[48px] overflow-hidden">{{ $product->description }}</p>
                                <p class="text-accent-color font-bold mb-2">Rs. {{ number_format($product->price, 2) }}</p>
                                <button class="button text-white px-4 py-2 rounded mt-2 w-full">View Details</button>
                            </div>
                        </div>
                    </a>

                    @endif
                @endforeach
            </div>
        </section>
    @endforeach

    {{-- Admin Dashboard Button --}}
    @if (Auth::check() && Auth::user()->isAdmin)
        <a href="{{ route('admin.dashboard') }}" 
            class="fixed bottom-5 right-5 bg-[#B2AC88] text-white px-4 py-2 rounded-full shadow-lg font-bold hover:bg-[#978F60] transition">
            Admin Dashboard
        </a>
    @endif
</x-app-layout>
