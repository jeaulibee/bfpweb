<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    /**
     * Display a listing of the devices.
     */
    public function index()
    {
        $devices = Device::all();
        return view('admin.devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new device.
     */
    public function create()
    {
        return view('admin.devices.create');
    }

    /**
     * Store a newly created device in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:devices,serial_number',
            'location' => 'nullable|string|max:255',
        ]);

        Device::create($request->only('name', 'serial_number', 'location'));

        return redirect()->route('admin.devices.index')->with('success', 'Device added successfully.');
    }

    /**
     * Show the form for editing the specified device.
     */
    public function edit(Device $device)
    {
        return view('admin.devices.edit', compact('device'));
    }

    /**
     * Update the specified device in storage.
     */
    public function update(Request $request, Device $device)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:devices,serial_number,' . $device->id,
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:online,warning,offline'
        ]);

        $device->update($request->only('name', 'serial_number', 'location', 'status'));

        return redirect()->route('admin.devices.index')->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified device from storage.
     */
    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('admin.devices.index')->with('success', 'Device deleted successfully.');
    }

    /**
     * Update device status via AJAX
     */
    public function updateStatus(Request $request, Device $device)
    {
        $request->validate([
            'status' => 'required|in:online,warning,offline'
        ]);

        $device->update([
            'status' => $request->status,
            'last_active' => $request->status === 'online' ? now() : $device->last_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device status updated successfully',
            'device' => $device
        ]);
    }
}