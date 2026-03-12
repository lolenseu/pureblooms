<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $oldStatus, $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = match($this->newStatus) {
            'processing' => '🔄 Your Order is Being Processed - #' . $this->order->order_number,
            'shipped' => '🚚 Your Order Has Been Shipped - #' . $this->order->order_number,
            'delivered' => '✅ Your Order Has Been Delivered - #' . $this->order->order_number,
            'cancelled' => '❌ Your Order Has Been Cancelled - #' . $this->order->order_number,
            default => '📦 Order Status Update - #' . $this->order->order_number,
        };

        return $this->subject($subject)
                    ->view('emails.orders.status-update')
                    ->with([
                        'order' => $this->order,
                        'oldStatus' => $this->oldStatus,
                        'newStatus' => $this->newStatus,
                    ]);
    }
}