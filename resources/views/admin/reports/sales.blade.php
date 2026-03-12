<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                💰 Sales Report
            </h2>
            <a href="{{ route('admin.reports.index') }}" class="bg-white text-gray-700 px-4 py-2 rounded-full shadow-sm hover:shadow-md transition">← Back to Reports</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Total Sales Card -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-3xl shadow-2xl p-8 mb-8 text-white">
                <p class="text-sm font-medium text-emerald-100 mb-2">Total Sales (Selected Period)</p>
                <p class="text-5xl font-bold">₱{{ number_format($totalSales, 2) }}</p>
            </div>

            <!-- Date Filter -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 mb-6 border border-white/20">
                <form method="GET" action="{{ route('admin.reports.sales') }}" class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 border px-4 py-2">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 border px-4 py-2">
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-2 rounded-xl font-medium hover:shadow-lg hover:scale-105 transition">Filter</button>
                </form>
            </div>

            <!-- Sales Table -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/20">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-emerald-500 to-teal-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Order #</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($sales as $sale)
                            <tr class="hover:bg-emerald-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $sale->order_number }}</td>
                                <td class="px-6 py-4">{{ $sale->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $sale->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 font-bold text-emerald-600">₱{{ number_format($sale->total_amount, 2) }}</td>
                                <td class="px-6 py-4"><span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Paid</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">No sales found in this period</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t">{{ $sales->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>