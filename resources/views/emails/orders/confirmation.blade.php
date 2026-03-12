<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #f43f5e, #ec4899, #a855f7); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
        .order-info { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .item { border-bottom: 1px solid #e5e7eb; padding: 10px 0; }
        .total { font-size: 20px; font-weight: bold; color: #f43f5e; }
        .button { display: inline-block; background: linear-gradient(135deg, #f43f5e, #ec4899); color: white; padding: 12px 30px; text-decoration: none; border-radius: 8px; margin-top: 20px; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🌸 PureBlooms</h1>
            <p>Thank you for your order!</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hi <strong>{{ $order->customer_name }}</strong>,</p>
            
            <p>Thank you for shopping with PureBlooms! Your order has been received and is being processed.</p>

            <!-- Order Info -->
            <div class="order-info">
                <h3>📦 Order Details</h3>
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y • h:i A') }}</p>
                <p><strong>Status:</strong> 
                    <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </p>
            </div>

            <!-- Order Items -->
            <div class="order-info">
                <h3>🛍️ Items Ordered</h3>
                @foreach($order->items as $item)
                <div class="item">
                    <strong>{{ $item->product_name }}</strong><br>
                    <span>Qty: {{ $item->quantity }} × ₱{{ number_format($item->price, 2) }}</span>
                    <span style="float: right; font-weight: bold;">₱{{ number_format($item->subtotal, 2) }}</span>
                </div>
                @endforeach

                <div style="margin-top: 20px; padding-top: 10px; border-top: 2px solid #e5e7eb;">
                    <span class="total">Total: ₱{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="order-info">
                <h3>📍 Shipping Address</h3>
                <p>
                    {{ $order->shipping_address }}<br>
                    {{ $order->city }}, {{ $order->zip_code }}<br>
                    {{ $order->customer_phone }}
                </p>
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