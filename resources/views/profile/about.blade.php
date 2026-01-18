@section('title', 'About Us | Tian Hua')

<x-app-layout>

    <section class="max-w-full mx-auto bg-white py-6 mt-10 px-4 sm:px-6 md:px-8">
        <h1 class="text-4xl font-serif font-bold text-[#49608a] mb-12 text-center">About Tian Hua</h1>

        @foreach($sections as $section)
            <div class="w-full mx-auto md:flex md:flex-wrap items-center justify-between mb-12 flex-col md:flex-row">
                @if($loop->iteration % 2 != 0)
                    <!-- Text left, Image right -->
                    <div class="w-full sm:w-1/2 mb-6 md:mb-0 md:pr-6 text-center md:text-left">
                        <p class="text-lg text-[#49608a]">
                            {{ $section->content }}
                        </p>
                    </div>
                    <div class="w-full sm:w-1/2 flex justify-center mb-6 md:mb-0">
                        <img src="{{ asset($section->image) }}" alt="{{ $section->title }}" class="h-[300px] w-[400px] md:h-[350px] md:w-[550px] object-cover rounded-lg shadow-md">
                    </div>
                @else
                    <!-- Image left, Text right -->
                    <div class="w-full sm:w-1/2 flex justify-center mb-6 md:mb-0 md:pr-6">
                        <img src="{{ asset($section->image) }}" alt="{{ $section->title }}" class="h-[300px] w-[400px] md:h-[350px] md:w-[550px] object-cover rounded-lg shadow-md">
                    </div>
                    <div class="w-full sm:w-1/2 text-center md:text-left">
                        <p class="text-lg text-[#49608a]">
                            {{ $section->content }}
                        </p>
                    </div>
                @endif
            </div>
        @endforeach
    </section>

    <!-- Your logos section stays unchanged -->
    <section class="max-w-[1500px] mx-auto py-1 pb-16">
        <div class="flex flex-wrap justify-center">
            <!-- Logo 1 -->
            <div class="text-center mb-8 px-8">
                <img src="{{ asset('images/aboutus/infoimg1.png') }}" alt="Logo 1" class="w-[100px] h-[100px] mx-auto mb-4 lg:h-[150px] lg:w-[150px]">
                <h2 class="text-lg font-semibold text-[#49608a] text-center">PREMIUM PAPER QUALITY</h2>
                <p class="text-sm text-[#49608a] text-center">
                    Sourced from trusted, eco-conscious mills,<br> our notebooks offer smooth, durable pages<br> for a flawless writing experience.
                </p>
            </div>
            <div class="text-center mb-8 px-8">
                <img src="{{ asset('images/aboutus/infoimg2.png') }}" alt="Logo 2" class="w-[100px] h-[100px] mx-auto mb-4 lg:h-[150px] lg:w-[150px]">
                <h2 class="text-lg font-semibold text-[#49608a] text-center">ARTISANAL DESIGNS</h2>
                <p class="text-sm text-[#49608a] text-center">
                    Thoughtfully crafted journals <br> with timeless aesthetics to<br> elevate everyday writing moments.
                </p>
            </div>
            <div class="text-center mb-8 px-8">
                <img src="{{ asset('images/aboutus/infoimg3.png') }}" alt="Logo 3" class="w-[100px] h-[100px] mx-auto mb-4 lg:h-[150px] lg:w-[150px]">
                <h2 class="text-lg font-semibold text-[#49608a] text-center">QUICK DELIVERY SERVICE</h2>
                <p class="text-sm text-[#49608a] text-center">Enjoy same-day<br> delivery.</p>
            </div>
        </div>
    </section>

</x-app-layout>
