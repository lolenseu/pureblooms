<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                📊 Reports & Analytics
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Date Range Filter -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 mb-6 border border-white/20">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 border px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 border px-4 py-2">
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-rose-500 to-pink-600 text-white px-6 py-2 rounded-xl font-medium hover:shadow-lg hover:scale-105 transition">🔄 Update Report</button>
                </form>
            </div>

            <!-- Key Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl shadow-xl p-6 text-white">
                    <p class="text-sm font-medium text-emerald-100 mb-1">Total Revenue</p>
                    <p class="text-4xl font-bold">₱{{ number_format($totalRevenue, 2) }}</p>
                    <p class="text-xs text-emerald-100 mt-2">From {{ $totalOrders }} orders</p>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-3xl shadow-xl p-6 text-white">
                    <p class="text-sm font-medium text-purple-100 mb-1">Total Orders</p>
                    <p class="text-4xl font-bold">{{ $totalOrders }}</p>
                    <p class="text-xs text-purple-100 mt-2">In selected period</p>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl shadow-xl p-6 text-white">
                    <p class="text-sm font-medium text-amber-100 mb-1">Avg Order Value</p>
                    <p class="text-4xl font-bold">₱{{ number_format($avgOrderValue, 2) }}</p>
                    <p class="text-xs text-amber-100 mt-2">Per order</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Status Breakdown -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 border border-white/20">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">📦 Order Status Breakdown</h3>
                    <div class="space-y-4">
                        @foreach(['pending' => '⏳ Pending', 'processing' => '🔄 Processing', 'shipped' => '🚚 Shipped', 'delivered' => '✅ Delivered', 'cancelled' => '❌ Cancelled'] as $status => $label)
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl">
                            <span class="font-medium text-gray-700">{{ $label }}</span>
                            <span class="px-4 py-2 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-full font-bold">
                                {{ $orderStatuses[$status] ?? 0 }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Top Selling Products -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 border border-white/20">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">🌺 Top Selling Products</h3>
                    <div class="space-y-3">
                        @forelse($topProducts as $index => $product)
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl">
                            <div class="flex items-center">
                                <span class="w-8 h-8 bg-gradient-to-br from-rose-500 to-pink-600 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $product->product_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $product->total_sold }} sold</p>
                                </div>
                            </div>
                            <p class="font-bold text-rose-600">₱{{ number_format($product->total_revenue, 2) }}</p>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-8">No sales data yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <a href="{{ route('admin.reports.sales') }}" class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl hover:scale-105 transition">
                    <h4 class="text-lg font-bold mb-2">💰 Sales Report</h4>
                    <p class="text-sm text-emerald-100">View detailed sales transactions</p>
                </a>
                <a href="{{ route('admin.reports.inventory') }}" class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl hover:scale-105 transition">
                    <h4 class="text-lg font-bold mb-2">📦 Inventory Report</h4>
                    <p class="text-sm text-purple-100">Check stock levels & values</p>
                </a>
                <a href="{{ route('admin.reports.customers') }}" class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl hover:scale-105 transition">
                    <h4 class="text-lg font-bold mb-2">👥 Customer Report</h4>
                    <p class="text-sm text-amber-100">Analyze customer behavior</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>