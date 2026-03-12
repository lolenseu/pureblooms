<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                🌸 Admin Dashboard
            </h2>
            <p class="text-sm font-medium text-gray-600 bg-white px-4 py-2 rounded-full shadow-sm">
                📅 {{ now()->format('l, F d, Y') }}
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="relative overflow-hidden bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 rounded-3xl shadow-2xl p-8 mb-8 text-white">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS1vcGFjaXR5PSIwLjEiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')] opacity-20"></div>
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-extrabold mb-3 drop-shadow-lg">
                            Welcome back, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-rose-100 text-lg">Manage your PureBlooms flower shop with elegance ✨</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-white/20 backdrop-blur-sm rounded-3xl p-6 shadow-2xl">
                            <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4 mb-8">
                <!-- Total Products -->
                <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-4 border border-white/20 hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                    <div class="relative z-10">
                        <p class="text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Products</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">{{ $totalProducts ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2 font-medium">🌺 Flowers</p>
                    </div>
                </div>

                <!-- Total Categories -->
                <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-4 border border-white/20 hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                    <div class="relative z-10">
                        <p class="text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Categories</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">{{ $totalCategories ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2 font-medium">📂 Groups</p>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-4 border border-white/20 hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                    <div class="relative z-10">
                        <p class="text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Orders</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">{{ $totalOrders ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2 font-medium">🛍️ Total</p>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-4 border border-white/20 hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                    <div class="relative z-10">
                        <p class="text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Revenue</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">₱{{ number_format($totalRevenue ?? 0, 2) }}</p>
                        <p class="text-xs text-gray-500 mt-2 font-medium">💰 Sales</p>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-4 border border-white/20 hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                    <div class="relative z-10">
                        <p class="text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Pending</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-amber-600 to-red-600 bg-clip-text text-transparent">{{ $pendingOrders ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2 font-medium">⏳ Attention</p>
                    </div>
                </div>

                <!-- Total Customers -->
                <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-4 border border-white/20 hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                    <div class="relative z-10">
                        <p class="text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wide">Customers</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">{{ $totalCustomers ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-2 font-medium">👥 Users</p>
                    </div>
                </div>

                <!-- ✅ Total Addons -->
                <div class="group relative bg-gradient-to-br from-purple-500 via-indigo-500 to-violet-600 rounded-3xl shadow-xl p-4 text-white hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                    <div class="relative z-10">
                        <p class="text-xs font-semibold text-white/80 mb-1 uppercase tracking-wide">Addons</p>
                        <p class="text-3xl font-extrabold">{{ $totalAddons ?? 0 }}</p>
                        <p class="text-xs text-white/70 mt-2 font-medium">{{ $activeAddons ?? 0 }} active</p>
                    </div>
                </div>
            </div>

            <!-- ✅ Addon Revenue & Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <!-- Addon Revenue -->
                <div class="bg-gradient-to-r from-purple-500 via-pink-500 to-rose-600 rounded-3xl shadow-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-white/80 mb-1">🎁 Addon Revenue</p>
                            <p class="text-3xl font-bold">₱{{ number_format($addonRevenue ?? 0, 2) }}</p>
                            <p class="text-xs text-white/70 mt-1">From all orders with addons</p>
                        </div>
                        <div class="bg-white/20 p-4 rounded-2xl">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active vs Inactive Addons -->
                <div class="bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-600 rounded-3xl shadow-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-white/80 mb-1">📊 Addon Status</p>
                            <p class="text-3xl font-bold">{{ $activeAddons ?? 0 }} / {{ $totalAddons ?? 0 }}</p>
                            <p class="text-xs text-white/70 mt-1">Active / Total addons</p>
                        </div>
                        <div class="bg-white/20 p-4 rounded-2xl">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alert -->
            @if(isset($lowStockProducts) && $lowStockProducts > 0)
            <div class="relative overflow-hidden bg-gradient-to-r from-red-500 via-orange-500 to-amber-500 p-6 mb-8 rounded-3xl shadow-2xl">
                <div class="relative z-10 flex items-center">
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 mr-4">
                        <svg class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white">⚠️ Low Stock Alert!</h3>
                        <p class="text-white/90 mt-1">
                            <span class="font-bold">{{ $lowStockProducts }} product(s)</span> need restocking. 
                            <a href="{{ route('admin.products.index') }}" class="underline font-bold hover:text-white">View products →</a>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Recent Products -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-white/20">
                    <div class="bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 px-6 py-5">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-bold text-white">🌺 Recent Products</h3>
                            <a href="{{ route('admin.products.index') }}" class="bg-white/20 backdrop-blur-sm text-white hover:bg-white/30 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300">View All →</a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if(isset($recentProducts) && $recentProducts->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentProducts as $product)
                                <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-2xl border border-gray-100 hover:shadow-xl hover:border-rose-200 transition-all duration-300 hover:-translate-x-2">
                                    <div class="flex items-center">
                                        @if($product->image_path)
                                            <img src="{{ Storage::url($product->image_path) }}" class="w-20 h-20 object-cover rounded-2xl shadow-md group-hover:shadow-lg transition-shadow duration-300" alt="{{ $product->name }}">
                                        @else
                                            <div class="w-20 h-20 bg-gradient-to-br from-rose-100 to-pink-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                <svg class="h-10 w-10 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <p class="font-bold text-gray-900 text-lg">{{ $product->name }}</p>
                                            <p class="text-sm text-gray-500 font-medium">{{ $product->category->name ?? 'No Category' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-rose-600 to-pink-600">₱{{ number_format($product->price, 2) }}</p>
                                        <p class="text-xs {{ $product->stock_quantity > 0 ? 'text-emerald-600' : 'text-red-600' }} font-bold mt-1">
                                            {{ $product->stock_quantity > 0 ? '✓ ' : '✗ ' }}{{ $product->stock_quantity }} in stock
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="bg-gradient-to-br from-rose-100 to-pink-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4 animate-pulse">
                                    <svg class="h-12 w-12 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-semibold text-lg">No products yet</p>
                                <a href="{{ route('admin.products.create') }}" class="inline-block mt-4 bg-gradient-to-r from-rose-500 to-pink-600 text-white px-8 py-3 rounded-full font-bold shadow-lg hover:shadow-rose-500/50 hover:scale-105 transition-all duration-300">Add First Product →</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden border border-white/20">
                    <div class="bg-gradient-to-r from-purple-500 via-indigo-500 to-blue-600 px-6 py-5">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-bold text-white">📦 Recent Orders</h3>
                            <a href="{{ route('admin.orders.index') }}" class="bg-white/20 backdrop-blur-sm text-white hover:bg-white/30 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300">View All →</a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if(isset($recentOrders) && $recentOrders->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentOrders as $order)
                                <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-2xl border border-gray-100 hover:shadow-xl hover:border-purple-200 transition-all duration-300 hover:-translate-x-2">
                                    <div>
                                        <p class="font-bold text-gray-900 text-lg">{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-500 font-medium">{{ $order->customer_name }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">₱{{ number_format($order->total_amount, 2) }}</p>
                                        <span class="inline-block px-3 py-1 text-xs font-bold rounded-full mt-1 {{ $order->getStatusBadgeClass() }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="bg-gradient-to-br from-purple-100 to-indigo-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4 animate-pulse">
                                    <svg class="h-12 w-12 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-semibold text-lg">No orders yet</p>
                                <p class="text-gray-400 text-sm mt-1">Orders will appear here when customers place them</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20 mb-8">
                <h3 class="text-3xl font-bold text-gray-900 mb-8 text-center">⚡ Quick Actions</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-4">
                    <!-- Add Product -->
                    <a href="{{ route('admin.products.create') }}" class="group relative overflow-hidden bg-gradient-to-br from-rose-500 via-pink-500 to-purple-600 rounded-2xl p-4 text-white shadow-xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                        <div class="relative z-10 text-center">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl w-12 h-12 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <p class="font-bold text-sm">Add Product</p>
                        </div>
                    </a>
                    
                    <!-- ✅ Manage Addons - NEW BUTTON -->
                    <a href="{{ route('admin.addons.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-violet-500 via-purple-500 to-indigo-600 rounded-2xl p-4 text-white shadow-xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                        <div class="relative z-10 text-center">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl w-12 h-12 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <p class="font-bold text-sm">Manage Addons</p>
                        </div>
                    </a>
                    
                    <!-- Add Category -->
                    <a href="{{ route('admin.categories.create') }}" class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600 rounded-2xl p-4 text-white shadow-xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                        <div class="relative z-10 text-center">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl w-12 h-12 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <p class="font-bold text-sm">Add Category</p>
                        </div>
                    </a>
                    
                    <!-- View Products -->
                    <a href="{{ route('admin.products.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-purple-500 via-indigo-500 to-blue-600 rounded-2xl p-4 text-white shadow-xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                        <div class="relative z-10 text-center">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl w-12 h-12 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                            <p class="font-bold text-sm">Products</p>
                        </div>
                    </a>
                    
                    <!-- View Orders -->
                    <a href="{{ route('admin.orders.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-amber-500 via-orange-500 to-red-600 rounded-2xl p-4 text-white shadow-xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                        <div class="relative z-10 text-center">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl w-12 h-12 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <p class="font-bold text-sm">Orders</p>
                        </div>
                    </a>
                    
                    <!-- Users -->
                    <a href="{{ route('admin.users.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-cyan-500 via-blue-500 to-indigo-600 rounded-2xl p-4 text-white shadow-xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                        <div class="relative z-10 text-center">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl w-12 h-12 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <p class="font-bold text-sm">Users</p>
                        </div>
                    </a>
                    
                    <!-- Categories -->
                    <a href="{{ route('admin.categories.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-green-500 via-lime-500 to-emerald-600 rounded-2xl p-4 text-white shadow-xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-2 hover:scale-105">
                        <div class="relative z-10 text-center">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl w-12 h-12 flex items-center justify-center mx-auto mb-2 group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <p class="font-bold text-sm">Categories</p>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>