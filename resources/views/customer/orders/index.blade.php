@extends('layouts.app')

@section('header', 'My Orders')

@section('content')
<div class="space-y-6">
    @forelse($orders as $order)
    <div class="card-glass">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Order #{{ $order->order_number }}</h3>
                <p class="text-slate-500 text-sm">{{ $order->created_at->format('M d, Y • h:i A') }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($order->order_status === 'delivered') bg-green-100 text-green-700
                @elseif($order->order_status === 'shipped') bg-blue-100 text-blue-700
                @elseif($order->order_status === 'processing') bg-yellow-100 text-yellow-700
                @else bg-gray-100 text-gray-700 @endif">
                {{ ucfirst($order->order_status) }}
            </span>
        </div>
        
        <div class="flex justify-between items-center">
            <p class="text-slate-600">{{ $order->items->count() }} items • Total: <span class="font-bold text-rose-600">₱{{ number_format($order->total_amount, 2) }}</span></p>
            <a href="{{ route('customer.orders.show', $order->id) }}" 
               class="btn-premium px-6 py-2 text-sm">
                View Details 📱
            </a>
        </div>
    </div>
    @empty
    <div class="card-glass text-center py-12">
        <div class="text-6xl mb-4">🛍️</div>
        <h3 class="text-xl font-bold text-slate-900 mb-2">No Orders Yet</h3>
        <p class="text-slate-500 mb-6">Start shopping to see your orders here!</p>
        <a href="{{ route('customer.dashboard') }}" class="btn-premium">
            Browse Products
        </a>
    </div>
    @endforelse

    @if($orders->hasPages())
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection