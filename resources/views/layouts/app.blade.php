<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explore the elegance of Tian Hua. Purchase premium notebooks online and enjoy same-day delivery. Discover the beauty of exquisite journals that have been meticulously designed with excellence.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Tian Hua | Notebook Store')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-white">
    <x-banner />

    <!-- Navigation -->
    @include('navigation-menu')

    <!-- Main Page Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer Section -->
    <footer class="footer bg-[#7dadc4] mt-10 border-t border-gray-200">
        <div class="max-w-[1500px] mx-auto px-8 py-10">
            <div class="flex flex-wrap justify-between">
                <div class="w-full sm:w-1/3 mb-6 sm:mb-0">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Tian Hua Logo" class="h-[50px]">
                    </div>
                    <p class="mt-4 text-lg">Bringing elegance and beauty to every occasion with classic notebooks.</p>
                </div>

                <div class="w-full sm:w-1/3 mb-6 sm:mb-0">
                    <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 flex flex-col">
                        <li><a href="{{ route('dashboard') }}" class="hover:text-[#49608a]">Home</a></li>
                        <li><a href="{{ url('profile/about') }}" class="hover:text-[#49608a]">About Us</a></li>
                        <li><a href="{{ url('profile/products') }}" class="hover:text-[#49608a]">Products</a></li>
                        <li><a href="{{ url('profile/contact') }}" class="hover:text-[#49608a]">Contact</a></li>
                    </ul>
                </div>

                <div class="w-full sm:w-1/3">
                    <h3 class="text-xl font-semibold mb-4">Contact Us</h3>
                    <p class="text-lg flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <a href="mailto:info@tianhua.com" class="hover:text-[#49608a]">info@tianhua.com</a>
                    </p>
                    <p class="text-lg flex items-center mt-2">
                        <i class="fas fa-phone-alt mr-2"></i>
                        +1 234 567 890
                    </p>
                    <h3 class="text-xl font-semibold mt-4 mb-2">Our Address</h3>
                    <p class="text-lg">123 Blossom Avenue, Suite 101, Flower City, FL 56789</p>
                    <div class="mt-4">
                        <a href="https://www.google.com/maps?q=123+Blossom+Avenue,+Flower+City,+FL+56789" 
                           target="_blank" 
                           class="text-lg text-[#49608a] hover:text-[#ffffff]">
                            <i class="fas fa-map-marker-alt mr-2"></i> View on Map
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center text-sm">
                <p>&copy; 2025 Tian Hua. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('modals')
    @livewireScripts
</body>
</html>
