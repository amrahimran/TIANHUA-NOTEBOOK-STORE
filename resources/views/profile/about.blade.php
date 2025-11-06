@section('title', 'About Us | Tian Hua')

<x-app-layout>

    <!-- About Us Section with Flexbox -->
    <section class="max-w-full mx-auto bg-white py-6 mt-10 px-4 sm:px-6 md:px-8">
        <h1 class="text-4xl font-serif font-bold text-accent-color mb-12 text-center">About Tian Hua</h1>

        <!-- First Section: Text and Image -->
        <div class="w-full mx-auto md:flex md:flex-wrap items-center justify-between mb-12 flex-col md:flex-row">
            <!-- Text on the left (for larger screens) -->
            <div class="w-full sm:w-1/2 mb-6 md:mb-0 md:pr-6 text-center md:text-left">
                <p class="text-lg text-accent-color">
                    At Tian Hua, we believe notebooks are more than just pages; they are vessels for thoughts, dreams, and creativity. As a premium stationery store, we are dedicated to offering only the finest journals and writing essentials that meet our rigorous standards for quality, design, and functionality. Our thoughtfully curated collections are crafted to inspire every writer, artist, student, and professional.
                </p>
            </div>

            <!-- Image on the right (for larger screens) -->
            <div class="w-full sm:w-1/2 flex justify-center mb-6 md:mb-0">
                <img src="{{ asset('images/aboutus/aboutus1.jpg') }}" alt="image" class="h-[300px] w-[400px] md:h-[350px] md:w-[550px] object-cover rounded-lg shadow-md">
            </div>
        </div>

        <!-- Second Section: Text and Image -->
        <div class="w-full mx-auto md:flex md:flex-wrap items-center justify-between mb-12 flex-col md:flex-row">
            <!-- Image on the left (for larger screens) -->
            <div class="w-full sm:w-1/2 flex justify-center mb-6 md:mb-0 md:pr-6">
                <img src="{{ asset('images/aboutus/aboutus2.jpg') }}" alt="image" class="h-[300px] w-[400px] md:h-[350px] md:w-[550px] object-cover rounded-lg shadow-md">
            </div>

            <!-- Text on the right (for larger screens) -->
            <div class="w-full sm:w-1/2 text-center md:text-left">
                <p class="text-lg text-accent-color">
                    With a deep appreciation for craftsmanship, Tian Hua brings the art of fine journaling to life in every piece we offer. Each notebook is carefully designed to blend elegance with practicality—whether for documenting daily reflections, planning big ideas, or sketching creative works. Our selection ranges from minimalist hardcovers to vintage-inspired designs, ensuring there’s a perfect fit for every personality and purpose.
                </p>
            </div>
        </div>

        <!-- Third Section: Text and Image -->
        <div class="w-full mx-auto md:flex md:flex-wrap items-center justify-between mb-12 flex-col md:flex-row">
            <!-- Text on the left (for larger screens) -->
            <div class="w-full sm:w-1/2 mb-6 md:mb-0 md:pr-6 text-center md:text-left">
                <p class="text-lg text-accent-color">
                    At Tian Hua, we are also committed to sustainability in every step of our production and sourcing process. From eco-friendly paper to ethically crafted covers, we partner with makers who prioritize responsible practices. We believe luxury should go hand in hand with environmental mindfulness. Every purchase from Tian Hua reflects your support for quality, creativity, and a more sustainable world—one page at a time.
                </p>
            </div>

            <!-- Image on the right (for larger screens) -->
            <div class="w-full sm:w-1/2 flex justify-center mb-6 md:mb-0">
                <img src="{{ asset('images/aboutus/aboutus3.jpg') }}" alt="image" class="h-[300px] w-[400px] md:h-[350px] md:w-[550px] object-cover rounded-lg shadow-md">
            </div>
        </div>
    </section>

    <section class="max-w-[1500px] mx-auto py-1 pb-16">
        <!-- Row of 3 logos -->
        <div class="flex flex-wrap justify-center">
            <!-- Logo 1 -->
            <div class="text-center mb-8 px-8">
                <img src="{{ asset('images/aboutus/infoimg1.png') }}" alt="Logo 1" class="w-[100px] h-[100px] mx-auto mb-4 lg:h-[150px] lg:w-[150px]">
                <h2 class="text-lg font-semibold text-accent-color text-center">PREMIUM PAPER QUALITY</h2>
                <p class="text-sm text-accent-color text-center">
                    Sourced from trusted, eco-conscious mills,<br> our notebooks offer smooth, durable pages<br> for a flawless writing experience.
                </p>
            </div>

            <div class="text-center mb-8 px-8">
                <img src="{{ asset('images/aboutus/infoimg2.png') }}" alt="Logo 2" class="w-[100px] h-[100px] mx-auto mb-4 lg:h-[150px] lg:w-[150px]">
                <h2 class="text-lg font-semibold text-accent-color text-center">ARTISANAL DESIGNS</h2>
                <p class="text-sm text-accent-color text-center">
                    Thoughtfully crafted journals <br> with timeless aesthetics to<br> elevate everyday writing moments.
                </p>
            </div>

            <div class="text-center mb-8 px-8">
                <img src="{{ asset('images/aboutus/infoimg3.png') }}" alt="Logo 3" class="w-[100px] h-[100px] mx-auto mb-4 lg:h-[150px] lg:w-[150px]">
                <h2 class="text-lg font-semibold text-accent-color text-center">QUICK DELIVERY SERVICE</h2>
                <p class="text-sm text-accent-color text-center">Enjoy same-day<br> delivery.</p>
            </div>
        </div>
    </section>
</x-app-layout>
