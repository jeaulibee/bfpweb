<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\Mapping;
use App\Models\User;
use App\Events\IncidentReported;
use App\Events\IncidentUpdated;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IncidentController extends Controller
{
    /**
     * Display all incidents.
     */
    public function index()
    {
        $incidents = Incident::with(['mapping', 'reporter', 'assignee', 'citizen'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get counts for stats
        $totalIncidentsCount = Incident::count();
        $pendingCount = Incident::where('status', 'pending')->count();
        $inProgressCount = Incident::where('status', 'in-progress')->count();
        $resolvedCount = Incident::where('status', 'resolved')->count();

        return view('admin.incidents.index', compact(
            'incidents',
            'totalIncidentsCount',
            'pendingCount',
            'inProgressCount',
            'resolvedCount'
        ));
    }

    /**
     * Show form to create incident.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.incidents.create', compact('users'));
    }

    /**
     * Store a new incident (staff or citizen).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'required|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'status'      => 'required|in:pending,in-progress,resolved',
            'reported_by' => 'nullable|exists:users,id',
            'citizen_id'  => 'nullable|exists:citizens,id',
            'assigned_to' => 'nullable|exists:users,id',
            'priority'    => 'required|in:low,medium,high,critical',
            'type'        => 'required|in:safety,security,environmental,equipment,medical,other'
        ]);

        // Geocode location if coordinates not provided
        if (!$request->filled(['latitude', 'longitude']) && $request->filled('location')) {
            $coordinates = $this->geocodeAddress($validated['location']);
            if ($coordinates) {
                $validated['latitude'] = $coordinates['lat'];
                $validated['longitude'] = $coordinates['lng'];
                Log::info("Geocoding successful for incident creation", [
                    'location' => $validated['location'],
                    'coordinates' => $coordinates
                ]);
            } else {
                // If geocoding fails, use default coordinates for Koronadal
                $validated['latitude'] = 6.5030;
                $validated['longitude'] = 124.8470;
                Log::warning("Geocoding failed, using default Koronadal coordinates", [
                    'location' => $validated['location']
                ]);
            }
        }

        // Create the incident
        $incident = Incident::create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location'    => $validated['location'],
            'status'      => $validated['status'],
            'reported_by' => $validated['reported_by'] ?? auth()->id(),
            'citizen_id'  => $validated['citizen_id'] ?? null,
            'assigned_to' => $validated['assigned_to'] ?? null,
            'priority'    => $validated['priority'],
            'type'        => $validated['type'],
        ]);

        // Save mapping if coordinates available
        if (isset($validated['latitude']) && isset($validated['longitude'])) {
            Mapping::create([
                'incident_id' => $incident->id,
                'latitude'    => $validated['latitude'],
                'longitude'   => $validated['longitude'],
            ]);
        }

        // Load relationships for broadcasting
        $incident->load(['mapping', 'reporter', 'assignee', 'citizen']);

        // Broadcast the incident event
        broadcast(new IncidentReported($incident))->toOthers();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'incident' => $this->formatIncidentForResponse($incident),
                'message' => 'Incident created successfully.'
            ]);
        }

        return redirect()
            ->route('admin.incidents.index')
            ->with('success', 'Incident created successfully.');
    }

    /**
     * Show a single incident.
     */
    public function show(Incident $incident)
    {
        $incident->load(['reporter', 'assignee', 'citizen', 'mapping']);
        return view('admin.incidents.show', compact('incident'));
    }

    /**
     * Edit incident form.
     */
    public function edit(Incident $incident)
    {
        $users = User::all();
        $incident->load(['reporter', 'assignee', 'citizen', 'mapping']);
        return view('admin.incidents.edit', compact('incident', 'users'));
    }

    /**
     * Update an incident.
     */
    public function update(Request $request, Incident $incident)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'required|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'status'      => 'required|in:pending,in-progress,resolved',
            'reported_by' => 'nullable|exists:users,id',
            'citizen_id'  => 'nullable|exists:citizens,id',
            'assigned_to' => 'nullable|exists:users,id',
            'priority'    => 'required|in:low,medium,high,critical',
            'type'        => 'required|in:safety,security,environmental,equipment,medical,other'
        ]);

        // Geocode location if coordinates not provided but location changed
        if (!$request->filled(['latitude', 'longitude']) && 
            $request->filled('location') && 
            $incident->location !== $validated['location']) {
            $coordinates = $this->geocodeAddress($validated['location']);
            if ($coordinates) {
                $validated['latitude'] = $coordinates['lat'];
                $validated['longitude'] = $coordinates['lng'];
                Log::info("Geocoding successful for incident update", [
                    'location' => $validated['location'],
                    'coordinates' => $coordinates
                ]);
            } else {
                // If geocoding fails, use default coordinates for Koronadal
                $validated['latitude'] = 6.5030;
                $validated['longitude'] = 124.8470;
                Log::warning("Geocoding failed for update, using default Koronadal coordinates", [
                    'location' => $validated['location']
                ]);
            }
        }

        $incident->update([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location'    => $validated['location'],
            'status'      => $validated['status'],
            'reported_by' => $validated['reported_by'] ?? $incident->reported_by,
            'citizen_id'  => $validated['citizen_id'] ?? $incident->citizen_id,
            'assigned_to' => $validated['assigned_to'] ?? $incident->assigned_to,
            'priority'    => $validated['priority'],
            'type'        => $validated['type'],
        ]);

        // Update or create mapping
        if (isset($validated['latitude']) && isset($validated['longitude'])) {
            Mapping::updateOrCreate(
                ['incident_id' => $incident->id],
                [
                    'latitude'  => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                ]
            );
        }

        // Load relationships for broadcasting
        $incident->load(['mapping', 'reporter', 'assignee', 'citizen']);

        // Broadcast update event
        broadcast(new IncidentUpdated($incident))->toOthers();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'incident' => $this->formatIncidentForResponse($incident),
                'message' => 'Incident updated successfully.'
            ]);
        }

        return redirect()
            ->route('admin.incidents.index')
            ->with('success', 'Incident updated successfully.');
    }

    /**
     * Mark incident as resolved.
     */
    public function complete(Request $request, $id)
    {
        $incident = Incident::findOrFail($id);
        $incident->status = 'resolved';
        $incident->save();

        // Load relationships for broadcasting
        $incident->load(['mapping', 'reporter', 'assignee', 'citizen']);

        // Broadcast update event
        broadcast(new IncidentUpdated($incident))->toOthers();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'incident' => $this->formatIncidentForResponse($incident),
                'message' => 'Incident marked as completed.'
            ]);
        }

        return redirect()
            ->route('admin.incidents.index')
            ->with('success', 'Incident marked as completed.');
    }

    /**
     * Delete an incident.
     */
    public function destroy(Request $request, Incident $incident)
    {
        $incidentId = $incident->id;
        $incident->delete();

        // Broadcast deletion event
        broadcast(new IncidentUpdated($incidentId, true))->toOthers();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Incident deleted successfully.'
            ]);
        }

        return redirect()
            ->route('admin.incidents.index')
            ->with('success', 'Incident deleted successfully.');
    }

    /**
     * Bulk delete incidents
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:incidents,id'
        ]);

        try {
            $incidentIds = $validated['ids'];
            $deletedCount = Incident::whereIn('id', $incidentIds)->delete();

            // Broadcast deletion events for each incident
            foreach ($incidentIds as $incidentId) {
                broadcast(new IncidentUpdated($incidentId, true))->toOthers();
            }

            Log::info("Bulk delete completed", [
                'deleted_count' => $deletedCount,
                'incident_ids' => $incidentIds,
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => "{$deletedCount} incidents deleted successfully."
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk delete failed', [
                'error' => $e->getMessage(),
                'incident_ids' => $validated['ids'] ?? []
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete incidents. Please try again.'
            ], 500);
        }
    }

    /**
     * Bulk mark incidents as complete
     */
    public function bulkComplete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:incidents,id'
        ]);

        try {
            $incidentIds = $validated['ids'];
            $updatedCount = Incident::whereIn('id', $incidentIds)->update(['status' => 'resolved']);

            // Load and broadcast update for each incident
            $incidents = Incident::with(['mapping', 'reporter', 'assignee', 'citizen'])
                ->whereIn('id', $incidentIds)
                ->get();

            foreach ($incidents as $incident) {
                broadcast(new IncidentUpdated($incident))->toOthers();
            }

            Log::info("Bulk complete completed", [
                'updated_count' => $updatedCount,
                'incident_ids' => $incidentIds,
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => "{$updatedCount} incidents marked as resolved."
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk complete failed', [
                'error' => $e->getMessage(),
                'incident_ids' => $validated['ids'] ?? []
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update incidents. Please try again.'
            ], 500);
        }
    }

    /**
     * Get all incidents for map (API endpoint)
     */
    public function getIncidentsForMap()
    {
        $incidents = Incident::with(['mapping', 'reporter', 'assignee', 'citizen'])
            ->whereHas('mapping')
            ->get()
            ->map(function ($incident) {
                return $this->formatIncidentForResponse($incident);
            });

        return response()->json([
            'success' => true,
            'incidents' => $incidents
        ]);
    }

    /**
     * Store incident from map click
     */
    public function storeMap(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:pending,in-progress,resolved',
            'priority' => 'required|in:low,medium,high,critical',
            'type' => 'required|in:safety,security,environmental,equipment,medical,other'
        ]);

        // Reverse geocode to get location name
        $locationName = $this->reverseGeocode($validated['latitude'], $validated['longitude']);

        // Create the incident
        $incident = Incident::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location' => $locationName ?? 'Unknown Location',
            'status' => $validated['status'],
            'reported_by' => auth()->id(),
            'priority' => $validated['priority'],
            'type' => $validated['type'],
        ]);

        // Save mapping
        Mapping::create([
            'incident_id' => $incident->id,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        // Load relationships for broadcasting
        $incident->load(['mapping', 'reporter']);

        // Broadcast the incident event
        broadcast(new IncidentReported($incident))->toOthers();

        return response()->json([
            'success' => true,
            'incident' => $this->formatIncidentForResponse($incident),
            'message' => 'Incident created successfully from map.'
        ]);
    }

    /**
     * Format incident for API response
     */
    private function formatIncidentForResponse($incident)
    {
        return [
            'id' => $incident->id,
            'title' => $incident->title,
            'description' => $incident->description,
            'location' => $incident->location,
            'status' => $incident->status,
            'priority' => $incident->priority,
            'type' => $incident->type,
            'reporter_name' => $incident->reporter_name,
            'created_at' => $incident->created_at->diffForHumans(),
            'coordinates' => $incident->coordinates,
            'priority_color' => $incident->priority_color,
            'type_icon' => $incident->type_icon,
            'has_coordinates' => $incident->hasCoordinates(),
            'latitude' => $incident->mapping->latitude ?? null,
            'longitude' => $incident->mapping->longitude ?? null,
        ];
    }

    /**
     * Geocode address using OpenStreetMap Nominatim with better accuracy for Philippine locations
     */
    private function geocodeAddress($address)
    {
        try {
            // Clean and format the address for better geocoding
            $cleanedAddress = $this->cleanAddressForGeocoding($address);
            
            Log::info("Geocoding attempt for: {$address} -> {$cleanedAddress}");

            // First attempt: Search with specific Philippines context and Mindanao bounding box
            $response = Http::timeout(10)->get('https://nominatim.openstreetmap.org/search', [
                'q' => $cleanedAddress,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1,
                'countrycodes' => 'ph',
                'viewbox' => '124.0,5.5,126.0,7.5', // Bounding box for Mindanao region
                'bounded' => 1
            ]);

            $data = $response->json();

            if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                Log::info("Geocoding successful (with bounds) for: {$address}", [
                    'found_location' => $data[0]['display_name'],
                    'coordinates' => [$data[0]['lat'], $data[0]['lon']]
                ]);
                
                return [
                    'lat' => (float) $data[0]['lat'],
                    'lng' => (float) $data[0]['lon']
                ];
            }

            // Second attempt: Try without bounding box but with Philippines restriction
            $response = Http::timeout(10)->get('https://nominatim.openstreetmap.org/search', [
                'q' => $cleanedAddress,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1,
                'countrycodes' => 'ph'
            ]);

            $data = $response->json();

            if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                Log::info("Geocoding successful (Philippines only) for: {$address}", [
                    'found_location' => $data[0]['display_name'],
                    'coordinates' => [$data[0]['lat'], $data[0]['lon']]
                ]);
                
                return [
                    'lat' => (float) $data[0]['lat'],
                    'lng' => (float) $data[0]['lon']
                ];
            }

            // Third attempt: Use known coordinates for common locations
            $knownLocations = $this->getKnownPhilippineLocations();
            $locationKey = strtolower(trim($address));
            
            // Check for partial matches
            foreach ($knownLocations as $key => $coords) {
                if (str_contains($locationKey, $key)) {
                    Log::info("Using known coordinates for: {$address} -> {$key}", $coords);
                    return $coords;
                }
            }

            // Fourth attempt: Try without any country restriction
            $response = Http::timeout(10)->get('https://nominatim.openstreetmap.org/search', [
                'q' => $cleanedAddress,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1
            ]);

            $data = $response->json();

            if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                Log::info("Geocoding successful (global search) for: {$address}", [
                    'found_location' => $data[0]['display_name'],
                    'coordinates' => [$data[0]['lat'], $data[0]['lon']]
                ]);
                
                return [
                    'lat' => (float) $data[0]['lat'],
                    'lng' => (float) $data[0]['lon']
                ];
            }

            Log::warning("All geocoding attempts failed for address: {$address}");
            return null;

        } catch (\Exception $e) {
            Log::error('Geocoding error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Clean and format address for better geocoding results
     */
    private function cleanAddressForGeocoding($address)
    {
        $address = trim($address);
        
        // Common location mappings for better geocoding
        $locationMappings = [
            'koronadal' => 'Koronadal City, South Cotabato, Philippines',
            'gensan' => 'General Santos City, South Cotabato, Philippines',
            'general santos' => 'General Santos City, South Cotabato, Philippines',
            'davao' => 'Davao City, Davao del Sur, Philippines',
            'davao city' => 'Davao City, Davao del Sur, Philippines',
            'manila' => 'Manila, Metro Manila, Philippines',
            'cebu' => 'Cebu City, Cebu, Philippines',
            'cebu city' => 'Cebu City, Cebu, Philippines',
            'cotabato' => 'Cotabato City, Maguindanao, Philippines',
            'zamboanga' => 'Zamboanga City, Zamboanga del Sur, Philippines',
            'cagayan de oro' => 'Cagayan de Oro City, Misamis Oriental, Philippines',
            'iloilo' => 'Iloilo City, Iloilo, Philippines',
            'bacolod' => 'Bacolod City, Negros Occidental, Philippines',
        ];
        
        $lowerAddress = strtolower($address);
        
        // Check if address matches any known locations
        foreach ($locationMappings as $key => $mappedLocation) {
            if (str_contains($lowerAddress, $key)) {
                return $mappedLocation;
            }
        }
        
        // If no specific mapping, add Philippines context
        if (!str_contains(strtolower($address), 'philippines')) {
            $address .= ', Philippines';
        }
        
        return $address;
    }

    /**
     * Get known coordinates for common Philippine locations
     */
    private function getKnownPhilippineLocations()
    {
        return [
            'koronadal' => ['lat' => 6.5030, 'lng' => 124.8470],
            'koronadal city' => ['lat' => 6.5030, 'lng' => 124.8470],
            'general santos' => ['lat' => 6.1164, 'lng' => 125.1716],
            'gensan' => ['lat' => 6.1164, 'lng' => 125.1716],
            'davao' => ['lat' => 7.1907, 'lng' => 125.4553],
            'davao city' => ['lat' => 7.1907, 'lng' => 125.4553],
            'manila' => ['lat' => 14.5995, 'lng' => 120.9842],
            'cebu' => ['lat' => 10.3157, 'lng' => 123.8854],
            'cebu city' => ['lat' => 10.3157, 'lng' => 123.8854],
            'cotabato' => ['lat' => 7.2045, 'lng' => 124.2310],
            'zamboanga' => ['lat' => 6.9214, 'lng' => 122.0790],
            'cagayan de oro' => ['lat' => 8.4542, 'lng' => 124.6319],
            'iloilo' => ['lat' => 10.7202, 'lng' => 122.5621],
            'bacolod' => ['lat' => 10.6765, 'lng' => 122.9509],
            'tacurong' => ['lat' => 6.6920, 'lng' => 124.6760],
            'tacurong city' => ['lat' => 6.6920, 'lng' => 124.6760],
            'surallah' => ['lat' => 6.3720, 'lng' => 124.7340],
            'tupi' => ['lat' => 6.3340, 'lng' => 124.9520],
            'polomolok' => ['lat' => 6.2210, 'lng' => 125.0630],
            // Add more Mindanao and Philippine locations as needed
        ];
    }

    /**
     * Reverse geocode coordinates to get address
     */
    private function reverseGeocode($latitude, $longitude)
    {
        try {
            $response = Http::timeout(10)->get('https://nominatim.openstreetmap.org/reverse', [
                'lat' => $latitude,
                'lon' => $longitude,
                'format' => 'json',
                'zoom' => 16,
                'addressdetails' => 1
            ]);

            $data = $response->json();

            if (isset($data['display_name'])) {
                Log::info("Reverse geocoding successful", [
                    'coordinates' => [$latitude, $longitude],
                    'address' => $data['display_name']
                ]);
                return $data['display_name'];
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Reverse geocoding error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Quick update incident status
     */
    public function quickUpdate(Request $request, Incident $incident)
    {
        $request->validate([
            'status' => 'required|in:pending,in-progress,resolved',
            'priority' => 'required|in:low,medium,high,critical'
        ]);

        $incident->update([
            'status' => $request->status,
            'priority' => $request->priority
        ]);

        // Load relationships for broadcasting
        $incident->load(['mapping', 'reporter', 'assignee', 'citizen']);

        // Broadcast update event
        broadcast(new IncidentUpdated($incident))->toOthers();

        return response()->json([
            'success' => true,
            'incident' => $this->formatIncidentForResponse($incident),
            'message' => 'Incident updated successfully.'
        ]);
    }

    /**
     * Get incident timeline
     */
    public function timeline(Incident $incident)
    {
        // Return timeline data for the incident
        return response()->json([
            'success' => true,
            'timeline' => [
                'created' => $incident->created_at,
                'updated' => $incident->updated_at,
                'status_changes' => [] // You can implement status change tracking
            ]
        ]);
    }

    /**
     * Check for incident updates
     */
    public function checkUpdates(Incident $incident)
    {
        // Return whether the incident has been updated
        return response()->json([
            'success' => true,
            'updated' => $incident->updated_at,
            'has_updates' => false // Implement your update checking logic
        ]);
    }
}