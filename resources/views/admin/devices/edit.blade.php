@extends('layouts.app')
@section('title', 'Edit Device')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-edit text-white text-2xl"></i>
                    </div>
                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-yellow-500 rounded-full border-4 border-white animate-pulse"></div>
                </div>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                Edit Device
            </h1>
            <p class="text-gray-500 text-lg">Update device information and settings</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-sm border border-white/20 p-8 hover:shadow-md transition-all duration-300">
            <form action="{{ route('admin.devices.update', $device->id) }}" method="POST" id="device-form" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Device Name -->
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-tag text-blue-500 mr-2"></i>
                        Device Name
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
                               value="{{ $device->name }}"
                               class="w-full px-4 py-4 bg-white/50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 placeholder-gray-400 text-lg shadow-sm"
                               placeholder="Enter device name"
                               required
                               onfocus="this.parentElement.classList.add('input-focused')"
                               onblur="this.parentElement.classList.remove('input-focused')">
                        <div class="absolute inset-0 rounded-2xl border-2 border-transparent group-hover:border-blue-500/30 transition-all duration-300 pointer-events-none"></div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-info-circle text-blue-400 mr-1"></i>
                        Give your device a descriptive name for easy identification
                    </p>
                </div>

                <!-- Serial Number -->
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-barcode text-green-500 mr-2"></i>
                        Serial Number
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="serial_number" 
                               value="{{ $device->serial_number }}"
                               class="w-full px-4 py-4 bg-white/50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all duration-300 placeholder-gray-400 text-lg shadow-sm font-mono"
                               placeholder="Enter serial number"
                               required
                               onfocus="this.parentElement.classList.add('input-focused')"
                               onblur="this.parentElement.classList.remove('input-focused')">
                        <div class="absolute inset-0 rounded-2xl border-2 border-transparent group-hover:border-green-500/30 transition-all duration-300 pointer-events-none"></div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-info-circle text-green-400 mr-1"></i>
                        Unique identifier for your device
                    </p>
                </div>

                <!-- Location -->
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-map-marker-alt text-orange-500 mr-2"></i>
                        Location
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="location" 
                               value="{{ $device->location }}"
                               class="w-full px-4 py-4 bg-white/50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-300 placeholder-gray-400 text-lg shadow-sm"
                               placeholder="Enter device location"
                               onfocus="this.parentElement.classList.add('input-focused')"
                               onblur="this.parentElement.classList.remove('input-focused')">
                        <div class="absolute inset-0 rounded-2xl border-2 border-transparent group-hover:border-orange-500/30 transition-all duration-300 pointer-events-none"></div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2 flex items-center">
                        <i class="fas fa-info-circle text-orange-400 mr-1"></i>
                        Physical location of the device (optional)
                    </p>
                </div>

                <!-- Device Status -->
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-power-off text-purple-500 mr-2"></i>
                        Device Status
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative">
                            <input type="radio" name="status" value="online" class="sr-only peer" {{ $device->status === 'online' ? 'checked' : '' }}>
                            <div class="p-4 bg-white border-2 border-gray-200 rounded-2xl cursor-pointer transition-all duration-300 peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:scale-105 hover:scale-105">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-semibold text-gray-800">Online</div>
                                        <div class="text-sm text-gray-500">Active and connected</div>
                                    </div>
                                    <div class="w-3 h-3 bg-green-500 rounded-full peer-checked:animate-pulse"></div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="status" value="warning" class="sr-only peer" {{ $device->status === 'warning' ? 'checked' : '' }}>
                            <div class="p-4 bg-white border-2 border-gray-200 rounded-2xl cursor-pointer transition-all duration-300 peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:scale-105 hover:scale-105">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-semibold text-gray-800">Warning</div>
                                        <div class="text-sm text-gray-500">Needs attention</div>
                                    </div>
                                    <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="status" value="offline" class="sr-only peer" {{ $device->status === 'offline' ? 'checked' : '' }}>
                            <div class="p-4 bg-white border-2 border-gray-200 rounded-2xl cursor-pointer transition-all duration-300 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:scale-105 hover:scale-105">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-semibold text-gray-800">Offline</div>
                                        <div class="text-sm text-gray-500">Not connected</div>
                                    </div>
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Additional Settings -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100/30 rounded-2xl p-6 border border-gray-200/50">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-cog text-purple-500 mr-2"></i>
                        Device Settings
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Device Type</label>
                            <select name="type" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-300">
                                <option value="Fire Sensor" {{ $device->type === 'Fire Sensor' ? 'selected' : '' }}>Fire Sensor</option>
                                <option value="Temperature Monitor" {{ $device->type === 'Temperature Monitor' ? 'selected' : '' }}>Temperature Monitor</option>
                                <option value="Smoke Detector" {{ $device->type === 'Smoke Detector' ? 'selected' : '' }}>Smoke Detector</option>
                                <option value="System Controller" {{ $device->type === 'System Controller' ? 'selected' : '' }}>System Controller</option>
                            </select>
                        </div>
                        
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alert Threshold</label>
                            <select name="alert_threshold" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-300">
                                <option value="Low" {{ $device->alert_threshold === 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ $device->alert_threshold === 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ $device->alert_threshold === 'High' ? 'selected' : '' }}>High</option>
                                <option value="Critical" {{ $device->alert_threshold === 'Critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Battery Level</label>
                            <div class="flex items-center space-x-3">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full transition-all duration-500" style="width: {{ $device->battery_level ?? 85 }}%"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-700 w-12">{{ $device->battery_level ?? 85 }}%</span>
                            </div>
                            <input type="hidden" name="battery_level" value="{{ $device->battery_level ?? 85 }}">
                        </div>

                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Signal Strength</label>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 4; $i++)
                                    <div class="w-2 h-{{ 4 + $i * 2 }} bg-{{ $i <= ($device->signal_strength ?? 3) ? 'green' : 'gray' }}-500 rounded-full transition-all duration-300 {{ $i <= ($device->signal_strength ?? 3) ? 'animate-pulse' : '' }}"></div>
                                @endfor
                            </div>
                            <input type="hidden" name="signal_strength" value="{{ $device->signal_strength ?? 3 }}">
                        </div>
                    </div>
                </div>

                <!-- Device Information -->
                <div class="bg-gradient-to-r from-blue-50 to-blue-100/30 rounded-2xl p-6 border border-blue-200/50">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Device Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Device ID:</span>
                            <span class="font-mono font-semibold">{{ $device->id }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Created:</span>
                            <span class="font-semibold">{{ $device->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="font-semibold">{{ $device->updated_at->format('M j, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Last Active:</span>
                            <span class="font-semibold">{{ $device->last_active ? $device->last_active->diffForHumans() : 'Never' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200/50">
                    <a href="{{ route('admin.devices.index') }}" 
                       class="flex-1 px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 group text-center">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        Back to Devices
                    </a>
                    <button type="submit" 
                            id="submit-btn"
                            class="flex-1 px-6 py-4 bg-gradient-to-r from-purple-600 to-blue-700 hover:from-purple-700 hover:to-blue-800 text-white rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group">
                        <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                        Update Device
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-3xl shadow-sm border border-red-200/50 p-6">
            <h3 class="text-lg font-semibold text-red-800 mb-4 flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                Danger Zone
            </h3>
            <p class="text-gray-600 mb-4">Once you delete a device, there is no going back. Please be certain.</p>
            <form action="{{ route('admin.devices.destroy', $device->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete()">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-2xl font-semibold transition-all duration-300 hover:scale-105 group">
                    <i class="fas fa-trash mr-2 group-hover:shake transition-transform"></i>
                    Delete Device
                </button>
            </form>
        </div>

        <!-- Progress Steps -->
        <div class="flex justify-center mt-8">
            <div class="flex items-center space-x-4 text-sm text-gray-500">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="font-medium text-green-600">Device Found</span>
                </div>
                <div class="w-8 h-0.5 bg-gray-300"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-purple-500 rounded-full animate-pulse"></div>
                    <span class="font-medium text-purple-600">Editing</span>
                </div>
                <div class="w-8 h-0.5 bg-gray-300"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                    <span>Updated</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-8 max-w-md mx-4 transform scale-95 opacity-0 transition-all duration-300">
        <div class="text-center">
            <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Device Updated!</h3>
            <p class="text-gray-600 mb-6">Your device has been successfully updated.</p>
            <div class="flex space-x-3">
                <a href="{{ route('admin.devices.index') }}" class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-semibold transition-all duration-300 inline-block text-center">
                    View Devices
                </a>
                <button onclick="location.reload()" class="flex-1 px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-2xl font-semibold transition-all duration-300">
                    Edit Again
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Real-time Status Update Modal -->
<div id="real-time-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-6 max-w-sm mx-4 transform scale-95 opacity-0 transition-all duration-300">
        <div class="text-center">
            <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-sync-alt text-white text-xl animate-spin"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Updating Status</h3>
            <p class="text-gray-600 mb-4">Synchronizing device status across the system...</p>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-2px); }
        75% { transform: translateX(2px); }
    }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(147, 51, 234, 0.3); }
        50% { box-shadow: 0 0 40px rgba(147, 51, 234, 0.6); }
    }

    @keyframes status-update {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .animate-pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }

    .hover\:shake:hover {
        animation: shake 0.5s ease-in-out;
    }

    .input-focused {
        transform: scale(1.02);
    }

    .status-updated {
        animation: status-update 0.6s ease-out;
    }

    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Loading animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Radio card selection animation */
    .peer:checked + div {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('device-form');
    const submitBtn = document.getElementById('submit-btn');
    const successModal = document.getElementById('success-modal');
    const realTimeModal = document.getElementById('real-time-modal');
    const realTimeModalContent = realTimeModal.querySelector('.bg-white');

    // Store original status for comparison
    const originalStatus = '{{ $device->status }}';
    let hasStatusChanged = false;

    // Monitor status changes
    document.querySelectorAll('input[name="status"]').forEach(radio => {
        radio.addEventListener('change', function() {
            hasStatusChanged = this.value !== originalStatus;
        });
    });

    // Enhanced form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<div class="loading"></div> Updating Device...';
        submitBtn.disabled = true;
        
        // Add pulse animation to submit button
        submitBtn.classList.add('animate-pulse-glow');

        // If status changed, show real-time sync modal first
        if (hasStatusChanged) {
            showRealTimeSync();
        }

        // Simulate API call with real-time sync
        setTimeout(() => {
            if (hasStatusChanged) {
                // Update device status in real-time (simulate WebSocket/Pusher)
                updateDeviceStatusInRealTime();
                
                // Hide real-time modal and show success
                setTimeout(() => {
                    hideRealTimeSync();
                    showSuccessModal();
                }, 1500);
            } else {
                // Direct to success if no status change
                showSuccessModal();
            }
        }, 1000);
    });

    function showRealTimeSync() {
        realTimeModal.classList.remove('opacity-0', 'pointer-events-none');
        realTimeModalContent.classList.remove('scale-95', 'opacity-0');
    }

    function hideRealTimeSync() {
        realTimeModal.classList.add('opacity-0', 'pointer-events-none');
        realTimeModalContent.classList.add('scale-95', 'opacity-0');
    }

    function showSuccessModal() {
        successModal.classList.remove('opacity-0', 'pointer-events-none');
        successModal.querySelector('.bg-white').classList.remove('scale-95', 'opacity-0');
        
        // Actually submit the form after animation
        setTimeout(() => {
            form.submit();
        }, 3000);
    }

    // Simulate real-time status update across the system
    function updateDeviceStatusInRealTime() {
        const formData = new FormData(form);
        const newStatus = formData.get('status');
        const deviceId = '{{ $device->id }}';
        const deviceName = '{{ $device->name }}';

        // In a real application, this would be a WebSocket/Pusher broadcast
        // For demo purposes, we'll simulate the real-time update
        
        console.log(`Real-time update: Device ${deviceId} (${deviceName}) status changed to ${newStatus}`);
        
        // You would typically send this to a WebSocket server:
        // socket.emit('device-status-update', {
        //     device_id: deviceId,
        //     status: newStatus,
        //     updated_at: new Date().toISOString()
        // });
        
        // For now, we'll store in localStorage to simulate cross-page communication
        const statusUpdate = {
            deviceId: deviceId,
            status: newStatus,
            timestamp: new Date().toISOString(),
            deviceName: deviceName
        };
        
        localStorage.setItem('lastDeviceStatusUpdate', JSON.stringify(statusUpdate));
        
        // Also update the browser tab title to show real-time activity
        document.title = `✓ Updated ${deviceName} - Device Management`;
        
        setTimeout(() => {
            document.title = 'Edit Device - Device Management';
        }, 2000);
    }

    // Input animations
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('input-focused');
        });
    });

    // Radio card animations
    const radioCards = document.querySelectorAll('input[type="radio"]');
    radioCards.forEach(radio => {
        radio.addEventListener('change', function() {
            // Add subtle animation to all cards
            document.querySelectorAll('input[type="radio"] + div').forEach(card => {
                card.style.transform = 'scale(1)';
            });
            
            // Scale up the selected card
            if (this.checked) {
                this.nextElementSibling.style.transform = 'scale(1.05)';
                this.nextElementSibling.classList.add('status-updated');
                
                setTimeout(() => {
                    this.nextElementSibling.classList.remove('status-updated');
                }, 600);
            }
        });
    });

    // Battery level animation
    const batteryLevel = {{ $device->battery_level ?? 85 }};
    const batteryBar = document.querySelector('.bg-green-500');
    if (batteryBar) {
        setTimeout(() => {
            batteryBar.style.width = batteryLevel + '%';
        }, 500);
    }

    // Signal strength animation
    const signalStrength = {{ $device->signal_strength ?? 3 }};
    const signalBars = document.querySelectorAll('.w-2');
    signalBars.forEach((bar, index) => {
        if (index < signalStrength) {
            setTimeout(() => {
                bar.classList.add('bg-green-500', 'animate-pulse');
            }, index * 200 + 500);
        }
    });

    // Delete confirmation
    window.confirmDelete = function() {
        const deviceName = '{{ $device->name }}';
        return confirm(`Are you sure you want to delete "${deviceName}"? This action cannot be undone.`);
    };

    // Add character counter for serial number
    const serialInput = document.querySelector('input[name="serial_number"]');
    serialInput.addEventListener('input', function() {
        const counter = this.parentElement.querySelector('.char-counter') || 
                       document.createElement('div');
        counter.className = 'char-counter text-xs text-gray-500 mt-1 text-right';
        counter.textContent = `${this.value.length} characters`;
        
        if (!this.parentElement.querySelector('.char-counter')) {
            this.parentElement.appendChild(counter);
        }
    });

    // Initialize character counter
    if (serialInput.value) {
        const counter = document.createElement('div');
        counter.className = 'char-counter text-xs text-gray-500 mt-1 text-right';
        counter.textContent = `${serialInput.value.length} characters`;
        serialInput.parentElement.appendChild(counter);
    }

    // Quick status preview
    const statusRadios = document.querySelectorAll('input[name="status"]');
    statusRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const status = this.value;
            const statusConfig = {
                'online': { color: 'bg-green-100 text-green-800', icon: 'fa-wifi' },
                'warning': { color: 'bg-orange-100 text-orange-800', icon: 'fa-exclamation-triangle' },
                'offline': { color: 'bg-red-100 text-red-800', icon: 'fa-power-off' }
            };
            
            const config = statusConfig[status];
            const previewElement = document.getElementById('status-preview') || createStatusPreview();
            
            previewElement.className = `inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${config.color} status-updated`;
            previewElement.innerHTML = `<i class="fas ${config.icon} mr-1.5"></i>${status.charAt(0).toUpperCase() + status.slice(1)}`;
        });
    });

    function createStatusPreview() {
        const preview = document.createElement('div');
        preview.id = 'status-preview';
        preview.className = 'fixed bottom-4 right-4 z-50 px-4 py-2 rounded-2xl shadow-lg bg-white border';
        preview.innerHTML = '<span class="text-sm font-medium">Status Preview</span>';
        document.body.appendChild(preview);
        return preview;
    }

    // Check for any pending real-time updates when page loads
    const lastUpdate = localStorage.getItem('lastDeviceStatusUpdate');
    if (lastUpdate) {
        const update = JSON.parse(lastUpdate);
        if (update.deviceId === '{{ $device->id }}') {
            console.log('Device status was recently updated:', update);
            // You could show a notification or update the form accordingly
        }
        // Clear the update after processing
        localStorage.removeItem('lastDeviceStatusUpdate');
    }
});
</script>
@endsection