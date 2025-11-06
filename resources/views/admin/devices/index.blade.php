@extends('layouts.app')
@section('title', 'Devices')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30 p-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
        <div class="mb-4 lg:mb-0">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-microchip text-white text-lg"></i>
                    </div>
                    <div class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Device Management
                    </h1>
                    <p class="text-gray-500 mt-1">Manage and monitor all connected devices</p>
                </div>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-2xl shadow-sm border border-white/20">
                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-gray-700" id="active-count">{{ $devices->count() }} Active</span>
            </div>
            <a href="{{ route('admin.devices.create') }}" class="bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group flex items-center space-x-2">
                <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Add Device</span>
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" id="stats-cards">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Devices</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2" id="total-devices">{{ $devices->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-microchip text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Online Now</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2" id="online-devices">{{ $devices->where('status', 'online')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-wifi text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Needs Attention</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2" id="warning-devices">{{ $devices->where('status', 'warning')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Offline</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2" id="offline-devices">{{ $devices->where('status', 'offline')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-power-off text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-sm border border-white/20 overflow-hidden">
        <!-- Table Header -->
        <div class="border-b border-gray-100/50 bg-gradient-to-r from-gray-50 to-gray-100/30 px-6 py-4">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <h2 class="text-xl font-semibold text-gray-800">Device Inventory</h2>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search devices..." class="pl-10 pr-4 py-2 bg-white/50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 search-input">
                    </div>
                    <select class="bg-white/50 border border-gray-200 rounded-2xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 status-filter">
                        <option value="all">All Status</option>
                        <option value="online">Online</option>
                        <option value="warning">Needs Attention</option>
                        <option value="offline">Offline</option>
                    </select>
                    <button id="refresh-devices" class="bg-white/50 border border-gray-200 rounded-2xl px-4 py-2 hover:bg-white transition-all duration-300 group">
                        <i class="fas fa-sync-alt text-gray-600 group-hover:text-blue-600 group-hover:rotate-180 transition-all duration-500"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Devices Table -->
        <div class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100/50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Device</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Serial Number</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Last Active</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100/30" id="devices-table">
                        @foreach($devices as $device)
                            <tr class="group hover:bg-blue-50/30 transition-all duration-300 animate-slide-in device-row" 
                                data-device-id="{{ $device->id }}"
                                data-status="{{ $device->status }}"
                                data-name="{{ strtolower($device->name) }}"
                                style="animation-delay: {{ $loop->index * 0.05 }}s">
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-sm">
                                            <i class="fas fa-microchip text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 device-name">{{ $device->name }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $device->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-mono bg-gray-100 px-3 py-1 rounded-lg border">
                                        {{ $device->serial_number }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-map-marker-alt text-gray-400 text-xs"></i>
                                        <span class="text-sm text-gray-700 device-location">{{ $device->location ?? 'Not specified' }}</span>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusConfig = [
                                            'online' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'fa-wifi', 'pulse' => 'animate-pulse'],
                                            'warning' => ['color' => 'bg-orange-100 text-orange-800', 'icon' => 'fa-exclamation-triangle', 'pulse' => ''],
                                            'offline' => ['color' => 'bg-red-100 text-red-800', 'icon' => 'fa-power-off', 'pulse' => '']
                                        ];
                                        $config = $statusConfig[$device->status] ?? $statusConfig['offline'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['color'] }} status-badge {{ $config['pulse'] }}" data-device-status="{{ $device->status }}">
                                        <i class="fas {{ $config['icon'] }} mr-1.5"></i>
                                        {{ ucfirst($device->status) }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 last-active">
                                        @if($device->last_active)
                                            {{ \Carbon\Carbon::parse($device->last_active)->diffForHumans() }}
                                        @else
                                            <span class="text-gray-400">Never</span>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.devices.edit', $device->id) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-200 group hover:scale-105">
                                            <i class="fas fa-edit text-xs mr-1.5 group-hover:rotate-12 transition-transform"></i>
                                            <span class="text-sm font-medium">Edit</span>
                                        </a>
                                        
                                        <button class="inline-flex items-center px-3 py-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition-all duration-200 group hover:scale-105 quick-status-btn"
                                                data-device-id="{{ $device->id }}"
                                                data-current-status="{{ $device->status }}">
                                            <i class="fas fa-bolt text-xs mr-1.5 group-hover:shake transition-transform"></i>
                                            <span class="text-sm font-medium">Quick Status</span>
                                        </button>
                                        
                                        <form action="{{ route('admin.devices.destroy', $device->id) }}" method="POST" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-all duration-200 group hover:scale-105 delete-btn"
                                                    data-device-name="{{ $device->name }}">
                                                <i class="fas fa-trash text-xs mr-1.5 group-hover:shake transition-transform"></i>
                                                <span class="text-sm font-medium">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table Footer -->
        <div class="border-t border-gray-100/50 bg-gray-50/30 px-6 py-4">
            <div class="flex items-center justify-between text-sm text-gray-500">
                <div>
                    Showing <span class="font-semibold" id="showing-count">{{ $devices->count() }}</span> devices
                </div>
                <div class="flex items-center space-x-4">
                    <button class="hover:text-gray-700 transition-colors duration-200 hover:scale-110">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="font-semibold">1</span>
                    <button class="hover:text-gray-700 transition-colors duration-200 hover:scale-110">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    @if($devices->count() === 0)
    <div class="text-center py-12">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-microchip text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No devices found</h3>
            <p class="text-gray-500 mb-6">Get started by adding your first device to the system.</p>
            <a href="{{ route('admin.devices.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <i class="fas fa-plus-circle mr-2"></i>
                Add First Device
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Quick Status Modal -->
<div id="quick-status-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-6 max-w-md mx-4 transform scale-95 opacity-0 transition-all duration-300">
        <div class="text-center">
            <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-bolt text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Quick Status Update</h3>
            <p class="text-gray-600 mb-4">Change device status:</p>
            
            <div class="grid grid-cols-3 gap-3 mb-6">
                <button class="status-option p-4 bg-green-50 border-2 border-green-200 rounded-xl hover:bg-green-100 transition-all duration-200" data-status="online">
                    <div class="w-3 h-3 bg-green-500 rounded-full mx-auto mb-2"></div>
                    <span class="text-sm font-medium text-green-800">Online</span>
                </button>
                <button class="status-option p-4 bg-orange-50 border-2 border-orange-200 rounded-xl hover:bg-orange-100 transition-all duration-200" data-status="warning">
                    <div class="w-3 h-3 bg-orange-500 rounded-full mx-auto mb-2"></div>
                    <span class="text-sm font-medium text-orange-800">Warning</span>
                </button>
                <button class="status-option p-4 bg-red-50 border-2 border-red-200 rounded-xl hover:bg-red-100 transition-all duration-200" data-status="offline">
                    <div class="w-3 h-3 bg-red-500 rounded-full mx-auto mb-2"></div>
                    <span class="text-sm font-medium text-red-800">Offline</span>
                </button>
            </div>
            
            <div class="flex space-x-3">
                <button id="cancel-status" class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-all duration-200">
                    Cancel
                </button>
                <button id="confirm-status" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-200">
                    Update Status
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    @keyframes slide-in {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-2px); }
        75% { transform: translateX(2px); }
    }

    @keyframes status-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .animate-slide-in {
        animation: slide-in 0.5s ease-out both;
    }

    .hover\:shake:hover {
        animation: shake 0.5s ease-in-out;
    }

    .animate-pulse {
        animation: status-pulse 2s ease-in-out infinite;
    }

    .status-updated {
        animation: status-pulse 0.6s ease-out;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s ease;
    }

    /* Glass morphism effect */
    .glass {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    /* Status option hover effects */
    .status-option:hover {
        transform: translateY(-2px);
    }

    .status-option.selected {
        border-color: #3b82f6;
        background-color: #dbeafe;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentDeviceId = null;
    let selectedStatus = null;
    const statusModal = document.getElementById('quick-status-modal');
    const modalContent = statusModal.querySelector('.bg-white');

    // Search functionality
    const searchInput = document.querySelector('.search-input');
    const statusFilter = document.querySelector('.status-filter');
    
    searchInput.addEventListener('input', filterDevices);
    statusFilter.addEventListener('change', filterDevices);
    
    // Refresh devices - ACTUALLY RELOAD THE PAGE
    document.getElementById('refresh-devices').addEventListener('click', function() {
        const icon = this.querySelector('i');
        icon.classList.add('rotate-180');
        
        // Actually reload the page to get fresh data from server
        setTimeout(() => {
            window.location.reload();
        }, 500);
    });
    
    // Quick status buttons
    document.querySelectorAll('.quick-status-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            currentDeviceId = this.getAttribute('data-device-id');
            const currentStatus = this.getAttribute('data-current-status');
            
            // Reset selection
            document.querySelectorAll('.status-option').forEach(option => {
                option.classList.remove('selected');
                if (option.getAttribute('data-status') === currentStatus) {
                    option.classList.add('selected');
                    selectedStatus = currentStatus;
                }
            });
            
            // Show modal
            statusModal.classList.remove('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-95', 'opacity-0');
        });
    });
    
    // Status option selection
    document.querySelectorAll('.status-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.status-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            selectedStatus = this.getAttribute('data-status');
        });
    });
    
    // Confirm status change
    document.getElementById('confirm-status').addEventListener('click', function() {
        if (currentDeviceId && selectedStatus) {
            updateDeviceStatus(currentDeviceId, selectedStatus);
            hideStatusModal();
        }
    });
    
    // Cancel status change
    document.getElementById('cancel-status').addEventListener('click', hideStatusModal);
    
    function hideStatusModal() {
        statusModal.classList.add('opacity-0', 'pointer-events-none');
        modalContent.classList.add('scale-95', 'opacity-0');
        currentDeviceId = null;
        selectedStatus = null;
    }
    
    function updateDeviceStatus(deviceId, newStatus) {
        // Find the device row
        const deviceRow = document.querySelector(`.device-row[data-device-id="${deviceId}"]`);
        const statusBadge = deviceRow.querySelector('.status-badge');
        const quickStatusBtn = deviceRow.querySelector('.quick-status-btn');
        
        // Show loading state
        const originalHTML = quickStatusBtn.innerHTML;
        quickStatusBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i><span>Updating...</span>';
        quickStatusBtn.disabled = true;
        
        // Send AJAX request to update status on server
        fetch(`/admin/devices/${deviceId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                status: newStatus,
                _method: 'PUT'
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update status badge with animation
                statusBadge.classList.add('status-updated');
                
                // Update status data attribute
                deviceRow.setAttribute('data-status', newStatus);
                quickStatusBtn.setAttribute('data-current-status', newStatus);
                
                // Update status badge appearance
                const statusConfig = {
                    'online': { color: 'bg-green-100 text-green-800', icon: 'fa-wifi', pulse: 'animate-pulse' },
                    'warning': { color: 'bg-orange-100 text-orange-800', icon: 'fa-exclamation-triangle', pulse: '' },
                    'offline': { color: 'bg-red-100 text-red-800', icon: 'fa-power-off', pulse: '' }
                };
                
                const config = statusConfig[newStatus];
                
                // Update badge classes and content
                statusBadge.className = `inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${config.color} status-badge ${config.pulse} status-updated`;
                statusBadge.setAttribute('data-device-status', newStatus);
                statusBadge.innerHTML = `<i class="fas ${config.icon} mr-1.5"></i>${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}`;
                
                // Update last active time if setting to online
                if (newStatus === 'online') {
                    const lastActiveElement = deviceRow.querySelector('.last-active');
                    lastActiveElement.textContent = 'Just now';
                }
                
                // Remove animation class after animation completes
                setTimeout(() => {
                    statusBadge.classList.remove('status-updated');
                }, 600);
                
                // Update statistics
                updateStatistics();
                
                // Show success message
                showToast(`Device status updated to ${newStatus}`, 'success');
                
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error updating device status:', error);
            showToast('Failed to update device status', 'error');
            
            // Restore original button state
            quickStatusBtn.innerHTML = originalHTML;
            quickStatusBtn.disabled = false;
        })
        .finally(() => {
            // Restore button state after a delay even on success
            setTimeout(() => {
                quickStatusBtn.innerHTML = '<i class="fas fa-bolt text-xs mr-1.5 group-hover:shake transition-transform"></i><span class="text-sm font-medium">Quick Status</span>';
                quickStatusBtn.disabled = false;
            }, 1000);
        });
    }
    
    function updateStatistics() {
        const devices = document.querySelectorAll('.device-row');
        let onlineCount = 0;
        let warningCount = 0;
        let offlineCount = 0;
        
        devices.forEach(device => {
            const status = device.getAttribute('data-status');
            if (status === 'online') onlineCount++;
            else if (status === 'warning') warningCount++;
            else if (status === 'offline') offlineCount++;
        });
        
        // Update stats cards with animation
        animateCounter('online-devices', onlineCount);
        animateCounter('warning-devices', warningCount);
        animateCounter('offline-devices', offlineCount);
        animateCounter('total-devices', devices.length);
        
        // Update active count
        document.getElementById('active-count').textContent = `${devices.length} Active`;
        document.getElementById('showing-count').textContent = devices.length;
    }
    
    function animateCounter(elementId, targetValue) {
        const element = document.getElementById(elementId);
        const currentValue = parseInt(element.textContent);
        
        if (currentValue !== targetValue) {
            element.style.transform = 'scale(1.1)';
            setTimeout(() => {
                element.textContent = targetValue;
                element.style.transform = 'scale(1)';
            }, 150);
        }
    }
    
    // Delete confirmation with sweet animation
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const deviceName = this.getAttribute('data-device-name');
            const form = this.closest('form');
            
            // Create custom confirmation modal
            if (confirm(`Are you sure you want to delete "${deviceName}"? This action cannot be undone.`)) {
                // Add loading state
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i><span>Deleting...</span>';
                this.disabled = true;
                
                // Add fade out animation to row
                const row = this.closest('.device-row');
                row.style.opacity = '0.5';
                row.style.transform = 'translateX(20px)';
                
                // Update statistics before removing
                setTimeout(() => {
                    updateStatistics();
                }, 200);
                
                setTimeout(() => {
                    form.submit();
                }, 500);
            }
        });
    });
    
    // Row hover effects
    document.addEventListener('mouseover', function(e) {
        if (e.target.closest('.device-row')) {
            const row = e.target.closest('.device-row');
            row.style.transform = 'translateX(8px)';
        }
    });
    
    document.addEventListener('mouseout', function(e) {
        if (e.target.closest('.device-row')) {
            const row = e.target.closest('.device-row');
            row.style.transform = 'translateX(0)';
        }
    });
    
    function filterDevices() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        let visibleCount = 0;
        
        document.querySelectorAll('.device-row').forEach(row => {
            const deviceName = row.getAttribute('data-name');
            const deviceStatus = row.getAttribute('data-status');
            const deviceLocation = row.querySelector('.device-location').textContent.toLowerCase();
            
            let showRow = true;
            
            // Search filter
            if (searchTerm && !deviceName.includes(searchTerm) && !deviceLocation.includes(searchTerm)) {
                showRow = false;
            }
            
            // Status filter
            if (statusValue !== 'all' && deviceStatus !== statusValue) {
                showRow = false;
            }
            
            if (showRow) {
                row.style.display = '';
                row.style.animation = 'slide-in 0.3s ease-out';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update showing count
        document.getElementById('showing-count').textContent = visibleCount;
    }
    
    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 bg-${type === 'success' ? 'green' : 'red'}-500 text-white px-6 py-3 rounded-2xl shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
        toast.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    // Initialize animations
    const initialRows = document.querySelectorAll('.device-row');
    initialRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
    });
});
</script>
@endsection