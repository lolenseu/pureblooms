<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderStatusUpdatedMail;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product'])->latest();

        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status')) {
            $query->where('order_status', $request->status);
        }

        // Payment status filter
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->paginate(15);

        // Statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $processingOrders = Order::where('order_status', 'processing')->count();
        $deliveredOrders = Order::where('order_status', 'delivered')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');

        return view('admin.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'deliveredOrders',
            'totalRevenue'
        ));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        // Store old status for email notification
        $oldStatus = $order->order_status;
        $newStatus = $validated['order_status'];

        $order->update($validated);

        // Update timestamps based on status
        if ($validated['order_status'] === 'shipped') {
            $order->shipped_at = now();
        }

        if ($validated['order_status'] === 'delivered') {
            $order->delivered_at = now();
        }

        if ($validated['order_status'] === 'cancelled') {
            $order->cancelled_at = now();
        }

        $order->save();

        // ✅ SEND STATUS UPDATE EMAIL
        try {
            // Only send email if status actually changed
            if ($oldStatus !== $newStatus) {
                Mail::to($order->customer_email)->send(
                    new OrderStatusUpdatedMail($order, $oldStatus, $newStatus)
                );
                Log::info('Status update email sent to: ' . $order->customer_email, [
                    'order_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send status update email: ' . $e->getMessage(), [
                'order_id' => $order->id
            ]);
            // Don't fail the status update if email fails - just log it
        }

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', '✅ Order status updated successfully! Email notification sent.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully!');
    }
}