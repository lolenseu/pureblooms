<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg p-6 mb-6 text-white">
                <h3 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}! 🌸</h3>
                <p class="mt-2">Thank you for choosing PureBlooms Flower Shop</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ $totalOrders ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Orders</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ $pendingOrders ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shop Now -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-pink-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-pink-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Shop Now</dt>
                                    <dd class="text-lg font-semibold text-pink-600">
                                        <a href="#" class="hover:underline">Browse Flowers →</a>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- My Recent Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">My Recent Orders</h3>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View All →</a>
                        </div>
                        
                        @if(isset($myOrders) && $myOrders->count() > 0)
                            <div class="space-y-3">
                                @foreach($myOrders as $order)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">₱{{ number_format($order->total_amount, 2) }}</p>
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $order->order_status === 'delivered' ? 'bg-green-100 text-green-800' : 
                                               ($order->order_status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                               ($order->order_status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <p class="text-gray-500 mt-2">No orders yet.</p>
                                <a href="#" class="text-pink-600 hover:text-pink-800 text-sm">Start Shopping →</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Featured Products -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Featured Flowers</h3>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View All →</a>
                        </div>
                        
                        @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($featuredProducts as $product)
                                <div class="border rounded-lg overflow-hidden hover:shadow-md transition">
                                    @if($product->image_path)
                                        <img src="{{ Storage::url($product->image_path) }}" class="w-full h-32 object-cover" alt="{{ $product->name }}">
                                    @else
                                        <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        </div>
                                    @endif
                                    <div class="p-3">
                                        <p class="font-medium text-gray-900 text-sm truncate">{{ $product->name }}</p>
                                        <p class="text-pink-600 font-semibold">₱{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">No products available yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-pink-50 hover:bg-pink-100 rounded-lg transition">
                            <svg class="h-8 w-8 text-pink-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span class="text-sm font-medium text-pink-900">Shop Now</span>
                        </a>
                        
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition">
                            <svg class="h-8 w-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="text-sm font-medium text-purple-900">My Orders</span>
                        </a>
                        
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                            <svg class="h-8 w-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium text-blue-900">My Profile</span>
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition">
                            <svg class="h-8 w-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-sm font-medium text-green-900">Settings</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>