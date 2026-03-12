<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Addon; // ✅ Add this import
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalCustomers = User::where('role', 'customer')->count();

        // ✅ Addon Statistics
        $totalAddons = Addon::count();
        $activeAddons = Addon::where('is_active', true)->count();
        $addonRevenue = Order::whereNotNull('addons_total')
            ->where('addons_total', '>', 0)
            ->sum('addons_total');

        // Low stock products
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)->count();

        // Recent products
        $recentProducts = Product::with('category')->latest()->take(5)->get();

        // Recent orders
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'totalCustomers',
            'totalAddons',      // ✅ Added
            'activeAddons',     // ✅ Added
            'addonRevenue',     // ✅ Added
            'lowStockProducts',
            'recentProducts',
            'recentOrders'
        ));
    }
}
