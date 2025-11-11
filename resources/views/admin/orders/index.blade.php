<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Orders
        </h2>
    </x-slot>

    <x-nav-link :href="route('admin.dashboard')" class="ml-8 mt-4">
        Back To Dashboard
    </x-nav-link>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <table class="min-w-full bg-white shadow rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">City</th>
                        <th class="px-4 py-2">Payment</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="border px-4 py-2">{{ $order->id }}</td>
                        <td class="border px-4 py-2">{{ $order->name }}</td>
                        <td class="border px-4 py-2">{{ $order->email }}</td>
                        <td class="border px-4 py-2">{{ $order->phone }}</td>
                        <td class="border px-4 py-2">{{ $order->city }}</td>
                        <td class="border px-4 py-2">{{ $order->payment_method }}</td>
                        <td class="border px-4 py-2">Rs. {{ number_format($order->total, 2) }}</td>
                        <td class="border px-4 py-2">
                            <span class="{{ $order->status === 'Pending' ? 'text-yellow-600' : 'text-green-600' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-blue-500">Edit</a>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this order?')" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
