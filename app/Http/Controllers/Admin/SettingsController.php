<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'notification_email' => 'nullable|email|max:255',
            'other_config' => 'nullable|string',
        ]);

        $settings = Setting::first();
        if (!$settings) {
            $settings = Setting::create($request->only('site_name', 'notification_email', 'other_config'));
        } else {
            $settings->update($request->only('site_name', 'notification_email', 'other_config'));
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
