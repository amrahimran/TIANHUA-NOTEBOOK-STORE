<x-app-layout>
    @section('title', 'Contact Us | Tian Hua')

    <main class="max-w-[1500px] mx-auto py-12 px-4 font-roboto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-6">Contact Us</h1>
            <p class="text-lg">
                We'd love to hear from you! Whether you have questions, need assistance, or want to provide feedback, we're here to help.
            </p>
        </div>

        <!-- Contact Form Section -->
        <div class="flex items-center justify-center w-full sm:w-3/4 mx-auto bg-white p-8 rounded-lg shadow-lg">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md text-center">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('contact.submit') }}" method="POST" class="w-full">
                @csrf
                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-lg text-accent-color font-semibold mb-2">Your Name :</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-4 py-2 border-[2px] border-accent-color rounded-md text-lg focus:outline-none focus:ring-2 focus:ring-[#B2AC88]"
                        required>
                </div>

                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-lg text-accent-color font-semibold mb-2">Your Email :</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-2 border-[2px] border-accent-color rounded-md text-lg focus:outline-none focus:ring-2 focus:ring-[#B2AC88]"
                        required>
                </div>

                <!-- Message Field -->
                <div class="mb-6">
                    <label for="message" class="block text-lg text-accent-color font-semibold mb-2">Your Message :</label>
                    <textarea id="message" name="message" rows="6"
                        class="w-full px-4 py-2 border-[2px] border-accent-color rounded-md text-lg focus:outline-none focus:ring-2 focus:ring-[#B2AC88]"
                        required></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="button transition-all">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>
