<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                📦 Order Management
            </h2>
            <p class="text-sm font-medium text-gray-600 bg-white px-4 py-2 rounded-full shadow-sm">
                {{ $orders->total() }} total orders
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 border border-white/20 text-center hover:shadow-xl transition">
                    <p class="text-3xl font-bold text-gray-900">{{ $totalOrders ?? 0 }}</p>
                    <p class="text-xs text-gray-600 font-medium">Total Orders</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 border border-white/20 text-center hover:shadow-xl transition">
                    <p class="text-3xl font-bold text-amber-600">{{ $pendingOrders ?? 0 }}</p>
                    <p class="text-xs text-gray-600 font-medium">Pending</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 border border-white/20 text-center hover:shadow-xl transition">
                    <p class="text-3xl font-bold text-blue-600">{{ $processingOrders ?? 0 }}</p>
                    <p class="text-xs text-gray-600 font-medium">Processing</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 border border-white/20 text-center hover:shadow-xl transition">
                    <p class="text-3xl font-bold text-emerald-600">{{ $deliveredOrders ?? 0 }}</p>
                    <p class="text-xs text-gray-600 font-medium">Delivered</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 border border-white/20 text-center hover:shadow-xl transition">
                    <p class="text-3xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">₱{{ number_format($totalRevenue ?? 0, 2) }}</p>
                    <p class="text-xs text-gray-600 font-medium">Revenue</p>
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 mb-6 border border-white/20">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap gap-4 items-end">
                    
                    <!-- Search -->
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Order #, Customer, Email..."
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 border px-4 py-2">
                    </div>

                    <!-- Order Status Filter -->
                    <div class="min-w-[150px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                        <select name="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 border px-4 py-2">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Payment Status Filter -->
                    <div class="min-w-[150px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment</label>
                        <select name="payment_status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 border px-4 py-2">
                            <option value="">All Payments</option>
                            <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="bg-gradient-to-r from-rose-500 to-pink-600 text-white px-6 py-2 rounded-xl font-medium hover:shadow-lg hover:scale-105 transition">
                            🔍 Filter
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium hover:bg-gray-300 transition">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/20">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-rose-500 to-pink-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Order #</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Payment</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 transition group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-900">{{ $order->order_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->customer_email }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-lg text-rose-600">₱{{ number_format($order->total_amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $order->getPaymentStatusBadgeClass() }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $order->getStatusBadgeClass() }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="text-rose-600 hover:text-rose-900 font-semibold mr-3 hover:underline">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="bg-gradient-to-br from-rose-100 to-pink-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                        <svg class="h-10 w-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium text-lg">No orders found</p>
                                    <p class="text-gray-400 text-sm mt-1">Orders will appear here when customers place them</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $orders->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>