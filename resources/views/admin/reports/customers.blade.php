<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                👥 Customer Report
            </h2>
            <a href="{{ route('admin.reports.index') }}" class="bg-white text-gray-700 px-4 py-2 rounded-full shadow-sm hover:shadow-md transition">← Back to Reports</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl shadow-xl p-6 text-white">
                    <p class="text-sm text-amber-100 mb-1">Total Customers</p>
                    <p class="text-4xl font-bold">{{ $totalCustomers }}</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl shadow-xl p-6 text-white">
                    <p class="text-sm text-emerald-100 mb-1">New This Month</p>
                    <p class="text-4xl font-bold">{{ $newCustomersThisMonth }}</p>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-3xl shadow-xl p-6 text-white">
                    <p class="text-sm text-purple-100 mb-1">Active Buyers</p>
                    <p class="text-4xl font-bold">{{ $customersWithOrders }}</p>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/20">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-amber-500 to-orange-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Orders</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($customers as $customer)
                            <tr class="hover:bg-amber-50 transition">
                                <td class="px-6 py-4 font-semibold">{{ $customer->name }}</td>
                                <td class="px-6 py-4">{{ $customer->email }}</td>
                                <td class="px-6 py-4"><span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">{{ $customer->orders_count }} orders</span></td>
                                <td class="px-6 py-4">{{ $customer->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t">{{ $customers->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>