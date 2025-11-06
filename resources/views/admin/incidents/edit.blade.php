@extends('layouts.app')
@section('title', 'Edit Incident Report')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Toast Container -->
        <div id="toast" class="toast"></div>

        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-2xl shadow-sm mb-4">
                <i class="fas fa-edit text-red-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Incident Report</h1>
            <p class="text-gray-600 text-lg">Update incident details and information</p>
        </div>

        <!-- Progress Steps -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center w-full max-w-md">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-semibold shadow-lg">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-sm font-medium text-green-600 mt-2">Details</span>
                </div>
                <div class="flex-1 h-1 bg-green-600 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div id="step2" class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-semibold shadow-lg">
                        2
                    </div>
                    <span class="text-sm font-medium text-red-600 mt-2">Edit</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div id="step3" class="w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-semibold">
                        3
                    </div>
                    <span class="text-sm font-medium text-gray-500 mt-2">Review</span>
                </div>
            </div>
        </div>

        <!-- Edit Form Card -->
        <div id="editForm" class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                    <i class="fas fa-edit"></i>
                    Edit Incident #{{ $incident->id }}
                </h2>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                {{-- Display Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <h3 class="text-red-800 font-semibold">Please fix the following errors:</h3>
                        </div>
                        <ul class="list-disc pl-5 text-red-700 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="incidentForm" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Title & Location Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Title --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fas fa-heading text-red-500 text-sm"></i>
                                Incident Title *
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="title" 
                                    value="{{ old('title', $incident->title) }}"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm"
                                    placeholder="Enter incident title"
                                    required
                                >
                                <i class="fas fa-pen absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-red-500 text-sm"></i>
                                Location
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="location" 
                                    value="{{ old('location', $incident->location) }}"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm"
                                    placeholder="Enter incident location"
                                >
                                <i class="fas fa-location-dot absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-align-left text-red-500 text-sm"></i>
                            Description
                        </label>
                        <div class="relative">
                            <textarea 
                                name="description" 
                                rows="5"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm resize-vertical"
                                placeholder="Provide detailed description of the incident..."
                            >{{ old('description', $incident->description) }}</textarea>
                            <i class="fas fa-file-text absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Provide as much detail as possible</span>
                            <span id="charCount">{{ strlen(old('description', $incident->description)) }} characters</span>
                        </div>
                    </div>

                    <!-- Status & Reported By Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Status --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fas fa-flag text-red-500 text-sm"></i>
                                Status *
                            </label>
                            <div class="relative">
                                <select 
                                    name="status" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm appearance-none"
                                    required
                                >
                                    <option value="pending" {{ old('status', $incident->status) == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                                    <option value="in-progress" {{ old('status', $incident->status) == 'in-progress' ? 'selected' : '' }}>🔵 In Progress</option>
                                    <option value="resolved" {{ old('status', $incident->status) == 'resolved' ? 'selected' : '' }}>🟢 Resolved</option>
                                </select>
                                <i class="fas fa-caret-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                                <i class="fas fa-chart-line absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            </div>
                        </div>

                        {{-- Reported By --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fas fa-user text-red-500 text-sm"></i>
                                Reported By *
                            </label>
                            <div class="relative">
                                <select 
                                    name="reported_by" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm appearance-none"
                                    required
                                >
                                    <option value="">-- Select User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('reported_by', $incident->reported_by) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-caret-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                                <i class="fas fa-users absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Priority & Type Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Priority --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle text-red-500 text-sm"></i>
                                Priority
                            </label>
                            <div class="relative">
                                <select 
                                    name="priority" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm appearance-none"
                                >
                                    <option value="low" {{ old('priority', $incident->priority) == 'low' ? 'selected' : '' }}>🟢 Low Priority</option>
                                    <option value="medium" {{ old('priority', $incident->priority) == 'medium' ? 'selected' : '' }}>🟡 Medium Priority</option>
                                    <option value="high" {{ old('priority', $incident->priority) == 'high' ? 'selected' : '' }}>🔴 High Priority</option>
                                    <option value="critical" {{ old('priority', $incident->priority) == 'critical' ? 'selected' : '' }}>⚫ Critical</option>
                                </select>
                                <i class="fas fa-caret-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                                <i class="fas fa-arrow-up-wide-short absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            </div>
                        </div>

                        {{-- Incident Type --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fas fa-tag text-red-500 text-sm"></i>
                                Incident Type
                            </label>
                            <div class="relative">
                                <select 
                                    name="type" 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm appearance-none"
                                >
                                    <option value="">-- Select Type --</option>
                                    <option value="safety" {{ old('type', $incident->type) == 'safety' ? 'selected' : '' }}>🚧 Safety Incident</option>
                                    <option value="security" {{ old('type', $incident->type) == 'security' ? 'selected' : '' }}>🔒 Security Breach</option>
                                    <option value="environmental" {{ old('type', $incident->type) == 'environmental' ? 'selected' : '' }}>🌿 Environmental</option>
                                    <option value="equipment" {{ old('type', $incident->type) == 'equipment' ? 'selected' : '' }}>🔧 Equipment Failure</option>
                                    <option value="medical" {{ old('type', $incident->type) == 'medical' ? 'selected' : '' }}>🏥 Medical Emergency</option>
                                    <option value="other" {{ old('type', $incident->type) == 'other' ? 'selected' : '' }}>📋 Other</option>
                                </select>
                                <i class="fas fa-caret-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                                <i class="fas fa-tags absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Coordinates Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Latitude --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fas fa-globe text-red-500 text-sm"></i>
                                Latitude
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="latitude" 
                                    value="{{ old('latitude', $incident->mapping->latitude ?? '') }}"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm"
                                    placeholder="e.g., 6.5039"
                                >
                                <i class="fas fa-map-pin absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            </div>
                        </div>

                        {{-- Longitude --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <i class="fas fa-globe text-red-500 text-sm"></i>
                                Longitude
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="longitude" 
                                    value="{{ old('longitude', $incident->mapping->longitude ?? '') }}"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm"
                                    placeholder="e.g., 124.8481"
                                >
                                <i class="fas fa-map-pin absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.incidents.show', $incident->id) }}" 
                           class="flex-1 px-6 py-3.5 border border-gray-300 text-gray-700 rounded-xl font-semibold text-center hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                        <button 
                            type="button" 
                            onclick="showReview()"
                            class="flex-1 px-6 py-3.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group"
                        >
                            <span>Review Changes</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-200"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Review Card (Hidden by Default) -->
        <div id="reviewCard" class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hidden">
            <!-- Review Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                    <i class="fas fa-clipboard-check"></i>
                    Review Changes
                </h2>
            </div>

            <!-- Review Content -->
            <div class="p-6">
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                        <div>
                            <h3 class="font-semibold text-blue-800">Please review your changes</h3>
                            <p class="text-blue-600 text-sm mt-1">Verify all information before submitting the update</p>
                        </div>
                    </div>
                </div>

                <!-- Review Summary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Current Values -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-history text-blue-500"></i>
                            Current Values
                        </h4>
                        <div class="space-y-3 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Title:</span>
                                <p class="text-sm text-gray-900 mt-1" id="currentTitle">{{ $incident->title }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Location:</span>
                                <p class="text-sm text-gray-900 mt-1" id="currentLocation">{{ $incident->location ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Status:</span>
                                <p class="text-sm text-gray-900 mt-1" id="currentStatus">{{ ucfirst($incident->status) }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Priority:</span>
                                <p class="text-sm text-gray-900 mt-1" id="currentPriority">{{ ucfirst($incident->priority ?? 'Not set') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Updated Values -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-edit text-green-500"></i>
                            Updated Values
                        </h4>
                        <div class="space-y-3 bg-green-50 p-4 rounded-xl border border-green-200">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Title:</span>
                                <p class="text-sm text-green-800 font-medium mt-1" id="updatedTitle"></p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Location:</span>
                                <p class="text-sm text-green-800 font-medium mt-1" id="updatedLocation"></p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Status:</span>
                                <p class="text-sm text-green-800 font-medium mt-1" id="updatedStatus"></p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Priority:</span>
                                <p class="text-sm text-green-800 font-medium mt-1" id="updatedPriority"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Comparison -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <h5 class="font-semibold text-gray-700">Current Description</h5>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-700" id="currentDescription">{{ $incident->description ?? 'No description' }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <h5 class="font-semibold text-gray-700">Updated Description</h5>
                        <div class="bg-green-50 p-3 rounded-lg border border-green-200">
                            <p class="text-sm text-green-800 font-medium" id="updatedDescription"></p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 mt-6">
                    <button 
                        type="button" 
                        onclick="backToEdit()"
                        class="flex-1 px-6 py-3.5 border border-gray-300 text-gray-700 rounded-xl font-semibold text-center hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md flex items-center justify-center gap-2"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Back to Edit
                    </button>
                    <button 
                        type="button" 
                        id="submitBtn"
                        onclick="submitUpdate()"
                        class="flex-1 px-6 py-3.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group"
                    >
                        <span>Update Incident Report</span>
                        <i class="fas fa-check group-hover:scale-110 transition-transform duration-200"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Incident Info Summary -->
        <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-red-500"></i>
                Incident Summary
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">Created:</span>
                    <span class="text-gray-900 ml-2">{{ $incident->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Last Updated:</span>
                    <span class="text-gray-900 ml-2">{{ $incident->updated_at->format('M d, Y h:i A') }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Reporter:</span>
                    <span class="text-gray-900 ml-2">{{ $incident->reporter->name ?? 'Unknown' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ====== Toast Styles ====== */
    .toast {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-20px);
        background: #1f2937;
        color: #fff;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        opacity: 0;
        transition: all 0.4s ease;
        z-index: 1000;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    .toast.error { 
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        border-left: 4px solid #fca5a5;
    }
    .toast.success { 
        background: linear-gradient(135deg, #16a34a, #15803d);
        border-left: 4px solid #86efac;
    }

    /* ====== Loading Animation ====== */
    .loader {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #dc2626;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 0.8s linear infinite;
        display: inline-block;
    }
    @keyframes spin { 
        to { transform: rotate(360deg); } 
    }

    /* ====== Custom Select Styling ====== */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* ====== Hidden State ====== */
    .hidden {
        display: none !important;
    }

    /* ====== Slide Animations ====== */
    .slide-up {
        animation: slideUp 0.5s ease-out;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    // Character counter for description
    const descriptionTextarea = document.querySelector('textarea[name="description"]');
    const charCount = document.getElementById('charCount');

    descriptionTextarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = `${length} characters`;
        
        // Change color based on length
        if (length > 500) {
            charCount.className = 'text-green-600 font-semibold';
        } else if (length > 100) {
            charCount.className = 'text-blue-600';
        } else {
            charCount.className = 'text-gray-500';
        }
    });

    // Show review screen
    function showReview() {
        // Validate form first
        const form = document.getElementById('incidentForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Collect updated values
        const formData = new FormData(form);
        
        // Update review card with new values
        document.getElementById('updatedTitle').textContent = formData.get('title');
        document.getElementById('updatedLocation').textContent = formData.get('location') || 'N/A';
        document.getElementById('updatedStatus').textContent = getStatusText(formData.get('status'));
        document.getElementById('updatedPriority').textContent = getPriorityText(formData.get('priority'));
        document.getElementById('updatedDescription').textContent = formData.get('description') || 'No description';

        // Hide edit form and show review card
        document.getElementById('editForm').classList.add('hidden');
        document.getElementById('reviewCard').classList.remove('hidden');
        document.getElementById('reviewCard').classList.add('slide-up');

        // Update progress steps
        document.getElementById('step2').classList.remove('bg-red-600');
        document.getElementById('step2').classList.add('bg-green-600');
        document.getElementById('step3').classList.remove('bg-gray-300', 'text-gray-600');
        document.getElementById('step3').classList.add('bg-red-600', 'text-white');
        
        // Update step text colors
        document.querySelector('#step2 + span').classList.remove('text-red-600');
        document.querySelector('#step2 + span').classList.add('text-green-600');
        document.querySelector('#step3 + span').classList.remove('text-gray-500');
        document.querySelector('#step3 + span').classList.add('text-red-600');
        
        // Update progress line
        document.querySelectorAll('.flex-1.h-1')[1].classList.remove('bg-gray-300');
        document.querySelectorAll('.flex-1.h-1')[1].classList.add('bg-green-600');
    }

    // Go back to edit screen
    function backToEdit() {
        document.getElementById('reviewCard').classList.add('hidden');
        document.getElementById('editForm').classList.remove('hidden');
        document.getElementById('editForm').classList.add('slide-up');
    }

    // Submit the update
    async function submitUpdate() {
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = `
            <div class="loader mr-2"></div>
            Updating Incident...
        `;
        submitBtn.disabled = true;

        try {
            const form = document.getElementById('incidentForm');
            const formData = new FormData(form);
            
            const response = await fetch('{{ route("admin.incidents.update", $incident->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: formData
            });

            if (response.ok) {
                showToast('success', 'Incident updated successfully! 🎉');
                
                // Redirect to incidents index after a delay
                setTimeout(() => {
                    window.location.href = '{{ route("admin.incidents.index") }}';
                }, 1500);
            } else {
                throw new Error('Failed to update incident');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('error', 'Failed to update incident. Please try again.');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    // Helper functions for display text
    function getStatusText(status) {
        const statusMap = {
            'pending': '🟡 Pending',
            'in-progress': '🔵 In Progress',
            'resolved': '🟢 Resolved'
        };
        return statusMap[status] || status;
    }

    function getPriorityText(priority) {
        const priorityMap = {
            'low': '🟢 Low',
            'medium': '🟡 Medium',
            'high': '🔴 High',
            'critical': '⚫ Critical'
        };
        return priorityMap[priority] || priority || 'Not set';
    }

    // Show toast function
    function showToast(type, message) {
        const toast = document.getElementById('toast');
        const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
        
        toast.innerHTML = `
            <i class="${icon}"></i>
            <span>${message}</span>
        `;
        toast.className = `toast show ${type}`;
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, 4000);
    }

    // Real-time validation feedback
    const formInputs = document.querySelectorAll('input, select, textarea');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value) {
                this.classList.add('border-red-300', 'bg-red-50');
            } else {
                this.classList.remove('border-red-300', 'bg-red-50');
                this.classList.add('border-green-300', 'bg-green-50');
                
                // Remove green styling after a delay
                setTimeout(() => {
                    this.classList.remove('border-green-300', 'bg-green-50');
                }, 2000);
            }
        });

        input.addEventListener('focus', function() {
            this.classList.remove('border-red-300', 'bg-red-50', 'border-green-300', 'bg-green-50');
        });
    });

    // Check if there are success messages from redirect
    const successMessage = '{!! session("success") !!}';
    if (successMessage) {
        showToast('success', successMessage);
    }
</script>
@endsection