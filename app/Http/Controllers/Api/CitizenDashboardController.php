<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\Alert;
use App\Models\User;
use App\Models\Announcement;
use App\Models\Mapping;
use App\Events\IncidentReported; // ADD THIS
use App\Events\IncidentUpdated;  // ADD THIS
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CitizenDashboardController extends Controller
{
    /**
     * 🔥 Get latest active fire alerts (PUBLIC)
     */
    public function alerts()
    {
        $alerts = Alert::where('status', 'active')
            ->latest()
            ->take(10)
            ->get(['id', 'title', 'description', 'location', 'status', 'created_at']);

        return response()->json([
            'success' => true,
            'alerts'  => $alerts,
        ], 200);
    }

    /**
     * 👤 Get authenticated citizen profile
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated or invalid token.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user'    => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'role'       => $user->role,
                'is_active'  => $user->is_active,
                'created_at' => $user->created_at,
            ],
        ], 200);
    }

    /**
     * 📄 Get reports submitted by this logged-in citizen (PROTECTED)
     */
    public function myReports(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $reports = Incident::with('mapping')
            ->where('reported_by', $user->id)
            ->latest()
            ->get(['id', 'title', 'description', 'location', 'status', 'priority', 'created_at']);

        return response()->json([
            'success' => true,
            'reports' => $reports,
        ], 200);
    }

    /**
     * 📄 Get user reports by user_id (PUBLIC)
     */
    public function getUserReportsPublic($user_id)
    {
        // Verify user exists
        $user = User::where('id', $user_id)
                    ->where('role', 'citizen')
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        $reports = Incident::with('mapping')
            ->where('reported_by', $user_id)
            ->latest()
            ->get(['id', 'title', 'description', 'location', 'status', 'priority', 'created_at']);

        return response()->json([
            'success' => true,
            'reports' => $reports,
            'user' => [
                'id' => $user->id,
                'name' => $user->name
            ]
        ], 200);
    }

    /**
     * 🆕 Get latest announcement for notification checking (PUBLIC)
     */
    public function getLatestAnnouncement()
    {
        $latestAnnouncement = Announcement::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->first(['id', 'title', 'message as content', 'created_at']);

        return response()->json([
            'success' => true,
            'announcement' => $latestAnnouncement,
            'timestamp' => now()->toISOString()
        ], 200);
    }

    /**
     * 🧭 Submit a new incident report (AUTHENTICATED)
     */
    public function storeIncident(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'required|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'priority'    => 'nullable|in:low,medium,high,critical',
            'type'        => 'nullable|in:safety,security,environmental,equipment,medical,other',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $incident = Incident::create([
                'title'       => $request->title,
                'description' => $request->description ?? 'No description provided',
                'location'    => $request->location,
                'status'      => 'pending',
                'reported_by' => $user->id,
                'priority'    => $request->priority ?? 'medium',
                'type'        => $request->type ?? 'safety',
            ]);

            if ($request->filled(['latitude', 'longitude'])) {
                $incident->mapping()->create([
                    'latitude'  => $request->latitude,
                    'longitude' => $request->longitude,
                ]);
            }

            // Load relationships for broadcasting
            $incident->load(['mapping', 'reporter', 'citizen']);

            // 🔥 ADD EVENT BROADCASTING - Instant notification
            broadcast(new IncidentReported($incident));

            Log::info("Citizen {$user->id} submitted an incident report: {$incident->id}");

            return response()->json([
                'success' => true,
                'message' => 'Report submitted successfully!',
                'report'  => $incident->load('mapping'),
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error submitting incident: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting the report.',
            ], 500);
        }
    }

    /**
     * 🔓 Submit incident report WITHOUT authentication (PUBLIC)
     */
    public function storeIncidentPublic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'required|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'user_id'     => 'required|exists:users,id',
            'priority'    => 'nullable|in:low,medium,high,critical',
            'type'        => 'nullable|in:safety,security,environmental,equipment,medical,other',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            // Verify user exists and is a citizen
            $user = User::where('id', $request->user_id)
                        ->where('role', 'citizen')
                        ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or not authorized to submit reports.',
                ], 404);
            }

            // Create the incident with priority and type
            $incident = Incident::create([
                'title'       => $request->title,
                'description' => $request->description ?? 'No description provided',
                'location'    => $request->location,
                'status'      => 'pending',
                'reported_by' => $user->id,
                'priority'    => $request->priority ?? 'medium',
                'type'        => $request->type ?? 'safety',
            ]);

            // Add mapping if coordinates provided
            if ($request->filled(['latitude', 'longitude'])) {
                $incident->mapping()->create([
                    'latitude'  => $request->latitude,
                    'longitude' => $request->longitude,
                ]);
            }

            // Load relationships for broadcasting
            $incident->load(['mapping', 'reporter', 'citizen']);

            // 🔥 ADD EVENT BROADCASTING - Instant notification for public reports
            broadcast(new IncidentReported($incident));

            Log::info("🔔 PUBLIC REPORT: Incident created and event fired", [
                'user_id' => $user->id,
                'incident_id' => $incident->id,
                'time' => now()->toDateTimeString()
            ]);

            Log::info("Public report submitted by user {$user->id}: {$incident->id}");

            return response()->json([
                'success' => true,
                'message' => 'Report submitted successfully via public endpoint!',
                'report'  => $incident->load('mapping'),
                'user'    => [
                    'id'   => $user->id,
                    'name' => $user->name,
                ],
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error submitting public incident: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting the report.',
                'error'   => env('APP_DEBUG') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * 🗂️ List all incidents reported by the citizen
     */
    public function listIncidents(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $incidents = Incident::with('mapping')
            ->where('reported_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'description', 'location', 'status', 'priority', 'created_at']);

        return response()->json([
            'success'   => true,
            'incidents' => $incidents,
        ], 200);
    }

    /**
     * 📢 Get announcements (PUBLIC)
     */
    public function getAnnouncements()
    {
        $announcements = Announcement::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'message as content', 'created_at']);

        return response()->json([
            'success' => true,
            'announcements' => $announcements,
        ], 200);
    }
}