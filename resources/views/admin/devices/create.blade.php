@extends('layouts.app')
@section('title', 'Add Device')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-microchip text-white text-2xl"></i>
                    </div>
                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-4 border-white animate-pulse"></div>
                </div>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                Add New Device
            </h1>
            <p class="text-gray-500 text-lg">Register a new device to your monitoring system</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-sm border border-white/20 p-8 hover:shadow-md transition-all duration-300">
            <form action="{{ route('admin.devices.store') }}" method="POST" id="device-form" class="space-y-6">
                @csrf
                
                <!-- Device Name -->
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-tag text-blue-500 mr-2"></i>
                        Device Name
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
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

                <!-- Additional Settings -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100/30 rounded-2xl p-6 border border-gray-200/50">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-cog text-purple-500 mr-2"></i>
                        Device Settings
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Device Type</label>
                            <select class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-300">
                                <option>Fire Sensor</option>
                                <option>Temperature Monitor</option>
                                <option>Smoke Detector</option>
                                <option>System Controller</option>
                            </select>
                        </div>
                        
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alert Threshold</label>
                            <select class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-300">
                                <option>Low</option>
                                <option>Medium</option>
                                <option>High</option>
                                <option>Critical</option>
                            </select>
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
                            class="flex-1 px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group">
                        <i class="fas fa-plus-circle mr-2 group-hover:rotate-90 transition-transform"></i>
                        Add Device
                    </button>
                </div>
            </form>
        </div>

        <!-- Progress Steps -->
        <div class="flex justify-center mt-8">
            <div class="flex items-center space-x-4 text-sm text-gray-500">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                    <span class="font-medium text-blue-600">Adding Device</span>
                </div>
                <div class="w-8 h-0.5 bg-gray-300"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                    <span>Configuration</span>
                </div>
                <div class="w-8 h-0.5 bg-gray-300"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                    <span>Ready</span>
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
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Device Added!</h3>
            <p class="text-gray-600 mb-6">Your device has been successfully registered to the system.</p>
            <a href="{{ route('admin.devices.index') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-semibold transition-all duration-300 inline-block">
                View Devices
            </a>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
        50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.6); }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    .animate-pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }

    .input-focused {
        transform: scale(1.02);
    }

    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Custom focus styles */
    input:focus, select:focus {
        transform: scale(1.02);
    }

    /* Glass morphism effect */
    .glass {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('device-form');
    const submitBtn = document.getElementById('submit-btn');
    const successModal = document.getElementById('success-modal');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<div class="loading"></div> Adding Device...';
        submitBtn.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            // Show success modal
            successModal.classList.remove('opacity-0', 'pointer-events-none');
            successModal.querySelector('.bg-white').classList.remove('scale-95', 'opacity-0');
            
            // Actually submit the form after animation
            setTimeout(() => {
                form.submit();
            }, 2000);
        }, 1500);
    });

    // Input animations
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('input-focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('input-focused');
        });
        
        // Add floating label effect
        input.addEventListener('input', function() {
            if (this.value) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
    });

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
        
        // Add validation feedback
        if (this.value.length < 5) {
            this.style.borderColor = '#f87171';
        } else {
            this.style.borderColor = '#34d399';
        }
    });

    // Add hover effects to form sections
    const formGroups = document.querySelectorAll('.group');
    formGroups.forEach(group => {
        group.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        group.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection