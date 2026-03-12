<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">🎁 Manage Addons</h2>
            <a href="{{ route('admin.addons.create') }}" 
               class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:shadow-lg transition">
                ➕ Add New Addon
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-xl">
                <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Revenue Stats -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Addon Revenue Stats</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-6">
                        <p class="text-sm text-gray-600">Total Addon Revenue</p>
                        <p class="text-3xl font-bold text-purple-600">₱{{ number_format($totalRevenue, 2) }}</p>
                    </div>
                    <div class="bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-6">
                        <p class="text-sm text-gray-600">Active Addons</p>
                        <p class="text-3xl font-bold text-pink-600">{{ $addons->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6">
                        <p class="text-sm text-gray-600">Total Addons</p>
                        <p class="text-3xl font-bold text-amber-600">{{ $addons->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Addons Table -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">🎁 Addons List</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Price</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Order</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($addons as $addon)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $addon->name }}</p>
                                        <p class="text-sm text-gray-500">{{ Str::limit($addon->description, 50) }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-lg font-bold text-purple-600">₱{{ number_format($addon->price, 2) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($addon->is_active)
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                                            ✓ Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold">
                                            ✗ Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-600">{{ $addon->sort_order }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.addons.edit', $addon) }}" 
                                           class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.addons.toggle-status', $addon) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="px-4 py-2 {{ $addon->is_active ? 'bg-amber-500' : 'bg-emerald-500' }} text-white rounded-lg text-sm font-semibold hover:opacity-90 transition">
                                                {{ $addon->is_active ? '🔴 Deactivate' : '🟢 Activate' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.addons.destroy', $addon) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this addon?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600 transition">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <p class="text-lg">No addons found</p>
                                    <p class="text-sm">Click "Add New Addon" to create one</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>