@section('title', 'Wishlist | Tian Hua')
<x-app-layout>

    <div class="py-8 px-6">
        @if ($wishlists->isEmpty())
            <p class="text-gray-500 text-center text-lg">Your wishlist is empty 🥺</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($wishlists as $item)
                    <div class="bg-white shadow rounded-xl p-4 flex flex-col items-center transition hover:shadow-lg">
                        <a href="{{ url('/products/' . $item->product_id) }}">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-48 h-48 object-cover rounded-lg">
                            <h3 class="text-lg font-semibold mt-3">{{ $item->name }}</h3>
                        </a>
                        <p class="text-gray-600 mt-1">{{ number_format($item->price, 2) }} LKR</p>

                        <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-4 py-1 rounded-lg hover:bg-red-600">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
