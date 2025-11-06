@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
use App\Models\Incident;
use App\Models\Device;
use App\Models\User;

// Stats
$activeAlerts = Incident::where('status', 'pending')->count();
$reportsSubmitted = Incident::count();
$devicesCount = Device::count();
$personnelCount = User::count();
$personnelOnLeave = 0;

// Recent Reports
$recentReports = Incident::with('mapping')->latest()->take(5)->get();
$activeIncidents = Incident::where('status', 'pending')->get();

// All incidents for the map with mapping data
$allIncidents = Incident::with('mapping')->get();

// Chart data - Weekly reports
$weeklyReports = Incident::where('created_at', '>=', now()->subDays(7))
    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
    ->groupBy('date')
    ->orderBy('date')
    ->get();

// NEW: Locations with most incidents
$locationsWithMostIncidents = Incident::select('location')
    ->selectRaw('COUNT(*) as incident_count')
    ->whereNotNull('location')
    ->where('location', '!=', '')
    ->groupBy('location')
    ->orderByDesc('incident_count')
    ->limit(10) // Top 10 locations
    ->get();

// Prepare data for the chart
$locationLabels = $locationsWithMostIncidents->pluck('location')->toArray();
$locationCounts = $locationsWithMostIncidents->pluck('incident_count')->toArray();

// If no location data, use some defaults
if(empty($locationLabels)) {
    $locationLabels = ['No location data available'];
    $locationCounts = [0];
}
@endphp

<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name ?? 'Admin' }} 👋</h1>
            <p class="text-gray-600 text-lg">Here's what's happening with your fire detection system today.</p>
        </div>
        <!-- Removed the Add Incident Report button -->
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 transition-all duration-300 hover:shadow-xl hover:scale-105 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-fire text-red-600 text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">{{ $activeAlerts }}</div>
                    <div class="text-xs text-green-600 font-semibold flex items-center gap-1 justify-end">
                        <i class="fas fa-arrow-up"></i>
                        12%
                    </div>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-700 mb-1">Active Fire Alerts</h3>
            <p class="text-xs text-gray-500">Requires immediate attention</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 transition-all duration-300 hover:shadow-xl hover:scale-105 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-file-alt text-orange-600 text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">{{ $reportsSubmitted }}</div>
                    <div class="text-xs text-green-600 font-semibold flex items-center gap-1 justify-end">
                        <i class="fas fa-arrow-up"></i>
                        8%
                    </div>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-700 mb-1">Reports Submitted</h3>
            <p class="text-xs text-gray-500">Total incident reports</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 transition-all duration-300 hover:shadow-xl hover:scale-105 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-microchip text-green-600 text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">{{ $devicesCount }}</div>
                    <div class="text-xs text-green-600 font-semibold flex items-center gap-1 justify-end">
                        <i class="fas fa-arrow-up"></i>
                        5%
                    </div>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-700 mb-1">Active Devices</h3>
            <p class="text-xs text-gray-500">IoT sensors online</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 transition-all duration-300 hover:shadow-xl hover:scale-105 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">{{ $personnelCount }}</div>
                    <div class="text-xs text-red-600 font-semibold flex items-center gap-1 justify-end">
                        <i class="fas fa-user-clock"></i>
                        {{ $personnelOnLeave }} on leave
                    </div>
                </div>
            </div>
            <h3 class="text-sm font-semibold text-gray-700 mb-1">Personnel</h3>
            <p class="text-xs text-gray-500">Team members</p>
        </div>
    </div>

    <!-- NEW: Locations with Most Incidents Chart -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-bar text-purple-600"></i>
                    </div>
                    Locations with Most Incidents
                </h2>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle"></i>
                    <span>Top {{ count($locationLabels) }} locations</span>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                <canvas id="locationsChart"></canvas>
            </div>
        </div>
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            <div class="text-sm text-gray-600">
                <i class="fas fa-lightbulb mr-2"></i>
                This chart shows areas that require the most attention based on incident frequency.
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Fire Map & Controls -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Fire Map Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-map-marked-alt text-red-600"></i>
                            </div>
                            Fire Map Overview
                        </h2>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-sync-alt"></i>
                            <span id="mapLastUpdate">Updated just now</span>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div id="fireMap" class="h-96 w-full relative z-0"></div>
                    
                    <!-- Map Overlay Controls -->
                    <div class="absolute top-4 left-4 z-10 bg-white rounded-xl shadow-lg p-3 min-w-[200px]">
                        <div class="text-sm font-semibold text-gray-700 mb-2">Live Incidents</div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-purple-500 rounded-full pulse-fast"></div>
                                <span class="text-xs text-gray-600">Critical: <span id="criticalCount">0</span></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full pulse"></div>
                                <span class="text-xs text-gray-600">High: <span id="highCount">0</span></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full pulse"></div>
                                <span class="text-xs text-gray-600">Medium: <span id="mediumCount">0</span></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-xs text-gray-600">Low: <span id="lowCount">0</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Legend -->
                    <div class="absolute top-4 right-4 z-10 bg-white rounded-xl shadow-lg p-3 min-w-[200px]">
                        <div class="text-sm font-semibold text-gray-700 mb-2">Status Legend</div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full pulse"></div>
                                <span class="text-xs text-gray-600">Pending</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-blue-500 rounded-full pulse-slow"></div>
                                <span class="text-xs text-gray-600">In Progress</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-xs text-gray-600">Resolved</span>
                            </div>
                        </div>
                    </div>

                    <!-- Real-time Status -->
                    <div class="absolute bottom-4 left-4 z-10 bg-white rounded-xl shadow-lg p-3">
                        <div class="flex items-center gap-2 text-sm">
                            <div class="w-2 h-2 bg-green-500 rounded-full pulse"></div>
                            <span class="text-gray-700">Live</span>
                            <span class="text-xs text-gray-500" id="connectionStatus">Connected</span>
                        </div>
                    </div>
                </div>

                <!-- Map Controls -->
                <div class="p-6 border-t border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="relative md:col-span-2">
                            <input 
                                id="searchAddress" 
                                type="text" 
                                placeholder="Search location (e.g., Koronadal, Manila, etc.)" 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200"
                            >
                            <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                        </div>
                        <button 
                            id="goToAddress" 
                            class="bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-location-arrow"></i>
                            Search
                        </button>
                        <button 
                            id="markPlace" 
                            class="bg-gradient-to-r from-green-600 to-green-700 text-white py-3 px-6 rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-map-pin"></i>
                            Mark
                        </button>
                    </div>

                    <!-- Location Controls -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <button 
                            id="getCurrentLocation" 
                            class="bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 px-6 rounded-xl font-semibold hover:from-purple-700 hover:to-purple-800 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-location-crosshairs"></i>
                            My Location
                        </button>
                        <button 
                            id="clearMarks" 
                            class="bg-gradient-to-r from-gray-600 to-gray-700 text-white py-3 px-6 rounded-xl font-semibold hover:from-gray-700 hover:to-gray-800 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-trash"></i>
                            Clear Marks
                        </button>
                        <button 
                            id="refreshMap" 
                            class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white py-3 px-6 rounded-xl font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>
                    </div>

                    <!-- Marked Locations -->
                    <div id="markDetails" class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-200 max-h-48 overflow-y-auto">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold text-gray-700">Marked Locations</h4>
                            <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded-full" id="markCount">0 marked</span>
                        </div>
                        <div id="markList" class="space-y-2">
                            <p class="text-gray-500 text-sm text-center py-4">No locations marked yet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Content -->
        <div class="space-y-6">
            <!-- Recent Reports -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clipboard-list text-orange-600"></i>
                            </div>
                            Recent Reports
                        </h2>
                        <button id="refreshReports" class="text-gray-500 hover:text-blue-600 transition-colors duration-200">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="max-h-96 overflow-y-auto" id="reportsContainer">
                    <div class="divide-y divide-gray-100">
                        @forelse($recentReports as $report)
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-200 cursor-pointer group report-item animate-fade-in" 
                                 data-report-id="{{ $report->id }}"
                                 data-location="{{ $report->location }}"
                                 data-title="{{ $report->title }}"
                                 data-status="{{ $report->status }}"
                                 data-priority="{{ $report->priority ?? 'medium' }}"
                                 data-latitude="{{ $report->mapping->latitude ?? '' }}"
                                 data-longitude="{{ $report->mapping->longitude ?? '' }}">
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-red-600 transition-colors duration-200">
                                        {{ $report->title }}
                                    </h4>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold 
                                        {{ $report->status === 'resolved' ? 'bg-green-100 text-green-800' : 
                                           ($report->status === 'in-progress' ? 'bg-blue-100 text-blue-800' : 
                                           ($report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-purple-100 text-purple-800')) }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2 flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-red-500 text-xs"></i>
                                    {{ $report->location ?? 'Unknown location' }}
                                </p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>{{ $report->created_at->diffForHumans() }}</span>
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center">
                                <i class="fas fa-inbox text-gray-300 text-3xl mb-3"></i>
                                <p class="text-gray-500">No recent reports</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="p-4 border-t border-gray-100 bg-gray-50">
                    <a href="{{ route('admin.incidents.index') }}" 
                       class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                        View All Reports
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 transition-all duration-300 hover:shadow-xl">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-3">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-purple-600"></i>
                    </div>
                    Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.maps.index') }}" 
                       class="flex items-center gap-3 p-3 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition-all duration-200 group">
                        <i class="fas fa-map text-blue-600 group-hover:scale-110 transition-transform duration-200"></i>
                        <span class="font-semibold">View Full Map</span>
                    </a>
                    <a href="{{ route('admin.devices.index') }}" 
                       class="flex items-center gap-3 p-3 bg-green-50 text-green-700 rounded-xl hover:bg-green-100 transition-all duration-200 group">
                        <i class="fas fa-microchip text-green-600 group-hover:scale-110 transition-transform duration-200"></i>
                        <span class="font-semibold">Manage Devices</span>
                    </a>
                </div>
            </div>

            <!-- Pusher Notifications -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bell text-red-600"></i>
                        </div>
                        Live Notifications
                    </h3>
                </div>
                <div class="max-h-64 overflow-y-auto" id="notificationsContainer">
                    <div class="divide-y divide-gray-100">
                        <div class="p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-fire text-red-600 text-xs"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">System connected</p>
                                    <p class="text-xs text-gray-500 mt-1">Ready to receive live alerts</p>
                                </div>
                                <span class="text-xs text-gray-400">Just now</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-100 bg-gray-50">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500" id="pusherStatus">Pusher: Connected</span>
                        <button id="clearNotifications" class="text-gray-500 hover:text-red-600 transition-colors">
                            Clear All
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mark Reason Modal -->
<div id="markReasonModal" class="modal fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-4 border w-full max-w-md shadow-2xl rounded-2xl bg-white transform transition-all duration-300 scale-95">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Mark Location</h3>
            <button onclick="hideMarkModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                <p class="text-gray-600 bg-gray-50 p-3 rounded-xl" id="markAddressLabel">No address selected</p>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Reason for Marking *</label>
                <input type="text" id="markReasonInput" placeholder="Enter reason for marking this location..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
            </div>
            <div class="flex gap-3 pt-2">
                <button onclick="hideMarkModal()" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5">
                    Cancel
                </button>
                <button id="saveMarkBtn" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition-all duration-200 transform hover:-translate-y-0.5">
                    Mark Location
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Unmark Confirmation Modal -->
<div id="unmarkConfirmModal" class="modal fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-4 border w-full max-w-md shadow-2xl rounded-2xl bg-white transform transition-all duration-300 scale-95">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Unmark Location</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to remove this marked location?</p>
            <div class="flex gap-3">
                <button id="cancelUnmark" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5">
                    Keep
                </button>
                <button id="confirmUnmark" class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:-translate-y-0.5">
                    Remove
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .mark-item { transition: all 0.2s ease; }
    .mark-item:hover { transform: translateX(4px); }
    .pulse { animation: pulse 2s infinite; }
    .pulse-slow { animation: pulse 3s infinite; }
    .pulse-fast { animation: pulse 1s infinite; }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
    .report-item:hover {
        background-color: #f9fafb;
        cursor: pointer;
    }
    .highlight-marker {
        animation: highlight-pulse 1.5s infinite;
        z-index: 1000 !important;
    }
    @keyframes highlight-pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }
    .modal.active {
        display: block !important;
    }
    .modal.active .scale-95 {
        transform: scale(1) !important;
    }
    .leaflet-container {
        font-family: 'Poppins', sans-serif !important;
    }
    .notification-item {
        animation: slideInRight 0.3s ease-out;
    }
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    /* Clean marker styles */
    .custom-marker {
        background: none !important;
        border: none !important;
    }
    .incident-icon {
        font-size: 18px;
        color: #dc2626;
        filter: drop-shadow(2px 2px 2px rgba(0,0,0,0.3));
    }
    .marker-icon {
        font-size: 20px;
        color: #dc2626;
        filter: drop-shadow(2px 2px 2px rgba(0,0,0,0.3));
    }
    .search-icon {
        font-size: 16px;
        color: #2563eb;
        filter: drop-shadow(2px 2px 2px rgba(0,0,0,0.3));
    }
    .location-icon {
        font-size: 16px;
        color: #7c3aed;
        filter: drop-shadow(2px 2px 2px rgba(0,0,0,0.3));
    }
</style>

<script>
// Global variables
let map;
let marked = [];
let selectedLat, selectedLon, selectedAddress;
let unmarkIndex = null;
let incidentMarkers = {};
let reports = @json($allIncidents);
console.log('Loaded reports:', reports);
let refreshInterval;
let currentLocationMarker = null;
let pusher = null;
let notificationCount = 0;

// Wait for the page to fully load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard loaded, initializing map system...');
    
    // Initialize the chart
    initializeLocationsChart();
    
    // Initialize the map system
    setTimeout(initializeMapSystem, 100);
    
    // Set up real-time updates
    setupRealTimeUpdates();
    
    // Initialize Pusher for real-time notifications
    initializePusher();
});

function initializeLocationsChart() {
    const ctx = document.getElementById('locationsChart').getContext('2d');
    
    // Get data from PHP
    const locationLabels = @json($locationLabels);
    const locationCounts = @json($locationCounts);
    
    // Generate colors based on incident count (darker red for higher counts)
    const backgroundColors = locationCounts.map(count => {
        const intensity = Math.min(0.3 + (count / Math.max(...locationCounts)) * 0.7, 1);
        return `rgba(220, 38, 38, ${intensity})`;
    });
    
    const borderColors = locationCounts.map(count => {
        const intensity = Math.min(0.5 + (count / Math.max(...locationCounts)) * 0.5, 1);
        return `rgba(185, 28, 28, ${intensity})`;
    });
    
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: locationLabels,
            datasets: [{
                label: 'Number of Incidents',
                data: locationCounts,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Incidents: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Incidents'
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Locations'
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            onClick: (e, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const location = locationLabels[index];
                    
                    // Search for this location on the map
                    document.getElementById('searchAddress').value = location;
                    document.getElementById('goToAddress').click();
                    
                    // Show notification
                    showNotification(`Searching for ${location} on map...`, 'info');
                }
            }
        }
    });
    
    // Add chart to window for potential updates
    window.locationsChart = chart;
}

// Function to update chart with new data
function updateLocationsChart(newLabels, newCounts) {
    if (window.locationsChart) {
        window.locationsChart.data.labels = newLabels;
        window.locationsChart.data.datasets[0].data = newCounts;
        
        // Update colors
        const backgroundColors = newCounts.map(count => {
            const intensity = Math.min(0.3 + (count / Math.max(...newCounts)) * 0.7, 1);
            return `rgba(220, 38, 38, ${intensity})`;
        });
        
        const borderColors = newCounts.map(count => {
            const intensity = Math.min(0.5 + (count / Math.max(...newCounts)) * 0.5, 1);
            return `rgba(185, 28, 28, ${intensity})`;
        });
        
        window.locationsChart.data.datasets[0].backgroundColor = backgroundColors;
        window.locationsChart.data.datasets[0].borderColor = borderColors;
        window.locationsChart.update();
    }
}

function initializeMapSystem() {
    console.log('Initializing advanced map system...');
    
    // Check if Leaflet is available
    if (typeof L === 'undefined') {
        console.error('Leaflet library not loaded!');
        alert('Map library failed to load. Please refresh the page.');
        return;
    }

    // Initialize map with Koronadal as default center
    try {
        map = L.map('fireMap', {
            zoomControl: false,
            preferCanvas: true
        }).setView([6.5030, 124.8470], 13); // Koronadal coordinates and zoom level
        
        // Add zoom control to top right
        L.control.zoom({
            position: 'topright'
        }).addTo(map);
        
        // Add multiple tile layers for better performance
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Add scale control
        L.control.scale({ imperial: false }).addTo(map);
        
        // Add click event to map for marking locations
        map.on('click', function(e) {
            handleMapClick(e);
        });
        
        console.log('Advanced map initialized successfully with Koronadal center');
    } catch (error) {
        console.error('Error initializing map:', error);
        alert('Failed to initialize map. Please check console for details.');
        return;
    }

    // Load and display incidents with actual coordinates
    loadIncidentsWithCoordinates();

    // Load saved marks
    loadSavedMarks();
    
    // Set up map controls
    setupMapControls();

    console.log('Advanced map system fully initialized');
}

function handleMapClick(e) {
    selectedLat = e.latlng.lat;
    selectedLon = e.latlng.lng;
    
    // Reverse geocode to get address
    reverseGeocode(selectedLat, selectedLon).then(address => {
        selectedAddress = address;
        
        // Show mark modal
        document.getElementById('markAddressLabel').textContent = selectedAddress;
        document.getElementById('markReasonInput').value = '';
        showMarkModal();
    }).catch(error => {
        console.error('Error reverse geocoding:', error);
        selectedAddress = `Lat: ${selectedLat.toFixed(6)}, Lng: ${selectedLon.toFixed(6)}`;
        document.getElementById('markAddressLabel').textContent = selectedAddress;
        document.getElementById('markReasonInput').value = '';
        showMarkModal();
    });
}

async function reverseGeocode(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
        const data = await response.json();
        
        if (data && data.display_name) {
            return data.display_name;
        } else {
            return `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
        }
    } catch (error) {
        console.error('Error reverse geocoding:', error);
        return `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
    }
}

function loadIncidentsWithCoordinates() {
    console.log('Loading incidents with coordinates...');
    
    const priorityCounts = {
        critical: 0,
        high: 0,
        medium: 0,
        low: 0
    };

    reports.forEach(incident => {
        // Check if incident has mapping coordinates
        if (incident.mapping && incident.mapping.latitude && incident.mapping.longitude) {
            addIncidentMarker(incident, incident.mapping.latitude, incident.mapping.longitude);
            priorityCounts[incident.priority] = (priorityCounts[incident.priority] || 0) + 1;
        } else {
            console.warn('Incident missing coordinates:', incident.id, incident.location);
            // Try to geocode if no coordinates but has location
            if (incident.location && incident.location !== 'Unknown location') {
                geocodeAndAddIncident(incident, priorityCounts);
            }
        }
    });

    // Update priority counts
    updatePriorityCounts(priorityCounts);
}

async function geocodeAndAddIncident(incident, priorityCounts) {
    try {
        const searchQuery = await improveSearchQuery(incident.location);
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery)}&limit=1&countrycodes=ph`);
        const data = await response.json();
        
        if (data && data.length > 0) {
            const lat = parseFloat(data[0].lat);
            const lon = parseFloat(data[0].lon);
            
            addIncidentMarker(incident, lat, lon);
            priorityCounts[incident.priority] = (priorityCounts[incident.priority] || 0) + 1;
        } else {
            console.error('Geocoding failed for location:', incident.location);
        }
    } catch (error) {
        console.error('Error geocoding location:', incident.location, error);
    }
}

function addIncidentMarker(incident, lat, lon) {
    const priority = incident.priority || 'medium';
    const status = incident.status || 'pending';
    
    // Status-based pulsing effects
    let pulseClass = '';
    if (status === 'pending') {
        pulseClass = 'pending-pulse';
    } else if (status === 'in-progress') {
        pulseClass = 'in-progress-pulse';
    }

    const marker = L.marker([lat, lon], {
        icon: L.divIcon({
            className: `custom-marker ${pulseClass}`,
            html: `
                <div class="relative">
                    <i class="fas fa-fire incident-icon"></i>
                    ${status !== 'resolved' ? '<div class="absolute inset-0 rounded-full border-2 border-current opacity-50" style="animation: inherit;"></div>' : ''}
                </div>
            `,
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        })
    }).addTo(map).bindPopup(`
        <div class="p-3 min-w-[250px]">
            <h4 class="font-bold text-gray-900 text-sm mb-2">${incident.title || 'No Title'}</h4>
            <div class="space-y-1 text-xs">
                <p class="text-gray-600"><i class="fas fa-map-marker-alt mr-1"></i> ${incident.location || 'Unknown location'}</p>
                <p class="text-gray-500">Status: <span class="font-semibold ${getStatusColor(incident.status)}">${incident.status || 'N/A'}</span></p>
                <p class="text-gray-500">Priority: <span class="font-semibold ${getPriorityColor(priority)}">${priority}</span></p>
                ${incident.description ? `<p class="text-gray-500 mt-2">${incident.description}</p>` : ''}
            </div>
            <button onclick="window.viewIncident(${incident.id})" class="mt-3 w-full px-3 py-2 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700 transition-colors font-semibold">
                <i class="fas fa-external-link-alt mr-1"></i>View Details
            </button>
        </div>
    `);
    
    incidentMarkers[incident.id] = marker;
    console.log(`Added marker for incident ${incident.id} at ${lat}, ${lon}`);
}

function getStatusColor(status) {
    const colors = {
        'pending': 'text-yellow-600',
        'in-progress': 'text-blue-600',
        'resolved': 'text-green-600'
    };
    return colors[status] || 'text-gray-600';
}

function getPriorityColor(priority) {
    const colors = {
        'critical': 'text-purple-600',
        'high': 'text-red-600',
        'medium': 'text-orange-600',
        'low': 'text-green-600'
    };
    return colors[priority] || 'text-gray-600';
}

function updatePriorityCounts(counts) {
    document.getElementById('criticalCount').textContent = counts.critical || 0;
    document.getElementById('highCount').textContent = counts.high || 0;
    document.getElementById('mediumCount').textContent = counts.medium || 0;
    document.getElementById('lowCount').textContent = counts.low || 0;
}

function loadSavedMarks() {
    try {
        const savedMarks = JSON.parse(localStorage.getItem('markedPlaces') || '[]');
        savedMarks.forEach(m => {
            const marker = createNormalMarker(m.lat, m.lon);
            marker.addTo(map).bindPopup(`<div class="p-2"><b>${m.address}</b><br>${m.reason}</div>`);
            
            marked.push({ ...m, marker });
        });
        console.log(`Loaded ${savedMarks.length} saved marks`);
        updateMarkDetails();
    } catch (error) {
        console.error('Error loading saved marks:', error);
    }
}

function createNormalMarker(lat, lon) {
    return L.marker([lat, lon], {
        icon: L.divIcon({
            className: 'custom-marker',
            html: `<i class="fas fa-map-pin marker-icon"></i>`,
            iconSize: [30, 30],
            iconAnchor: [15, 30]
        })
    });
}

function setupMapControls() {
    // Search address with improved geocoding
    document.getElementById('goToAddress').addEventListener('click', async function () {
        const address = document.getElementById('searchAddress').value.trim();
        if(!address) {
            alert('Please enter a location to search.');
            return;
        }
        
        console.log('Searching for location:', address);
        
        try {
            // Improved search with Philippines context
            const searchQuery = await improveSearchQuery(address);
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery)}&limit=1&countrycodes=ph`);
            const data = await response.json();
            
            if (data && data.length > 0) {
                selectedLat = parseFloat(data[0].lat);
                selectedLon = parseFloat(data[0].lon);
                selectedAddress = data[0].display_name;
                
                map.setView([selectedLat, selectedLon], 15);
                
                // Remove existing searched marker
                if (window.searchedMarker) {
                    map.removeLayer(window.searchedMarker);
                }
                
                // Add new searched marker
                window.searchedMarker = L.marker([selectedLat, selectedLon], {
                    icon: L.divIcon({
                        className: 'custom-marker pulse',
                        html: `<i class="fas fa-search search-icon"></i>`,
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    })
                }).addTo(map).bindPopup(`<b>Found Location</b><br>${selectedAddress}`).openPopup();
                
                console.log('Location found:', selectedAddress, 'at', selectedLat, selectedLon);
            } else {
                alert('Location not found. Please try a different search term.');
            }
        } catch (error) {
            console.error('Error searching location:', error);
            alert('Error searching location. Please try again.');
        }
    });

    // Mark place
    document.getElementById('markPlace').addEventListener('click', function() {
        if(!selectedAddress) {
            alert('Please search and select a location first by using the Search button or clicking on the map.');
            return;
        }
        
        document.getElementById('markAddressLabel').textContent = selectedAddress;
        document.getElementById('markReasonInput').value = '';
        showMarkModal();
    });

    // Save mark
    document.getElementById('saveMarkBtn').addEventListener('click', function() {
        const reason = document.getElementById('markReasonInput').value.trim();
        if(!reason) {
            alert('Please enter a reason for marking this location.');
            return;
        }
        
        const marker = createNormalMarker(selectedLat, selectedLon);
        marker.addTo(map).bindPopup(`<b>${selectedAddress}</b><br>${reason}`);
        
        const newMark = { 
            address: selectedAddress, 
            lat: selectedLat, 
            lon: selectedLon, 
            reason: reason, 
            timestamp: new Date().toLocaleString() 
        };
        
        marked.push({ ...newMark, marker });
        saveMarks();
        updateMarkDetails();
        hideMarkModal();
        
        console.log('Location marked:', newMark);
        showNotification('Location marked successfully!', 'success');
    });

    // Get current location
    document.getElementById('getCurrentLocation').addEventListener('click', function() {
        getCurrentLocation();
    });

    // Clear all marks
    document.getElementById('clearMarks').addEventListener('click', function() {
        if (marked.length === 0) {
            showNotification('No marks to clear!', 'info');
            return;
        }
        
        if (confirm('Are you sure you want to clear all marked locations?')) {
            marked.forEach(m => {
                map.removeLayer(m.marker);
            });
            marked = [];
            saveMarks();
            updateMarkDetails();
            showNotification('All marks cleared!', 'success');
        }
    });

    // Refresh map
    document.getElementById('refreshMap').addEventListener('click', function() {
        refreshMapData();
    });

    // Unmark handlers
    document.getElementById('cancelUnmark').addEventListener('click', function(){
        hideUnmarkModal();
    });

    document.getElementById('confirmUnmark').addEventListener('click', function(){
        if(unmarkIndex !== null && marked[unmarkIndex]) {
            map.removeLayer(marked[unmarkIndex].marker);
            marked.splice(unmarkIndex, 1);
            saveMarks();
            updateMarkDetails();
            unmarkIndex = null;
            console.log('Location unmarked');
            showNotification('Location removed successfully!', 'success');
        }
        hideUnmarkModal();
    });

    // Report click handlers
    document.querySelectorAll('.report-item').forEach(item => {
        item.addEventListener('click', function() {
            const reportId = this.getAttribute('data-report-id');
            const latitude = this.getAttribute('data-latitude');
            const longitude = this.getAttribute('data-longitude');
            
            focusOnReport(reportId, latitude, longitude);
        });
    });

    // Enter key for search
    document.getElementById('searchAddress').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('goToAddress').click();
        }
    });

    // Refresh reports button
    document.getElementById('refreshReports').addEventListener('click', function() {
        refreshReports();
    });

    // Clear notifications
    document.getElementById('clearNotifications').addEventListener('click', function() {
        clearNotifications();
    });
}

// Helper function to improve search queries
async function improveSearchQuery(address) {
    const knownLocations = {
        'koronadal': 'Koronadal City, South Cotabato, Philippines',
        'gensan': 'General Santos City, South Cotabato, Philippines',
        'general santos': 'General Santos City, South Cotabato, Philippines',
        'davao': 'Davao City, Davao del Sur, Philippines',
        'davao city': 'Davao City, Davao del Sur, Philippines',
        'manila': 'Manila, Metro Manila, Philippines',
        'cebu': 'Cebu City, Cebu, Philippines',
        'cebu city': 'Cebu City, Cebu, Philippines',
        'cotabato': 'Cotabato City, Maguindanao, Philippines',
        'zamboanga': 'Zamboanga City, Zamboanga del Sur, Philippines',
        'cagayan de oro': 'Cagayan de Oro City, Misamis Oriental, Philippines',
        'iloilo': 'Iloilo City, Iloilo, Philippines',
        'bacolod': 'Bacolod City, Negros Occidental, Philippines',
        'tacurong': 'Tacurong City, Sultan Kudarat, Philippines',
        'surallah': 'Surallah, South Cotabato, Philippines',
        'tupi': 'Tupi, South Cotabato, Philippines',
        'polomolok': 'Polomolok, South Cotabato, Philippines'
    };
    
    const lowerAddress = address.toLowerCase().trim();
    
    // Check for known locations
    for (const [key, value] of Object.entries(knownLocations)) {
        if (lowerAddress.includes(key)) {
            console.log(`Improved search query from "${address}" to "${value}"`);
            return value;
        }
    }
    
    // Add Philippines context if not present
    if (!lowerAddress.includes('philippines')) {
        const improvedQuery = address + ', Philippines';
        console.log(`Improved search query from "${address}" to "${improvedQuery}"`);
        return improvedQuery;
    }
    
    console.log(`Using original search query: "${address}"`);
    return address;
}

function getCurrentLocation() {
    if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser');
        return;
    }

    showNotification('Getting your location...', 'info');
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            // Remove existing current location marker
            if (currentLocationMarker) {
                map.removeLayer(currentLocationMarker);
            }
            
            // Add current location marker
            currentLocationMarker = L.marker([lat, lng], {
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: `
                        <div class="relative">
                            <i class="fas fa-location-crosshairs location-icon"></i>
                            <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full whitespace-nowrap">
                                You are here
                            </div>
                        </div>
                    `,
                    iconSize: [80, 40],
                    iconAnchor: [40, 40]
                })
            }).addTo(map).bindPopup('<b>Your Current Location</b><br>You are here').openPopup();
            
            // Center map on current location
            map.setView([lat, lng], 16);
            
            showNotification('Location found!', 'success');
        },
        function(error) {
            console.error('Error getting location:', error);
            let message = 'Unable to retrieve your location';
            
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    message = 'Location access denied by user';
                    break;
                case error.POSITION_UNAVAILABLE:
                    message = 'Location information unavailable';
                    break;
                case error.TIMEOUT:
                    message = 'Location request timed out';
                    break;
            }
            
            showNotification(message, 'error');
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000
        }
    );
}

function focusOnReport(reportId, latitude, longitude) {
    // If we have specific coordinates, use them
    if (latitude && longitude) {
        map.setView([parseFloat(latitude), parseFloat(longitude)], 16, { animate: true, duration: 1 });
        
        // If we have a marker for this report, highlight it
        if (incidentMarkers[reportId]) {
            const marker = incidentMarkers[reportId];
            marker.openPopup();
            
            const markerElement = marker.getElement();
            if (markerElement) {
                markerElement.classList.add('highlight-marker');
                setTimeout(() => {
                    markerElement.classList.remove('highlight-marker');
                }, 3000);
            }
        }
    } 
    // Otherwise try to use the marker if it exists
    else if (incidentMarkers[reportId]) {
        const marker = incidentMarkers[reportId];
        const latLng = marker.getLatLng();
        map.setView([latLng.lat, latLng.lng], 16, { animate: true, duration: 1 });
        
        const markerElement = marker.getElement();
        if (markerElement) {
            markerElement.classList.add('highlight-marker');
            setTimeout(() => {
                markerElement.classList.remove('highlight-marker');
            }, 3000);
        }
        
        marker.openPopup();
    }
    
    console.log('Focused on report:', reportId);
}

function setupRealTimeUpdates() {
    // Update timestamp every minute
    setInterval(() => {
        document.getElementById('mapLastUpdate').textContent = 'Updated ' + new Date().toLocaleTimeString();
    }, 60000);

    // Simulate real-time connection status
    setInterval(() => {
        const statusElement = document.getElementById('connectionStatus');
        statusElement.textContent = 'Connected';
        statusElement.className = 'text-xs text-green-500';
    }, 5000);

    // Refresh reports every 30 seconds
    refreshInterval = setInterval(refreshReports, 30000);
}

function initializePusher() {
    // Check if Pusher is available
    if (typeof Pusher === 'undefined') {
        console.warn('Pusher library not loaded. Real-time notifications disabled.');
        document.getElementById('pusherStatus').textContent = 'Pusher: Not Available';
        return;
    }

    try {
        // Initialize Pusher with your credentials
        pusher = new Pusher('{{ env("PUSHER_APP_KEY", "your-pusher-key") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER", "mt1") }}',
            encrypted: true
        });

        // Subscribe to the incidents channel
        const channel = pusher.subscribe('incidents');

        // Listen for new incidents
        channel.bind('new-incident', function(data) {
            console.log('New incident received:', data);
            addNotification(data);
            showNotification(`New incident: ${data.title}`, 'warning');
            
            // Add the new incident to the map if it has coordinates
            if (data.latitude && data.longitude) {
                addIncidentMarker(data, data.latitude, data.longitude);
            }
        });

        // Listen for incident updates
        channel.bind('incident-updated', function(data) {
            console.log('Incident updated:', data);
            addNotification({
                title: 'Incident Updated',
                message: `${data.title} status changed to ${data.status}`,
                type: 'info',
                timestamp: new Date().toISOString()
            });
            
            // Update the incident marker if it exists
            if (incidentMarkers[data.id]) {
                map.removeLayer(incidentMarkers[data.id]);
                addIncidentMarker(data, data.latitude, data.longitude);
            }
        });

        document.getElementById('pusherStatus').textContent = 'Pusher: Connected';
        console.log('Pusher initialized successfully');
    } catch (error) {
        console.error('Error initializing Pusher:', error);
        document.getElementById('pusherStatus').textContent = 'Pusher: Error';
    }
}

function addNotification(data) {
    const container = document.getElementById('notificationsContainer');
    const notification = document.createElement('div');
    notification.className = 'notification-item p-4 border-b border-gray-100';
    
    const typeIcon = data.type === 'warning' ? 'fa-exclamation-triangle' : 
                    data.type === 'info' ? 'fa-info-circle' : 'fa-bell';
    const typeColor = data.type === 'warning' ? 'text-red-600' : 
                     data.type === 'info' ? 'text-blue-600' : 'text-yellow-600';
    const typeBg = data.type === 'warning' ? 'bg-red-100' : 
                  data.type === 'info' ? 'bg-blue-100' : 'bg-yellow-100';
    
    notification.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 ${typeBg} rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas ${typeIcon} ${typeColor} text-xs"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">${data.title || 'New Alert'}</p>
                <p class="text-xs text-gray-500 mt-1">${data.message || data.description || 'New incident reported'}</p>
            </div>
            <span class="text-xs text-gray-400">Just now</span>
        </div>
    `;
    
    // Add to top of container
    container.insertBefore(notification, container.firstChild);
    
    // Limit to 10 notifications
    if (container.children.length > 10) {
        container.removeChild(container.lastChild);
    }
    
    notificationCount++;
    updateNotificationBadge();
}

function clearNotifications() {
    const container = document.getElementById('notificationsContainer');
    container.innerHTML = `
        <div class="p-4">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-green-600 text-xs"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Notifications cleared</p>
                    <p class="text-xs text-gray-500 mt-1">All notifications have been cleared</p>
                </div>
                <span class="text-xs text-gray-400">Just now</span>
            </div>
        </div>
    `;
    
    notificationCount = 0;
    updateNotificationBadge();
}

function updateNotificationBadge() {
    // You can implement a badge on the notification icon if needed
    // For now, we'll just update the count in the console
    console.log(`Active notifications: ${notificationCount}`);
}

async function refreshReports() {
    try {
        const response = await fetch('/admin/incidents/map-data');
        const data = await response.json();
        
        if (data.success && JSON.stringify(data.incidents) !== JSON.stringify(reports)) {
            reports = data.incidents;
            updateReportsDisplay();
            updateIncidentsOnMap();
            showNotification('Reports updated!', 'info');
        }
    } catch (error) {
        console.error('Error refreshing reports:', error);
    }
}

function refreshMapData() {
    showNotification('Refreshing map data...', 'info');
    refreshReports();
}

function updateReportsDisplay() {
    const container = document.getElementById('reportsContainer');
    container.innerHTML = '';
    
    if (reports.length === 0) {
        container.innerHTML = `
            <div class="p-6 text-center">
                <i class="fas fa-inbox text-gray-300 text-3xl mb-3"></i>
                <p class="text-gray-500">No recent reports</p>
            </div>`;
        return;
    }

    const reportsList = document.createElement('div');
    reportsList.className = 'divide-y divide-gray-100';
    
    reports.forEach(report => {
        const reportItem = document.createElement('div');
        reportItem.className = 'p-4 hover:bg-gray-50 transition-colors duration-200 cursor-pointer group report-item animate-fade-in';
        reportItem.setAttribute('data-report-id', report.id);
        reportItem.setAttribute('data-location', report.location);
        reportItem.setAttribute('data-title', report.title);
        reportItem.setAttribute('data-status', report.status);
        reportItem.setAttribute('data-priority', report.priority || 'medium');
        reportItem.setAttribute('data-latitude', report.latitude || '');
        reportItem.setAttribute('data-longitude', report.longitude || '');
        
        reportItem.innerHTML = `
            <div class="flex items-start justify-between mb-2">
                <h4 class="font-semibold text-gray-900 group-hover:text-red-600 transition-colors duration-200">
                    ${report.title}
                </h4>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold 
                    ${report.status === 'resolved' ? 'bg-green-100 text-green-800' : 
                       (report.status === 'in-progress' ? 'bg-blue-100 text-blue-800' : 
                       (report.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-purple-100 text-purple-800'))}">
                    ${ucfirst(report.status)}
                </span>
            </div>
            <p class="text-sm text-gray-600 mb-2 flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-red-500 text-xs"></i>
                ${report.location || 'Unknown location'}
            </p>
            <div class="flex items-center justify-between text-xs text-gray-500">
                <span>${new Date(report.created_at).toLocaleDateString()}</span>
                <span class="flex items-center gap-1">
                    <i class="fas fa-eye"></i>
                    View
                </span>
            </div>
        `;
        
        reportItem.addEventListener('click', function() {
            focusOnReport(report.id, report.latitude, report.longitude);
        });
        
        reportsList.appendChild(reportItem);
    });
    
    container.appendChild(reportsList);
}

function updateIncidentsOnMap() {
    // Remove existing incident markers
    Object.values(incidentMarkers).forEach(marker => {
        map.removeLayer(marker);
    });
    incidentMarkers = {};
    
    // Add updated incident markers
    loadIncidentsWithCoordinates();
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-lg transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        type === 'warning' ? 'bg-yellow-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation' : 'info'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Helper functions
function saveMarks() {
    try {
        const stored = marked.map(m => ({ 
            address: m.address, 
            lat: m.lat, 
            lon: m.lon, 
            reason: m.reason, 
            timestamp: m.timestamp 
        }));
        localStorage.setItem('markedPlaces', JSON.stringify(stored));
    } catch (error) {
        console.error('Error saving marks:', error);
    }
}

function updateMarkDetails() {
    const container = document.getElementById('markList');
    const count = document.getElementById('markCount');
    
    container.innerHTML = '';
    count.textContent = `${marked.length} marked`;
    
    if(marked.length === 0) { 
        container.innerHTML = '<p class="text-gray-500 text-sm text-center py-4">No locations marked yet</p>'; 
        return; 
    }

    marked.forEach((m, i) => {
        const markItem = document.createElement('div');
        markItem.className = 'mark-item flex justify-between items-center p-3 bg-white rounded-lg border border-gray-200 cursor-pointer transition-all duration-200 animate-fade-in';
        markItem.innerHTML = `
            <div class="flex-1">
                <div class="font-medium text-gray-900 text-sm">${m.address}</div>
                <div class="text-xs text-gray-600 mt-1">${m.reason}</div>
                <div class="text-xs text-gray-400 mt-1">${m.timestamp}</div>
            </div>
            <button class="unmark-btn text-red-500 hover:text-red-700 transition-colors duration-200 p-2 rounded-lg hover:bg-red-50">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        // Add click event to focus on the marked location
        markItem.querySelector('.flex-1').addEventListener('click', function() {
            map.setView([m.lat, m.lon], 17, { animate: true });
            m.marker.openPopup();
            
            // Highlight the marker
            const markerElement = m.marker.getElement();
            if (markerElement) {
                markerElement.classList.add('highlight-marker');
                setTimeout(() => {
                    markerElement.classList.remove('highlight-marker');
                }, 3000);
            }
        });
        
        // Add click event to remove the marked location
        markItem.querySelector('.unmark-btn').addEventListener('click', function(e) {
            e.stopPropagation();
            unmarkIndex = i;
            showUnmarkModal();
        });
        
        container.appendChild(markItem);
    });
}

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// Global functions
window.viewIncident = function(incidentId) {
    window.location.href = `/admin/incidents/${incidentId}`;
};

window.focusReport = function(reportId) {
    focusOnReport(reportId);
};

// Modal functions
function showMarkModal() {
    const modal = document.getElementById('markReasonModal');
    modal.classList.remove('hidden');
    modal.classList.add('active');
    setTimeout(() => {
        modal.querySelector('.scale-95').style.transform = 'scale(1)';
    }, 10);
}

function hideMarkModal() {
    const modal = document.getElementById('markReasonModal');
    const content = modal.querySelector('.scale-95');
    content.style.transform = 'scale(0.95)';
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('active');
    }, 300);
}

function showUnmarkModal() {
    const modal = document.getElementById('unmarkConfirmModal');
    modal.classList.remove('hidden');
    modal.classList.add('active');
    setTimeout(() => {
        modal.querySelector('.scale-95').style.transform = 'scale(1)';
    }, 10);
}

function hideUnmarkModal() {
    const modal = document.getElementById('unmarkConfirmModal');
    const content = modal.querySelector('.scale-95');
    content.style.transform = 'scale(0.95)';
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('active');
    }, 300);
}

// Close modals on backdrop click
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
        if (e.target.id === 'markReasonModal') hideMarkModal();
        if (e.target.id === 'unmarkConfirmModal') hideUnmarkModal();
    }
});

// Clean up on page unload
window.addEventListener('beforeunload', function() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
    
    if (pusher) {
        pusher.disconnect();
    }
});
</script>

<!-- Include Pusher library -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
@endsection