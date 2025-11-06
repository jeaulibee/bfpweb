@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
@php
use App\Models\Incident;
use App\Models\Alert;
use App\Models\Device;

// Dynamic data
$alerts = Alert::latest()->take(5)->get();
$incidents = Incident::with('mapping')->latest()->take(5)->get();
$devices = Device::all();

// Stats for dashboard - Fixed queries
$activeAlerts = Alert::count();
$activeIncidents = Incident::count();
$totalDevices = Device::count();
$onlineDevices = Device::count();
@endphp

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }} 👋</h1>
                    <p class="text-gray-600 mt-1">Here's an overview of your assigned incidents and devices.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <button 
                        class="bg-gradient-to-r from-red-600 to-red-700 text-white px-5 py-2.5 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg flex items-center font-medium group"
                        onclick="openModal()">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Incident
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Active Alerts Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-red-50 text-red-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Alerts</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $activeAlerts }}</h3>
                    </div>
                </div>
            </div>

            <!-- Active Incidents Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-orange-50 text-orange-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Incidents</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $activeIncidents }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Devices Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Devices</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $totalDevices }}</h3>
                    </div>
                </div>
            </div>

            <!-- Online Devices Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-green-50 text-green-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Devices Online</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $onlineDevices }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Incident Map -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            Interactive Incident Map
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Click anywhere on the map to mark locations</p>
                    </div>
                    <div class="p-4">
                        <div id="fireMap" class="h-96 rounded-xl overflow-hidden relative z-0 border border-gray-200"></div>
                        
                        <!-- Map Controls -->
                        <div class="mt-4 flex flex-col sm:flex-row gap-3">
                            <div class="flex-1 relative">
                                <input id="searchAddress" type="text" placeholder="Search address or location..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition pl-10">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div class="flex gap-2">
                                <button id="goToAddress" class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-md hover:shadow-lg flex items-center font-medium group flex-1">
                                    <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Search
                                </button>
                                <button id="clearMarkers" class="px-4 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-md hover:shadow-lg flex items-center font-medium group">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Marked Locations -->
                        <div id="markDetails" class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-xl h-40 overflow-y-auto">
                            <div class="flex items-center justify-center h-full text-gray-500">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p>No locations marked yet. Click on the map to mark locations.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- Recent Alerts -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            Recent Fire Alerts
                        </h2>
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $alerts->count() }}</span>
                    </div>
                    <div class="p-4">
                        <ul class="space-y-3">
                            @forelse($alerts as $alert)
                                <li class="p-3 rounded-lg bg-red-50 border border-red-100 hover:bg-red-100 transition-all duration-200 transform hover:scale-[1.02]">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $alert->message }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $alert->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center py-4 text-gray-500">
                                    <svg class="w-8 h-8 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="mt-2">No alerts found</p>
                                </li>
                            @endforelse
                        </ul>
                        <a href="{{ route('staff.alerts.index') }}" class="block mt-4 text-center text-red-600 hover:text-red-800 font-medium py-2 border border-red-200 rounded-lg hover:bg-red-50 transition-all duration-200">
                            View all alerts
                        </a>
                    </div>
                </div>

                <!-- Assigned Incidents -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                            </svg>
                            Assigned Incidents
                        </h2>
                        <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $incidents->count() }}</span>
                    </div>
                    <div class="p-4">
                        <ul class="space-y-3">
                            @forelse($incidents as $incident)
                                <li class="p-3 rounded-lg bg-orange-50 border border-orange-100 hover:bg-orange-100 transition-all duration-200 transform hover:scale-[1.02]">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">#{{ $incident->id }} - {{ $incident->location ?? 'N/A' }}</p>
                                            <div class="flex items-center mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ ucfirst($incident->status ?? 'Unknown') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center py-4 text-gray-500">
                                    <svg class="w-8 h-8 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="mt-2">No incidents assigned</p>
                                </li>
                            @endforelse
                        </ul>
                        <a href="{{ route('staff.incidents.index') }}" class="block mt-4 text-center text-orange-600 hover:text-orange-800 font-medium py-2 border border-orange-200 rounded-lg hover:bg-orange-50 transition-all duration-200">
                            View incidents
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Incident Modal -->
<div id="addIncidentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gradient-to-r from-gray-50 to-white rounded-t-2xl">
            <h3 class="text-lg font-semibold text-gray-900">Add New Incident</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition p-1 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="{{ route('staff.incidents.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label class="block mb-2 font-medium text-gray-700">Title</label>
                    <input type="text" name="title" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" required>
                </div>
                <div>
                    <label class="block mb-2 font-medium text-gray-700">Location</label>
                    <input type="text" name="location" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" required>
                </div>
                <div>
                    <label class="block mb-2 font-medium text-gray-700">Description</label>
                    <textarea name="description" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" rows="3" required></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 rounded-b-2xl flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium shadow-md hover:shadow-lg">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Mark Location Modal -->
<div id="markLocationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95 opacity-0" id="markModalContent">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gradient-to-r from-gray-50 to-white rounded-t-2xl">
            <h3 class="text-lg font-semibold text-gray-900">Mark Location</h3>
            <button onclick="closeMarkModal()" class="text-gray-400 hover:text-gray-600 transition p-1 rounded-lg hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block mb-2 font-medium text-gray-700">Address</label>
                <input type="text" id="markAddress" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" readonly>
            </div>
            <div>
                <label class="block mb-2 font-medium text-gray-700">Coordinates</label>
                <input type="text" id="markCoordinates" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" readonly>
            </div>
            <div>
                <label class="block mb-2 font-medium text-gray-700">Reason</label>
                <textarea id="markReason" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" rows="3" placeholder="Enter reason for marking this location..."></textarea>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 rounded-b-2xl flex justify-end space-x-3">
            <button type="button" onclick="closeMarkModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">Cancel</button>
            <button type="button" onclick="confirmMarkLocation()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium shadow-md hover:shadow-lg">Mark Location</button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
    .leaflet-pane, .leaflet-top, .leaflet-bottom { z-index: 1 !important; }
    .custom-marker {
        background: #ef4444;
        border: 3px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    .marked-marker {
        background: #10b981;
        border: 3px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    .pulse-dot {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        70% { transform: scale(3); opacity: 0; }
        100% { transform: scale(1); opacity: 0; }
    }
    .notification-glow {
        animation: glow 2s ease-in-out infinite alternate;
    }
    @keyframes glow {
        from {
            box-shadow: 0 0 5px #ef4444, 0 0 10px #ef4444, 0 0 15px #ef4444;
        }
        to {
            box-shadow: 0 0 10px #ef4444, 0 0 15px #ef4444, 0 0 20px #ef4444;
        }
    }
</style>

<script>
// Global variables
let map;
let marked = [];
let incidentMarkers = [];
let tempMarker = null;
let clickMarker = null;
let currentClickLatLng = null;

// Debug function to check if script is running
console.log('Dashboard script loaded');

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded');
    initializeMap();
    initializeEventListeners();
});

function initializeMap() {
    console.log('Initializing map...');
    
    // Initialize map
    map = L.map('fireMap').setView([14.5, 121.0], 6);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Add click event to map for marking locations
    map.on('click', function(e) {
        console.log('Map clicked at:', e.latlng);
        handleMapClick(e);
    });

    // Load incident markers
    loadIncidentMarkers();
    
    // Load previously marked locations
    loadSavedMarks();
    
    console.log('Map initialized successfully');
}

function initializeEventListeners() {
    console.log('Initializing event listeners...');
    
    // Search address functionality - SIMPLIFIED AND FIXED
    const searchButton = document.getElementById('goToAddress');
    const searchInput = document.getElementById('searchAddress');
    
    if (searchButton) {
        console.log('Search button found, adding click listener');
        searchButton.addEventListener('click', function() {
            console.log('Search button clicked');
            performSearch();
        });
    } else {
        console.error('Search button not found!');
    }
    
    if (searchInput) {
        console.log('Search input found, adding keypress listener');
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                console.log('Enter key pressed in search input');
                performSearch();
            }
        });
    }

    // Clear markers functionality
    const clearButton = document.getElementById('clearMarkers');
    if (clearButton) {
        clearButton.addEventListener('click', clearAllMarkers);
    }

    // Modal functionality
    const addIncidentButton = document.querySelector('button[onclick*="openModal"]');
    if (addIncidentButton) {
        addIncidentButton.addEventListener('click', openModal);
    }
    
    // Close modals when clicking outside
    const incidentModal = document.getElementById('addIncidentModal');
    if (incidentModal) {
        incidentModal.addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    }
    
    const markModal = document.getElementById('markLocationModal');
    if (markModal) {
        markModal.addEventListener('click', function(e) {
            if (e.target === this) closeMarkModal();
        });
    }
    
    console.log('Event listeners initialized');
}

function performSearch() {
    console.log('performSearch function called');
    const address = document.getElementById('searchAddress').value;
    const button = document.getElementById('goToAddress');
    
    console.log('Searching for:', address);
    
    if (!address || address.trim() === '') {
        console.log('No address provided');
        showNotification('Please enter an address to search.', 'warning');
        return;
    }
    
    // Show loading state
    const originalText = button.innerHTML;
    button.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Searching...';
    button.disabled = true;
    
    console.log('Making API request to Nominatim...');
    
    // Use a more robust search URL with proper parameters
    const searchUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1&addressdetails=1`;
    
    fetch(searchUrl)
        .then(res => {
            console.log('API response received, status:', res.status);
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            console.log('API data received:', data);
            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lng = parseFloat(data[0].lon);
                const displayName = data[0].display_name;
                
                console.log('Location found:', displayName, 'at', lat, lng);
                
                // Remove previous temp marker
                if (tempMarker) {
                    map.removeLayer(tempMarker);
                }
                
                // Add new marker and center map
                tempMarker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(`<b>Search Result</b><br>${displayName}`)
                    .openPopup();
                
                map.setView([lat, lng], 15);
                showNotification('Location found!', 'success');
            } else {
                console.log('No results found for address:', address);
                showNotification('Address not found. Please try a different search.', 'error');
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            showNotification('Search failed. Please check your connection and try again.', 'error');
        })
        .finally(() => {
            console.log('Search completed, resetting button');
            button.innerHTML = originalText;
            button.disabled = false;
        });
}

function handleMapClick(e) {
    const { lat, lng } = e.latlng;
    currentClickLatLng = e.latlng;
    
    // Remove previous click marker
    if (clickMarker) {
        map.removeLayer(clickMarker);
    }
    
    // Add a temporary marker with pulse animation
    clickMarker = L.marker([lat, lng], {
        icon: L.divIcon({
            className: 'custom-marker pulse-dot',
            html: '<div class="w-4 h-4 rounded-full bg-red-500"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        })
    }).addTo(map);
    
    // Get address from coordinates
    getAddressFromCoordinates(lat, lng).then(address => {
        document.getElementById('markAddress').value = address;
        document.getElementById('markCoordinates').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        openMarkModal();
    });
}

async function getAddressFromCoordinates(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
        const data = await response.json();
        return data.display_name || 'Address not found';
    } catch (error) {
        console.error('Error fetching address:', error);
        return 'Address lookup failed';
    }
}

function confirmMarkLocation() {
    const reason = document.getElementById('markReason').value;
    
    if (!reason.trim()) {
        showNotification('Please enter a reason for marking this location.', 'warning');
        return;
    }
    
    const { lat, lng } = currentClickLatLng;
    const address = document.getElementById('markAddress').value;
    
    // Create permanent marker
    const marker = L.marker([lat, lng], {
        icon: L.divIcon({
            className: 'marked-marker',
            html: '<div class="w-4 h-4 rounded-full bg-green-500"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        })
    }).addTo(map).bindPopup(`
        <div class="p-2">
            <h3 class="font-bold text-green-700">Marked Location</h3>
            <p class="text-sm">${address}</p>
            <p class="text-xs mt-1"><strong>Reason:</strong> ${reason}</p>
            <p class="text-xs mt-2 text-gray-500">Coordinates: ${lat.toFixed(6)}, ${lng.toFixed(6)}</p>
            <button onclick="removeMarkedLocation(${marked.length})" class="mt-2 px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition">
                Remove
            </button>
        </div>
    `);
    
    // Add to marked array
    marked.push({
        address: address,
        lat: lat,
        lng: lng,
        reason: reason,
        marker: marker
    });
    
    // Save to localStorage
    saveMarkedLocations();
    
    // Update UI
    updateMarkedPlacesList();
    
    // Clean up
    if (clickMarker) {
        map.removeLayer(clickMarker);
        clickMarker = null;
    }
    
    closeMarkModal();
    showNotification('Location marked successfully!', 'success');
}

function removeMarkedLocation(index) {
    if (marked[index]) {
        // Remove marker from map
        map.removeLayer(marked[index].marker);
        
        // Remove from array
        marked.splice(index, 1);
        
        // Update storage and UI
        saveMarkedLocations();
        updateMarkedPlacesList();
        
        showNotification('Location removed successfully!', 'success');
    }
}

function clearAllMarkers() {
    if (marked.length === 0) {
        showNotification('No markers to clear.', 'info');
        return;
    }
    
    if (confirm('Are you sure you want to remove all marked locations?')) {
        // Remove all markers from map
        marked.forEach(location => {
            map.removeLayer(location.marker);
        });
        
        // Clear array
        marked = [];
        
        // Update storage and UI
        saveMarkedLocations();
        updateMarkedPlacesList();
        
        showNotification('All markers cleared successfully!', 'success');
    }
}

function saveMarkedLocations() {
    localStorage.setItem('markedPlaces', JSON.stringify(
        marked.map(m => ({
            address: m.address,
            lat: m.lat,
            lng: m.lng,
            reason: m.reason
        }))
    ));
}

function loadSavedMarks() {
    const savedMarks = localStorage.getItem('markedPlaces');
    if (savedMarks) {
        const marks = JSON.parse(savedMarks);
        marks.forEach(place => {
            const marker = L.marker([place.lat, place.lng], {
                icon: L.divIcon({
                    className: 'marked-marker',
                    html: '<div class="w-4 h-4 rounded-full bg-green-500"></div>',
                    iconSize: [16, 16],
                    iconAnchor: [8, 8]
                })
            }).addTo(map).bindPopup(`
                <div class="p-2">
                    <h3 class="font-bold text-green-700">Marked Location</h3>
                    <p class="text-sm">${place.address}</p>
                    <p class="text-xs mt-1"><strong>Reason:</strong> ${place.reason}</p>
                    <p class="text-xs mt-2 text-gray-500">Coordinates: ${place.lat.toFixed(6)}, ${place.lng.toFixed(6)}</p>
                    <button onclick="removeMarkedLocation(${marked.length})" class="mt-2 px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition">
                        Remove
                    </button>
                </div>
            `);
            
            marked.push({ ...place, marker });
        });
        updateMarkedPlacesList();
    }
}

function loadIncidentMarkers() {
    const incidents = @json($incidents);
    
    incidents.forEach((incident, index) => {
        if (!incident.location) return;
        
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(incident.location)}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);
                    
                    // Create custom icon
                    const customIcon = L.divIcon({
                        html: `<div class="w-6 h-6 rounded-full bg-red-500 border-2 border-white shadow-lg flex items-center justify-center">
                                 <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                     <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                                 </svg>
                               </div>`,
                        className: 'custom-div-icon',
                        iconSize: [24, 24],
                        iconAnchor: [12, 12]
                    });
                    
                    const marker = L.marker([lat, lng], {icon: customIcon}).addTo(map)
                        .bindPopup(`
                            <div class="p-2 min-w-[200px]">
                                <h3 class="font-bold text-lg text-red-700">${incident.title || 'Incident'}</h3>
                                <p class="text-sm text-gray-600">${incident.location}</p>
                                <p class="text-xs mt-1">
                                    Status: <span class="font-medium">${incident.status || 'Unknown'}</span>
                                </p>
                                <p class="text-xs mt-2 text-gray-500">
                                    Created: ${new Date(incident.created_at).toLocaleDateString()}
                                </p>
                            </div>
                        `);
                    
                    incidentMarkers.push(marker);
                    
                    // Center map on first incident
                    if (index === 0) {
                        map.setView([lat, lng], 10);
                    }
                }
            })
            .catch(error => {
                console.error('Error loading incident marker:', error);
            });
    });
}

function updateMarkedPlacesList() {
    const container = document.getElementById('markDetails');
    
    if (marked.length === 0) {
        container.innerHTML = `
            <div class="flex items-center justify-center h-full text-gray-500">
                <div class="text-center">
                    <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p>No locations marked yet. Click on the map to mark locations.</p>
                </div>
            </div>
        `;
        return;
    }
    
    let html = '<div class="space-y-3">';
    marked.forEach((place, index) => {
        html += `
            <div class="p-3 bg-white border border-green-200 rounded-lg hover:bg-green-50 transition-all duration-200">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center mb-1">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <p class="font-medium text-sm text-gray-900 truncate">${place.address}</p>
                        </div>
                        <p class="text-xs text-gray-600 mb-1"><strong>Reason:</strong> ${place.reason}</p>
                        <p class="text-xs text-gray-500">Coordinates: ${place.lat.toFixed(4)}, ${place.lng.toFixed(4)}</p>
                    </div>
                    <button onclick="removeMarkedLocation(${index})" class="ml-2 text-gray-400 hover:text-red-500 transition p-1 rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    });
    html += '</div>';
    container.innerHTML = html;
}

// Modal Functions
function openModal() {
    const modal = document.getElementById('addIncidentModal');
    const modalContent = document.getElementById('modalContent');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('addIncidentModal');
    const modalContent = document.getElementById('modalContent');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function openMarkModal() {
    const modal = document.getElementById('markLocationModal');
    const modalContent = document.getElementById('markModalContent');
    
    // Clear previous reason
    document.getElementById('markReason').value = '';
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeMarkModal() {
    const modal = document.getElementById('markLocationModal');
    const modalContent = document.getElementById('markModalContent');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        
        // Remove temporary click marker
        if (clickMarker) {
            map.removeLayer(clickMarker);
            clickMarker = null;
        }
    }, 300);
}

// Notification system with red glowing effect
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500 notification-glow',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    
    notification.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg text-white font-medium transform transition-all duration-300 translate-x-64 z-50 ${colors[type]}`;
    
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            ${message}
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-64');
    }, 10);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-64');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>
@endsection