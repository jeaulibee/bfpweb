<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    public function __construct()
    {
        // Only authenticated staff can access
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->role !== 'staff') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of incidents reported or assigned to this staff.
     */
    public function index()
    {
        $user = Auth::user();

        $incidents = Incident::with(['reporter', 'assignee'])
            ->where(function($query) use ($user) {
                $query->where('reported_by', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.incidents.index', compact('incidents'));
    }

    /**
     * Show the form to create a new incident.
     */
    public function create()
    {
        // No need to pass users since the current user will be the reporter
        return view('staff.incidents.create');
    }

    /**
     * Store a newly created incident in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:pending,in-progress,resolved',
            'priority' => 'nullable|in:low,medium,high,critical',
            // Remove 'reported_by' from validation since we'll set it automatically
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $incident = Incident::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'status' => $validated['status'],
            'priority' => $validated['priority'] ?? 'medium',
            'reported_by' => $user->id, // Automatically set the current user as reporter
            'assigned_to' => $validated['assigned_to'] ?? $user->id, // Default to current user if not assigned
        ]);

        return redirect()
            ->route('staff.incidents.index')
            ->with('success', 'Incident created successfully.');
    }

    /**
     * Display a single incident.
     */
    public function show(Incident $incident)
    {
        $user = Auth::user();

        if ($incident->reported_by !== $user->id && $incident->assigned_to !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $incident->load(['reporter', 'assignee']);
        return view('staff.incidents.show', compact('incident'));
    }

    /**
     * Show the form for editing the specified incident.
     */
    public function edit(Incident $incident)
    {
        $user = Auth::user();

        // Check if the user is authorized to edit this incident
        if ($incident->reported_by !== $user->id && $incident->assigned_to !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $incident->load(['reporter', 'assignee']);
        return view('staff.incidents.edit', compact('incident'));
    }

    /**
     * Update the specified incident in storage.
     */
    public function update(Request $request, Incident $incident)
    {
        $user = Auth::user();

        // Check if the user is authorized to update this incident
        if ($incident->reported_by !== $user->id && $incident->assigned_to !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:pending,in-progress,resolved',
            'priority' => 'nullable|in:low,medium,high,critical',
            'resolution_notes' => 'nullable|string',
        ]);

        $incident->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'status' => $validated['status'],
            'priority' => $validated['priority'] ?? 'medium',
            'resolution_notes' => $validated['resolution_notes'] ?? null,
        ]);

        return redirect()
            ->route('staff.incidents.index')
            ->with('success', 'Incident updated successfully.');
    }

    /**
     * Mark the incident as completed (resolved) by staff.
     */
    public function complete(Request $request, $id)
    {
        $user = Auth::user();

        $incident = Incident::where('id', $id)
            ->where(function($q) use ($user) {
                $q->where('reported_by', $user->id)
                  ->orWhere('assigned_to', $user->id);
            })
            ->firstOrFail();

        $incident->status = 'resolved';
        $incident->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Incident marked as completed.'
            ]);
        }

        return redirect()
            ->route('staff.incidents.index')
            ->with('success', 'Incident marked as completed.');
    }

    /**
     * Delete an incident assigned to or reported by this staff.
     */
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();

        $incident = Incident::where('id', $id)
            ->where(function($q) use ($user) {
                $q->where('reported_by', $user->id)
                  ->orWhere('assigned_to', $user->id);
            })
            ->firstOrFail();

        $incident->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Incident deleted successfully.'
            ]);
        }

        return redirect()
            ->route('staff.incidents.index')
            ->with('success', 'Incident deleted successfully.');
    }

    /**
     * Map view of incidents.
     */
    public function map()
    {
        $user = Auth::user();

        $incidents = Incident::with('reporter')
            ->where(function($q) use ($user) {
                $q->where('reported_by', $user->id)
                  ->orWhere('assigned_to', $user->id);
            })
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('staff.incidents.map', compact('incidents'));
    }
}