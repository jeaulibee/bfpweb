<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;
use App\Models\Device;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class AlertController extends Controller
{
    /**
     * Display a listing of the alerts.
     */
    public function index()
    {
        // Show latest alerts first
        $alerts = Alert::with('device')->latest()->get();
        return view('admin.alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new alert.
     */
    public function create()
    {
        $devices = Device::all();
        return view('admin.alerts.create', compact('devices'));
    }

    /**
     * Store a newly created alert in storage (from admin panel).
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'nullable|exists:devices,id',
            'type' => 'required|string|max:50',
            'message' => 'nullable|string',
            'read' => 'nullable|boolean',
        ]);

        Alert::create([
            'device_id' => $request->device_id,
            'type' => $request->type,
            'message' => $request->message,
            'read' => $request->read ?? false,
        ]);

        return redirect()->route('admin.alerts.index')->with('success', 'Alert added successfully.');
    }

    /**
     * API endpoint for Arduino / external systems.
     *
     * Example POST body:
     * {
     *   "type": "fire",
     *   "message": "Flame detected",
     *   "device_id": 1,         // optional
     *   "timestamp": "2025-10-15 11:09:52" // optional
     * }
     */
    public function apiStore(Request $request)
{
    Log::info('Incoming sensor alert:', $request->all());

    $request->validate([
        'type' => 'required|string|max:50',
        'message' => 'nullable|string',
        'device_id' => 'nullable|exists:devices,id',
        'timestamp' => 'nullable|string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    $alert = new Alert([
        'device_id' => $request->device_id,
        'type' => $request->type,
        'message' => $request->message,
        'read' => false,
    ]);

    if ($request->filled('timestamp')) {
        try {
            $alert->created_at = \Carbon\Carbon::parse($request->timestamp);
        } catch (\Exception $e) {
            Log::warning('Invalid timestamp: ' . $request->timestamp);
        }
    }

    $alert->save();

    // ✅ Save coordinates if present
    if ($request->filled('latitude') && $request->filled('longitude')) {
        \App\Models\AlertMapping::create([
            'alert_id' => $alert->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Alert saved successfully',
        'data' => $alert,
    ], 201);
}


    /**
     * Display the specified alert.
     */
    public function show(Alert $alert)
    {
        return view('admin.alerts.show', compact('alert'));
    }

    /**
     * Show the form for editing the specified alert.
     */
    public function edit(Alert $alert)
    {
        $devices = Device::all();
        return view('admin.alerts.edit', compact('alert', 'devices'));
    }

    /**
     * Update the specified alert in storage.
     */
    public function update(Request $request, Alert $alert)
    {
        $request->validate([
            'device_id' => 'nullable|exists:devices,id',
            'type' => 'required|string|max:50',
            'message' => 'nullable|string',
            'read' => 'nullable|boolean',
        ]);

        $alert->update([
            'device_id' => $request->device_id,
            'type' => $request->type,
            'message' => $request->message,
            'read' => $request->read ?? false,
        ]);

        return redirect()->route('admin.alerts.index')->with('success', 'Alert updated successfully.');
    }

    /**
     * Remove the specified alert from storage.
     */
    public function destroy(Alert $alert)
    {
        $alert->delete();
        return redirect()->route('admin.alerts.index')->with('success', 'Alert deleted successfully.');
    }
}
