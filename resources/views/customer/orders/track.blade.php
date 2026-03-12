<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                📦 Track Order
            </h2>
            <a href="{{ route('customer.profile.show') }}" class="bg-white text-gray-700 px-4 py-2 rounded-full shadow-sm hover:shadow-md transition">
                ← Back to Profile
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto space-y-6">
            
            <!-- Order Header -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 p-6 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold mb-2">Order #{{ $order->order_number }}</h1>
                            <p class="text-rose-100">Placed on {{ $order->created_at->format('M d, Y • h:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold 
                                {{ $order->order_status === 'delivered' ? 'bg-emerald-500 text-white' : 
                                   ($order->order_status === 'shipped' ? 'bg-purple-500 text-white' : 
                                   ($order->order_status === 'processing' ? 'bg-blue-500 text-white' : 'bg-amber-500 text-white')) }}">
                                @if($order->order_status === 'pending')
                                    ⏳ Pending
                                @elseif($order->order_status === 'processing')
                                    🔄 Processing
                                @elseif($order->order_status === 'shipped')
                                    🚚 Shipped
                                @elseif($order->order_status === 'delivered')
                                    ✅ Delivered
                                @else
                                    {{ ucfirst($order->order_status) }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <!-- Left Column: Timeline + Order Details (3/4 width) -->
                <div class="lg:col-span-3 space-y-6">
                    
                    <!-- Tracking Timeline -->
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-8">📍 Order Timeline</h3>
                        
                        <div class="relative">
                            <!-- Timeline Line -->
                            <div class="absolute left-8 top-0 bottom-0 w-1 bg-gray-200"></div>
                            
                            <!-- Step 1: Order Placed -->
                            <div class="relative flex items-start mb-8">
                                <div class="absolute left-0 w-16 h-16 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center
                                        {{ $order->created_at ? 'bg-emerald-500 text-white' : 'bg-gray-300 text-gray-500' }}">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-24 flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg">Order Placed</h4>
                                    <p class="text-gray-600 mt-1">
                                        {{ $order->created_at->format('M d, Y • h:i A') }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-2">Your order has been received and is being processed.</p>
                                </div>
                            </div>

                            <!-- Step 2: Processing -->
                            <div class="relative flex items-start mb-8">
                                <div class="absolute left-0 w-16 h-16 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center
                                        {{ in_array($order->order_status, ['processing', 'shipped', 'delivered']) ? 'bg-emerald-500 text-white' : 'bg-gray-300 text-gray-500' }}">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-24 flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg">Processing</h4>
                                    @if($order->order_status !== 'pending')
                                        <p class="text-gray-600 mt-1">
                                            {{ $order->updated_at->format('M d, Y • h:i A') }}
                                        </p>
                                    @endif
                                    <p class="text-sm text-gray-500 mt-2">Your order is being prepared for shipment.</p>
                                </div>
                            </div>

                            <!-- Step 3: Shipped -->
                            <div class="relative flex items-start mb-8">
                                <div class="absolute left-0 w-16 h-16 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center
                                        {{ in_array($order->order_status, ['shipped', 'delivered']) ? 'bg-emerald-500 text-white' : 'bg-gray-300 text-gray-500' }}">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-24 flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg">Shipped</h4>
                                    @if($order->shipped_at)
                                        <p class="text-gray-600 mt-1">
                                            {{ $order->shipped_at->format('M d, Y • h:i A') }}
                                        </p>
                                    @endif
                                    <p class="text-sm text-gray-500 mt-2">Your order is on its way to you!</p>
                                </div>
                            </div>

                            <!-- Step 4: Delivered -->
                            <div class="relative flex items-start">
                                <div class="absolute left-0 w-16 h-16 flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center
                                        {{ $order->order_status === 'delivered' ? 'bg-emerald-500 text-white' : 'bg-gray-300 text-gray-500' }}">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-24 flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg">Delivered</h4>
                                    @if($order->delivered_at)
                                        <p class="text-gray-600 mt-1">
                                            {{ $order->delivered_at->format('M d, Y • h:i A') }}
                                        </p>
                                    @endif
                                    <p class="text-sm text-gray-500 mt-2">Your order has been delivered. Enjoy!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items & Shipping Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Order Items -->
                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">📦 Order Items</h3>
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                                    @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         class="w-16 h-16 object-cover rounded-lg" alt="{{ $item->product_name }}">
                                    @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-rose-100 to-pink-100 rounded-lg flex items-center justify-center">
                                        <span class="text-2xl">🌸</span>
                                    </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × ₱{{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <p class="font-bold text-gray-900">₱{{ number_format($item->subtotal, 2) }}</p>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex justify-between items-center text-lg font-bold">
                                    <span>Total</span>
                                    <span class="text-rose-600 text-xl">₱{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Info -->
                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">📍 Shipping Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">👤 Recipient</p>
                                    <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">📧 Email</p>
                                    <p class="font-semibold text-gray-900">{{ $order->customer_email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">📱 Phone</p>
                                    <p class="font-semibold text-gray-900">{{ $order->customer_phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">🏠 Address</p>
                                    <p class="font-semibold text-gray-900">{{ $order->shipping_address }}</p>
                                    <p class="font-semibold text-gray-900">{{ $order->city }}, {{ $order->zip_code }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">💳 Payment Method</p>
                                    <p class="font-semibold text-gray-900">
                                        @if($order->payment_method === 'cod')
                                            💵 Cash on Delivery (COD)
                                        @else
                                            📱 GCash
                                        @endif
                                    </p>
                                </div>
                                @if($order->notes)
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">📝 Notes</p>
                                    <p class="font-semibold text-gray-900">{{ $order->notes }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: QR Code Card (1/4 width - Sticky) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center">📱 Quick Track</h3>
                        <p class="text-sm text-gray-500 mb-6 text-center">Scan to open this page on any device</p>
                        
                        <!-- QR Code -->
                        <div class="bg-gradient-to-br from-rose-50 to-pink-50 p-4 rounded-2xl flex justify-center mb-6">
                            <div class="bg-white p-4 rounded-xl shadow-lg border-4 border-rose-100">
                                {!! $qrCode !!}
                            </div>
                        </div>
                        
                        <!-- Tracking URL -->
                        <div class="p-4 bg-rose-50 rounded-xl mb-6">
                            <p class="text-xs text-gray-500 mb-2 text-center">Tracking Link:</p>
                            <a href="{{ $qrCodeUrl }}" target="_blank" 
                               class="text-sm text-rose-600 font-semibold hover:text-rose-700 break-all text-center block">
                                {{ Str::limit($qrCodeUrl, 30) }}
                            </a>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <a href="{{ $qrCodeUrl }}" target="_blank" 
                               class="btn-premium w-full justify-center text-sm">
                                🔗 Open in New Tab
                            </a>
                            <button onclick="navigator.clipboard.writeText('{{ $qrCodeUrl }}')" 
                                    class="w-full px-4 py-3 bg-white border-2 border-rose-200 text-rose-600 font-semibold rounded-xl hover:bg-rose-50 transition text-sm">
                                📋 Copy Link
                            </button>
                            <a href="{{ route('customer.orders.index') }}" 
                               class="block w-full px-4 py-3 text-center bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition text-sm">
                                ← All Orders
                            </a>
                        </div>
                        
                        <!-- Help Text -->
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <p class="text-xs text-gray-400 text-center">
                                💡 Tip: Share this QR code with anyone who needs to track this order!
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Action Buttons (Mobile Only) -->
            <div class="lg:hidden flex gap-4">
                @if($order->canBeCancelled())
                <button class="flex-1 bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-semibold transition">
                    ❌ Cancel Order
                </button>
                @endif
                <a href="{{ route('customer.orders.index') }}" class="flex-1 bg-gradient-to-r from-rose-500 to-pink-600 text-white text-center py-3 rounded-xl font-semibold hover:shadow-lg transition">
                    View All Orders
                </a>
            </div>

        </div>
    </div>

    <!-- Copy Link Toast Notification -->
    <div id="copyToast" class="fixed bottom-6 right-6 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-2xl transform translate-y-20 opacity-0 transition-all duration-300 z-50">
        ✅ Link copied to clipboard!
    </div>

    <script>
        // Copy link functionality
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById('copyToast');
                toast.classList.remove('translate-y-20', 'opacity-0');
                setTimeout(() => {
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3000);
            });
        }
    </script>
</x-app-layout>