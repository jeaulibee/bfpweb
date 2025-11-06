@extends('layouts.app')

@section('title', 'My Incidents')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="min-h-screen bg-gradient-to-br from-white to-red-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center" data-aos="fade-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-3xl shadow-2xl mb-6 transform transition-all duration-500 hover:scale-110 hover:shadow-2xl hover:from-red-700 hover:to-red-800">
                <i class="fas fa-fire text-white text-2xl"></i>
            </div>
            <h1 class="text-5xl font-black text-gray-900 mb-4 bg-gradient-to-r from-red-700 to-red-600 bg-clip-text text-transparent">
                My Incidents
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Manage and track all incidents assigned to you with real-time status updates
            </p>
            <div class="w-32 h-1.5 bg-gradient-to-r from-red-500 to-red-400 rounded-full mx-auto mt-6 shadow-sm"></div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8" data-aos="fade-up">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Incidents</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $incidents->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-fire text-red-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Active</p>
                        <p class="text-3xl font-bold text-yellow-600">
                            {{ $incidents->where('status', 'active')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-hourglass-half text-yellow-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">In Progress</p>
                        <p class="text-3xl font-bold text-blue-600">
                            {{ $incidents->where('status', 'in-progress')->count() }}
                        </p>
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
                        <p class="text-3xl font-bold text-green-600">
                            {{ $incidents->where('status', 'resolved')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-red-100 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-fire text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Incident Management</h2>
                            <p class="text-red-100">Manage all your assigned incidents</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('staff.incidents.create') }}" 
                       class="inline-flex items-center gap-3 bg-white text-red-700 px-6 py-3 rounded-2xl font-bold shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 group">
                        <i class="fas fa-plus group-hover:scale-110 transition-transform duration-300"></i>
                        Create New Incident
                    </a>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-red-600 to-red-700 text-white">
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-hashtag"></i>
                                    ID
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left font-bold uppercase tracking-wider text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-heading"></i>
                                    Title
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
                                    <i class="fas fa-user"></i>
                                    Reported By
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
                        @forelse($incidents as $incident)
                            <tr class="hover:bg-gray-50 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shadow-inner">
                                            <span class="text-red-700 font-bold text-sm">#{{ $incident->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <div class="font-semibold text-gray-900 group-hover:text-gray-700 transition-colors duration-300">
                                            {{ $incident->title }}
                                        </div>
                                        @if($incident->description)
                                            <div class="text-sm text-gray-500 truncate mt-1">
                                                {{ Str::limit($incident->description, 50) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <i class="fas fa-map-marker-alt text-red-500 text-sm"></i>
                                        {{ $incident->location ?? '—' }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center shadow-md">
                                            <span class="text-white text-xs font-bold">
                                                {{ strtoupper(substr($incident->reporter->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <span class="text-gray-700 font-medium">
                                            {{ $incident->reporter->name ?? '—' }}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    @if($incident->status === 'resolved')
                                        <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-2xl font-semibold text-sm shadow-sm">
                                            <i class="fas fa-check-circle animate-pulse"></i>
                                            Resolved
                                        </span>
                                    @elseif($incident->status === 'in-progress')
                                        <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-2xl font-semibold text-sm shadow-sm">
                                            <i class="fas fa-spinner fa-spin"></i>
                                            In Progress
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-4 py-2 rounded-2xl font-semibold text-sm shadow-sm">
                                            <i class="fas fa-hourglass-half"></i>
                                            {{ ucfirst($incident->status) }}
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('staff.incidents.edit', $incident->id) }}" 
                                           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                                            <i class="fas fa-edit group-hover:scale-110 transition-transform duration-300"></i>
                                            Edit
                                        </a>
                                        
                                        <a href="{{ route('staff.incidents.show', $incident->id) }}" 
                                           class="inline-flex items-center gap-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white px-4 py-2 rounded-2xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                                            <i class="fas fa-eye group-hover:scale-110 transition-transform duration-300"></i>
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="max-w-md mx-auto" data-aos="zoom-in">
                                        <div class="w-24 h-24 bg-red-100 rounded-3xl flex items-center justify-center shadow-inner mx-auto mb-4">
                                            <i class="fas fa-fire text-red-400 text-3xl"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-700 mb-2">No Incidents Found</h3>
                                        <p class="text-gray-500 mb-6">You don't have any incidents assigned to you yet.</p>
                                        <a href="{{ route('staff.incidents.create') }}" 
                                           class="inline-flex items-center gap-3 bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                            <i class="fas fa-plus"></i>
                                            Create Your First Incident
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast" class="fixed top-6 right-6 z-50 transform translate-x-full transition-transform duration-300">
    <div class="bg-gray-900 text-white px-6 py-4 rounded-2xl shadow-2xl max-w-sm">
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-green-400 text-lg"></i>
            <div>
                <p class="font-semibold" id="toast-message">Success!</p>
                <p class="text-gray-300 text-sm" id="toast-description">Operation completed successfully</p>
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
        
        // Check for success messages in URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === 'true') {
            showToast('Incident updated successfully!', 'success');
        }
    });
    
    // Enhanced toast function
    function showToast(message, type = 'success', description = '') {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        const toastDescription = document.getElementById('toast-description');
        
        // Update toast content
        toastMessage.textContent = message;
        toastDescription.textContent = description;
        
        // Update toast style based on type
        const icon = toast.querySelector('i');
        if (type === 'error') {
            icon.className = 'fas fa-exclamation-circle text-red-400 text-lg';
            toast.querySelector('.bg-gray-900').className = 'bg-red-600 text-white px-6 py-4 rounded-2xl shadow-2xl max-w-sm';
        } else {
            icon.className = 'fas fa-check-circle text-green-400 text-lg';
            toast.querySelector('.bg-gray-900').className = 'bg-gray-900 text-white px-6 py-4 rounded-2xl shadow-2xl max-w-sm';
        }
        
        // Show toast
        toast.style.transform = 'translateX(0)';
        
        // Hide toast after 3 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(full)';
        }, 3000);
    }
</script>
@endsection