<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                👤 My Profile
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Profile Header -->
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
                            <a href="{{ route('customer.profile.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                ✏️ Edit Profile
                            </a>
                        </div>
                    </div>

                    <!-- User Info -->
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
                            <p class="text-sm text-gray-600 mb-1">🔐 Account Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $user->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->is_active ? '✓ Active' : '✗ Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">📦 Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">💰 Total Spent</p>
                    <p class="text-3xl font-bold text-emerald-600">₱{{ number_format($totalSpent, 2) }}</p>
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
                <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900">📋 My Orders</h3>
                    <a href="{{ route('customer.profile.password.edit') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                        🔐 Change Password
                    </a>
                </div>
                <div class="p-6">
                    @if($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($orders as $order)
                            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-lg transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y • h:i A') }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $order->items->count() }} item(s)</p>
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
                                <div class="mt-3">
                                    <a href="{{ route('customer.orders.details', $order->id) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                        View Order Details →
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">No orders yet</p>
                            <p class="text-gray-400 text-sm mt-1">Start shopping to see your orders here!</p>
                            <a href="{{ route('customer.dashboard') }}" class="inline-block mt-4 bg-gradient-to-r from-rose-500 to-pink-600 text-white px-6 py-2 rounded-xl font-semibold hover:shadow-lg transition">
                                🌸 Browse Products
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>