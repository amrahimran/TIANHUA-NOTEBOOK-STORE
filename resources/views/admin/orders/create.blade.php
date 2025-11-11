<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Order
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.orders.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block">Customer Name</label>
                    <input type="text" name="name" class="w-full border rounded px-2 py-1">
                </div>
                <div class="mb-4">
                    <label class="block">Total</label>
                    <input type="number" name="total" class="w-full border rounded px-2 py-1">
                </div>
                <div class="mb-4">
                    <label class="block">Status</label>
                    <select name="status" class="w-full border rounded px-2 py-1">
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="bg-[#49608a] text-white px-4 py-2 rounded hover:bg-[#3a4e73]">Save</button>
            </form>
        </div>
    </div>
</x-app-layout>
