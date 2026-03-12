<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderController extends Controller
{
    /**
     * Display order details with QR code.
     */
    public function show(Order $order)
    {
        // Ensure customer owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Generate QR Code for order tracking
        $qrCodeUrl = route('customer.orders.track', $order->id);
        $qrCode = QrCode::size(250)
            ->color(244, 63, 94)        // Rose-500
            ->backgroundColor(255, 255, 255)  // White
            ->generate($qrCodeUrl);

        return view('customer.orders.show', compact('order', 'qrCode', 'qrCodeUrl'));
    }

    /**
     * Show public order tracking page.
     */
    public function track($orderId)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($orderId);
        return view('customer.orders.track', compact('order'));
    }

    /**
     * Display all orders for the customer.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }
}