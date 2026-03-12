<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display reports dashboard.
     */
    public function index()
    {
        // Date range (default: last 30 days)
        $startDate = request('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = request('end_date', now()->format('Y-m-d'));

        // Revenue data
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Order status breakdown
        $orderStatuses = Order::select('order_status', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('order_status')
            ->pluck('count', 'order_status');

        // Top selling products
        $topProducts = DB::table('order_items')
    ->select('order_items.product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
    ->join('orders', 'order_items.order_id', '=', 'orders.id')
    ->whereBetween('orders.created_at', [$startDate, $endDate])
    ->groupBy('order_items.product_name')
    ->orderByDesc('total_sold')
    ->take(10)
    ->get();

        // Monthly revenue chart data
        $monthlyRevenue = DB::table('orders')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total_amount) as revenue'))
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalRevenue',
            'totalOrders',
            'avgOrderValue',
            'orderStatuses',
            'topProducts',
            'monthlyRevenue'
        ));
    }

    /**
     * Display sales report.
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $sales = Order::with('user')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->paginate(20);

        $totalSales = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        return view('admin.reports.sales', compact('sales', 'totalSales', 'startDate', 'endDate'));
    }

    /**
     * Display inventory report.
     */
    public function inventory()
    {
        $products = Product::with('category')
            ->select('id', 'name', 'category_id', 'price', 'stock_quantity', 'created_at')
            ->orderBy('stock_quantity', 'asc')
            ->paginate(20);

        $lowStock = Product::where('stock_quantity', '<=', 5)->count();
        $outOfStock = Product::where('stock_quantity', 0)->count();
        $totalProducts = Product::count();
        $totalInventoryValue = Product::sum(DB::raw('price * stock_quantity'));

        return view('admin.reports.inventory', compact(
            'products',
            'lowStock',
            'outOfStock',
            'totalProducts',
            'totalInventoryValue'
        ));
    }

    /**
     * Display customer report.
     */
    public function customers()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->select('id', 'name', 'email', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalCustomers = User::where('role', 'customer')->count();
        $newCustomersThisMonth = User::where('role', 'customer')
            ->whereMonth('created_at', now()->month)
            ->count();
        $customersWithOrders = User::where('role', 'customer')->whereHas('orders')->count();

        return view('admin.reports.customers', compact(
            'customers',
            'totalCustomers',
            'newCustomersThisMonth',
            'customersWithOrders'
        ));
    }
}