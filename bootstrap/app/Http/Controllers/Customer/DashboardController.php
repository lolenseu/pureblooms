<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Addon; // ✅ Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard with search & filters.
     */
    public function index(Request $request)
    {
        // Get authenticated customer
        $user = Auth::user();

        // ==================== ORDER STATISTICS ====================
        $recentOrders = Order::where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)
            ->where('order_status', 'pending')
            ->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // ==================== PRODUCT DATA WITH SEARCH & FILTER ====================

        // ✅ FIXED: Remove is_active filter
        $categories = Category::all();

        // Build product query
        $query = Product::where('stock_quantity', '>', 0)
            ->with('category');

        // 🔍 Search by product name
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // 📂 Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 📊 Sort options
        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_low' => $query->orderBy('price', 'asc'),
                'price_high' => $query->orderBy('price', 'desc'),
                'newest' => $query->orderBy('created_at', 'desc'),
                'oldest' => $query->orderBy('created_at', 'asc'),
                default => $query->latest(),
            };
        } else {
            $query->latest();
        }

        // Paginate products (keep filters in pagination links)
        $products = $query->paginate(12)->withQueryString();

        // ✅ FIXED: Featured products - removed is_featured filter
        $featuredProducts = Product::where('stock_quantity', '>', 0)
            ->latest()
            ->limit(4)
            ->get();

        // Available products count (for stats)
        $availableProducts = $query->count();

        // ✅ GET ACTIVE ADDONS FROM DATABASE
        $addons = Addon::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // ==================== RETURN VIEW ====================
        return view('customer.dashboard', compact(
            'user',
            'recentOrders',
            'totalOrders',
            'pendingOrders',
            'totalSpent',
            'availableProducts',
            'products',
            'categories',
            'featuredProducts',
            'addons'  // ✅ Pass addons to view
        ));
    }
}
