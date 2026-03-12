<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">➕ Create New Addon</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form action="{{ route('admin.addons.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Addon Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-purple-100 focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all outline-none @error('name') border-red-400 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Price (₱) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-purple-100 focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all outline-none @error('price') border-red-400 @enderror">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-3 rounded-xl border-2 border-purple-100 focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all outline-none">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Display Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                                class="w-full px-4 py-3 rounded-xl border-2 border-purple-100 focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all outline-none">
                            <p class="text-sm text-gray-500 mt-1">Lower numbers appear first</p>
                        </div>

                        <!-- Is Active -->
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-5 h-5 text-purple-600 rounded">
                            <label for="is_active" class="text-sm font-semibold text-gray-700">Active (show to customers)</label>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-purple-500 to-indigo-600 text-white py-4 rounded-xl font-bold hover:shadow-lg transition">
                            ✅ Create Addon
                        </button>
                        <a href="{{ route('admin.addons.index') }}" 
                            class="flex-1 bg-gray-200 text-gray-700 py-4 rounded-xl font-bold hover:bg-gray-300 transition text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>