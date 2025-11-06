@extends('layouts.app')

@section('title', 'Nearby Devices')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-white to-red-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-12 text-center" data-aos="fade-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-3xl shadow-2xl mb-6 transform transition-all duration-500 hover:scale-110 hover:shadow-2xl hover:from-red-700 hover:to-red-800">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h1 class="text-5xl font-black text-gray-900 mb-4 bg-gradient-to-r from-red-700 to-red-600 bg-clip-text text-transparent">
                Nearby IoT Devices
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Monitor and manage all connected IoT devices in your network with real-time status updates
            </p>
            <div class="w-32 h-1.5 bg-gradient-to-r from-red-500 to-red-400 rounded-full mx-auto mt-6 shadow-sm"></div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8" data-aos="fade-up">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Devices</p>
                        <p class="text-3xl font-bold text-gray-900">24</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Online</p>
                        <p class="text-3xl font-bold text-green-600">18</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Offline</p>
                        <p class="text-3xl font-bold text-red-600">4</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Maintenance</p>
                        <p class="text-3xl font-bold text-yellow-600">2</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls Bar -->
        <div class="mb-8 flex flex-col sm:flex-row gap-4 justify-between items-center" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center gap-4">
                <!-- Search -->
                <div class="relative">
                    <input type="text" placeholder="Search devices..." class="pl-10 pr-4 py-3 bg-white border border-red-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 w-64">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                
                <!-- Filter -->
                <select class="px-4 py-3 bg-white border border-red-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300">
                    <option>All Status</option>
                    <option>Online</option>
                    <option>Offline</option>
                    <option>Maintenance</option>
                </select>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center gap-3">
                <button class="inline-flex items-center px-6 py-3 bg-gradient-to-br from-red-600 to-red-700 text-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Device
                </button>
                
                <button class="inline-flex items-center px-6 py-3 bg-white text-gray-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-red-200 hover:border-red-300 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Devices Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Device Card 1 -->
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-red-100 overflow-hidden group"
                 data-aos="fade-up" data-aos-delay="100">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-2 bg-green-100 px-3 py-1 rounded-full">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-semibold text-green-700">Active</span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-red-700 transition-colors duration-300">Device A</h3>
                    <p class="text-gray-600 mb-4">Smart Sensor Unit</p>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500">Signal</p>
                            <p class="text-lg font-bold text-gray-900">92%</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500">Battery</p>
                            <p class="text-lg font-bold text-green-600">78%</p>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-sm text-gray-500">Last active: 2m ago</span>
                        <button class="text-red-600 hover:text-red-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Device Card 2 -->
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-red-100 overflow-hidden group"
                 data-aos="fade-up" data-aos-delay="200">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-2 bg-red-100 px-3 py-1 rounded-full">
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                            <span class="text-sm font-semibold text-red-700">Offline</span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-red-700 transition-colors duration-300">Device B</h3>
                    <p class="text-gray-600 mb-4">Temperature Monitor</p>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500">Signal</p>
                            <p class="text-lg font-bold text-gray-900">0%</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500">Battery</p>
                            <p class="text-lg font-bold text-red-600">15%</p>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-sm text-gray-500">Last active: 2h ago</span>
                        <button class="text-red-600 hover:text-red-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Device Card 3 -->
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-red-100 overflow-hidden group"
                 data-aos="fade-up" data-aos-delay="300">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-2 bg-green-100 px-3 py-1 rounded-full">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-semibold text-green-700">Active</span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-red-700 transition-colors duration-300">Device C</h3>
                    <p class="text-gray-600 mb-4">Motion Detector</p>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500">Signal</p>
                            <p class="text-lg font-bold text-gray-900">85%</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500">Battery</p>
                            <p class="text-lg font-bold text-green-600">92%</p>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-sm text-gray-500">Last active: 5m ago</span>
                        <button class="text-red-600 hover:text-red-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Device Card 4 -->
            <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-red-100 overflow-hidden group"
                 data-aos="fade-up" data-aos-delay="400">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-2 bg-yellow-100 px-3 py-1 rounded-full">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                            <span class="text-sm font-semibold text-yellow-700">Maintenance</span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-red-700 transition-colors duration-300">Device D</h3>
                    <p class="text-gray-600 mb-4">Humidity Sensor</p>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500">Signal</p>
                            <p class="text-lg font-bold text-gray-900">45%</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-xl">
                            <p class="text-sm text-gray-500">Battery</p>
                            <p class="text-lg font-bold text-yellow-600">32%</p>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-sm text-gray-500">Under maintenance</span>
                        <button class="text-red-600 hover:text-red-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State (if no devices) -->
        <div class="text-center py-16 hidden" id="emptyState">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-red-100 rounded-3xl flex items-center justify-center shadow-inner mx-auto mb-6">
                    <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-3">No Devices Found</h3>
                <p class="text-gray-500 mb-8">
                    No IoT devices are currently connected to your network.
                </p>
                <button class="inline-flex items-center px-6 py-3 bg-gradient-to-br from-red-600 to-red-700 text-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add First Device
                </button>
            </div>
        </div>
    </div>
</div>

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
    
    /* Status animations */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

<script>
    // Initialize AOS animations
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic'
        });
        
        // Add hover effects to device cards
        const deviceCards = document.querySelectorAll('.bg-white.rounded-3xl');
        deviceCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-12px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Simulate real-time status updates
        setInterval(() => {
            const statusIndicators = document.querySelectorAll('.animate-pulse');
            statusIndicators.forEach(indicator => {
                indicator.style.animation = 'none';
                setTimeout(() => {
                    indicator.style.animation = 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite';
                }, 10);
            });
        }, 5000);
        
        // Search functionality
        const searchInput = document.querySelector('input[type="text"]');
        searchInput?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.bg-white.rounded-3xl');
            
            cards.forEach(card => {
                const deviceName = card.querySelector('h3').textContent.toLowerCase();
                if (deviceName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection