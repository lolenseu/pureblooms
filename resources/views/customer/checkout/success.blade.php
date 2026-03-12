<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
            🎉 Order Successful!
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto">
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Success Header -->
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-8 text-center text-white">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Thank You for Your Order!</h1>
                    <p class="text-emerald-100">Your order has been placed successfully</p>
                </div>

                <div class="p-8">
                    <!-- Order Info -->
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Order Number</p>
                            <p class="text-xl font-bold text-gray-900">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Order Date</p>
                            <p class="text-xl font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Order Details</h3>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × ₱{{ number_format($item->price, 2) }}</p>
                                </div>
                                <p class="font-bold text-gray-900">₱{{ number_format($item->subtotal, 2) }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <div class="flex justify-between items-center text-xl font-bold">
                            <span>Total Amount</span>
                            <span class="text-rose-600">₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">📦 Shipping Information</h3>
                        <div class="space-y-2 text-gray-700">
                            <p><span class="font-semibold">Name:</span> {{ $order->customer_name }}</p>
                            <p><span class="font-semibold">Email:</span> {{ $order->customer_email }}</p>
                            <p><span class="font-semibold">Phone:</span> {{ $order->customer_phone }}</p>
                            <p><span class="font-semibold">Address:</span> {{ $order->shipping_address }}, {{ $order->city }} {{ $order->postal_code }}</p>
                            <p><span class="font-semibold">Payment:</span> {{ strtoupper($order->payment_method) }}</p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-semibold text-amber-900">Order Status: <span class="uppercase">{{ $order->order_status }}</span></p>
                                <p class="text-sm text-amber-700">We'll notify you when your order is processed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4">
                        <a href="{{ route('customer.profile.show') }}" class="flex-1 bg-gradient-to-r from-rose-500 to-pink-600 text-white text-center py-3 rounded-xl font-semibold hover:shadow-lg transition">
                            View All Orders
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="flex-1 bg-white border-2 border-gray-300 text-gray-700 text-center py-3 rounded-xl font-semibold hover:bg-gray-50 transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>