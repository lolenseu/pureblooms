<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::orderBy('sort_order')->get();
        $totalRevenue = $this->calculateAddonRevenue();

        return view('admin.addons.index', compact('addons', 'totalRevenue'));
    }

    public function create()
    {
        return view('admin.addons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        Addon::create($validated);

        return redirect()->route('admin.addons.index')
            ->with('success', '✅ Addon created successfully!');
    }

    public function edit(Addon $addon)
    {
        return view('admin.addons.edit', compact('addon'));
    }

    public function update(Request $request, Addon $addon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $addon->update($validated);

        return redirect()->route('admin.addons.index')
            ->with('success', '✅ Addon updated successfully!');
    }

    public function destroy(Addon $addon)
    {
        $addon->delete();

        return redirect()->route('admin.addons.index')
            ->with('success', '✅ Addon deleted successfully!');
    }

    public function toggleStatus(Addon $addon)
    {
        $addon->update(['is_active' => !$addon->is_active]);

        return redirect()->route('admin.addons.index')
            ->with('success', '✅ Addon status updated!');
    }

    private function calculateAddonRevenue()
    {
        // Get all orders with addons
        $orders = \App\Models\Order::whereNotNull('addons')
            ->where('addons_total', '>', 0)
            ->get();

        return $orders->sum('addons_total');
    }
}
