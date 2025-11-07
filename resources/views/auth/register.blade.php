<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center"
        style="background-image: url('{{ asset('images/login-img.jpg') }}');">

        <div class="bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl p-8 w-full max-w-md border-t-4 border-[#7dadc4]">
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('images/transparentlogo.png') }}" alt="Logo" class="block h-14 w-auto">
                <h2 class="text-2xl font-semibold text-[#49608a] mt-2">Create Your Account</h2>
                <p class="text-sm text-gray-600">Join the Tian Hua community</p>
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-label for="name" value="{{ __('Full Name') }}" class="text-[#49608a]" />
                    <x-input id="name" class="block mt-1 w-full border-gray-300 focus:border-[#7dadc4] focus:ring-[#7dadc4]"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email Address') }}" class="text-[#49608a]" />
                    <x-input id="email" class="block mt-1 w-full border-gray-300 focus:border-[#7dadc4] focus:ring-[#7dadc4]"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" class="text-[#49608a]" />
                    <x-input id="password" class="block mt-1 w-full border-gray-300 focus:border-[#7dadc4] focus:ring-[#7dadc4]"
                        type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-[#49608a]" />
                    <x-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-[#7dadc4] focus:ring-[#7dadc4]"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />
                                <span class="ms-2 text-sm text-gray-600">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-[#49608a] hover:underline">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-[#49608a] hover:underline">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </span>
                            </div>
                        </x-label>
                    </div>
                @endif

                <div class="mt-6 w-full flex justify-end">
                    <x-button class="mx-auto bg-[#49608a] hover:bg-[#752c37] text-white font-semibold py-2 px-4 rounded-lg shadow-md transition">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>

            <p class="text-center text-sm text-gray-600 mt-6">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-[#49608a] hover:underline">Login here</a>
            </p>
        </div>
    </div>
</x-guest-layout>
