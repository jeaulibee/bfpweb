<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Mapping;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Display the full incidents map.
     */
    public function index()
    {
        $incidents = Incident::with(['mapping', 'reporter', 'assignee', 'citizen'])
            ->whereHas('mapping')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get stats for the map view
        $totalIncidents = Incident::count();
        $incidentsWithLocation = Incident::whereHas('mapping')->count();
        $pendingIncidents = Incident::where('status', 'pending')->count();
        $resolvedIncidents = Incident::where('status', 'resolved')->count();

        return view('admin.maps.index', compact(
            'incidents',
            'totalIncidents',
            'incidentsWithLocation',
            'pendingIncidents',
            'resolvedIncidents'
        ));
    }

    /**
     * Get incidents for map (API endpoint).
     */
    public function getIncidentsForMap()
    {
        $incidents = Incident::with(['mapping', 'reporter', 'assignee', 'citizen'])
            ->whereHas('mapping')
            ->get()
            ->map(function ($incident) {
                return $this->formatIncidentForMap($incident);
            });

        return response()->json([
            'success' => true,
            'incidents' => $incidents,
            'stats' => [
                'total' => Incident::count(),
                'with_location' => Incident::whereHas('mapping')->count(),
                'pending' => Incident::where('status', 'pending')->count(),
                'resolved' => Incident::where('status', 'resolved')->count(),
            ]
        ]);
    }

    /**
     * Filter incidents for map based on criteria.
     */
    public function filterIncidents(Request $request)
    {
        $query = Incident::with(['mapping', 'reporter', 'assignee', 'citizen'])
            ->whereHas('mapping');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $incidents = $query->get()->map(function ($incident) {
            return $this->formatIncidentForMap($incident);
        });

        return response()->json([
            'success' => true,
            'incidents' => $incidents,
            'filters' => $request->all(),
            'count' => $incidents->count()
        ]);
    }

    /**
     * Search incidents by location or title.
     */
    public function searchIncidents(Request $request)
    {
        $searchTerm = $request->get('search', '');

        if (empty($searchTerm)) {
            return $this->getIncidentsForMap();
        }

        $incidents = Incident::with(['mapping', 'reporter', 'assignee', 'citizen'])
            ->whereHas('mapping')
            ->where(function($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('location', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%");
            })
            ->get()
            ->map(function ($incident) {
                return $this->formatIncidentForMap($incident);
            });

        return response()->json([
            'success' => true,
            'incidents' => $incidents,
            'search_term' => $searchTerm,
            'count' => $incidents->count()
        ]);
    }

    /**
     * Get incident clusters for better performance with many markers.
     */
    public function getIncidentClusters(Request $request)
    {
        $zoom = $request->get('zoom', 6);
        
        // For lower zoom levels, return clustered data
        if ($zoom < 10) {
            $incidents = Incident::with(['mapping'])
                ->whereHas('mapping')
                ->get()
                ->groupBy(function($incident) use ($zoom) {
                    // Simple clustering by rounded coordinates based on zoom level
                    $precision = max(1, 6 - floor($zoom / 2));
                    $lat = round($incident->mapping->latitude, $precision);
                    $lng = round($incident->mapping->longitude, $precision);
                    return $lat . ',' . $lng;
                })
                ->map(function($cluster, $key) {
                    $coords = explode(',', $key);
                    $firstIncident = $cluster->first();
                    
                    return [
                        'cluster' => true,
                        'latitude' => (float) $coords[0],
                        'longitude' => (float) $coords[1],
                        'count' => $cluster->count(),
                        'incidents' => $cluster->take(3)->map(function($incident) {
                            return $this->formatIncidentForMap($incident);
                        }),
                        'status_summary' => $cluster->groupBy('status')->map->count(),
                        'priority_summary' => $cluster->groupBy('priority')->map->count()
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'clusters' => $incidents,
                'is_clustered' => true
            ]);
        }

        // For higher zoom levels, return individual incidents
        return $this->getIncidentsForMap();
    }

    /**
     * Format incident data for map display.
     */
    private function formatIncidentForMap($incident)
    {
        $statusColors = [
            'pending' => 'orange',
            'in-progress' => 'blue',
            'resolved' => 'green'
        ];

        $priorityColors = [
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red'
        ];

        $typeIcons = [
            'safety' => 'hard-hat',
            'security' => 'shield-alt',
            'environmental' => 'leaf',
            'equipment' => 'tools',
            'medical' => 'first-aid',
            'other' => 'exclamation-triangle'
        ];

        return [
            'id' => $incident->id,
            'title' => $incident->title,
            'description' => $incident->description,
            'location' => $incident->location,
            'status' => $incident->status,
            'priority' => $incident->priority,
            'type' => $incident->type,
            'reporter_name' => $incident->reporter->name ?? 'Unknown',
            'assignee_name' => $incident->assignee->name ?? 'Unassigned',
            'created_at' => $incident->created_at->format('M d, Y h:i A'),
            'created_at_human' => $incident->created_at->diffForHumans(),
            'coordinates' => [
                'latitude' => $incident->mapping->latitude,
                'longitude' => $incident->mapping->longitude
            ],
            'status_color' => $statusColors[$incident->status] ?? 'gray',
            'priority_color' => $priorityColors[$incident->priority] ?? 'gray',
            'type_icon' => $typeIcons[$incident->type] ?? 'exclamation-triangle',
            'has_coordinates' => !is_null($incident->mapping),
            'popup_content' => $this->generatePopupContent($incident)
        ];
    }

    /**
     * Generate HTML content for map popup.
     */
    private function generatePopupContent($incident)
{
    $statusColors = [
        'pending' => 'yellow',
        'in-progress' => 'blue',
        'resolved' => 'green'
    ];

    $priorityColors = [
        'low' => 'green',
        'medium' => 'yellow',
        'high' => 'orange',
        'critical' => 'red'
    ];

    $statusColor = $statusColors[$incident->status] ?? 'gray';
    $priorityColor = $priorityColors[$incident->priority] ?? 'gray';

    $formattedDate = $incident->created_at->format('M d, Y h:i A');
    $description = $incident->description 
        ? (strlen($incident->description) > 150 
            ? substr($incident->description, 0, 150) . '...' 
            : $incident->description) 
        : '';

    return '
        <div class="incident-popup min-w-[280px]">
            <div class="flex items-start justify-between mb-3">
                <h3 class="font-bold text-gray-900 text-lg leading-tight">' . $incident->title . '</h3>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-' . $statusColor . '-100 text-' . $statusColor . '-800 ml-2 flex-shrink-0">'
                    . ucfirst(str_replace('-', ' ', $incident->status)) .
                '</span>
            </div>

            <div class="space-y-2 text-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-gray-500 w-4 flex-shrink-0"></i>
                    <span class="text-gray-700">' . $incident->location . '</span>
                </div>

                <div class="flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-gray-500 w-4 flex-shrink-0"></i>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-' . $priorityColor . '-100 text-' . $priorityColor . '-800">'
                        . ucfirst($incident->priority) . ' priority
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <i class="fas fa-user text-gray-500 w-4 flex-shrink-0"></i>
                    <span class="text-gray-700">Reported by: ' . ($incident->reporter->name ?? 'Unknown') . '</span>
                </div>

                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar text-gray-500 w-4 flex-shrink-0"></i>
                    <span class="text-gray-700">' . $formattedDate . '</span>
                </div>

                ' . ($description ? '
                    <div class="mt-2 pt-2 border-t border-gray-200">
                        <p class="text-gray-600 text-sm leading-relaxed">' . $description . '</p>
                    </div>
                ' : '') . '

                <div class="mt-3 pt-2 border-t border-gray-200">
                    <a href="/admin/incidents/' . $incident->id . '" 
                       class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-lg hover:bg-red-700 transition-colors duration-200">
                        <i class="fas fa-eye mr-1"></i>
                        View Details
                    </a>
                </div>
            </div>
        </div>
    ';
}


    /**
     * Get map statistics for dashboard.
     */
    public function getMapStats()
    {
        $stats = [
            'total_incidents' => Incident::count(),
            'incidents_with_location' => Incident::whereHas('mapping')->count(),
            'pending_incidents' => Incident::where('status', 'pending')->count(),
            'resolved_incidents' => Incident::where('status', 'resolved')->count(),
            'incidents_by_status' => Incident::groupBy('status')->selectRaw('status, count(*) as count')->get()->pluck('count', 'status'),
            'incidents_by_priority' => Incident::groupBy('priority')->selectRaw('priority, count(*) as count')->get()->pluck('count', 'priority'),
            'incidents_by_type' => Incident::groupBy('type')->selectRaw('type, count(*) as count')->get()->pluck('count', 'type'),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}