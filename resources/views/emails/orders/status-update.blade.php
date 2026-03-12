<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Status Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #f43f5e, #ec4899, #a855f7); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .status-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
        .status-badge { display: inline-block; padding: 8px 20px; border-radius: 20px; font-weight: bold; font-size: 16px; }
        .button { display: inline-block; background: linear-gradient(135deg, #f43f5e, #ec4899); color: white; padding: 12px 30px; text-decoration: none; border-radius: 8px; margin-top: 20px; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🌸 PureBlooms</h1>
            <p>Order Status Update</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hi <strong>{{ $order->customer_name }}</strong>,</p>
            
            <p>Good news! Your order status has been updated.</p>

            <!-- Status Update -->
            <div class="status-box">
                <p style="color: #6b7280; margin-bottom: 10px;">Your order is now:</p>
                
                @if($newStatus === 'processing')
                    <span class="status-badge" style="background: #dbeafe; color: #1e40af;">🔄 Processing</span>
                @elseif($newStatus === 'shipped')
                    <span class="status-badge" style="background: #e9d5ff; color: #5b21b6;">🚚 Shipped</span>
                @elseif($newStatus === 'delivered')
                    <span class="status-badge" style="background: #d1fae5; color: #065f46;">✅ Delivered</span>
                @elseif($newStatus === 'cancelled')
                    <span class="status-badge" style="background: #fee2e2; color: #991b1b;">❌ Cancelled</span>
                @endif

                <p style="margin-top: 20px; color: #6b7280;">
                    Previous status: <strong>{{ ucfirst($oldStatus) }}</strong>
                </p>
            </div>

            <!-- Order Info -->
            <div class="status-box" style="text-align: left;">
                <h3>📦 Order #{{ $order->order_number }}</h3>
                <p><strong>Total Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}, {{ $order->city }}</p>
            </div>

            <!-- Track Order Button -->
            <div style="text-align: center;">
                <a href="{{ url('/customer/orders/' . $order->id . '/track') }}" class="button">
                    📍 Track Your Order
                </a>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>Need help? Reply to this email or contact us at support@pureblooms.com</p>
                <p>&copy; {{ date('Y') }} PureBlooms. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>