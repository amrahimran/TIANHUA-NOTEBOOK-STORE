<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center" 
        style="background-image: url('{{ asset('images/login-img.jpg') }}');">

        <div class="bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl p-8 w-full max-w-md border-t-4 border-[#7dadc4]">
            
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('images/transparentlogo.png') }}" alt="Logo" class="block h-14 w-auto">
                <h2 class="text-2xl font-semibold text-[#49608a] mt-2">Forgot Password?</h2>
                <p class="text-sm text-gray-600 text-center mt-1">
                    Don’t worry — we’ll help you reset it quickly.
                </p>
            </div>

            <x-validation-errors class="mb-4" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <x-label for="email" value="{{ __('Email Address') }}" class="text-[#49608a]" />
                    <x-input id="email" 
                        class="block mt-1 w-full border-gray-300 focus:border-[#7dadc4] focus:ring-[#7dadc4]" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" />
                </div>

                <div class="mt-6 w-full flex justify-center">
                    <x-button class="bg-[#49608a] hover:bg-[#752c37] text-white font-semibold py-2 px-4 rounded-lg shadow-md transition">
                        {{ __('Send Reset Link') }}
                    </x-button>
                </div>
            </form>

            <p class="text-center text-sm text-gray-600 mt-6">
                Remember your password? 
                <a href="{{ route('login') }}" class="text-[#49608a] hover:underline">
                    Log in
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
