<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛒 Shopping Cart
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl">
                    <p class="font-medium">✅ {{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl">
                    <p class="font-medium">❌ {{ session('error') }}</p>
                </div>
            @endif

            @if(count($cart) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Cart Items ({{ count($cart) }})</h3>
                                
                                <div class="space-y-4">
                                    @foreach($cart as $id => $item)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                        <div class="flex items-center gap-4">
                                            @if($item['image'])
                                                <img src="{{ Storage::url($item['image']) }}" 
                                                     class="w-20 h-20 object-cover rounded-lg" 
                                                     alt="{{ $item['name'] }}">
                                            @else
                                                <div class="w-20 h-20 bg-gradient-to-br from-rose-100 to-pink-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $item['name'] }}</p>
                                                <p class="text-sm text-gray-600">₱{{ number_format($item['price'], 2) }} each</p>
                                                <p class="text-xs text-gray-500 mt-1">Stock: {{ $item['stock'] }} available</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-4">
                                            <!-- Quantity -->
                                            <form action="{{ route('customer.cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" 
                                                       name="quantity" 
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1" 
                                                       max="{{ $item['stock'] }}"
                                                       class="w-16 border-gray-300 rounded-lg text-center" 
                                                       required>
                                                <button type="submit" class="text-blue-600 hover:text-blue-700">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <!-- Remove -->
                                            <form action="{{ route('customer.cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700" onclick="return confirm('Remove this item?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <!-- Subtotal -->
                                            <div class="text-right">
                                                <p class="font-bold text-lg text-gray-900">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <!-- Clear Cart -->
                                <div class="mt-6 pt-6 border-t">
                                    <form action="{{ route('customer.cart.clear') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium" onclick="return confirm('Clear entire cart?')">
                                            🗑️ Clear Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div>
                        <div class="bg-white overflow-hidden shadow-xl rounded-xl sticky top-6">
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h3>
                                
                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between text-gray-600">
                                        <span>Subtotal</span>
                                        <span>₱{{ number_format($total, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600">
                                        <span>Shipping</span>
                                        <span class="text-emerald-600">FREE</span>
                                    </div>
                                    <div class="border-t pt-3 flex justify-between font-bold text-lg">
                                        <span>Total</span>
                                        <span class="text-rose-600">₱{{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                                
                                <!-- Checkout Button -->
                                <a href="{{ route('customer.checkout.index') }}" class="block w-full bg-gradient-to-r from-rose-500 to-pink-600 text-white text-center py-3 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition">
    💳 Proceed to Checkout
</a>
                                
                                <!-- Continue Shopping -->
                                <a href="{{ route('customer.dashboard') }}" class="block w-full text-center py-3 text-gray-600 hover:text-gray-900 font-medium mt-3">
                                    ← Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                    <div class="p-12 text-center">
                        <div class="bg-gradient-to-br from-rose-100 to-pink-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
                        <p class="text-gray-600 mb-6">Looks like you haven't added any flowers yet!</p>
                        <a href="{{ route('customer.dashboard') }}" class="inline-block bg-gradient-to-r from-rose-500 to-pink-600 text-white px-8 py-3 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition">
                            🌸 Browse Flowers
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>