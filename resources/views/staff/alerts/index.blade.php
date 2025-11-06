@extends('layouts.app')

@section('title', 'My Alerts')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="min-h-screen bg-gradient-to-br from-white to-red-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center" data-aos="fade-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-3xl shadow-2xl mb-6 transform transition-all duration-500 hover:scale-110 hover:shadow-2xl hover:from-red-700 hover:to-red-800">
                <i class="fas fa-bell text-white text-2xl"></i>
            </div>
            <h1 class="text-5xl font-black text-gray-900 mb-4 bg-gradient-to-r from-red-700 to-red-600 bg-clip-text text-transparent">
                My Alerts
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Monitor and manage all fire and safety alerts in real-time
            </p>
            <div class="w-32 h-1.5 bg-gradient-to-r from-red-500 to-red-400 rounded-full mx-auto mt-6 shadow-sm"></div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8" data-aos="fade-up">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Alerts</p>
                        <p class="text-3xl font-bold text-gray-900">24</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-bell text-red-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Active</p>
                        <p class="text-3xl font-bold text-red-600">8</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">In Progress</p>
                        <p class="text-3xl font-bold text-blue-600">12</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-spinner text-blue-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Resolved</p>
                        <p class="text-3xl font-bold text-green-600">4</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Alerts Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-red-100 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-fire text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Fire Alerts Management</h2>
                            <p class="text-red-100">Monitor and respond to all safety alerts</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <input type="text" placeholder="Search alerts..." 
                                   class="pl-10 pr-4 py-2 bg-white/20 backdrop-blur-sm border border-white/30 rounded-2xl text-white placeholder-red-100 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50 transition-all duration-300">
                            <i class="fas fa-search absolute left-3 top-2.5 text-red-100 text-sm"></i>
                        </div>
                        <button class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/30 hover:bg-white/30 transition-all duration-300">
                            <i class="fas fa-filter text-white text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Alerts Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-red-600 to-red-700 text-white">
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-hashtag"></i>
                                    Alert ID
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Location
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-fire"></i>
                                    Alert Type
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-gauge-high"></i>
                                    Severity
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock"></i>
                                    Time Reported
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-tasks"></i>
                                    Status
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-cog"></i>
                                    Actions
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Active Alert -->
                        <tr class="hover:bg-red-50 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="300">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shadow-inner">
                                        <span class="text-red-700 font-bold text-sm">#101</span>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <div class="font-semibold text-gray-900 group-hover:text-red-700 transition-colors duration-300">
                                        Zone 2 - Main Building
                                    </div>
                                    <div class="text-sm text-gray-500 truncate mt-1">
                                        Floor 3, Room 301 - Near emergency exit
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-gray-700">
                                    <i class="fas fa-fire-flame-curved text-red-500 text-sm"></i>
                                    <span class="font-medium">Fire Detected</span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-3 py-1 rounded-2xl font-semibold text-sm shadow-sm">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Critical
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="text-gray-700">
                                    <div class="font-medium">2 minutes ago</div>
                                    <div class="text-sm text-gray-500">14:25 PM</div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 bg-red-100 text-red-700 px-4 py-2 rounded-2xl font-semibold text-sm shadow-sm animate-pulse">
                                    <i class="fas fa-circle"></i>
                                    Active
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                                        <i class="fas fa-check group-hover:scale-110 transition-transform duration-300"></i>
                                        Respond
                                    </button>
                                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                                        <i class="fas fa-eye group-hover:scale-110 transition-transform duration-300"></i>
                                        View
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- In Progress Alert -->
                        <tr class="hover:bg-blue-50 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="350">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center shadow-inner">
                                        <span class="text-blue-700 font-bold text-sm">#102</span>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <div class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-300">
                                        Zone 5 - Library
                                    </div>
                                    <div class="text-sm text-gray-500 truncate mt-1">
                                        West Wing, Reading Area - Smoke detected
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-gray-700">
                                    <i class="fas fa-smog text-orange-500 text-sm"></i>
                                    <span class="font-medium">Smoke Alert</span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 bg-orange-100 text-orange-700 px-3 py-1 rounded-2xl font-semibold text-sm shadow-sm">
                                    <i class="fas fa-exclamation"></i>
                                    High
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="text-gray-700">
                                    <div class="font-medium">15 minutes ago</div>
                                    <div class="text-sm text-gray-500">14:12 PM</div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-2xl font-semibold text-sm shadow-sm">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    In Progress
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                                        <i class="fas fa-check group-hover:scale-110 transition-transform duration-300"></i>
                                        Resolve
                                    </button>
                                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                                        <i class="fas fa-eye group-hover:scale-110 transition-transform duration-300"></i>
                                        View
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Resolved Alert -->
                        <tr class="hover:bg-green-50 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="400">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center shadow-inner">
                                        <span class="text-green-700 font-bold text-sm">#103</span>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <div class="font-semibold text-gray-900 group-hover:text-green-700 transition-colors duration-300">
                                        Zone 3 - Cafeteria
                                    </div>
                                    <div class="text-sm text-gray-500 truncate mt-1">
                                        Kitchen Area - False alarm, cooking smoke
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-gray-700">
                                    <i class="fas fa-temperature-high text-yellow-500 text-sm"></i>
                                    <span class="font-medium">Heat Alert</span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-3 py-1 rounded-2xl font-semibold text-sm shadow-sm">
                                    <i class="fas fa-info-circle"></i>
                                    Medium
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="text-gray-700">
                                    <div class="font-medium">1 hour ago</div>
                                    <div class="text-sm text-gray-500">13:30 PM</div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-2xl font-semibold text-sm shadow-sm">
                                    <i class="fas fa-check-circle"></i>
                                    Resolved
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                                        <i class="fas fa-eye group-hover:scale-110 transition-transform duration-300"></i>
                                        View Details
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Additional Sample Alerts -->
                        <tr class="hover:bg-yellow-50 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="450">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center shadow-inner">
                                        <span class="text-yellow-700 font-bold text-sm">#104</span>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <div class="font-semibold text-gray-900 group-hover:text-yellow-700 transition-colors duration-300">
                                        Zone 1 - Admin Building
                                    </div>
                                    <div class="text-sm text-gray-500 truncate mt-1">
                                        Server Room - Temperature spike detected
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-gray-700">
                                    <i class="fas fa-microchip text-purple-500 text-sm"></i>
                                    <span class="font-medium">Equipment Alert</span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-3 py-1 rounded-2xl font-semibold text-sm shadow-sm">
                                    <i class="fas fa-exclamation"></i>
                                    High
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="text-gray-700">
                                    <div class="font-medium">2 hours ago</div>
                                    <div class="text-sm text-gray-500">12:45 PM</div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-4 py-2 rounded-2xl font-semibold text-sm shadow-sm">
                                    <i class="fas fa-hourglass-half"></i>
                                    Pending
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                                        <i class="fas fa-play group-hover:scale-110 transition-transform duration-300"></i>
                                        Start
                                    </button>
                                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                                        <i class="fas fa-eye group-hover:scale-110 transition-transform duration-300"></i>
                                        View
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="500">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Alert Analytics</h3>
                        <p class="text-sm text-gray-500">View detailed reports and trends</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-download text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Export Reports</h3>
                        <p class="text-sm text-gray-500">Download alert history</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-cog text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Alert Settings</h3>
                        <p class="text-sm text-gray-500">Configure notifications</p>
                    </div>
                </div>
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
    
    /* Table row animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Status animations */
    .fa-spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
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
        
        // Add hover effects to table rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(8px)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
        
        // Simulate real-time updates
        setInterval(() => {
            const activeAlerts = document.querySelectorAll('[class*="bg-red-100"]');
            activeAlerts.forEach(alert => {
                if (alert.classList.contains('animate-pulse')) {
                    alert.classList.remove('animate-pulse');
                    setTimeout(() => {
                        alert.classList.add('animate-pulse');
                    }, 100);
                }
            });
        }, 5000);
    });
    
    // Handle alert actions
    function handleAlertAction(alertId, action) {
        console.log(`Action: ${action} on Alert: ${alertId}`);
        // Add your alert handling logic here
    }
</script>
@endsection