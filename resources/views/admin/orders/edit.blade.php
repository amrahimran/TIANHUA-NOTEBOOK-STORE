<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Order
        </h2>
    </x-slot>

    <x-nav-link :href="route('admin.orders.index')" class="ml-8 mt-4">
        Back To Orders Dashboard
    </x-nav-link>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white shadow-md rounded p-6">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block">Customer Name</label>
                    <input type="text" name="name" value="{{ $order->name }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Email</label>
                    <input type="email" name="email" value="{{ $order->email }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Phone</label>
                    <input type="text" name="phone" value="{{ $order->phone }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Address</label>
                    <input type="text" name="address" value="{{ $order->address }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">City</label>
                    <input type="text" name="city" value="{{ $order->city }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Payment Method</label>
                    <input type="text" name="payment_method" value="{{ $order->payment_method }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Total</label>
                    <input type="number" step="0.01" name="total" value="{{ $order->total }}" class="w-full border rounded px-2 py-1">
                </div>

                <div class="mb-4">
                    <label class="block">Status</label>
                    <select name="status" class="w-full border rounded px-2 py-1">
                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <button type="submit" class="bg-[#49608a] text-white px-4 py-2 rounded hover:bg-[#3a4e73]">
                    Update Order
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
