@extends('layouts.app')
@section('title', 'Incidents Map')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.incidents.index') }}" 
                       class="flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Incidents
                    </a>
                    <div class="w-1 h-6 bg-gray-300"></div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                            <div class="p-2 bg-red-100 rounded-xl">
                                <i class="fas fa-map text-red-600 text-xl"></i>
                            </div>
                            Incidents Map
                        </h1>
                        <p class="text-gray-600 text-sm mt-1">View all incidents on an interactive map</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Container -->
    <div id="map" class="w-full h-[calc(100vh-120px)]"></div>

    <!-- Map Legend -->
    <div class="fixed bottom-6 left-6 bg-white rounded-xl shadow-lg border border-gray-200 p-4 z-[1000]">
        <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
            <i class="fas fa-legend text-red-600"></i>
            Incident Status
        </h3>
        <div class="space-y-2">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                <span class="text-sm text-gray-700">Pending</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                <span class="text-sm text-gray-700">In Progress</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                <span class="text-sm text-gray-700">Resolved</span>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-white bg-opacity-90 flex items-center justify-center z-[999] transition-opacity duration-300">
        <div class="text-center">
            <div class="w-16 h-16 border-4 border-red-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-gray-700 font-semibold">Loading Map...</p>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Pusher & Laravel Echo -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>

<style>
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .leaflet-popup-content { margin: 16px; font-family: 'Inter', sans-serif; }
    .leaflet-popup-tip { box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let map;
    let incidents = @json($incidents);

    function initMap() {
        map = L.map('map', { zoomControl: true }).setView([12.8797, 121.7740], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        // Show existing incidents
        incidents.forEach(incident => {
            if (incident.mapping && incident.mapping.latitude && incident.mapping.longitude) {
                const marker = createIncidentMarker(incident);
                marker.addTo(map);
            }
        });

        // Show loading overlay for 1 sec
        setTimeout(() => {
            document.getElementById('loadingOverlay').style.opacity = '0';
            setTimeout(() => document.getElementById('loadingOverlay').style.display = 'none', 300);
        }, 1000);

        // Track user location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                map.setView([lat, lng], 13);
                L.circle([lat, lng], { radius: 50, color: 'blue' }).addTo(map)
                 .bindPopup('You are here').openPopup();
            });
        }

        // Add new incident on map click
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            const popupContent = `
                <div class="p-2">
                    <h3 class="font-bold text-gray-900 mb-2">New Incident</h3>
                    <input type="text" id="newTitle" placeholder="Title" class="border w-full mb-2 px-2 py-1 rounded"/>
                    <textarea id="newDescription" placeholder="Description" class="border w-full mb-2 px-2 py-1 rounded"></textarea>
                    <select id="newPriority" class="border w-full mb-2 px-2 py-1 rounded">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                    <select id="newType" class="border w-full mb-2 px-2 py-1 rounded">
                        <option value="safety">Safety</option>
                        <option value="security">Security</option>
                        <option value="environmental">Environmental</option>
                        <option value="equipment">Equipment</option>
                        <option value="medical">Medical</option>
                        <option value="other">Other</option>
                    </select>
                    <button id="submitIncident" class="bg-red-600 text-white px-3 py-1 rounded w-full">Submit</button>
                </div>
            `;

            const marker = L.marker([lat, lng]).addTo(map).bindPopup(popupContent).openPopup();

            document.getElementById('submitIncident').addEventListener('click', function() {
                const title = document.getElementById('newTitle').value;
                const description = document.getElementById('newDescription').value;
                const priority = document.getElementById('newPriority').value;
                const type = document.getElementById('newType').value;

                if (!title) { alert('Title is required'); return; }

                fetch("{{ route('admin.incidents.store.map') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ title, description, latitude: lat, longitude: lng, status: 'pending', priority, type })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        map.removeLayer(marker);
                        const newMarker = createIncidentMarker(data.incident);
                        newMarker.addTo(map).openPopup();
                        alert('Incident created successfully!');
                    } else { alert('Error creating incident.'); }
                })
                .catch(err => { console.error(err); alert('Error creating incident.'); });
            });
        });

        // Handle resize
        window.addEventListener('resize', () => setTimeout(() => map.invalidateSize(), 100));
    }

    // Create Leaflet marker
    function createIncidentMarker(incident) {
        const { latitude, longitude } = incident.mapping;
        let color = incident.status === 'pending' ? 'orange' :
                    incident.status === 'in-progress' ? 'blue' :
                    'green';

        const icon = L.divIcon({
            className: 'custom-marker',
            html: `<div class="w-6 h-6 rounded-full bg-${color}-500 border-2 border-white shadow-lg flex items-center justify-center">
                    <i class="fas fa-fire text-white text-xs"></i></div>`,
            iconSize: [24, 24], iconAnchor: [12, 12]
        });

        const marker = L.marker([latitude, longitude], { icon });

        const popupContent = `
            <div class="incident-popup min-w-[250px]">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-bold text-gray-900 text-lg">${incident.title}</h3>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-${color}-100 text-${color}-800">
                        ${incident.status.replace('-', ' ')}
                    </span>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-gray-500 w-4"></i>
                        <span class="text-gray-700">${incident.location || 'No location specified'}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-gray-500 w-4"></i>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-${incident.priority_color}-100 text-${incident.priority_color}-800">
                            ${incident.priority} priority
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar text-gray-500 w-4"></i>
                        <span class="text-gray-700">${new Date(incident.created_at).toLocaleDateString()}</span>
                    </div>
                    <div class="mt-3 pt-2 border-t border-gray-200">
                        <a href="/admin/incidents/${incident.id}" class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-lg hover:bg-red-700 transition-colors duration-200">
                            <i class="fas fa-eye mr-1"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        `;

        marker.bindPopup(popupContent);
        return marker;
    }

    // Initialize map
    initMap();

    // Laravel Echo real-time updates
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: "{{ env('PUSHER_APP_KEY') }}",
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        encrypted: true
    });

    window.Echo.channel('incidents')
        .listen('.incident.reported', (e) => {
            const marker = createIncidentMarker(e.incident);
            marker.addTo(map);
        })
        .listen('.incident.updated', (e) => {
            // Optional: update existing marker
        });
});
</script>
@endsection
