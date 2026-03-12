<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gradient bg-gradient-to-r from-rose-600 to-purple-600 bg-clip-text text-transparent">
                🌸 Welcome back, {{ Auth::user()->name }}!
            </h2>
            <a href="{{ route('customer.cart.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Cart</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Special Offer Banner -->
            <div class="bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 rounded-3xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <h3 class="text-3xl font-bold mb-3">🎉 Special Offer!</h3>
                    <p class="text-white/90 mb-4">Get 15% off on your first order! Use code: <span class="bg-white/20 px-3 py-1 rounded-full font-bold">FIRST15</span></p>
                    <button class="bg-white text-rose-600 px-6 py-3 rounded-xl font-bold hover:bg-white/90 transition shadow-lg">
                        Shop Now →
                    </button>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Orders</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalOrders ?? 0 }}</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Pending</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $pendingOrders ?? 0 }}</p>
                        </div>
                        <div class="bg-amber-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Available Products</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $productsCount ?? 0 }}</p>
                        </div>
                        <div class="bg-emerald-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Spent</p>
                            <p class="text-3xl font-bold text-gray-900">₱{{ number_format($totalSpent ?? 0, 2) }}</p>
                        </div>
                        <div class="bg-rose-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">⚡ Quick Actions</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('customer.profile.show') }}" class="group flex flex-col items-center p-6 bg-gray-50 rounded-xl hover:bg-rose-50 transition-all duration-300">
                        <div class="bg-rose-100 p-4 rounded-2xl mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-900">My Profile</p>
                        <p class="text-sm text-gray-500">View & edit</p>
                    </a>

                    <a href="{{ route('customer.cart.index') }}" class="group flex flex-col items-center p-6 bg-gray-50 rounded-xl hover:bg-rose-50 transition-all duration-300">
                        <div class="bg-rose-100 p-4 rounded-2xl mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-900">My Cart</p>
                        <p class="text-sm text-gray-500">{{ session('cart') ? count(session('cart')) : 0 }} items</p>
                    </a>

                    <a href="{{ route('customer.orders.index') }}" class="group flex flex-col items-center p-6 bg-gray-50 rounded-xl hover:bg-rose-50 transition-all duration-300">
                        <div class="bg-purple-100 p-4 rounded-2xl mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-900">My Orders</p>
                        <p class="text-sm text-gray-500">Track orders</p>
                    </a>

                    <a href="{{ route('customer.dashboard') }}" class="group flex flex-col items-center p-6 bg-gray-50 rounded-xl hover:bg-rose-50 transition-all duration-300">
                        <div class="bg-emerald-100 p-4 rounded-2xl mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-900">Browse</p>
                        <p class="text-sm text-gray-500">Shop now</p>
                    </a>
                </div>
            </div>

            <!-- Available Flowers Section -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-rose-500 to-pink-600 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-bold text-white">🌺 Available Flowers</h3>
                        <a href="#" class="text-white hover:text-rose-100 font-semibold">View All →</a>
                    </div>
                </div>

                <div class="p-6">
                    @if(isset($products) && $products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                        <div class="group bg-white rounded-2xl border-2 border-gray-100 hover:border-rose-300 hover:shadow-2xl transition-all duration-300 overflow-hidden"
                             data-product-id="{{ $product->id }}"
                             data-product-name="{{ $product->name }}"
                             data-product-price="{{ $product->price }}">
                            
                            <!-- Product Image -->
                            <div class="relative overflow-hidden bg-gray-50">
                                @if($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" 
                                     class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300" 
                                     alt="{{ $product->name }}">
                                @else
                                <div class="w-full h-64 bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                    <span class="text-6xl">🌸</span>
                                </div>
                                @endif
                                
                                <!-- Stock Badge -->
                                <div class="absolute top-3 right-3">
                                    @if($product->stock_quantity > 0)
                                    <span class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full">
                                        ✓ In Stock
                                    </span>
                                    @else
                                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full">
                                        ✗ Out of Stock
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-5">
                                <div class="mb-3">
                                    <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $product->name }}</h4>
                                    @if($product->category)
                                    <p class="text-sm text-gray-500">📂 {{ $product->category->name }}</p>
                                    @endif
                                </div>

                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-rose-600">₱{{ number_format($product->price, 2) }}</span>
                                    <span class="text-xs text-gray-500">{{ $product->stock_quantity }} available</span>
                                </div>

                                <!-- Action Buttons -->
                                @if($product->stock_quantity > 0)
                                <div class="space-y-2">
                                    <!-- Add to Cart Button -->
                                    <form action="{{ route('customer.cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full bg-gradient-to-r from-rose-500 to-pink-600 text-white py-3 rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                                            <span>🛒</span>
                                            <span>Add to Cart</span>
                                        </button>
                                    </form>

                                    <!-- Buy Now Button -->
                                    <button type="button" 
                                            class="buy-now-btn w-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white py-3 rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-price="{{ $product->price }}">
                                        <span>⚡</span>
                                        <span>Buy Now</span>
                                    </button>
                                </div>
                                @else
                                <button disabled 
                                        class="w-full bg-gray-300 text-gray-500 py-3 rounded-xl font-bold cursor-not-allowed">
                                    Out of Stock
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gradient-to-br from-rose-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <p class="text-gray-500 font-semibold text-lg">No products available yet</p>
                        <p class="text-gray-400 text-sm mt-1">Check back soon for beautiful flowers!</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Buy Now with Addons Modal -->
    <div id="buyNowModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4 rounded-t-3xl">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-white">⚡ Buy Now - Add Addons</h3>
                    <button type="button" onclick="closeBuyNowModal()" class="text-white hover:bg-white/20 p-2 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Product Info -->
                <div id="modalProductInfo" class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-1">Selected Product:</p>
                    <p id="modalProductName" class="font-bold text-gray-900 text-lg"></p>
                    <p id="modalProductPrice" class="text-purple-600 font-bold"></p>
                </div>

                <!-- Addons Selection Form -->
                <form id="buyNowForm" method="POST">
                    @csrf
                    
                    <!-- Hidden inputs -->
                    <input type="hidden" name="products" id="hiddenProductData" value="">

                    <h4 class="font-bold text-gray-900 mb-4">🎁 Choose Addons (Optional)</h4>
                    
                    <!-- ✅ DYNAMIC ADDONS FROM DATABASE -->
                    <div class="space-y-3 mb-6">
                        @forelse($addons as $addon)
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 transition">
                            <input type="checkbox" 
                                   name="addons[{{ $addon->slug }}]" 
                                   value="{{ $addon->price }}" 
                                   data-addon-name="{{ $addon->name }}"
                                   class="addon-checkbox w-5 h-5 text-purple-600 rounded">
                            <div class="ml-4 flex-1">
                                <p class="font-bold text-gray-900">{{ $addon->name }}</p>
                                <p class="text-sm text-gray-600">{{ $addon->description ?? 'Addon item' }}</p>
                            </div>
                            <span class="font-bold text-purple-600">+₱{{ number_format($addon->price, 2) }}</span>
                        </label>
                        @empty
                        <p class="text-gray-500 text-center py-4">No addons available at the moment</p>
                        @endforelse
                    </div>

                    <!-- Total Calculation -->
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-700">Product Price:</span>
                            <span id="modalBasePrice" class="font-bold">₱0.00</span>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="font-bold text-gray-700">Addons Total:</span>
                            <span id="modalAddonsTotal" class="font-bold text-purple-600">₱0.00</span>
                        </div>
                        <div class="border-t-2 border-purple-200 mt-3 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-900">Total:</span>
                                <span id="modalTotalPrice" class="text-2xl font-bold text-purple-600">₱0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button type="button" onclick="closeBuyNowModal()" 
                                class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition">
                            Cancel
                        </button>
                        <button type="button" onclick="proceedWithoutAddons()" 
                                class="flex-1 px-6 py-3 bg-gray-500 text-white rounded-xl font-bold hover:bg-gray-600 transition">
                            No Addons
                        </button>
                        <button type="button" onclick="proceedToCheckout()" 
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl font-bold hover:shadow-lg transition">
                            Proceed to Checkout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Buy Now Modal -->
    <script>
// Global variables
var currentProduct = null;
var currentPrice = 0;

// Open Buy Now Modal
function openBuyNowModal(productId, productName, productPrice) {
    var parsedPrice = parseFloat(productPrice);
    currentPrice = isNaN(parsedPrice) ? 0 : parsedPrice;
    currentProduct = productId;
    
    document.getElementById('modalProductName').textContent = productName;
    document.getElementById('modalProductPrice').textContent = '₱' + currentPrice.toFixed(2);
    document.getElementById('modalBasePrice').textContent = '₱' + currentPrice.toFixed(2);
    
    var productData = [{
        id: parseInt(productId),
        quantity: 1,
        name: productName,
        price: currentPrice
    }];
    
    document.getElementById('hiddenProductData').value = JSON.stringify(productData);
    
    var checkboxes = document.querySelectorAll('.addon-checkbox');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }
    
    document.getElementById('modalAddonsTotal').textContent = '₱0.00';
    document.getElementById('modalTotalPrice').textContent = '₱' + currentPrice.toFixed(2);
    
    var modal = document.getElementById('buyNowModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// Close Buy Now Modal
function closeBuyNowModal() {
    var modal = document.getElementById('buyNowModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    currentProduct = null;
    currentPrice = 0;
}

// Update total price with addons
function updateTotal() {
    var addonsTotal = 0;
    var checkboxes = document.querySelectorAll('.addon-checkbox:checked');
    
    for (var i = 0; i < checkboxes.length; i++) {
        var value = parseFloat(checkboxes[i].value);
        if (!isNaN(value)) {
            addonsTotal += value;
        }
    }
    
    var safePrice = isNaN(currentPrice) ? 0 : currentPrice;
    var total = safePrice + addonsTotal;
    
    document.getElementById('modalAddonsTotal').textContent = '₱' + addonsTotal.toFixed(2);
    document.getElementById('modalTotalPrice').textContent = '₱' + total.toFixed(2);
}

// ✅ FIXED: Proceed to Checkout - Redirect to checkout PAGE first
function proceedToCheckout() {
    // Get selected addons
    var checkboxes = document.querySelectorAll('.addon-checkbox:checked');
    var selectedAddons = {};
    
    for (var i = 0; i < checkboxes.length; i++) {
        var name = checkboxes[i].name.replace('addons[', '').replace(']', '');
        selectedAddons[name] = parseFloat(checkboxes[i].value);
    }
    
    // Get product data
    var productData = JSON.parse(document.getElementById('hiddenProductData').value);
    
    // Calculate totals
    var addonsTotal = Object.values(selectedAddons).reduce(function(a, b) { return a + b; }, 0);
    var total = currentPrice + addonsTotal;
    
    // Prepare Buy Now data object
    var buyNowData = {
        products: productData,
        addons: selectedAddons,
        addons_total: addonsTotal,
        total: total,
        timestamp: Date.now()
    };
    
    // ✅ Store in localStorage (persists across page redirect)
    localStorage.setItem('buy_now_data', JSON.stringify(buyNowData));
    
    // ✅ Redirect to checkout PAGE (GET request) - NOT direct submit!
    window.location.href = "{{ route('customer.checkout.index') }}?buy_now=1";
}

// Proceed without addons
function proceedWithoutAddons() {
    var checkboxes = document.querySelectorAll('.addon-checkbox');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }
    updateTotal();
    proceedToCheckout();
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    
    // Event delegation for Buy Now buttons
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('buy-now-btn')) {
            var btn = e.target;
            var productId = btn.getAttribute('data-product-id');
            var productName = btn.getAttribute('data-product-name');
            var productPrice = btn.getAttribute('data-product-price');
            
            openBuyNowModal(productId, productName, productPrice);
        }
    });
    
    // Event delegation for addon checkboxes
    var form = document.getElementById('buyNowForm');
    if (form) {
        form.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('addon-checkbox')) {
                updateTotal();
            }
        });
    }
    
    // Close modal on outside click
    var modal = document.getElementById('buyNowModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeBuyNowModal();
            }
        });
    }
});
</script>
</x-app-layout>