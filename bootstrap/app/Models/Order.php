<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'cart_token',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'city',
        'zip_code',
        'postal_code',  // ✅ ADDED - para ma-save ang postal_code
        'notes',
        'addons',           // ✅ Add this
        'addons_total', 
        'shipped_at',
        'delivered_at',
        'cancelled_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the user who placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber()
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    /**
     * Get the status badge CSS class.
     */
    public function getStatusBadgeClass()
    {
        return match($this->order_status) {
            'pending' => 'bg-amber-100 text-amber-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-emerald-100 text-emerald-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the payment status badge CSS class.
     */
    public function getPaymentStatusBadgeClass()
    {
        return match($this->payment_status) {
            'paid' => 'bg-emerald-100 text-emerald-800',
            'pending' => 'bg-amber-100 text-amber-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Check if order is pending.
     */
    public function isPending(): bool
    {
        return $this->order_status === 'pending';
    }

    /**
     * Check if order is processing.
     */
    public function isProcessing(): bool
    {
        return $this->order_status === 'processing';
    }

    /**
     * Check if order is shipped.
     */
    public function isShipped(): bool
    {
        return $this->order_status === 'shipped';
    }

    /**
     * Check if order is delivered.
     */
    public function isDelivered(): bool
    {
        return $this->order_status === 'delivered';
    }

    /**
     * Check if order is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->order_status === 'cancelled';
    }

    /**
     * Check if payment is paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Get formatted total amount.
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return '₱' . number_format($this->total_amount, 2);
    }

    /**
     * Get formatted order date.
     */
    public function getFormattedOrderDateAttribute(): string
    {
        return $this->created_at?->format('M d, Y - h:i A') ?? 'N/A';
    }

    /**
     * Scope to get pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    /**
     * Scope to get delivered orders.
     */
    public function scopeDelivered($query)
    {
        return $query->where('order_status', 'delivered');
    }

    /**
     * Scope to get paid orders.
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Calculate total items quantity.
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Check if order can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->order_status, ['pending', 'processing']);
    }

    /**
     * Get order timeline for tracking.
     */
    public function getTimelineAttribute(): array
    {
        $timeline = [
            [
                'status' => 'Order Placed',
                'date' => $this->created_at,
                'completed' => true,
            ],
            [
                'status' => 'Processing',
                'date' => $this->order_status !== 'pending' ? $this->updated_at : null,
                'completed' => $this->order_status !== 'pending',
            ],
            [
                'status' => 'Shipped',
                'date' => $this->shipped_at,
                'completed' => $this->isShipped() || $this->isDelivered(),
            ],
            [
                'status' => 'Delivered',
                'date' => $this->delivered_at,
                'completed' => $this->isDelivered(),
            ],
        ];

        if ($this->isCancelled()) {
            $timeline[] = [
                'status' => 'Cancelled',
                'date' => $this->cancelled_at,
                'completed' => true,
            ];
        }

        return $timeline;
    }
}