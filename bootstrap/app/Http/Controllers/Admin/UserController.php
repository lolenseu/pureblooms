<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $users = $query->paginate(15)->withQueryString();

        $totalCustomers = User::where('role', 'customer')->count();
        $activeCustomers = User::where('role', 'customer')->where('is_active', true)->count();
        $inactiveCustomers = User::where('role', 'customer')->where('is_active', false)->count();
        $customersWithOrders = User::where('role', 'customer')->whereHas('orders')->count();

        return view('admin.users.index', compact(
            'users',
            'totalCustomers',
            'activeCustomers',
            'inactiveCustomers',
            'customersWithOrders'
        ));
    }

    /**
     * Display the specified customer with details and order history.
     */
    public function show(User $user)
    {
        $user->load(['orders' => function ($query) {
            $query->with('items')->latest()->take(10);
        }]);

        $totalOrders = $user->orders()->count();
        $totalSpent = $user->orders()->where('payment_status', 'paid')->sum('total_amount');
        $pendingOrders = $user->orders()->where('order_status', 'pending')->count();
        $processingOrders = $user->orders()->where('order_status', 'processing')->count();
        $completedOrders = $user->orders()->where('order_status', 'delivered')->count();
        $cancelledOrders = $user->orders()->where('order_status', 'cancelled')->count();

        $avgOrderValue = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;
        $recentOrders = $user->orders()->with('items')->latest()->take(10)->get();

        return view('admin.users.show', compact(
            'user',
            'totalOrders',
            'totalSpent',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'avgOrderValue',
            'recentOrders'
        ));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, User $user)
    {
        // ✅ STRONG PASSWORD VALIDATION
        $passwordRules = [
            'nullable',
            'min:8',
            'max:255',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
        ];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'is_active' => ['required', 'boolean'],
            'password' => $passwordRules,
        ], [
            'name.required' => 'Customer name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered to another account.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character (@$!%*?&).',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->is_active = $validated['is_active'];

        // ✅ Hash password only if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', '✅ Customer updated successfully!');
    }

    /**
     * Toggle the active status of the specified customer.
     */
    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                ->with('error', '❌ Cannot change status of admin accounts.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';
        $message = $user->is_active
            ? "✅ Customer account has been activated."
            : "⚠️ Customer account has been deactivated.";

        return redirect()->route('admin.users.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                ->with('error', '❌ Cannot delete admin accounts.');
        }

        if ($user->orders()->count() > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', '❌ Cannot delete customer. They have ' . $user->orders()->count() . ' existing order(s).');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "🗑️ Customer '{$userName}' has been deleted.");
    }

    /**
     * Export customers to CSV.
     */
    public function export()
    {
        $customers = User::where('role', 'customer')
            ->select('id', 'name', 'email', 'phone', 'is_active', 'created_at')
            ->get();

        $filename = 'customers-' . date('Y-m-d') . '.csv';
        $handle = fopen('php://output', 'w');

        fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Status', 'Registered']);

        foreach ($customers as $customer) {
            fputcsv($handle, [
                $customer->id,
                $customer->name,
                $customer->email,
                $customer->phone ?? 'N/A',
                $customer->is_active ? 'Active' : 'Inactive',
                $customer->created_at->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($handle);

        return response()->stream(function () use ($handle) {}, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
