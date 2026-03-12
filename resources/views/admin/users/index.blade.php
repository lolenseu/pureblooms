<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                👥 User Management
            </h2>
            <p class="text-sm font-medium text-gray-600 bg-white px-4 py-2 rounded-full shadow-sm">
                {{ $users->total() }} total customers
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 border border-white/20 text-center hover:shadow-xl transition">
                    <p class="text-3xl font-bold text-gray-900">{{ $totalCustomers ?? 0 }}</p>
                    <p class="text-xs text-gray-600 font-medium">Total Customers</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 border border-white/20 text-center hover:shadow-xl transition">
                    <p class="text-3xl font-bold text-emerald-600">{{ $activeCustomers ?? 0 }}</p>
                    <p class="text-xs text-gray-600 font-medium">Active</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 border border-white/20 text-center hover:shadow-xl transition">
                    <p class="text-3xl font-bold text-red-600">{{ $inactiveCustomers ?? 0 }}</p>
                    <p class="text-xs text-gray-600 font-medium">Inactive</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 border border-white/20 text-center hover:shadow-xl transition">
                    <p class="text-3xl font-bold text-purple-600">{{ $customersWithOrders ?? 0 }}</p>
                    <p class="text-xs text-gray-600 font-medium">With Orders</p>
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 mb-6 border border-white/20">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or Email..." class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 border px-4 py-2">
                    </div>
                    <div class="min-w-[150px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 border px-4 py-2">
                            <option value="">All</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-gradient-to-r from-rose-500 to-pink-600 text-white px-6 py-2 rounded-xl font-medium hover:shadow-lg hover:scale-105 transition">🔍 Filter</button>
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium hover:bg-gray-300 transition">Clear</a>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/20">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-rose-500 to-pink-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Orders</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Joined</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($users as $user)
                            <tr class="hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $user->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->phone ?? 'No phone' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">{{ $user->orders()->count() }} orders</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->is_active ? '✓ Active' : '✗ Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="text-rose-600 hover:text-rose-900 mr-3 hover:underline">View</a>
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-purple-600 hover:text-purple-900 hover:underline">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="bg-gradient-to-br from-rose-100 to-pink-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                        <svg class="h-10 w-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium text-lg">No customers found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">{{ $users->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>