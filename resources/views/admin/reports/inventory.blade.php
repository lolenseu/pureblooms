<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                📦 Inventory Report
            </h2>
            <a href="{{ route('admin.reports.index') }}" class="bg-white text-gray-700 px-4 py-2 rounded-full shadow-sm hover:shadow-md transition">← Back to Reports</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/20">
                    <p class="text-sm text-gray-600 mb-1">Total Products</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/20">
                    <p class="text-sm text-gray-600 mb-1">Low Stock</p>
                    <p class="text-3xl font-bold text-amber-600">{{ $lowStock }}</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/20">
                    <p class="text-sm text-gray-600 mb-1">Out of Stock</p>
                    <p class="text-3xl font-bold text-red-600">{{ $outOfStock }}</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/20">
                    <p class="text-sm text-gray-600 mb-1">Inventory Value</p>
                    <p class="text-3xl font-bold text-emerald-600">₱{{ number_format($totalInventoryValue, 2) }}</p>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/20">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-purple-500 to-indigo-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Stock</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Value</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($products as $product)
                            <tr class="hover:bg-purple-50 transition">
                                <td class="px-6 py-4 font-semibold">{{ $product->name }}</td>
                                <td class="px-6 py-4">{{ $product->category->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">₱{{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4">{{ $product->stock_quantity }}</td>
                                <td class="px-6 py-4 font-bold">₱{{ number_format($product->price * $product->stock_quantity, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if($product->stock_quantity == 0)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                                    @elseif($product->stock_quantity <= 5)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Low Stock</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>