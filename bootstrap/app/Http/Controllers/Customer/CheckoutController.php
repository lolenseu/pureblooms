<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Addon;
use App\Mail\OrderConfirmationMail;

class CheckoutController extends Controller
{
    /**
     * Get addon prices from database (dynamic, admin-manageable)
     */
    protected function getAddonPrices()
    {
        return Addon::where('is_active', true)
            ->pluck('price', 'slug')
            ->toArray();
    }

    /**
     * Show checkout page - Handles BOTH Cart and Buy Now flows
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Check if this is Buy Now flow via query parameter
        $isBuyNow = $request->query('buy_now') === '1';

        // Get cart for regular flow
        $cart = session('cart', []);

        // Check if we have products from either flow
        $hasProducts = !empty($cart) || $isBuyNow;

        if (!$hasProducts) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Your cart is empty! Add products first.');
        }

        // Generate cart token if not exists
        if (!session()->has('cart_token')) {
            session()->put('cart_token', Str::uuid()->toString());
        }

        // Calculate total - Buy Now total comes from JS via form submission
        $total = 0;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        // Pass variables to view
        return view('customer.checkout.index', compact(
            'cart',
            'total',
            'isBuyNow'
        ));
    }

    /**
     * Process checkout - Handles BOTH Cart and Buy Now flows
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        try {
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
                'shipping_address' => 'required|string|max:500',
                'city' => 'required|string|max:100',
                'postal_code' => 'required|string|max:20',
                'payment_method' => 'required|in:cod,gcash',
                'notes' => 'nullable|string|max:1000',
                'products' => 'nullable|string',
                'addons' => 'nullable|array',
                'addons.*' => 'nullable|numeric|min:0',
            ]);

            // Determine products source: Buy Now or Cart
            $products = [];
            $isBuyNow = false;

            if ($request->filled('products')) {
                // Buy Now flow - parse JSON products from modal
                $isBuyNow = true;
                $productsJson = \json_decode($request->products, true);

                if (is_array($productsJson)) {
                    foreach ($productsJson as $item) {
                        $product = Product::find($item['id']);
                        if ($product) {
                            $products[$item['id']] = [
                                'id' => $product->id,
                                'name' => $product->name,
                                'price' => $product->price,
                                'quantity' => $item['quantity'] ?? 1,
                            ];
                        }
                    }
                }
            } else {
                // Cart flow - get from session
                $products = session('cart', []);
            }

            if (empty($products)) {
                return redirect()->back()->with('error', 'No products found in your order.');
            }

            // Calculate products total
            $productsTotal = 0;
            foreach ($products as $item) {
                $productsTotal += $item['price'] * $item['quantity'];
            }

            // ✅ Calculate addons total using DATABASE prices
            $addons = $request->input('addons', []);
            $addonsTotal = 0;
            $selectedAddons = [];
            $addonPrices = $this->getAddonPrices(); // Fetch from database

            foreach ($addons as $addonKey => $value) {
                // Validate addon exists in database and is active
                if (isset($addonPrices[$addonKey]) && $value) {
                    $addonsTotal += $addonPrices[$addonKey];
                    $selectedAddons[$addonKey] = $addonPrices[$addonKey];
                }
            }

            $total = $productsTotal + $addonsTotal;

            DB::beginTransaction();

            try {
                $orderNumber = Order::generateOrderNumber();

                $cartToken = session('cart_token');
                if (!$cartToken && !$isBuyNow) {
                    $cartToken = Str::uuid()->toString();
                    session()->put('cart_token', $cartToken);
                }

                // Check for duplicate orders (cart flow only)
                if (!$isBuyNow && $cartToken) {
                    $recentOrder = Order::where('user_id', $user->id)
                        ->where('cart_token', $cartToken)
                        ->where('created_at', '>', now()->subMinutes(5))
                        ->first();

                    if ($recentOrder) {
                        DB::rollBack();
                        return redirect()->route('customer.checkout.success', $recentOrder->id)
                            ->with('success', '🎉 Order already placed!');
                    }
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'order_number' => $orderNumber,
                    'cart_token' => $cartToken,
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_phone' => $validated['customer_phone'],
                    'shipping_address' => $validated['shipping_address'],
                    'city' => $validated['city'],
                    'zip_code' => $validated['postal_code'],
                    'total_amount' => $total,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'pending',
                    'order_status' => 'pending',
                    'notes' => $validated['notes'] ?? null,
                    'addons' => !empty($selectedAddons) ? \json_encode($selectedAddons) : null,
                    'addons_total' => $addonsTotal,
                ]);

                // Create order items and update stock
                foreach ($products as $item) {
                    $product = Product::find($item['id']);

                    if (!$product) {
                        throw new \Exception("Product not found: " . $item['id']);
                    }

                    if ($product->stock_quantity < $item['quantity']) {
                        throw new \Exception("Not enough stock for: " . $product->name);
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'product_name' => $item['name'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['price'] * $item['quantity'],
                    ]);

                    $product->stock_quantity -= $item['quantity'];
                    $product->save();
                }

                DB::commit();

                // Clear cart only for cart flow (not Buy Now)
                if (!$isBuyNow) {
                    session()->forget('cart');
                    session()->forget('cart_token');
                }

                // Send email
                try {
                    Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
                } catch (\Exception $e) {
                    Log::error('Email failed: ' . $e->getMessage());
                }

                return redirect()->route('customer.checkout.success', $order->id)
                    ->with('success', '🎉 Order placed successfully!');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Order creation failed: ' . $e->getMessage());
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please fill in all required fields.');
        } catch (\Exception $e) {
            Log::error('Checkout failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', '❌ Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);

        if ($order->addons) {
            $order->addons_decoded = \json_decode($order->addons, true);
        }

        return view('customer.checkout.success', compact('order'));
    }
}
