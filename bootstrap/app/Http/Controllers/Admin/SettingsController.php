<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        $settings = [
            'shop_name' => Setting::get('shop_name', config('app.name', 'PureBlooms')),
            'shop_email' => Setting::get('shop_email', config('mail.from.address', 'info@pureblooms.com')),
            'shop_phone' => Setting::get('shop_phone', ''),
            'shop_address' => Setting::get('shop_address', ''),
            'currency' => Setting::get('currency', 'PHP'),
            'maintenance_mode' => Setting::get('maintenance_mode', false),
            'allow_registration' => Setting::get('allow_registration', true),
            'cod_enabled' => Setting::get('cod_enabled', true),
            'gcash_enabled' => Setting::get('gcash_enabled', false),
            'logo_path' => Setting::get('logo_path', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update general settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_email' => 'required|email|max:255',
            'shop_phone' => 'nullable|string|max:20',
            'shop_address' => 'nullable|string|max:500',
            'currency' => 'required|string|max:10',
            'maintenance_mode' => 'boolean',
            'allow_registration' => 'boolean',
            'cod_enabled' => 'boolean',
            'gcash_enabled' => 'boolean',
        ]);

        Setting::set('shop_name', $validated['shop_name'], 'string', 'general');
        Setting::set('shop_email', $validated['shop_email'], 'string', 'general');
        Setting::set('shop_phone', $validated['shop_phone'] ?? '', 'string', 'general');
        Setting::set('shop_address', $validated['shop_address'] ?? '', 'string', 'general');
        Setting::set('currency', $validated['currency'], 'string', 'general');
        Setting::set('maintenance_mode', $validated['maintenance_mode'] ?? false, 'boolean', 'general');
        Setting::set('allow_registration', $validated['allow_registration'] ?? true, 'boolean', 'general');
        Setting::set('cod_enabled', $validated['cod_enabled'] ?? true, 'boolean', 'payment');
        Setting::set('gcash_enabled', $validated['gcash_enabled'] ?? false, 'boolean', 'payment');

        Cache::forget('settings');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    /**
     * Update shop logo.
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $oldLogo = Setting::get('logo_path');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $file = $request->file('logo');
            $timestamp = \time();
            $filename = 'logo-' . $timestamp . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('logos', $filename, 'public');
            
            Setting::set('logo_path', $path, 'string', 'general');
            Cache::forget('settings');

            return redirect()->route('admin.settings.index')
                ->with('success', 'Logo updated successfully!');
        }

        return redirect()->route('admin.settings.index')
            ->with('error', 'Failed to upload logo.');
    }
}