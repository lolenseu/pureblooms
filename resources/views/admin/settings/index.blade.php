<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">
            ⚙️ Settings
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl">
                    <p class="font-medium">✅ {{ session('success') }}</p>
                </div>
            @endif

            <!-- General Settings -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-8 mb-8 border border-white/20">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b">🏪 General Settings</h3>
                
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Shop Name *</label>
                            <input type="text" name="shop_name" value="{{ old('shop_name', $settings['shop_name']) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 border px-4 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="shop_email" value="{{ old('shop_email', $settings['shop_email']) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 border px-4 py-2" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="text" name="shop_phone" value="{{ old('shop_phone', $settings['shop_phone']) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 border px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                            <select name="currency" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 border px-4 py-2">
                                <option value="PHP" {{ $settings['currency'] === 'PHP' ? 'selected' : '' }}>₱ PHP (Philippine Peso)</option>
                                <option value="USD" {{ $settings['currency'] === 'USD' ? 'selected' : '' }}>$ USD (US Dollar)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Shop Address</label>
                        <textarea name="shop_address" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 border px-4 py-2">{{ old('shop_address', $settings['shop_address']) }}</textarea>
                    </div>

                    <div class="pt-4 border-t">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Payment Methods</h4>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="cod_enabled" value="1" {{ $settings['cod_enabled'] ? 'checked' : '' }} class="rounded text-cyan-600 focus:ring-cyan-500 h-5 w-5">
                                <span class="ml-3 text-gray-700">Cash on Delivery (COD)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="gcash_enabled" value="1" {{ $settings['gcash_enabled'] ? 'checked' : '' }} class="rounded text-cyan-600 focus:ring-cyan-500 h-5 w-5">
                                <span class="ml-3 text-gray-700">GCash</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">System Settings</h4>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="maintenance_mode" value="1" {{ $settings['maintenance_mode'] ? 'checked' : '' }} class="rounded text-cyan-600 focus:ring-cyan-500 h-5 w-5">
                                <span class="ml-3 text-gray-700">Maintenance Mode</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="allow_registration" value="1" {{ $settings['allow_registration'] ? 'checked' : '' }} class="rounded text-cyan-600 focus:ring-cyan-500 h-5 w-5">
                                <span class="ml-3 text-gray-700">Allow User Registration</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6">
                        <button type="submit" class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition">💾 Save Settings</button>
                    </div>
                </form>
            </div>

            <!-- Logo Upload -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-8 border border-white/20">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b">🎨 Shop Logo</h3>
                
                <form action="{{ route('admin.settings.update-logo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        @if($settings['logo_path'] && Storage::exists('public/' . $settings['logo_path']))
                            <div class="mb-4">
                                <img src="{{ Storage::url($settings['logo_path']) }}" alt="Current Logo" class="h-20 w-auto">
                            </div>
                        @endif
                        
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Logo</label>
                        <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100" required>
                        <p class="mt-1 text-xs text-gray-500">PNG, JPG up to 2MB</p>
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-6 py-2 rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition">📤 Upload Logo</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>