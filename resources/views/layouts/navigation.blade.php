@php
    // Determine if user is admin
    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
    
    // Set route prefixes based on role
    $dashboardRoute = $isAdmin ? 'admin.dashboard' : 'customer.dashboard';
    $ordersRoute = $isAdmin ? 'admin.orders.index' : 'customer.orders.index';
    $profileRoute = $isAdmin ? 'admin.dashboard' : 'customer.profile.show';
@endphp

<nav x-data="{ open: false, searchOpen: false }" class="bg-white/70 backdrop-blur-lg border-b border-rose-100/50 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            
            <!-- Logo & Search -->
            <div class="flex flex-1 items-center">
                <!-- Logo - Dynamic based on role -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-2">
                        <span class="text-2xl">{{ $isAdmin ? '👨‍💼' : '🌸' }}</span>
                        <span class="text-xl font-black text-rose-600 tracking-tighter uppercase">
                            {{ $isAdmin ? 'PureBlooms Admin' : 'PureBlooms' }}
                        </span>
                    </a>
                </div>

                <!-- 🔍 Search Bar (Desktop) - Only for customers -->
                @if(!$isAdmin)
                <div class="hidden md:flex ml-8 flex-1 max-w-lg">
                    <form action="{{ route('customer.dashboard') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="🔍 Search flowers, bouquets..." 
                                class="w-full pl-12 pr-4 py-3 rounded-full border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none text-slate-700 placeholder-slate-400"
                            >
                            <button type="submit" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-rose-500 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                            @if(request('search'))
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-rose-500 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
                @endif
            </div>

            <!-- Navigation Links - Dynamic based on role -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                
                @if($isAdmin)
                    <!-- ADMIN NAVIGATION -->
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-rose-500 font-medium transition">
                        🏠 Dashboard
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="text-slate-600 hover:text-rose-500 font-medium transition">
                        🌺 Products
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="text-slate-600 hover:text-rose-500 font-medium transition">
                        📦 Orders
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="text-slate-600 hover:text-rose-500 font-medium transition">
                        📂 Categories
                    </a>
                @else
                    <!-- CUSTOMER NAVIGATION -->
                    <a href="{{ route('customer.dashboard') }}" class="text-slate-600 hover:text-rose-500 font-medium transition">
                        🏠 Home
                    </a>
                    <a href="{{ route('customer.orders.index') }}" class="text-slate-600 hover:text-rose-500 font-medium transition">
                        📦 Orders
                    </a>
                    <a href="{{ route('customer.cart.index') }}" class="text-slate-600 hover:text-rose-500 font-medium transition relative">
                        🛒 Cart
                        @php
                            $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0;
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-2 -right-3 bg-rose-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </a>
                @endif
            </div>

            <!-- User Dropdown - Dynamic based on role -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button 
                        @click="dropdownOpen = !dropdownOpen"
                        @click.outside="dropdownOpen = false"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-bold rounded-xl text-slate-700 bg-rose-50 hover:bg-rose-100 transition ease-in-out duration-150 cursor-pointer"
                        style="pointer-events: auto !important; position: relative; z-index: 50;"
                    >
                        <div>{{ Auth::user()->name ?? 'Guest' }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4 transition-transform duration-200" 
                                 :class="{'rotate-180': dropdownOpen}" 
                                 xmlns="http://www.w3.org/2000/svg" 
                                 viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </div>
                    </button>

                    <div 
                        x-show="dropdownOpen"
                        x-transition
                        class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-rose-100/50 py-2 z-50"
                        style="display: none;"
                    >
                        @if($isAdmin)
                            <!-- ADMIN DROPDOWN -->
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition flex items-center gap-2">
                                <span>👨‍💼</span>
                                <span>Admin Panel</span>
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition flex items-center gap-2">
                                <span>🌺</span>
                                <span>Manage Products</span>
                            </a>
                            <a href="{{ route('admin.settings.index') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition flex items-center gap-2">
                                <span>⚙️</span>
                                <span>Settings</span>
                            </a>
                        @else
                            <!-- CUSTOMER DROPDOWN -->
                            <a href="{{ route('customer.profile.show') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition flex items-center gap-2">
                                <span>👤</span>
                                <span>My Profile</span>
                            </a>
                            <a href="{{ route('customer.orders.index') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-rose-50 hover:text-rose-600 transition flex items-center gap-2">
                                <span>📦</span>
                                <span>My Orders</span>
                            </a>
                        @endif
                        
                        <div class="border-t border-rose-100 my-1"></div>
                        
                        <!-- Logout (same for both) -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition flex items-center gap-2">
                                <span>🚪</span>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu - Dynamic based on role -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/95 backdrop-blur-lg border-b border-rose-100/50">
        
        @if(!$isAdmin)
        <!-- Mobile Search (customers only) -->
        <div class="px-4 py-3">
            <form action="{{ route('customer.dashboard') }}" method="GET">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="🔍 Search products..." 
                    class="w-full pl-4 pr-4 py-3 rounded-xl border-2 border-rose-100 bg-white/50 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 transition-all outline-none"
                >
            </form>
        </div>
        @endif
        
        <div class="pt-2 pb-3 space-y-1">
            @if($isAdmin)
                <!-- ADMIN MOBILE LINKS -->
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-slate-600 hover:text-rose-500">
                    🏠 Dashboard
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.products.index')" class="text-slate-600 hover:text-rose-500">
                    🌺 Products
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')" class="text-slate-600 hover:text-rose-500">
                    📦 Orders
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.categories.index')" class="text-slate-600 hover:text-rose-500">
                    📂 Categories
                </x-responsive-nav-link>
            @else
                <!-- CUSTOMER MOBILE LINKS -->
                <x-responsive-nav-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard')" class="text-slate-600 hover:text-rose-500">
                    🏠 Home
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customer.orders.index')" class="text-slate-600 hover:text-rose-500">
                    📦 Orders
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customer.cart.index')" class="text-slate-600 hover:text-rose-500">
                    🛒 Cart
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Mobile User Options -->
        <div class="pt-4 pb-1 border-t border-rose-100/50">
            <div class="px-4">
                <div class="font-bold text-base text-slate-800">{{ Auth::user()->name ?? 'Guest' }}</div>
                <div class="font-medium text-sm text-slate-500">
                    {{ $isAdmin ? 'Administrator' : Auth::user()->email ?? '' }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                @if($isAdmin)
                    <x-responsive-nav-link :href="route('admin.dashboard')" class="text-slate-600 hover:text-rose-500">
                        👨‍💼 Admin Panel
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.settings.index')" class="text-slate-600 hover:text-rose-500">
                        ⚙️ Settings
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('customer.profile.show')" class="text-slate-600 hover:text-rose-500">
                        👤 My Profile
                    </x-responsive-nav-link>
                @endif
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-600 hover:text-red-700">
                        🚪 Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>