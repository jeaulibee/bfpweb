@extends('layouts.app')

@section('title', 'Alert Mapping')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30 p-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
        <div class="mb-4 lg:mb-0">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-map-marked-alt text-white text-lg"></i>
                    </div>
                    <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full border-2 border-white animate-pulse"></div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Fire Alert Mapping
                    </h1>
                    <p class="text-gray-500 mt-1">Real-time monitoring of fire alerts across the region</p>
                </div>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-2xl shadow-sm border border-white/20">
                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-gray-700" id="live-alerts-count">0 Live Alerts</span>
            </div>
            <button id="refresh-btn" class="bg-white/80 backdrop-blur-sm hover:bg-white transition-all duration-300 px-4 py-2 rounded-2xl shadow-sm border border-white/20 group">
                <i class="fas fa-sync-alt text-gray-600 group-hover:text-blue-600 transition-all duration-300"></i>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active Alerts</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2" id="active-alerts">0</h3>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-fire text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">High Risk Areas</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2" id="high-risk">0</h3>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Resolved Today</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2" id="resolved">0</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active Devices</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2" id="devices">0</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-microchip text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Map and Sidebar Container -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-white/20 p-6 h-full">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-filter mr-2 text-blue-600"></i>
                    Alert Filters
                </h3>
                
                <!-- Alert Type Filter -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Alert Type</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="alert-type-filter" value="high" checked>
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                High Risk
                            </span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="alert-type-filter" value="medium" checked>
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                                Medium Risk
                            </span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="alert-type-filter" value="low" checked>
                            <span class="ml-2 text-sm text-gray-700 flex items-center">
                                <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                                Low Risk
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Time Filter -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Time Range</label>
                    <select id="time-filter" class="w-full bg-white/50 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="24">Last 24 Hours</option>
                        <option value="168">Last 7 Days</option>
                        <option value="720">Last 30 Days</option>
                        <option value="all">All Time</option>
                    </select>
                </div>

                <!-- Heatmap Toggle -->
                <div class="mb-6">
                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-sm font-medium text-gray-700">Heatmap View</span>
                        <div class="relative">
                            <input type="checkbox" id="heatmap-toggle" class="sr-only">
                            <div class="w-10 h-6 bg-gray-200 rounded-full transition-colors duration-200"></div>
                            <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200"></div>
                        </div>
                    </label>
                </div>

                <!-- Recent Alerts List -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Recent Alerts</h4>
                    <div class="space-y-3 max-h-60 overflow-y-auto" id="recent-alerts">
                        <!-- Recent alerts will be populated here -->
                        <div class="text-center text-gray-500 py-4">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Loading alerts...
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="lg:col-span-3">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-white/20 overflow-hidden relative">
                <div id="map" style="height: 600px;"></div>
                
                <!-- Map Controls -->
                <div class="absolute top-4 right-4 z-[1000] flex flex-col space-y-2">
                    <button id="zoom-in" class="w-10 h-10 bg-white rounded-xl shadow-lg flex items-center justify-center text-gray-600 hover:text-blue-600 transition-all duration-200 hover:scale-110">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button id="zoom-out" class="w-10 h-10 bg-white rounded-xl shadow-lg flex items-center justify-center text-gray-600 hover:text-blue-600 transition-all duration-200 hover:scale-110">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button id="locate-me" class="w-10 h-10 bg-white rounded-xl shadow-lg flex items-center justify-center text-gray-600 hover:text-blue-600 transition-all duration-200 hover:scale-110">
                        <i class="fas fa-crosshairs"></i>
                    </button>
                    <button id="fullscreen" class="w-10 h-10 bg-white rounded-xl shadow-lg flex items-center justify-center text-gray-600 hover:text-blue-600 transition-all duration-200 hover:scale-110">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>

                <!-- Map Legend -->
                <div class="absolute bottom-4 left-4 z-[1000] bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Alert Legend</h4>
                    <div class="space-y-2">
                        <div class="flex items-center text-sm">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                            <span>High Risk</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <div class="w-3 h-3 bg-orange-500 rounded-full mr-2"></div>
                            <span>Medium Risk</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <span>Low Risk</span>
                        </div>
                    </div>
                </div>

                <!-- Search Box -->
                <div class="absolute top-4 left-4 z-[1000]">
                    <div class="relative">
                        <input type="text" id="map-search" placeholder="Search location..." class="pl-10 pr-4 py-2 bg-white/90 backdrop-blur-sm rounded-xl shadow-lg border-0 focus:ring-2 focus:ring-blue-500/20 w-64">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<!-- Leaflet Heatmap -->
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    @keyframes pulse-glow {
        0%, 100% { 
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        }
        50% { 
            transform: scale(1.1);
            box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
        }
    }

    @keyframes bounce-in {
        0% { 
            opacity: 0;
            transform: scale(0.3) translateY(20px);
        }
        50% { 
            opacity: 1;
            transform: scale(1.05);
        }
        100% { 
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }

    .animate-bounce-in {
        animation: bounce-in 0.6s ease-out;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    /* Leaflet customizations */
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        backdrop-filter: blur(10px);
    }

    .leaflet-popup-content {
        margin: 16px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .risk-high { border-left: 4px solid #ef4444; }
    .risk-medium { border-left: 4px solid #f59e0b; }
    .risk-low { border-left: 4px solid #3b82f6; }

    /* Toggle switch */
    #heatmap-toggle:checked + div {
        background-color: #3b82f6;
    }

    #heatmap-toggle:checked + div > div {
        transform: translateX(1rem);
    }

    /* Alert notification */
    .alert-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        background: white;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border-left: 4px solid #ef4444;
        max-width: 350px;
        animation: slideInRight 0.5s ease-out;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .alert-notification.high { border-left-color: #ef4444; }
    .alert-notification.medium { border-left-color: #f59e0b; }
    .alert-notification.low { border-left-color: #3b82f6; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Initialize map with better view
    const map = L.map('map').setView([6.503, 124.846], 13);

    // Multiple tile layers for better UX
    const lightLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap, CARTO',
        maxZoom: 19
    });

    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '&copy; Esri, Earthstar Geographics'
    });

    // Add default layer
    lightLayer.addTo(map);

    // Layer control
    const baseMaps = {
        "Light": lightLayer,
        "Satellite": satelliteLayer
    };
    L.control.layers(baseMaps).addTo(map);

    // Map controls with enhanced functionality
    document.getElementById('zoom-in').addEventListener('click', () => {
        map.zoomIn();
    });
    
    document.getElementById('zoom-out').addEventListener('click', () => {
        map.zoomOut();
    });
    
    document.getElementById('locate-me').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    map.flyTo([position.coords.latitude, position.coords.longitude], 15, {
                        duration: 1.5,
                        easeLinearity: 0.25
                    });
                    
                    // Add user location marker
                    L.marker([position.coords.latitude, position.coords.longitude], {
                        icon: L.divIcon({
                            html: '<div class="w-6 h-6 bg-blue-600 rounded-full border-2 border-white shadow-lg animate-pulse"></div>',
                            className: 'user-location-marker',
                            iconSize: [24, 24],
                            iconAnchor: [12, 12]
                        })
                    }).addTo(map).bindPopup('Your Location').openPopup();
                },
                (error) => {
                    alert('Unable to retrieve your location. Please check location permissions.');
                }
            );
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });

    document.getElementById('fullscreen').addEventListener('click', () => {
        const mapContainer = document.getElementById('map');
        if (!document.fullscreenElement) {
            mapContainer.requestFullscreen?.();
        } else {
            document.exitFullscreen?.();
        }
    });

    // Heatmap layer
    let heatmapLayer = null;
    let heatmapData = [];
    let allMarkers = [];
    
    // Toggle switch functionality
    const heatmapToggle = document.getElementById('heatmap-toggle');
    const heatmapToggleVisual = heatmapToggle.nextElementSibling;
    const heatmapToggleHandle = heatmapToggleVisual.querySelector('div');
    
    heatmapToggle.addEventListener('change', function() {
        if (this.checked) {
            heatmapToggleVisual.style.backgroundColor = '#3b82f6';
            heatmapToggleHandle.style.transform = 'translateX(1rem)';
            if (heatmapData.length > 0) {
                heatmapLayer = L.heatLayer(heatmapData, {
                    radius: 25,
                    blur: 15,
                    maxZoom: 17,
                    gradient: {
                        0.4: 'blue',
                        0.6: 'cyan',
                        0.7: 'lime',
                        0.8: 'yellow',
                        1.0: 'red'
                    }
                }).addTo(map);
            }
        } else {
            heatmapToggleVisual.style.backgroundColor = '#e5e7eb';
            heatmapToggleHandle.style.transform = 'translateX(0)';
            if (heatmapLayer) {
                map.removeLayer(heatmapLayer);
                heatmapLayer = null;
            }
        }
    });

    // Enhanced marker creation with animations
    function createCustomIcon(alertType, isNew = false) {
        let iconColor, iconClass, pulseClass = '';
        
        switch(alertType.toLowerCase()) {
            case 'high':
                iconColor = '#ef4444';
                iconClass = 'fas fa-fire';
                pulseClass = 'animate-pulse-glow';
                break;
            case 'medium':
                iconColor = '#f59e0b';
                iconClass = 'fas fa-exclamation-triangle';
                break;
            case 'low':
            default:
                iconColor = '#3b82f6';
                iconClass = 'fas fa-info-circle';
        }

        const animationClass = isNew ? 'animate-bounce-in' : '';
        
        return L.divIcon({
            html: `
                <div class="${pulseClass} ${animationClass}" style="background-color: ${iconColor}; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; border: 3px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.3); cursor: pointer; transition: all 0.3s ease;">
                    <i class="${iconClass}"></i>
                </div>
            `,
            className: 'custom-marker',
            iconSize: [36, 36],
            iconAnchor: [18, 18]
        });
    }

    // Enhanced popup content
    function createPopupContent(alert, device) {
        const riskClass = `risk-${alert.type?.toLowerCase() || 'medium'}`;
        const timeAgo = new Date(alert.created_at).toLocaleString();
        
        return `
            <div class="min-w-64 ${riskClass} pl-3">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-bold text-lg" style="color: ${getRiskColor(alert.type)}">
                        🚨 ${alert.type?.toUpperCase() || 'ALERT'}
                    </h4>
                    <span class="text-xs text-gray-500">${timeAgo}</span>
                </div>
                <p class="text-gray-700 mb-3">${alert.message || 'No message provided'}</p>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <strong>Device:</strong><br>
                        <span class="text-gray-600">${device?.name || 'Unknown'}</span>
                    </div>
                    <div>
                        <strong>Status:</strong><br>
                        <span class="px-2 py-1 rounded-full text-xs ${alert.status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${alert.status || 'active'}
                        </span>
                    </div>
                </div>
                <div class="mt-4 flex space-x-2">
                    <button class="resolve-alert flex-1 bg-green-500 hover:bg-green-600 text-white py-2 px-3 rounded-lg text-sm transition-colors" data-alert-id="${alert.id}">
                        <i class="fas fa-check mr-1"></i>Resolve
                    </button>
                    <button class="view-details flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded-lg text-sm transition-colors" data-alert-id="${alert.id}">
                        <i class="fas fa-eye mr-1"></i>Details
                    </button>
                </div>
            </div>
        `;
    }

    function getRiskColor(riskLevel) {
        switch(riskLevel?.toLowerCase()) {
            case 'high': return '#ef4444';
            case 'medium': return '#f59e0b';
            case 'low': return '#3b82f6';
            default: return '#6b7280';
        }
    }

    // Show alert notification
    function showAlertNotification(alert, device) {
        const notification = document.createElement('div');
        notification.className = `alert-notification ${alert.type?.toLowerCase() || 'medium'}`;
        notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full ${alert.type === 'high' ? 'bg-red-100' : alert.type === 'medium' ? 'bg-orange-100' : 'bg-blue-100'} flex items-center justify-center">
                        <i class="${alert.type === 'high' ? 'fas fa-fire text-red-600' : alert.type === 'medium' ? 'fas fa-exclamation-triangle text-orange-600' : 'fas fa-info-circle text-blue-600'}"></i>
                    </div>
                </div>
                <div class="ml-3 flex-1">
                    <h5 class="font-bold text-gray-900">${alert.type?.toUpperCase()} Alert</h5>
                    <p class="text-sm text-gray-600 mt-1">${alert.message || 'No message provided'}</p>
                    <p class="text-xs text-gray-500 mt-1">${device?.name || 'Unknown device'} • ${new Date(alert.created_at).toLocaleTimeString()}</p>
                </div>
                <button class="close-notification ml-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.animation = 'slideInRight 0.5s ease-out reverse';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 500);
            }
        }, 5000);
        
        // Manual close
        notification.querySelector('.close-notification').addEventListener('click', () => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        });
    }

    // Load alert data with enhanced features
    function loadAlertData() {
        fetch('{{ route("admin.alertmapping.api") }}')
            .then(res => res.json())
            .then(data => {
                updateStats(data);
                updateRecentAlerts(data);
                plotMarkersOnMap(data);
            })
            .catch(err => console.error('Map Load Error:', err));
    }

    function updateStats(data) {
        document.getElementById('active-alerts').textContent = data.length;
        document.getElementById('live-alerts-count').textContent = `${data.length} Live Alerts`;
        
        const highRiskCount = data.filter(item => 
            item.alert.type && item.alert.type.toLowerCase() === 'high'
        ).length;
        document.getElementById('high-risk').textContent = highRiskCount;
        
        const today = new Date().toISOString().split('T')[0];
        const resolvedCount = data.filter(item => {
            const alertDate = new Date(item.alert.created_at).toISOString().split('T')[0];
            return alertDate === today && item.alert.status === 'resolved';
        }).length;
        document.getElementById('resolved').textContent = resolvedCount;
        
        const deviceIds = [...new Set(data.map(item => item.alert.device_id))];
        document.getElementById('devices').textContent = deviceIds.length;
    }

    function updateRecentAlerts(data) {
        const recentAlertsContainer = document.getElementById('recent-alerts');
        const recentAlerts = data.slice(0, 5); // Show last 5 alerts
        
        if (recentAlerts.length === 0) {
            recentAlertsContainer.innerHTML = '<div class="text-center text-gray-500 py-4">No recent alerts</div>';
            return;
        }
        
        recentAlertsContainer.innerHTML = recentAlerts.map(item => `
            <div class="bg-white rounded-lg p-3 shadow-sm border-l-4 ${`risk-${item.alert.type?.toLowerCase() || 'medium'}`}">
                <div class="flex justify-between items-start mb-1">
                    <span class="font-medium text-sm">${item.alert.type?.toUpperCase() || 'ALERT'}</span>
                    <span class="text-xs text-gray-500">${new Date(item.alert.created_at).toLocaleTimeString()}</span>
                </div>
                <p class="text-xs text-gray-600 truncate">${item.alert.message || 'No message'}</p>
            </div>
        `).join('');
    }

    function plotMarkersOnMap(data) {
        // Store previous markers to detect new ones
        const previousMarkerIds = allMarkers.map(marker => marker.alertId);
        
        // Clear existing markers
        allMarkers.forEach(marker => map.removeLayer(marker));
        allMarkers = [];
        heatmapData = [];

        data.forEach((item, index) => {
            const { latitude, longitude, alert, device } = item;
            
            if (latitude && longitude) {
                // Add to heatmap data with intensity based on alert type
                let intensity = 0.3;
                if (alert.type === 'high') intensity = 1.0;
                else if (alert.type === 'medium') intensity = 0.6;
                
                heatmapData.push([latitude, longitude, intensity]);

                // Check if this is a new alert
                const isNewAlert = !previousMarkerIds.includes(alert.id);
                
                // Create marker with animation
                const marker = L.marker([latitude, longitude], {
                    icon: createCustomIcon(alert.type, isNewAlert)
                }).addTo(map);

                // Store alert ID for tracking
                marker.alertId = alert.id;

                // Bind popup with enhanced content
                marker.bindPopup(createPopupContent(alert, device), {
                    className: 'custom-popup',
                    maxWidth: 400
                });

                // Add click event to fly to marker
                marker.on('click', function() {
                    map.flyTo([latitude, longitude], 15, {
                        duration: 1
                    });
                });

                allMarkers.push(marker);

                // Show notification for new alerts
                if (isNewAlert) {
                    showAlertNotification(alert, device);
                }

                // Staggered animation
                setTimeout(() => {
                    const element = marker.getElement();
                    if (element) {
                        element.style.opacity = '0';
                        element.style.transform = 'scale(0.8)';
                        element.style.transition = 'all 0.5s ease';
                        
                        setTimeout(() => {
                            element.style.opacity = '1';
                            element.style.transform = 'scale(1)';
                        }, 50);
                    }
                }, index * 100);
            }
        });

        // Update heatmap if it's active
        if (heatmapToggle.checked && heatmapLayer) {
            map.removeLayer(heatmapLayer);
            heatmapLayer = L.heatLayer(heatmapData, {
                radius: 25,
                blur: 15,
                maxZoom: 17,
                gradient: {
                    0.4: 'blue',
                    0.6: 'cyan',
                    0.7: 'lime',
                    0.8: 'yellow',
                    1.0: 'red'
                }
            }).addTo(map);
        }

        // Auto-fit map to show all markers if there are any
        if (allMarkers.length > 0) {
            const group = new L.featureGroup(allMarkers);
            map.fitBounds(group.getBounds(), { padding: [20, 20] });
        }
    }

    // Refresh button with enhanced animation
    const refreshBtn = document.getElementById('refresh-btn');
    refreshBtn.addEventListener('click', function() {
        const icon = this.querySelector('i');
        icon.style.transition = 'transform 0.6s ease';
        icon.style.transform = 'rotate(360deg)';
        
        setTimeout(() => {
            icon.style.transform = 'rotate(0deg)';
        }, 600);
        
        loadAlertData();
    });

    // Filter functionality
    document.querySelectorAll('.alert-type-filter').forEach(checkbox => {
        checkbox.addEventListener('change', filterMarkers);
    });

    function filterMarkers() {
        const selectedTypes = Array.from(document.querySelectorAll('.alert-type-filter:checked'))
            .map(cb => cb.value);
        
        allMarkers.forEach(marker => {
            const markerType = marker.options.icon?.options?.html?.includes('fa-fire') ? 'high' :
                             marker.options.icon?.options?.html?.includes('fa-exclamation-triangle') ? 'medium' : 'low';
            
            if (selectedTypes.includes(markerType)) {
                map.addLayer(marker);
            } else {
                map.removeLayer(marker);
            }
        });
    }

    // Time filter functionality
    document.getElementById('time-filter').addEventListener('change', function() {
        // In a real implementation, this would filter the data by time
        // For now, we'll just reload all data
        loadAlertData();
    });

    // Search functionality
    document.getElementById('map-search').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const query = this.value.trim();
            if (query) {
                // Simple geocoding simulation - in real app, use a geocoding service
                const foundMarker = allMarkers.find(marker => {
                    const popupContent = marker.getPopup()?.getContent();
                    return popupContent && popupContent.toLowerCase().includes(query.toLowerCase());
                });
                
                if (foundMarker) {
                    const latlng = foundMarker.getLatLng();
                    map.flyTo(latlng, 15, { duration: 1 });
                    foundMarker.openPopup();
                } else {
                    // If no marker found, try to geocode the location
                    // This is a simplified simulation - in production, use a real geocoding API
                    alert(`Location "${query}" not found in current alerts. Try a different search term.`);
                }
            }
        }
    });

    // Handle popup button clicks
    map.on('popupopen', function(e) {
        const popup = e.popup;
        const content = popup.getElement();
        
        // Resolve alert button
        const resolveBtn = content.querySelector('.resolve-alert');
        if (resolveBtn) {
            resolveBtn.addEventListener('click', function() {
                const alertId = this.getAttribute('data-alert-id');
                // In a real implementation, this would call an API to resolve the alert
                alert(`Alert ${alertId} marked as resolved!`);
                popup.close();
                loadAlertData(); // Refresh data
            });
        }
        
        // View details button
        const detailsBtn = content.querySelector('.view-details');
        if (detailsBtn) {
            detailsBtn.addEventListener('click', function() {
                const alertId = this.getAttribute('data-alert-id');
                // In a real implementation, this would open a detailed view
                alert(`Showing details for alert ${alertId}`);
            });
        }
    });

    // Initial load
    loadAlertData();
    
    // Auto-refresh every 30 seconds
    setInterval(loadAlertData, 30000);

    // Add resize handler for better responsiveness
    window.addEventListener('resize', () => {
        map.invalidateSize();
    });

    // Simulate new alerts for demo purposes
    // In a real application, this would come from a WebSocket or API
    function simulateNewAlert() {
        const alertTypes = ['high', 'medium', 'low'];
        const randomType = alertTypes[Math.floor(Math.random() * alertTypes.length)];
        
        // Generate random coordinates near the center
        const lat = 6.503 + (Math.random() - 0.5) * 0.1;
        const lng = 124.846 + (Math.random() - 0.5) * 0.1;
        
        const newAlert = {
            latitude: lat,
            longitude: lng,
            alert: {
                id: Date.now(),
                type: randomType,
                message: `Simulated ${randomType} risk alert detected`,
                status: 'active',
                created_at: new Date().toISOString(),
                device_id: Math.floor(Math.random() * 100) + 1
            },
            device: {
                name: `Sensor-${Math.floor(Math.random() * 50) + 1}`
            }
        };
        
        // Add to existing data and update map
        // In a real app, this would come from the server
        fetch('{{ route("admin.alertmapping.api") }}')
            .then(res => res.json())
            .then(data => {
                data.push(newAlert);
                updateStats(data);
                updateRecentAlerts(data);
                plotMarkersOnMap(data);
            })
            .catch(err => console.error('Error loading alert data:', err));
    }

    // Uncomment the line below to enable demo mode with simulated alerts
    // setInterval(simulateNewAlert, 45000); // Add a new alert every 45 seconds
});
</script>
@endsection