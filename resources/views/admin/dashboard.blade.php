<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 bg-white shadow rounded-lg text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Total Products</h3>
                    <p class="text-3xl font-bold text-[#49608a] mt-2">{{ $productsCount }}</p>
                    <a href="{{ route('admin.products.index') }}" class="mt-4 inline-block bg-[#49608a] text-white px-4 py-2 rounded hover:bg-[#3a4e73] transition">Manage Products</a>
                </div>
                
                <div class="p-6 bg-white shadow rounded-lg text-center">
                    <h3 class="text-lg font-semibold text-gray-700">Total Orders</h3>
                    <p class="text-3xl font-bold text-[#49608a] mt-2">{{ $ordersCount }}</p>
                    <a href="{{ route('admin.orders.index') }}" class="mt-4 inline-block bg-[#49608a] text-white px-4 py-2 rounded hover:bg-[#3a4e73] transition">Manage Orders</a>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
