<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Order
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block">Customer Name</label>
                    <input type="text" name="customer_name" value="{{ $order->name }}" class="w-full border rounded px-2 py-1">
                </div>
                <div class="mb-4">
                    <label class="block">Total</label>
                    <input type="number" name="total" value="{{ $order->total }}" class="w-full border rounded px-2 py-1">
                </div>
                <div class="mb-4">
                    <label class="block">Status</label>
                    <select name="status" class="w-full border rounded px-2 py-1">
                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        {{-- <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option> --}}
                    </select>
                </div>
                <button type="submit" class="bg-[#49608a] text-white px-4 py-2 rounded hover:bg-[#3a4e73]">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
