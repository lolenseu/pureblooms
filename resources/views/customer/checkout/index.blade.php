<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
            💳 Checkout
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 mb-6 rounded-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">⚠️</span>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 mb-6 rounded-xl shadow-sm">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">⚠️</span>
                    <div>
                        <p class="text-red-700 font-medium">Please correct the following errors:</p>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Checkout Form -->
            <form action="{{ route('customer.checkout.store') }}" method="POST" id="checkoutForm">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Shipping Information -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">📦 Shipping Information</h3>
                        
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required
                                    class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none @error('customer_name') border-red-400 @enderror">
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email) }}" required
                                    class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none @error('customer_email') border-red-400 @enderror">
                                @error('customer_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone) }}" required
                                    class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none @error('customer_phone') border-red-400 @enderror"
                                    pattern="[0-9+\-\s()]{11,20}" placeholder="09XXXXXXXXX">
                                @error('customer_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Shipping Address <span class="text-red-500">*</span></label>
                                <textarea name="shipping_address" rows="3" required
                                    class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none @error('shipping_address') border-red-400 @enderror">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City & Postal Code -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">City <span class="text-red-500">*</span></label>
                                    <input type="text" name="city" value="{{ old('city') }}" required
                                        class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none @error('city') border-red-400 @enderror">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Postal Code <span class="text-red-500">*</span></label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                                        class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none @error('postal_code') border-red-400 @enderror">
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Notes -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Order Notes (Optional)</label>
                                <textarea name="notes" rows="2" placeholder="Special delivery instructions..."
                                    class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                   <!-- Order Summary & Payment -->
<div class="space-y-6">
    <!-- Cart Items -->
    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
        <h3 class="text-xl font-bold text-gray-900 mb-6">📋 Order Summary</h3>
        
        <div class="space-y-3 max-h-64 overflow-y-auto pr-2" id="orderSummaryItems">
            @if(isset($isBuyNow) && $isBuyNow)
                <!-- Buy Now items will be loaded via JavaScript -->
                <p class="text-gray-500 text-center py-4">Loading order items...</p>
            @elseif(isset($cart) && !empty($cart))
                <!-- Regular Cart Flow -->
                @foreach($cart as $item)
                <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">₱{{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}</p>
                        <p class="font-bold text-rose-600">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <p class="text-gray-500 text-center py-4">No items in order</p>
            @endif
        </div>
        
        <div class="mt-6 pt-4 border-t-2 border-rose-100">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-gray-700">Subtotal</span>
                <span class="text-lg font-semibold" id="subtotalAmount">₱{{ number_format($total, 2) }}</span>
            </div>
            <div class="flex justify-between items-center mt-2 text-sm text-gray-500">
                <span>Shipping</span>
                <span class="text-emerald-600 font-medium">FREE</span>
            </div>
            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                <span class="text-xl font-bold text-gray-900">Total</span>
                <span class="text-2xl font-bold text-rose-600" id="totalAmount">₱{{ number_format($total, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Method -->
    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
        <h3 class="text-xl font-bold text-gray-900 mb-6">💳 Payment Method</h3>
        
        <div class="space-y-3">
            <!-- COD Option -->
            <label class="flex items-start p-4 border-2 border-rose-500 rounded-xl cursor-pointer bg-rose-50/50 transition-all hover:shadow-md">
                <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-rose-600 mt-1 cursor-pointer">
                <div class="ml-4 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">💵</span>
                        <p class="font-bold text-gray-900">Cash on Delivery (COD)</p>
                    </div>
                    <p class="text-sm text-gray-600 mt-1 ml-7">Pay when you receive your order</p>
                </div>
            </label>
            
            <!-- GCash Option -->
            <label class="flex items-start p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-rose-300 transition-all hover:shadow-md">
                <input type="radio" name="payment_method" value="gcash" class="w-5 h-5 text-rose-600 mt-1 cursor-pointer">
                <div class="ml-4 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">📱</span>
                        <p class="font-bold text-gray-900">GCash</p>
                    </div>
                    <p class="text-sm text-gray-600 mt-1 ml-7">Pay via GCash mobile wallet</p>
                </div>
            </label>
        </div>
        
        @error('payment_method')
            <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Place Order Button -->
    <button type="submit" id="placeOrderBtn" 
        class="w-full bg-gradient-to-r from-rose-500 to-pink-600 text-white py-4 rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2 text-lg">
        <span>✅</span>
        <span id="placeOrderText">Place Order - ₱{{ number_format($total, 2) }}</span>
    </button>
    
    <a href="{{ route('customer.cart.index') }}" class="block text-center text-gray-600 hover:text-rose-600 font-medium transition py-2">
        ← Back to Cart
    </a>
</div>
                </div>
            </form>
        </div>
    </div>

   <!-- ✅ JavaScript to handle Buy Now data from localStorage -->
@if(isset($isBuyNow) && $isBuyNow)
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get Buy Now data from localStorage
    var buyNowData = localStorage.getItem('buy_now_data');
    
    if (buyNowData) {
        try {
            var data = JSON.parse(buyNowData);
            console.log('Buy Now Data loaded:', data);
            
            // Get the checkout form
            var form = document.getElementById('checkoutForm');
            if (!form) return;
            
            // Add hidden input for products (JSON string)
            var productsInput = document.createElement('input');
            productsInput.type = 'hidden';
            productsInput.name = 'products';
            productsInput.value = JSON.stringify(data.products);
            form.appendChild(productsInput);
            
            // Add hidden inputs for each addon
            for (var addon in data.addons) {
                var addonInput = document.createElement('input');
                addonInput.type = 'hidden';
                addonInput.name = 'addons[' + addon + ']';
                addonInput.value = data.addons[addon];
                form.appendChild(addonInput);
            }
            
            // ✅ Display order items in summary
            var itemsContainer = document.getElementById('orderSummaryItems');
            if (itemsContainer && data.products) {
                var html = '';
                
                // Display products
                data.products.forEach(function(product) {
                    html += '<div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">';
                    html += '<div class="flex-1">';
                    html += '<p class="font-semibold text-gray-900">' + product.name + '</p>';
                    html += '<p class="text-sm text-gray-500">Qty: ' + product.quantity + '</p>';
                    html += '</div>';
                    html += '<div class="text-right">';
                    html += '<p class="text-sm text-gray-500">₱' + parseFloat(product.price).toFixed(2) + ' × ' + product.quantity + '</p>';
                    html += '<p class="font-bold text-rose-600">₱' + (product.price * product.quantity).toFixed(2) + '</p>';
                    html += '</div>';
                    html += '</div>';
                });
                
                // Display addons if any
                if (data.addons && Object.keys(data.addons).length > 0) {
                    html += '<div class="py-3 border-b border-purple-200 bg-purple-50 rounded-lg px-3 mt-2">';
                    html += '<p class="text-sm font-semibold text-purple-700 mb-2">🎁 Selected Addons:</p>';
                    for (var addon in data.addons) {
                        var addonName = addon.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        html += '<div class="flex justify-between text-xs text-purple-600">';
                        html += '<span>' + addonName + '</span>';
                        html += '<span>+₱' + parseFloat(data.addons[addon]).toFixed(2) + '</span>';
                        html += '</div>';
                    }
                    html += '</div>';
                }
                
                itemsContainer.innerHTML = html;
            }
            
            // ✅ Update subtotal and total displays
            var subtotalAmount = document.getElementById('subtotalAmount');
            var totalAmount = document.getElementById('totalAmount');
            var placeOrderText = document.getElementById('placeOrderText');
            
            if (subtotalAmount) {
                subtotalAmount.textContent = '₱' + parseFloat(data.total).toFixed(2);
            }
            
            if (totalAmount) {
                totalAmount.textContent = '₱' + parseFloat(data.total).toFixed(2);
            }
            
            if (placeOrderText) {
                placeOrderText.textContent = 'Place Order - ₱' + parseFloat(data.total).toFixed(2);
            }
            
            // Clear localStorage after transferring
            localStorage.removeItem('buy_now_data');
            
            console.log('✅ Buy Now data added to checkout form');
            
        } catch (e) {
            console.error('Error parsing Buy Now data:', e);
            localStorage.removeItem('buy_now_data');
        }
    } else {
        console.log('No Buy Now data found in localStorage');
    }
});
</script>
@endif
</x-app-layout>