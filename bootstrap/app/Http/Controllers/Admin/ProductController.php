<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'low') {
                $query->where('stock_quantity', '<=', 5);
            } elseif ($request->stock === 'out') {
                $query->where('stock_quantity', 0);
            } elseif ($request->stock === 'in') {
                $query->where('stock_quantity', '>', 0);
            }
        }

        if ($request->filled('sort')) {
            switch($request->sort) {
                case 'name_asc': $query->orderBy('name', 'asc'); break;
                case 'name_desc': $query->orderBy('name', 'desc'); break;
                case 'price_asc': $query->orderBy('price', 'asc'); break;
                case 'price_desc': $query->orderBy('price', 'desc'); break;
                case 'stock_asc': $query->orderBy('stock_quantity', 'asc'); break;
                case 'stock_desc': $query->orderBy('stock_quantity', 'desc'); break;
                case 'newest': $query->latest(); break;
                case 'oldest': $query->oldest(); break;
                default: $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0|max:999999.99',
                'stock_quantity' => 'required|integer|min:0|max:9999',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $timestamp = Carbon::now()->timestamp;
                $slug = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $extension = $file->getClientOriginalExtension();
                $filename = $slug . '-' . $timestamp . '.' . $extension;
                $path = $file->storeAs('products', $filename, 'public');
                $validated['image_path'] = $path;
            }

            $product = Product::create($validated);

            return redirect()->route('admin.products.index')
                ->with('success', "🌸 '{$product->name}' has been added successfully!");

        } catch (ValidationException $e) {
            return back()->withInput()->withErrors($e->errors())
                ->with('error', 'Please fix the errors below and try again.');
        } catch (\Exception $e) {
            Log::error('Product store failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to add product. Please try again.');
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0|max:999999.99',
                'stock_quantity' => 'required|integer|min:0|max:9999',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            if ($request->hasFile('image')) {
                if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                    Storage::disk('public')->delete($product->image_path);
                }
                $file = $request->file('image');
                $timestamp = Carbon::now()->timestamp;
                $slug = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $extension = $file->getClientOriginalExtension();
                $filename = $slug . '-' . $timestamp . '.' . $extension;
                $path = $file->storeAs('products', $filename, 'public');
                $validated['image_path'] = $path;
            }

            $product->update($validated);

            return redirect()->route('admin.products.index')
                ->with('success', "🌸 '{$product->name}' has been updated successfully!");

        } catch (ValidationException $e) {
            return back()->withInput()->withErrors($e->errors())
                ->with('error', 'Please fix the errors below and try again.');
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $productName = $product->name;
            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', "🗑️ '{$productName}' has been deleted successfully!");

        } catch (\Exception $e) {
            Log::error('Product delete failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete product. Please try again.');
        }
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        $status = $product->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "🌸 '{$product->name}' has been {$status}!");
    }

    /**
     * ✅ FIXED: Bulk delete with proper array handling
     */
    public function bulkDelete(Request $request)
    {
        // ✅ Accept both array and comma-separated string
        $products = $request->input('products');
        
        // Convert comma-separated string to array if needed
        if (is_string($products)) {
            $products = array_filter(explode(',', $products));
        }
        
        // Validate
        if (empty($products)) {
            return back()->with('error', 'Please select at least one product to delete.');
        }
        
        $count = 0;
        
        foreach ($products as $productId) {
            $product = Product::find($productId);
            
            if ($product) {
                // Delete image
                if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                    Storage::disk('public')->delete($product->image_path);
                }
                $product->delete();
                $count++;
            }
        }

        return redirect()->back()
            ->with('success', "🗑️ {$count} product(s) deleted successfully!");
    }
}