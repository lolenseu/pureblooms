<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES ====================

// Home Page - Smart Redirect
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('customer.dashboard');
    }
    return view('welcome');
})->name('home');

// Dashboard - Auto Redirect Based on Role
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('customer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public QR Code Page
Route::get('/qrcode', [QrCodeController::class, 'index'])->name('qrcode.index');

// ==================== CUSTOMER ROUTES ====================
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {

    // Customer Dashboard
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Customer Profile Routes
    Route::get('/profile', [CustomerProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [CustomerProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/orders/{orderId}', [CustomerProfileController::class, 'orderDetails'])->name('orders.details');

    // ✅ FIXED: Renamed to avoid duplicate
    Route::get('/orders/{orderId}/track', [CustomerProfileController::class, 'trackOrder'])->name('profile.orders.track');

    // Shopping Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // ✅ This one keeps the original name
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('orders.track');
});

// ==================== PROFILE ROUTES (Laravel Breeze) ====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Addon Management
    Route::resource('addons', \App\Http\Controllers\Admin\AddonController::class);
    Route::patch('addons/{addon}/toggle-status', [\App\Http\Controllers\Admin\AddonController::class, 'toggleStatus'])
        ->name('addons.toggle-status');

    // Category Management
    Route::resource('categories', CategoryController::class);

    // ✅ Product Management - CUSTOM ROUTES MUST BE BEFORE RESOURCE!
    Route::delete('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
    Route::resource('products', ProductController::class);

    // Order Management
    Route::resource('orders', AdminOrderController::class);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    // User Management
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');

    // Reports & Analytics
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/logo', [SettingsController::class, 'updateLogo'])->name('settings.update-logo');
});

// ==================== AUTH ROUTES (Laravel Breeze) ====================
require __DIR__ . '/auth.php';
