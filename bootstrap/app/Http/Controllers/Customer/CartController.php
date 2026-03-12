<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display cart page.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = $this->calculateTotal($cart);
        
        return view('customer.cart.index', compact('cart', 'total'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        
        // Validate stock
        if ($product->stock_quantity < $quantity) {
            return redirect()->back()
                ->with('error', 'Not enough stock available!');
        }

        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image_path,
                'quantity' => $quantity,
                'stock' => $product->stock_quantity,
            ];
        }
        
        Session::put('cart', $cart);
        
        return redirect()->back()
            ->with('success', 'Product added to cart! 🌸');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        $cart = Session::get('cart', []);
        $quantity = $request->input('quantity', 1);
        
        if (isset($cart[$id])) {
            $product = Product::find($id);
            
            if ($product && $product->stock_quantity >= $quantity) {
                $cart[$id]['quantity'] = $quantity;
                Session::put('cart', $cart);
                return redirect()->back()->with('success', 'Cart updated!');
            }
            
            return redirect()->back()->with('error', 'Not enough stock!');
        }
        
        return redirect()->back()->with('error', 'Item not found!');
    }

    /**
     * Remove item from cart.
     */
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Item removed from cart!');
        }
        
        return redirect()->back()->with('error', 'Item not found!');
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('customer.cart.index')
            ->with('success', 'Cart cleared!');
    }

    /**
     * Calculate cart total.
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Get cart count for navbar.
     */
    public function count()
    {
        $cart = Session::get('cart', []);
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
}