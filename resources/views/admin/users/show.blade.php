<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                👤 User Details
            </h2>
            <a href="{{ route('admin.users.index') }}" class="bg-white text-gray-700 px-4 py-2 rounded-full shadow-sm hover:shadow-md transition">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl">
                    <p class="font-medium">✅ {{ session('success') }}</p>
                </div>
            @endif

            <!-- User Profile Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 h-32"></div>
                <div class="px-8 pb-8">
                    <div class="relative flex justify-between items-end -mt-12 mb-6">
                        <div class="flex items-end">
                            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-3xl font-bold text-gray-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <div class="ml-4 mb-1">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-gray-600">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                ✏️ Edit User
                            </a>
                            <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="{{ $user->is_active ? 'bg-amber-500 hover:bg-amber-600' : 'bg-emerald-500 hover:bg-emerald-600' }} text-white px-4 py-2 rounded-lg font-medium transition">
                                    {{ $user->is_active ? '⏸️ Deactivate' : '✅ Activate' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- User Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-1">📱 Phone</p>
                            <p class="font-semibold text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-1">📅 Member Since</p>
                            <p class="font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 mb-1">🔐 Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $user->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->is_active ? '✓ Active' : '✗ Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">📦 Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">💰 Total Spent</p>
                    <p class="text-3xl font-bold text-emerald-600">₱{{ number_format($totalSpent, 2) }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">📊 Avg Order Value</p>
                    <p class="text-3xl font-bold text-blue-600">₱{{ number_format($avgOrderValue, 2) }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">⏳ Pending</p>
                    <p class="text-3xl font-bold text-amber-600">{{ $pendingOrders }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">✅ Completed</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ $completedOrders }}</p>
                </div>
            </div>

            <!-- Order History -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900">📋 Order History</h3>
                </div>
                <div class="p-6">
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-lg transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y • h:i A') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-lg text-rose-600">₱{{ number_format($order->total_amount, 2) }}</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $order->order_status === 'delivered' ? 'bg-emerald-100 text-emerald-800' : 
                                               ($order->order_status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                               ($order->order_status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800')) }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Order Items -->
                                <div class="bg-gray-50 rounded-lg p-3 mt-3">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Items ({{ $order->items->count() }}):</p>
                                    <div class="space-y-1">
                                        @foreach($order->items as $item)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $item->quantity }}x {{ $item->product_name }}</span>
                                            <span class="text-gray-900">₱{{ number_format($item->subtotal, 2) }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Order Actions -->
                                <div class="mt-3 flex justify-end">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                        View Order Details →
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">No orders yet</p>
                            <p class="text-gray-400 text-sm mt-1">This customer hasn't placed any orders</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>