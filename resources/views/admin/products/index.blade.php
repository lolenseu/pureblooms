<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                🌺 Product Management
            </h2>
            <a href="{{ route('admin.products.create') }}" 
               class="btn-premium px-6 py-3 flex items-center gap-2">
                <span>✨</span>
                <span>Add New Flower</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <!-- Messages -->
            @if(session('success'))
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif
            @if(session('error'))
            <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">⚠️</span>
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Filters Form -->
            <div class="card-glass">
                <form action="{{ route('admin.products.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">🔍 Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by name or description..." 
                                   class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">📂 Category</label>
                            <select name="category" class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">📦 Stock</label>
                            <select name="stock" class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none">
                                <option value="">All Stock</option>
                                <option value="in" {{ request('stock') === 'in' ? 'selected' : '' }}>In Stock</option>
                                <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock (≤5)</option>
                                <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">📊 Sort By</label>
                            <select name="sort" class="w-full px-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none">
                                <option value="">Default</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low→High</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High→Low</option>
                                <option value="stock_asc" {{ request('sort') === 'stock_asc' ? 'selected' : '' }}>Stock: Low→High</option>
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 mt-4">
                        <button type="submit" class="btn-premium px-6 py-3">🔍 Apply Filters</button>
                        <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-white border-2 border-rose-200 text-rose-600 font-semibold rounded-xl hover:bg-rose-50 transition">🔄 Reset</a>
                    </div>
                </form>
            </div>

            <!-- Active Filters -->
            @if(request('search') || request('category') || request('stock') || request('sort'))
            <div class="bg-rose-50 rounded-xl p-4 flex flex-wrap items-center gap-3">
                <span class="text-sm font-semibold text-rose-600">Active Filters:</span>
                @if(request('search'))
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full text-sm text-gray-700">
                    🔍 "{{ request('search') }}"
                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-rose-500 hover:text-rose-700 font-bold">✕</a>
                </span>
                @endif
                @if(request('category'))
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full text-sm text-gray-700">
                    📂 {{ $categories->find(request('category'))?->name }}
                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="text-rose-500 hover:text-rose-700 font-bold">✕</a>
                </span>
                @endif
                @if(request('stock'))
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full text-sm text-gray-700">
                    📦 {{ request('stock') === 'in' ? 'In Stock' : (request('stock') === 'low' ? 'Low Stock' : 'Out of Stock') }}
                    <a href="{{ request()->fullUrlWithQuery(['stock' => null]) }}" class="text-rose-500 hover:text-rose-700 font-bold">✕</a>
                </span>
                @endif
                @if(request('sort'))
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full text-sm text-gray-700">
                    📊 {{ request('sort') === 'name_asc' ? 'Name A-Z' : (request('sort') === 'price_asc' ? 'Price Low→High' : 'Sorted') }}
                    <a href="{{ request()->fullUrlWithQuery(['sort' => null]) }}" class="text-rose-500 hover:text-rose-700 font-bold">✕</a>
                </span>
                @endif
                <a href="{{ route('admin.products.index') }}" class="text-sm text-rose-600 font-semibold hover:text-rose-700 ml-auto">Clear All</a>
            </div>
            @endif

            <!-- Products Table -->
            <div class="card-glass">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">
                            @if(request('search')) 🔍 Results for "{{ request('search') }}"
                            @elseif(request('category')) 📂 {{ $categories->find(request('category'))?->name }}
                            @else 🌺 Flowers Inventory @endif
                        </h3>
                        <p class="text-sm text-gray-500">{{ $products->total() }} products found</p>
                    </div>
                    
                    @if($products->count() > 0)
                    <!-- ✅ FIXED: Bulk Delete Form with proper array inputs -->
                    <form action="{{ route('admin.products.bulk-delete') }}" method="POST" id="bulkDeleteForm">
                        @csrf
                        @method('DELETE')
                        <!-- Hidden inputs will be added by JS for proper array submission -->
                    </form>
                    <button type="button" onclick="confirmBulkDelete()" 
                            class="px-4 py-2 bg-red-50 text-red-600 border-2 border-red-200 rounded-xl hover:bg-red-100 transition text-sm font-semibold">
                        🗑️ Delete Selected
                    </button>
                    @endif
                </div>

                @if($products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-rose-50 to-pink-50">
                            <tr>
                                <th class="px-4 py-4 text-left">
                                    <input type="checkbox" id="selectAll" class="w-4 h-4 text-rose-600 border-rose-300 rounded focus:ring-rose-500">
                                </th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Image</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stock</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($products as $product)
                            <tr class="hover:bg-rose-50/50 transition group">
                                <td class="px-4 py-4">
                                    <input type="checkbox" name="products[]" value="{{ $product->id }}" 
                                           class="product-checkbox w-4 h-4 text-rose-600 border-rose-300 rounded focus:ring-rose-500">
                                </td>
                                <td class="px-4 py-4">
                                    @if($product->image_path)
                                    <img src="{{ Storage::url($product->image_path) }}" class="w-14 h-14 object-cover rounded-xl shadow-sm group-hover:shadow-md transition" alt="{{ $product->name }}">
                                    @else
                                    <div class="w-14 h-14 bg-gradient-to-br from-rose-100 to-pink-100 rounded-xl flex items-center justify-center">
                                        <span class="text-2xl">🌸</span>
                                    </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-bold text-gray-900">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500 line-clamp-1">{{ Str::limit($product->description, 40) }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">{{ $product->category->name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="font-bold text-rose-600">₱{{ number_format($product->price, 2) }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $product->stock_quantity == 0 ? 'bg-red-100 text-red-700' : ($product->stock_quantity <= 5 ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700') }}">
                                        {{ $product->stock_quantity == 0 ? '✗ Out' : ($product->stock_quantity <= 5 ? '⚠️ Low' : '✓ ' . $product->stock_quantity) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ ($product->is_active ?? true) ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ ($product->is_active ?? true) ? '🟢 Active' : '⚪ Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">✏️</a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete \'{{ $product->name }}\'?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">{{ $products->links() }}</div>
                @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gradient-to-br from-rose-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-5xl">🌸</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Products Found</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">{{ request('search') || request('category') || request('stock') ? 'Try adjusting your filters or search terms.' : 'Start by adding your first beautiful flower to the inventory!' }}</p>
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-white border-2 border-rose-200 text-rose-600 font-semibold rounded-xl hover:bg-rose-50 transition">🔄 Clear Filters</a>
                        <a href="{{ route('admin.products.create') }}" class="btn-premium px-6 py-3">✨ Add First Product</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ✅ FIXED: Bulk Delete Modal with proper JS -->
    <div id="bulkDeleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">⚠️</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Selected Products?</h3>
                <p class="text-gray-500 mb-6">This action cannot be undone.</p>
                <div class="flex gap-3 justify-center">
                    <button onclick="closeBulkDeleteModal()" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-semibold">Cancel</button>
                    <button onclick="submitBulkDelete()" class="px-6 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition font-semibold">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ FIXED: JavaScript for proper array submission -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select All
        document.getElementById('selectAll')?.addEventListener('change', function() {
            document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = this.checked);
        });

        // Bulk Delete
        window.confirmBulkDelete = function() {
            const checked = document.querySelectorAll('.product-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select at least one product to delete.');
                return;
            }
            
            // ✅ FIXED: Create hidden inputs for proper array submission
            const form = document.getElementById('bulkDeleteForm');
            // Remove old hidden inputs
            form.querySelectorAll('input[name="products[]"]').forEach(el => el.remove());
            
            // Add new hidden inputs for each selected product
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'products[]';  // ✅ Array notation
                input.value = cb.value;
                form.appendChild(input);
            });
            
            // Show modal
            const modal = document.getElementById('bulkDeleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        };

        window.closeBulkDeleteModal = function() {
            const modal = document.getElementById('bulkDeleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        window.submitBulkDelete = function() {
            document.getElementById('bulkDeleteForm').submit();
        };

        // Close modal on outside click
        document.getElementById('bulkDeleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeBulkDeleteModal();
        });
    });
    </script>
</x-app-layout>