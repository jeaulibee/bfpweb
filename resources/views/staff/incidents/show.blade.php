@extends('layouts.app')

@section('title', 'Incident Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-white to-red-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center" data-aos="fade-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-3xl shadow-2xl mb-6 transform transition-all duration-500 hover:scale-110 hover:shadow-2xl hover:from-red-700 hover:to-red-800">
                <i class="fas fa-fire-flame-curved text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-black text-gray-900 mb-4 bg-gradient-to-r from-red-700 to-red-600 bg-clip-text text-transparent">
                Incident Details
            </h1>
            <p class="text-lg text-gray-600 max-w-md mx-auto leading-relaxed">
                Comprehensive incident information and status tracking
            </p>
            <div class="w-24 h-1.5 bg-gradient-to-r from-red-500 to-red-400 rounded-full mx-auto mt-4 shadow-sm"></div>
        </div>

        <!-- Incident Overview Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8" data-aos="fade-up">
            <!-- Incident ID -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Incident ID</p>
                        <p class="text-2xl font-bold text-gray-900">#{{ $incident->id ?? '1' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-hashtag text-red-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <!-- Status -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Status</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Active
                            </span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-circle-check text-green-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <!-- Date Reported -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Date Reported</p>
                        <p class="text-lg font-bold text-gray-900">{{ $incident->created_at->format('M d, Y') ?? 'Oct 13, 2025' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar text-blue-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <!-- Priority -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Priority</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                                High
                            </span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation text-orange-600 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Details Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-red-100 overflow-hidden transform hover:shadow-3xl transition-all duration-500"
             data-aos="fade-up" data-aos-delay="200">
            
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-info-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Incident Information</h2>
                            <p class="text-red-100">Complete details and description</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-2xl px-4 py-2 border border-white/30">
                        <i class="fas fa-clock text-white text-sm"></i>
                        <span class="text-white text-sm font-medium">Last updated 2 hours ago</span>
                    </div>
                </div>
            </div>

            <!-- Card Content -->
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-red-500"></i>
                            Location Details
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">
                                    Incident Location
                                </label>
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-200">
                                    <i class="fas fa-location-dot text-red-500"></i>
                                    <span class="text-gray-900 font-medium">{{ $incident->location ?? 'Koronadal City' }}</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">
                                    Specific Area
                                </label>
                                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-200">
                                    <i class="fas fa-building text-blue-500"></i>
                                    <span class="text-gray-900 font-medium">Barangay San Isidro</span>
                                </div>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mt-6">
                            <i class="fas fa-calendar-day text-red-500"></i>
                            Timeline
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center gap-4 p-3 bg-blue-50 rounded-xl border border-blue-200">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-flag text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Incident Reported</p>
                                    <p class="text-sm text-gray-600">October 13, 2025 - 14:30</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 p-3 bg-green-50 rounded-xl border border-green-200">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-users text-green-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Response Team Deployed</p>
                                    <p class="text-sm text-gray-600">October 13, 2025 - 14:35</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description & Actions -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-file-lines text-red-500"></i>
                            Incident Description
                        </h3>
                        
                        <div class="p-6 bg-gray-50 rounded-2xl border border-gray-200">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $incident->description ?? 'Fire broke out at Barangay San Isidro. Multiple structures affected. Responding units deployed including fire trucks and emergency medical services. Situation is being contained with evacuation procedures in place for nearby residents.' }}
                            </p>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mt-6">
                            <i class="fas fa-users-gear text-red-500"></i>
                            Response Team
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-200 shadow-sm">
                                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-truck-fire text-red-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Fire Department</p>
                                    <p class="text-sm text-gray-600">3 units deployed</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-200 shadow-sm">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-truck-medical text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Emergency Medical</p>
                                    <p class="text-sm text-gray-600">2 ambulances on site</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-4">
                                <i class="fas fa-bolt text-yellow-500"></i>
                                Quick Actions
                            </h3>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('staff.incidents.edit', $incident->id ?? 1) }}" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all duration-300 font-semibold hover:scale-105 transform">
                                    <i class="fas fa-edit"></i>
                                    Edit Incident
                                </a>
                                <button class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-300 font-semibold hover:scale-105 transform">
                                    <i class="fas fa-print"></i>
                                    Print Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 mt-8" data-aos="fade-up" data-aos-delay="400">
            <a href="{{ route('staff.incidents.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-2xl border border-gray-300 shadow-sm hover:shadow-md transition-all duration-300 font-semibold hover:scale-105 transform group flex-1 text-center">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-300"></i>
                Back to Incidents
            </a>
            
            <a href="{{ route('staff.incidents.edit', $incident->id ?? 1) }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 font-bold hover:scale-105 transform group flex-1 text-center">
                <i class="fas fa-edit group-hover:scale-110 transition-transform duration-300"></i>
                Edit Incident Details
            </a>
        </div>

        <!-- Map Section -->
        <div class="mt-8 bg-white rounded-3xl shadow-2xl border border-red-100 overflow-hidden" data-aos="fade-up" data-aos-delay="500">
            <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-map text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Incident Location Map</h2>
                        <p class="text-gray-200 text-sm">Real-time location tracking</p>
                    </div>
                </div>
            </div>
            <div class="p-6 h-64 bg-gradient-to-br from-gray-100 to-gray-200 rounded-b-3xl flex items-center justify-center">
                <div class="text-center text-gray-600">
                    <i class="fas fa-map-marked-alt text-4xl mb-3 text-red-500"></i>
                    <p class="font-semibold">Interactive Map View</p>
                    <p class="text-sm">Location: Koronadal City, Barangay San Isidro</p>
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
    });
</script>
@endsection