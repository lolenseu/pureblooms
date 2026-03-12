<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'subtotal',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the order that owns this item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that was ordered.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate subtotal (price × quantity).
     */
    public function calculateSubtotal()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute()
    {
        return '₱' . number_format($this->price, 2);
    }

    /**
     * Get formatted subtotal.
     */
    public function getFormattedSubtotalAttribute()
    {
        return '₱' . number_format($this->subtotal, 2);
    }

    /**
     * Check if product still exists.
     */
    public function isProductAvailable()
    {
        return $this->product !== null && $this->product->is_active;
    }

    /**
     * Check if product is in stock.
     */
    public function isProductInStock()
    {
        return $this->product !== null && $this->product->stock_quantity >= $this->quantity;
    }

    /**
     * Get product image URL.
     */
    public function getProductImageUrlAttribute()
    {
        if ($this->product && $this->product->image_path) {
            return asset('storage/' . $this->product->image_path);
        }
        return asset('images/no-image.png');
    }

    /**
     * Scope to get items from a specific order.
     */
    public function scopeOfOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    /**
     * Scope to get items of a specific product.
     */
    public function scopeOfProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Boot method to auto-calculate subtotal before saving.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($orderItem) {
            if ($orderItem->price && $orderItem->quantity) {
                $orderItem->subtotal = $orderItem->price * $orderItem->quantity;
            }
        });
    }
}