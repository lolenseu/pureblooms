@extends('layouts.app')

@section('header', 'Order Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Order Information -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Order Header -->
        <div class="card-glass">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Order #{{ $order->order_number }}</h2>
                    <p class="text-slate-500">{{ $order->created_at->format('M d, Y • h:i A') }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    @if($order->order_status === 'delivered') bg-green-100 text-green-700
                    @elseif($order->order_status === 'shipped') bg-blue-100 text-blue-700
                    @elseif($order->order_status === 'processing') bg-yellow-100 text-yellow-700
                    @elseif($order->order_status === 'cancelled') bg-red-100 text-red-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ ucfirst($order->order_status) }}
                </span>
            </div>

            <!-- Payment Status -->
            <div class="flex items-center gap-2 text-sm">
                <span class="text-slate-500">Payment:</span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @if($order->payment_status === 'paid') bg-green-100 text-green-700
                    @elseif($order->payment_status === 'failed') bg-red-100 text-red-700
                    @else bg-amber-100 text-amber-700 @endif">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card-glass">
            <h3 class="text-lg font-bold text-slate-900 mb-4">📦 Order Items</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex gap-4 p-4 bg-white/60 rounded-xl">
                    @if($item->product && $item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                         class="w-20 h-20 object-cover rounded-lg" alt="{{ $item->product_name }}">
                    @else
                    <div class="w-20 h-20 bg-gradient-to-br from-rose-100 to-pink-100 rounded-lg flex items-center justify-center">
                        <span class="text-3xl">🌸</span>
                    </div>
                    @endif
                    <div class="flex-1">
                        <h4 class="font-semibold text-slate-900">{{ $item->product_name }}</h4>
                        <p class="text-slate-500 text-sm">Quantity: {{ $item->quantity }}</p>
                        <p class="font-bold text-rose-600 mt-1">₱{{ number_format($item->subtotal, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Total -->
            <div class="mt-6 pt-6 border-t-2 border-rose-100">
                <div class="flex justify-between items-center text-lg font-bold">
                    <span>Total Amount</span>
                    <span class="text-2xl text-rose-600">₱{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="card-glass">
            <h3 class="text-lg font-bold text-slate-900 mb-4">📍 Shipping Information</h3>
            <div class="space-y-2 text-slate-600">
                <p><span class="font-semibold">Name:</span> {{ $order->customer_name }}</p>
                <p><span class="font-semibold">Phone:</span> {{ $order->customer_phone }}</p>
                <p><span class="font-semibold">Email:</span> {{ $order->customer_email }}</p>
                <p><span class="font-semibold">Address:</span> {{ $order->shipping_address }}, {{ $order->city }}, {{ $order->zip_code }}</p>
                <p><span class="font-semibold">Payment Method:</span> {{ strtoupper($order->payment_method) }}</p>
                @if($order->notes)
                <p><span class="font-semibold">Notes:</span> {{ $order->notes }}</p>
                @endif
            </div>
        </div>

    </div>

    <!-- QR Code Sidebar -->
    <div class="lg:col-span-1">
        <div class="card-glass text-center sticky top-24">
            <h3 class="text-xl font-bold text-slate-900 mb-2">📱 Track Your Order</h3>
            <p class="text-sm text-slate-500 mb-6">Scan this QR code to quickly access your order tracking on any device</p>
            
            <!-- QR Code -->
            <div class="bg-white p-6 rounded-2xl inline-block shadow-xl border-4 border-rose-100">
                {!! $qrCode !!}
            </div>
            
            <!-- Tracking URL -->
            <div class="mt-6 p-4 bg-rose-50 rounded-xl">
                <p class="text-xs text-slate-500 mb-2">Tracking Link:</p>
                <a href="{{ $qrCodeUrl }}" target="_blank" 
                   class="text-sm text-rose-600 font-semibold hover:text-rose-700 break-all">
                    {{ $qrCodeUrl }}
                </a>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-6 space-y-3">
                <a href="{{ $qrCodeUrl }}" target="_blank" 
                   class="btn-premium w-full justify-center">
                    🔗 Open Tracking Page
                </a>
                <a href="{{ route('customer.orders.index') }}" 
                   class="block w-full px-4 py-3 bg-white border-2 border-rose-200 text-rose-600 font-semibold rounded-xl hover:bg-rose-50 transition">
                    ← Back to Orders
                </a>
            </div>
        </div>
    </div>
    
</div>
@endsection