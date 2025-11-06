@extends('layouts.app')

@section('title', 'IoT Devices Map')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="min-h-screen bg-gradient-to-br from-white to-red-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center" data-aos="fade-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-3xl shadow-2xl mb-6 transform transition-all duration-500 hover:scale-110 hover:shadow-2xl hover:from-red-700 hover:to-red-800">
                <i class="fas fa-microchip text-white text-2xl"></i>
            </div>
            <h1 class="text-5xl font-black text-gray-900 mb-4 bg-gradient-to-r from-red-700 to-red-600 bg-clip-text text-transparent">
                IoT Devices Map
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Real-time monitoring of fire and smoke detection sensors
            </p>
            <div class="w-32 h-1.5 bg-gradient-to-r from-red-500 to-red-400 rounded-full mx-auto mt-6 shadow-sm"></div>
        </div>

        <!-- Real-time Alerts -->
        <div id="liveAlerts" class="mb-8 space-y-4" data-aos="fade-up">
            <!-- Alerts will be dynamically inserted here -->
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8" data-aos="fade-up">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Devices</p>
                        <p class="text-3xl font-bold text-gray-900" id="totalDevices">0</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-microchip text-blue-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Online</p>
                        <p class="text-3xl font-bold text-green-600" id="onlineDevices">0</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-wifi text-green-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Active Alerts</p>
                        <p class="text-3xl font-bold text-red-600" id="activeAlerts">0</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Last Update</p>
                        <p class="text-lg font-bold text-gray-900" id="lastUpdate">Just now</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-purple-600 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Map Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-red-100 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-map text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Live Sensor Network</h2>
                            <p class="text-red-100">Real-time Arduino device monitoring</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-2xl px-4 py-2 border border-white/30">
                            <i class="fas fa-sync-alt text-white text-sm animate-spin" id="syncIcon"></i>
                            <span class="text-white text-sm font-medium">Live Updates</span>
                        </div>
                        <div class="flex gap-2">
                            <button id="zoomIn" class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/30 hover:bg-white/30 transition-all duration-300">
                                <i class="fas fa-plus text-white"></i>
                            </button>
                            <button id="zoomOut" class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/30 hover:bg-white/30 transition-all duration-300">
                                <i class="fas fa-minus text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Container -->
            <div class="p-6">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-gray-200 overflow-hidden shadow-inner">
                    <div id="map" class="w-full h-96 rounded-xl"></div>
                </div>

                <!-- Map Legend -->
                <div class="mt-6 flex flex-wrap gap-4 justify-center">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-green-500 rounded-full shadow-md"></div>
                        <span class="text-sm font-medium text-gray-700">Normal</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-yellow-500 rounded-full shadow-md"></div>
                        <span class="text-sm font-medium text-gray-700">Smoke Detected</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-orange-500 rounded-full shadow-md"></div>
                        <span class="text-sm font-medium text-gray-700">High Temperature</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-red-500 rounded-full shadow-md"></div>
                        <span class="text-sm font-medium text-gray-700">Fire Detected</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-gray-400 rounded-full shadow-md"></div>
                        <span class="text-sm font-medium text-gray-700">Offline</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Device List -->
        <div class="mt-8 bg-white rounded-3xl shadow-2xl border border-red-100 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
            <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-list text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Connected Devices</h2>
                        <p class="text-gray-200 text-sm">Live status of all Arduino sensors</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Device ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Temperature</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Smoke Level</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Last Update</th>
                            </tr>
                        </thead>
                        <tbody id="devicesTableBody" class="divide-y divide-gray-200">
                            <!-- Devices will be dynamically inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Connection Status -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="400">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-plug text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Arduino Connection</h3>
                        <p class="text-sm text-gray-500">Device communication status</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Serial Port:</span>
                        <span class="text-sm font-semibold" id="serialPort">Detecting...</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Baud Rate:</span>
                        <span class="text-sm font-semibold" id="baudRate">9600</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Connection:</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold" id="connectionStatus">
                            <span class="w-2 h-2 bg-gray-400 rounded-full mr-1"></span>
                            Disconnected
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-wave-square text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Sensor Data</h3>
                        <p class="text-sm text-gray-500">Live readings from devices</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Data Frequency:</span>
                        <span class="text-sm font-semibold" id="dataFrequency">0 Hz</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Packets Received:</span>
                        <span class="text-sm font-semibold" id="packetsReceived">0</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Packet:</span>
                        <span class="text-sm font-semibold" id="lastPacket">Never</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Leaflet CDN for map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- AOS Animation Library -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

<style>
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #fef2f2;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #dc2626, #b91c1c);
        border-radius: 4px;
    }
    
    /* Enhanced transitions */
    .transition-all {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Map custom styles */
    .leaflet-popup-content {
        margin: 8px 12px;
    }
    
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    /* Alert animations */
    @keyframes pulse-alert {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    .alert-pulse {
        animation: pulse-alert 2s infinite;
    }
</style>

<script>
    // Global variables
    let map;
    let deviceMarkers = [];
    let lastUpdateTime = new Date();
    let packetCount = 0;
    let updateInterval;

    // Device status definitions
    const DEVICE_STATUS = {
        NORMAL: 'normal',
        SMOKE_DETECTED: 'smoke',
        HIGH_TEMP: 'high_temp',
        FIRE_DETECTED: 'fire',
        OFFLINE: 'offline'
    };

    // Initialize the application
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic'
        });

        initializeMap();
        initializeWebSocket();
        startDeviceSimulation(); // Remove this in production - for demo only
        
        // Map controls
        document.getElementById('zoomIn').addEventListener('click', () => map.zoomIn());
        document.getElementById('zoomOut').addEventListener('click', () => map.zoomOut());
    });

    // Initialize the map
    function initializeMap() {
        map = L.map('map').setView([6.964, 125.072], 15); // Koronadal City center

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Add sample devices for demonstration
        addSampleDevices();
    }

    // Initialize WebSocket connection for real-time data
    function initializeWebSocket() {
        // In a real implementation, you would connect to your WebSocket server
        // that receives data from Arduino devices
        console.log('Initializing WebSocket connection...');
        
        // Simulate connection status
        setTimeout(() => {
            updateConnectionStatus(true);
        }, 2000);
    }

    // Add sample devices for demonstration
    function addSampleDevices() {
        const sampleDevices = [
            {
                id: 'ARDUINO_001',
                name: 'Main Building Sensor',
                location: [6.964, 125.072],
                status: DEVICE_STATUS.NORMAL,
                temperature: 25.5,
                smokeLevel: 45,
                lastUpdate: new Date(),
                battery: 85
            },
            {
                id: 'ARDUINO_002',
                name: 'Library Sensor',
                location: [6.966, 125.074],
                status: DEVICE_STATUS.NORMAL,
                temperature: 26.2,
                smokeLevel: 52,
                lastUpdate: new Date(),
                battery: 92
            },
            {
                id: 'ARDUINO_003',
                name: 'Cafeteria Sensor',
                location: [6.962, 125.070],
                status: DEVICE_STATUS.SMOKE_DETECTED,
                temperature: 35.8,
                smokeLevel: 280,
                lastUpdate: new Date(),
                battery: 78
            },
            {
                id: 'ARDUINO_004',
                name: 'Dormitory Sensor',
                location: [6.968, 125.076],
                status: DEVICE_STATUS.HIGH_TEMP,
                temperature: 42.3,
                smokeLevel: 120,
                lastUpdate: new Date(),
                battery: 65
            }
        ];

        sampleDevices.forEach(device => {
            addDeviceToMap(device);
        });

        updateDeviceList(sampleDevices);
        updateStats(sampleDevices);
    }

    // Add a device to the map
    function addDeviceToMap(device) {
        const markerColor = getStatusColor(device.status);
        const iconHtml = `
            <div class="relative">
                <div class="w-8 h-8 rounded-full shadow-lg border-2 border-white" style="background-color: ${markerColor};"></div>
                ${device.status !== DEVICE_STATUS.NORMAL ? '<div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border border-white animate-pulse"></div>' : ''}
            </div>
        `;

        const customIcon = L.divIcon({
            html: iconHtml,
            className: 'custom-device-marker',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        const marker = L.marker(device.location, { icon: customIcon }).addTo(map);
        
        const popupContent = createDevicePopup(device);
        marker.bindPopup(popupContent);
        
        deviceMarkers.push({
            id: device.id,
            marker: marker,
            device: device
        });
    }

    // Create popup content for a device
    function createDevicePopup(device) {
        const statusText = getStatusText(device.status);
        const statusColor = getStatusColor(device.status);
        
        return `
            <div class="min-w-64">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-gray-900 text-lg">${device.name}</h3>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold" style="background-color: ${statusColor}20; color: ${statusColor};">
                        ${statusText}
                    </span>
                </div>
                
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Device ID:</span>
                        <span class="font-semibold">${device.id}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Temperature:</span>
                        <span class="font-semibold ${device.temperature > 35 ? 'text-red-600' : 'text-green-600'}">${device.temperature}°C</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Smoke Level:</span>
                        <span class="font-semibold ${device.smokeLevel > 150 ? 'text-red-600' : 'text-green-600'}">${device.smokeLevel} ppm</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Battery:</span>
                        <span class="font-semibold ${device.battery < 20 ? 'text-red-600' : 'text-green-600'}">${device.battery}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Update:</span>
                        <span class="font-semibold">${formatTime(device.lastUpdate)}</span>
                    </div>
                </div>
                
                ${device.status !== DEVICE_STATUS.NORMAL ? `
                <div class="mt-3 p-2 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                        <span class="text-sm font-semibold text-red-700">Alert: ${getAlertMessage(device.status)}</span>
                    </div>
                </div>
                ` : ''}
            </div>
        `;
    }

    // Update device list table
    function updateDeviceList(devices) {
        const tbody = document.getElementById('devicesTableBody');
        tbody.innerHTML = '';

        devices.forEach(device => {
            const statusColor = getStatusColor(device.status);
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition-colors duration-200';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full" style="background-color: ${statusColor};"></div>
                        <span class="font-semibold text-gray-900">${device.id}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${device.name}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold" style="background-color: ${statusColor}20; color: ${statusColor};">
                        ${getStatusText(device.status)}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold ${device.temperature > 35 ? 'text-red-600' : 'text-green-600'}">
                    ${device.temperature}°C
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold ${device.smokeLevel > 150 ? 'text-red-600' : 'text-green-600'}">
                    ${device.smokeLevel} ppm
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formatTime(device.lastUpdate)}</td>
            `;
            tbody.appendChild(row);
        });
    }

    // Update statistics
    function updateStats(devices) {
        const totalDevices = devices.length;
        const onlineDevices = devices.filter(d => d.status !== DEVICE_STATUS.OFFLINE).length;
        const activeAlerts = devices.filter(d => d.status !== DEVICE_STATUS.NORMAL && d.status !== DEVICE_STATUS.OFFLINE).length;

        document.getElementById('totalDevices').textContent = totalDevices;
        document.getElementById('onlineDevices').textContent = onlineDevices;
        document.getElementById('activeAlerts').textContent = activeAlerts;
        document.getElementById('lastUpdate').textContent = 'Just now';
    }

    // Update connection status
    function updateConnectionStatus(connected) {
        const statusElement = document.getElementById('connectionStatus');
        const serialPortElement = document.getElementById('serialPort');
        
        if (connected) {
            statusElement.innerHTML = '<span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>Connected';
            statusElement.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800';
            serialPortElement.textContent = 'COM3'; // Simulated port
        } else {
            statusElement.innerHTML = '<span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span>Disconnected';
            statusElement.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800';
            serialPortElement.textContent = 'None';
        }
    }

    // Show alert notification
    function showAlert(device, alertType) {
        const alertsContainer = document.getElementById('liveAlerts');
        const alertId = `alert-${device.id}-${Date.now()}`;
        
        const alertHtml = `
            <div id="${alertId}" class="bg-red-50 border border-red-200 rounded-2xl p-4 shadow-lg alert-pulse">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-red-800 text-lg">${getAlertTitle(alertType)}</h3>
                        <p class="text-red-700">${device.name} (${device.id}) - ${getAlertMessage(alertType)}</p>
                        <p class="text-sm text-red-600 mt-1">Temperature: ${device.temperature}°C | Smoke: ${device.smokeLevel} ppm</p>
                    </div>
                    <button onclick="document.getElementById('${alertId}').remove()" class="text-red-500 hover:text-red-700 transition-colors duration-200">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
        `;
        
        alertsContainer.insertAdjacentHTML('afterbegin', alertHtml);
        
        // Auto-remove alert after 30 seconds
        setTimeout(() => {
            const alertElement = document.getElementById(alertId);
            if (alertElement) {
                alertElement.remove();
            }
        }, 30000);
    }

    // Utility functions
    function getStatusColor(status) {
        const colors = {
            [DEVICE_STATUS.NORMAL]: '#22c55e', // green
            [DEVICE_STATUS.SMOKE_DETECTED]: '#eab308', // yellow
            [DEVICE_STATUS.HIGH_TEMP]: '#f97316', // orange
            [DEVICE_STATUS.FIRE_DETECTED]: '#ef4444', // red
            [DEVICE_STATUS.OFFLINE]: '#6b7280' // gray
        };
        return colors[status] || '#6b7280';
    }

    function getStatusText(status) {
        const texts = {
            [DEVICE_STATUS.NORMAL]: 'Normal',
            [DEVICE_STATUS.SMOKE_DETECTED]: 'Smoke Detected',
            [DEVICE_STATUS.HIGH_TEMP]: 'High Temperature',
            [DEVICE_STATUS.FIRE_DETECTED]: 'Fire Detected',
            [DEVICE_STATUS.OFFLINE]: 'Offline'
        };
        return texts[status] || 'Unknown';
    }

    function getAlertTitle(status) {
        const titles = {
            [DEVICE_STATUS.SMOKE_DETECTED]: 'SMOKE DETECTED',
            [DEVICE_STATUS.HIGH_TEMP]: 'HIGH TEMPERATURE',
            [DEVICE_STATUS.FIRE_DETECTED]: 'FIRE DETECTED'
        };
        return titles[status] || 'ALERT';
    }

    function getAlertMessage(status) {
        const messages = {
            [DEVICE_STATUS.SMOKE_DETECTED]: 'Smoke levels above normal threshold',
            [DEVICE_STATUS.HIGH_TEMP]: 'Temperature exceeding safe limits',
            [DEVICE_STATUS.FIRE_DETECTED]: 'Fire detected - Immediate action required'
        };
        return messages[status] || 'Device alert triggered';
    }

    function formatTime(date) {
        return date.toLocaleTimeString() + ' ' + date.toLocaleDateString();
    }

    // DEMO ONLY: Simulate device data updates
    function startDeviceSimulation() {
        updateInterval = setInterval(() => {
            // Simulate random device updates
            deviceMarkers.forEach(deviceMarker => {
                if (Math.random() < 0.3) { // 30% chance of update
                    const device = deviceMarker.device;
                    
                    // Simulate sensor readings
                    device.temperature = Math.max(20, Math.min(50, device.temperature + (Math.random() - 0.5) * 2));
                    device.smokeLevel = Math.max(0, Math.min(500, device.smokeLevel + (Math.random() - 0.5) * 20));
                    device.lastUpdate = new Date();
                    
                    // Update status based on readings
                    let newStatus = DEVICE_STATUS.NORMAL;
                    if (device.smokeLevel > 250) {
                        newStatus = DEVICE_STATUS.FIRE_DETECTED;
                    } else if (device.smokeLevel > 150) {
                        newStatus = DEVICE_STATUS.SMOKE_DETECTED;
                    } else if (device.temperature > 40) {
                        newStatus = DEVICE_STATUS.HIGH_TEMP;
                    }
                    
                    // Show alert if status changed to alert state
                    if (newStatus !== DEVICE_STATUS.NORMAL && device.status === DEVICE_STATUS.NORMAL) {
                        showAlert(device, newStatus);
                    }
                    
                    device.status = newStatus;
                    
                    // Update marker
                    updateDeviceMarker(deviceMarker);
                }
            });
            
            // Update stats
            packetCount++;
            document.getElementById('packetsReceived').textContent = packetCount;
            document.getElementById('dataFrequency').textContent = (packetCount / ((new Date() - lastUpdateTime) / 1000)).toFixed(1) + ' Hz';
            document.getElementById('lastPacket').textContent = 'Just now';
            
        }, 2000); // Update every 2 seconds
    }

    function updateDeviceMarker(deviceMarker) {
        const device = deviceMarker.device;
        const markerColor = getStatusColor(device.status);
        const iconHtml = `
            <div class="relative">
                <div class="w-8 h-8 rounded-full shadow-lg border-2 border-white" style="background-color: ${markerColor};"></div>
                ${device.status !== DEVICE_STATUS.NORMAL ? '<div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border border-white animate-pulse"></div>' : ''}
            </div>
        `;

        const customIcon = L.divIcon({
            html: iconHtml,
            className: 'custom-device-marker',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        deviceMarker.marker.setIcon(customIcon);
        
        const popupContent = createDevicePopup(device);
        deviceMarker.marker.setPopupContent(popupContent);
        
        // Update device list
        const devices = deviceMarkers.map(dm => dm.device);
        updateDeviceList(devices);
        updateStats(devices);
    }

    // Clean up on page unload
    window.addEventListener('beforeunload', () => {
        if (updateInterval) {
            clearInterval(updateInterval);
        }
    });
</script>
@endsection