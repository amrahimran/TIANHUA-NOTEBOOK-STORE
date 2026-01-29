@php
use Illuminate\Support\Facades\Route;
@endphp

<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center" 
        style="background-image: url('{{ asset('images/login-img.jpg') }}')">

        <div class="bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl p-8 w-full max-w-md border-t-4 border-[#7dadc4]">
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('images/transparentlogo.png') }}" alt="Logo" class="block h-14 w-auto">
                <h2 class="text-2xl font-semibold text-[[#49608a]] mt-2">Welcome Back</h2>
                <p class="text-sm text-gray-600">Login to your Tian Hua account</p>
            </div>

            <x-validation-errors class="mb-4" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" class="text-[[#49608a]]" />
                    <x-input id="email" class="block mt-1 w-full border-gray-300 focus:border-[#7dadc4] focus:ring-[#7dadc4]" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" class="text-[[#49608a]]" />
                    <x-input id="password" class="block mt-1 w-full border-gray-300 focus:border-[#7dadc4] focus:ring-[#7dadc4]" 
                        type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-[#7dadc4] hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-6 w-full flex justify-end">
                    <x-button class="mx-auto bg-[#49608a] hover:bg-[#752c37] text-white font-semibold py-2 px-4 rounded-lg shadow-md transition">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>

            <div class="mt-6 flex items-center justify-between">
                <span class="border-b w-1/5 lg:w-1/4"></span>
                <span class="text-xs text-center text-gray-500 uppercase">or</span>
                <span class="border-b w-1/5 lg:w-1/4"></span>
            </div>

            <div class="mt-6">
                <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                    <img class="h-5 w-5 mr-2" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google logo">
                    Continue with Google
                </a>
            </div>

            <p class="text-center text-sm text-gray-600 mt-6">
                Don’t have an account? 
                <a href="{{ route('register') }}" class="text-[[#49608a]] hover:underline">Register here</a>
            </p>
        </div>
    </div>
</x-guest-layout>
