<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                📋 Order #{{ $order->order_number }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" 
               class="bg-white text-gray-700 px-4 py-2 rounded-full shadow-sm hover:shadow-md transition font-medium">
                ← Back to Orders
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl shadow-md">
                    <p class="font-medium">✅ {{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Order Info Card -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Order Details -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 pb-4 border-b">📦 Order Details</h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Order Number</p>
                                <p class="font-bold text-gray-900">{{ $order->order_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Order Date</p>
                                <p class="font-bold text-gray-900">{{ $order->created_at->format('M d, Y - h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Payment Method</p>
                                <p class="font-bold text-gray-900">{{ strtoupper($order->payment_method) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Payment Status</p>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $order->getPaymentStatusBadgeClass() }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 pb-4 border-b">👤 Customer Information</h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-bold text-gray-900">{{ $order->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-bold text-gray-900">{{ $order->customer_email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-bold text-gray-900">{{ $order->customer_phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">User ID</p>
                                <p class="font-bold text-gray-900">#{{ $order->user_id }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t">
                            <p class="text-sm text-gray-500 mb-1">Shipping Address</p>
                            <p class="font-medium text-gray-900">{{ $order->shipping_address }}, {{ $order->city }} {{ $order->zip_code }}</p>
                        </div>
                        
                        @if($order->notes)
                        <div class="mt-4 pt-4 border-t">
                            <p class="text-sm text-gray-500 mb-1">Order Notes</p>
                            <p class="text-gray-700">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 pb-4 border-b">🌺 Items Ordered</h3>
                        
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100">
                                <div class="flex items-center">
                                    @if($item->product?->image_path)
                                        <img src="{{ Storage::url($item->product->image_path) }}" 
                                             class="w-16 h-16 object-cover rounded-xl shadow-sm" 
                                             alt="{{ $item->product_name }}">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-br from-rose-100 to-pink-100 rounded-xl flex items-center justify-center">
                                            <svg class="h-8 w-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <p class="font-bold text-gray-900">{{ $item->product_name }}</p>
                                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ₱{{ number_format($item->price, 2) }}</p>
                                    </div>
                                </div>
                                <p class="font-bold text-lg text-rose-600">₱{{ number_format($item->subtotal, 2) }}</p>
                            </div>
                            @endforeach
                        </div>
                        <!-- Addons Section (if any) -->
@if($order->addons)
<div class="mt-6 pt-6 border-t border-purple-200">
    <h4 class="font-bold text-purple-700 mb-4 flex items-center gap-2">
        <span>🎁</span> Selected Addons
    </h4>
    
    @php
        $addons = json_decode($order->addons, true);
    @endphp
    
    @if($addons && is_array($addons))
        <div class="space-y-3">
            @foreach($addons as $addonKey => $price)
            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl border border-purple-100">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">
                        @switch($addonKey)
                            @case('greeting_card') 💌 @break
                            @case('chocolate') 🍫 @break
                            @case('balloon') 🎈 @break
                            @case('teddy_bear') 🧸 @break
                            @case('vase') 🏺 @break
                            @default 🎁
                        @endswitch
                    </span>
                    <div>
                        <p class="font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $addonKey)) }}</p>
                        <p class="text-xs text-gray-500">Addon Item</p>
                    </div>
                </div>
                <p class="font-bold text-purple-600">+₱{{ number_format($price, 2) }}</p>
            </div>
            @endforeach
        </div>
        
        <!-- Addons Total -->
        <div class="mt-4 pt-4 border-t-2 border-purple-300">
            <div class="flex justify-between items-center">
                <span class="font-bold text-gray-700">Addons Subtotal:</span>
                <span class="text-xl font-bold text-purple-600">₱{{ number_format($order->addons_total ?? 0, 2) }}</span>
            </div>
        </div>
    @else
        <p class="text-gray-500 text-sm italic">No addons data available</p>
    @endif
</div>
@endif
                        <!-- Order Summary -->
                        <div class="mt-6 pt-6 border-t">
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-medium text-gray-600">Total Amount</p>
                                <p class="text-3xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Update Card -->
                <div class="space-y-6">
                    
                    <!-- Update Status Form -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20 sticky top-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 pb-4 border-b">⚙️ Update Status</h3>
                        
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="space-y-4">
                                <!-- Order Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                                    <select name="order_status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 border px-4 py-2" required>
                                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                                        <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>🚚 Shipped</option>
                                        <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                    </select>
                                </div>

                                <!-- Payment Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                                    <select name="payment_status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 border px-4 py-2" required>
                                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>✅ Paid</option>
                                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>❌ Failed</option>
                                    </select>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2 pt-2">
                                    <button type="submit" 
                                            class="flex-1 bg-gradient-to-r from-rose-500 to-pink-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition">
                                        💾 Update Status
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-white/20">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Quick Stats</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Items</span>
                                <span class="font-bold">{{ $order->items->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Total Qty</span>
                                <span class="font-bold">{{ $order->items->sum('quantity') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Customer ID</span>
                                <span class="font-bold">#{{ $order->user_id }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-red-200">
                        <h3 class="text-lg font-bold text-red-600 mb-4">⚠️ Danger Zone</h3>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-100 text-red-700 py-3 rounded-xl font-semibold hover:bg-red-200 transition">
                                🗑️ Delete Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>