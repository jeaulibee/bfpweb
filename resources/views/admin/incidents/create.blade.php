@extends('layouts.app')
@section('title', 'Add Incident Report')

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
                <i class="fas fa-fire text-red-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Incident Report</h1>
            <p class="text-gray-600 text-lg">Fill in the details below to report a new incident</p>
        </div>

        <!-- Progress Steps -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center w-full max-w-md">
                <div class="flex flex-col items-center">
                    <div id="step1-indicator" class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-semibold shadow-lg transition-all duration-300">
                        1
                    </div>
                    <span class="text-sm font-medium text-red-600 mt-2">Details</span>
                </div>
                <div id="step1-line" class="flex-1 h-1 bg-gray-300 mx-2 transition-all duration-300"></div>
                <div class="flex flex-col items-center">
                    <div id="step2-indicator" class="w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-semibold transition-all duration-300">
                        2
                    </div>
                    <span class="text-sm font-medium text-gray-500 mt-2">Review</span>
                </div>
                <div id="step2-line" class="flex-1 h-1 bg-gray-300 mx-2 transition-all duration-300"></div>
                <div class="flex flex-col items-center">
                    <div id="step3-indicator" class="w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-semibold transition-all duration-300">
                        3
                    </div>
                    <span class="text-sm font-medium text-gray-500 mt-2">Submit</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <!-- Step 1: Incident Details -->
            <div id="step1" class="step-content active">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                        <i class="fas fa-clipboard-list"></i>
                        Incident Information
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

                    <div class="space-y-6">
                        <!-- Title & Location Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Title --}}
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-heading text-red-500 text-sm"></i>
                                    Incident Title *
                                </label>
                                
                                <!-- Title Selection Button -->
                                <div class="relative">
                                    <button 
                                        type="button"
                                        id="titlePickerBtn"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm text-left form-input hover:bg-gray-50 flex justify-between items-center"
                                    >
                                        <span id="titleDisplay" class="text-gray-500">Select incident category and type</span>
                                        <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                                    </button>
                                    <i class="fas fa-fire absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                                </div>

                                <!-- Clear title button -->
                                <div id="clearTitleContainer" class="hidden">
                                    <button 
                                        type="button"
                                        id="clearTitleBtn"
                                        class="text-red-600 text-sm font-medium hover:text-red-700 transition-colors duration-200 flex items-center gap-1"
                                    >
                                        <i class="fas fa-times"></i>
                                        Clear Title
                                    </button>
                                </div>

                                <!-- Title selection progress -->
                                <div id="titleProgress" class="mt-3 p-3 bg-gray-50 rounded-lg space-y-2 text-sm">
                                    <div class="flex items-center gap-2">
                                        <span id="categoryStatus" class="text-gray-500">1. Select Category</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span id="typeStatus" class="text-gray-500">2. Select Incident Type</span>
                                    </div>
                                </div>

                                <!-- Custom title input (hidden by default) -->
                                <div id="customTitleContainer" class="hidden mt-3">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Custom Title
                                    </label>
                                    <input 
                                        type="text" 
                                        id="customTitle"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm"
                                        placeholder="Enter custom incident title"
                                    >
                                </div>
                            </div>

                            {{-- Location --}}
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-red-500 text-sm"></i>
                                    Location *
                                </label>
                                
                                <!-- Location Picker Button -->
                                <div class="relative">
                                    <button 
                                        type="button"
                                        id="locationPickerBtn"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm text-left form-input hover:bg-gray-50 flex justify-between items-center"
                                    >
                                        <span id="locationDisplay" class="text-gray-500">Select location (Region → Municipality → Barangay)</span>
                                        <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                                    </button>
                                    <i class="fas fa-location-dot absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                                </div>

                                <!-- Clear location button -->
                                <div id="clearLocationContainer" class="hidden">
                                    <button 
                                        type="button"
                                        id="clearLocationBtn"
                                        class="text-red-600 text-sm font-medium hover:text-red-700 transition-colors duration-200 flex items-center gap-1"
                                    >
                                        <i class="fas fa-times"></i>
                                        Clear Location
                                    </button>
                                </div>

                                <!-- Location selection progress -->
                                <div id="locationProgress" class="mt-3 p-3 bg-gray-50 rounded-lg space-y-2 text-sm">
                                    <div class="flex items-center gap-2">
                                        <span id="regionStatus" class="text-gray-500">1. Select Region</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span id="municipalityStatus" class="text-gray-500">2. Select Municipality</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span id="barangayStatus" class="text-gray-500">3. Select Barangay</span>
                                    </div>
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
                                    id="description"
                                    rows="5"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm resize-vertical form-input"
                                    placeholder="Provide detailed description of the incident..."
                                >{{ old('description') }}</textarea>
                                <i class="fas fa-file-text absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Provide as much detail as possible</span>
                                <span id="charCount">0 characters</span>
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
                                        id="status"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm appearance-none form-input"
                                        required
                                    >
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                                        <option value="in-progress" {{ old('status') == 'in-progress' ? 'selected' : '' }}>🔵 In Progress</option>
                                        <option value="resolved" {{ old('status') == 'resolved' ? 'selected' : '' }}>🟢 Resolved</option>
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
                                        id="reported_by"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm appearance-none form-input"
                                        required
                                    >
                                        <option value="">-- Select User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('reported_by') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-caret-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                                    <i class="fas fa-users absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Fields Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Priority --}}
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-sm"></i>
                                    Priority *
                                </label>
                                <div class="relative">
                                    <select 
                                        name="priority" 
                                        id="priority"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm appearance-none form-input"
                                        required
                                    >
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>🟢 Low Priority</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>🟡 Medium Priority</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>🔴 High Priority</option>
                                        <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>⚫ Critical</option>
                                    </select>
                                    <i class="fas fa-caret-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                                    <i class="fas fa-arrow-up-wide-short absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                                </div>
                            </div>

                            {{-- Incident Type --}}
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-tag text-red-500 text-sm"></i>
                                    Incident Type *
                                </label>
                                <div class="relative">
                                    <select 
                                        name="type" 
                                        id="type"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm appearance-none form-input"
                                        required
                                    >
                                        <option value="">-- Select Type --</option>
                                        <option value="safety" {{ old('type') == 'safety' ? 'selected' : '' }}>🚧 Safety Incident</option>
                                        <option value="security" {{ old('type') == 'security' ? 'selected' : '' }}>🔒 Security Breach</option>
                                        <option value="environmental" {{ old('type') == 'environmental' ? 'selected' : '' }}>🌿 Environmental</option>
                                        <option value="equipment" {{ old('type') == 'equipment' ? 'selected' : '' }}>🔧 Equipment Failure</option>
                                        <option value="medical" {{ old('type') == 'medical' ? 'selected' : '' }}>🏥 Medical Emergency</option>
                                        <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>📋 Other</option>
                                    </select>
                                    <i class="fas fa-caret-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                                    <i class="fas fa-tags absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.incidents.index') }}" 
                               class="flex-1 px-6 py-3.5 border border-gray-300 text-gray-700 rounded-xl font-semibold text-center hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                Back to Incidents
                            </a>
                            <button 
                                type="button" 
                                id="nextToReviewBtn"
                                class="flex-1 px-6 py-3.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group"
                            >
                                <span>Continue to Review</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-200"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Review -->
            <div id="step2" class="step-content hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                        <i class="fas fa-eye"></i>
                        Review Incident Details
                    </h2>
                </div>

                <!-- Review Content -->
                <div class="p-6">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-yellow-800">Please review your incident details</h3>
                                <p class="text-yellow-700 text-sm mt-1">Verify all information before submitting the incident report.</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Review Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h3 class="font-semibold text-gray-900 border-b border-gray-200 pb-2">Basic Information</h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Title:</label>
                                        <p id="review-title" class="text-gray-900 font-semibold mt-1"></p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Location:</label>
                                        <p id="review-location" class="text-gray-900 font-semibold mt-1"></p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Status:</label>
                                        <p id="review-status" class="text-gray-900 font-semibold mt-1"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="font-semibold text-gray-900 border-b border-gray-200 pb-2">Additional Details</h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Priority:</label>
                                        <p id="review-priority" class="text-gray-900 font-semibold mt-1"></p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Type:</label>
                                        <p id="review-type" class="text-gray-900 font-semibold mt-1"></p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Reported By:</label>
                                        <p id="review-reported-by" class="text-gray-900 font-semibold mt-1"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="font-semibold text-gray-900 border-b border-gray-200 pb-2">Description</h3>
                            <div>
                                <p id="review-description" class="text-gray-700 bg-gray-50 rounded-lg p-4 min-h-[80px]"></p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button 
                                type="button" 
                                id="backToDetailsBtn"
                                class="flex-1 px-6 py-3.5 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md flex items-center justify-center gap-2"
                            >
                                <i class="fas fa-arrow-left"></i>
                                Back to Details
                            </button>
                            <button 
                                type="button" 
                                id="submitIncidentBtn"
                                class="flex-1 px-6 py-3.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group"
                            >
                                <span>Submit Incident</span>
                                <i class="fas fa-check group-hover:scale-110 transition-transform duration-200"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Success -->
            <div id="step3" class="step-content hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                        <i class="fas fa-check-circle"></i>
                        Incident Submitted Successfully
                    </h2>
                </div>

                <!-- Success Content -->
                <div class="p-6 text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-green-600 text-2xl"></i>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Incident Report Created!</h3>
                    <p class="text-gray-600 mb-6">Your incident has been successfully submitted and logged in the system.</p>

                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-2"></i>
                            You will be redirected to the incidents page shortly...
                        </p>
                    </div>

                    <a href="{{ route('admin.incidents.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                        <i class="fas fa-list mr-2"></i>
                        View All Incidents
                    </a>
                </div>
            </div>
        </div>

        <!-- Title Selection Modals -->
        <!-- Category Modal -->
        <div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl w-full max-w-md mx-4 max-h-[80vh] overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Select Incident Category</h3>
                    <button type="button" id="closeCategoryModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4">
                    <div class="space-y-2">
                        <button type="button" class="category-option w-full text-left p-4 rounded-lg border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200" data-category="fire">
                            <div class="font-medium text-gray-900 flex items-center gap-3">
                                <i class="fas fa-fire text-red-500"></i>
                                Fire Incident
                            </div>
                            <div class="text-sm text-gray-600 mt-1">Structure fires, vehicle fires, wildfires, etc.</div>
                        </button>
                        <button type="button" class="category-option w-full text-left p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200" data-category="medical">
                            <div class="font-medium text-gray-900 flex items-center gap-3">
                                <i class="fas fa-plus text-blue-500"></i>
                                Medical Emergency
                            </div>
                            <div class="text-sm text-gray-600 mt-1">Injuries, illnesses, medical emergencies</div>
                        </button>
                        <button type="button" class="category-option w-full text-left p-4 rounded-lg border border-gray-200 hover:border-orange-300 hover:bg-orange-50 transition-all duration-200" data-category="accident">
                            <div class="font-medium text-gray-900 flex items-center gap-3">
                                <i class="fas fa-car-crash text-orange-500"></i>
                                Accident
                            </div>
                            <div class="text-sm text-gray-600 mt-1">Vehicle accidents, workplace accidents</div>
                        </button>
                        <button type="button" class="category-option w-full text-left p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all duration-200" data-category="security">
                            <div class="font-medium text-gray-900 flex items-center gap-3">
                                <i class="fas fa-shield-alt text-purple-500"></i>
                                Security Incident
                            </div>
                            <div class="text-sm text-gray-600 mt-1">Theft, vandalism, security breaches</div>
                        </button>
                        <button type="button" class="category-option w-full text-left p-4 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all duration-200" data-category="environmental">
                            <div class="font-medium text-gray-900 flex items-center gap-3">
                                <i class="fas fa-tree text-green-500"></i>
                                Environmental
                            </div>
                            <div class="text-sm text-gray-600 mt-1">Floods, landslides, environmental hazards</div>
                        </button>
                        <button type="button" class="category-option w-full text-left p-4 rounded-lg border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all duration-200" data-category="other">
                            <div class="font-medium text-gray-900 flex items-center gap-3">
                                <i class="fas fa-ellipsis-h text-gray-500"></i>
                                Other Incident
                            </div>
                            <div class="text-sm text-gray-600 mt-1">Other types of incidents</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Type Modal -->
        <div id="typeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl w-full max-w-md mx-4 max-h-[80vh] overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Select Incident Type</h3>
                    <button type="button" id="closeTypeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto max-h-96">
                    <div class="space-y-2" id="typeList">
                        <!-- Types will be populated by JavaScript based on category -->
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <button type="button" id="useCustomTitleBtn" class="w-full p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-red-300 hover:bg-red-50 transition-all duration-200 text-center">
                            <div class="font-medium text-gray-900">Use Custom Title</div>
                            <div class="text-sm text-gray-600 mt-1">Create a custom incident title</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Selection Modals -->
        <!-- Region Modal -->
        <div id="regionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl w-full max-w-md mx-4 max-h-[80vh] overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Select Region</h3>
                    <button type="button" id="closeRegionModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4">
                    <div class="space-y-2">
                        <button type="button" class="location-option w-full text-left p-4 rounded-lg border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200" data-region="SOCCSKSARGEN (Region XII)">
                            <div class="font-medium text-gray-900">SOCCSKSARGEN (Region XII)</div>
                            <div class="text-sm text-gray-600 mt-1">South Cotabato Province</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Municipality Modal -->
        <div id="municipalityModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl w-full max-w-md mx-4 max-h-[80vh] overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Select Municipality</h3>
                    <button type="button" id="closeMunicipalityModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto max-h-96">
                    <div class="space-y-2" id="municipalityList">
                        <!-- Municipalities will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Barangay Modal -->
        <div id="barangayModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl w-full max-w-md mx-4 max-h-[80vh] overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Select Barangay</h3>
                    <button type="button" id="closeBarangayModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto max-h-96">
                    <div class="space-y-2" id="barangayList">
                        <!-- Barangays will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Actual Form (Hidden) -->
        <form action="{{ route('admin.incidents.store') }}" method="POST" id="incidentForm" class="hidden">
            @csrf
            <input type="hidden" name="title" id="form-title">
            <input type="hidden" name="location" id="form-location">
            <input type="hidden" name="description" id="form-description">
            <input type="hidden" name="status" id="form-status">
            <input type="hidden" name="reported_by" id="form-reported_by">
            <input type="hidden" name="priority" id="form-priority">
            <input type="hidden" name="type" id="form-type">
        </form>
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

    /* ====== Step Transitions ====== */
    .step-content {
        transition: all 0.5s ease-in-out;
    }
    .step-content.hidden {
        display: none;
        opacity: 0;
        transform: translateX(20px);
    }
    .step-content.active {
        display: block;
        opacity: 1;
        transform: translateX(0);
    }

    /* ====== Form Element Enhancements ====== */
    select:focus, input:focus, textarea:focus {
        transform: translateY(-1px);
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

    /* ====== Location Option Styling ====== */
    .location-option, .category-option, .type-option {
        transition: all 0.2s ease;
    }
    .location-option:hover, .category-option:hover, .type-option:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>

<script>
    // Title data structure
    const titleData = {
        fire: [
            "House Fire", "Apartment Fire", "Commercial Building Fire", "Vehicle Fire", 
            "Wildfire", "Brush Fire", "Electrical Fire", "Kitchen Fire", "Industrial Fire",
            "Warehouse Fire", "Gas Station Fire", "Forest Fire", "Grass Fire", "Trash Fire"
        ],
        medical: [
            "Heart Attack", "Stroke", "Respiratory Distress", "Seizure", "Allergic Reaction",
            "Traumatic Injury", "Unconscious Person", "Diabetic Emergency", "Overdose",
            "Childbirth", "Burn Injury", "Fracture", "Head Injury", "Chest Pain"
        ],
        accident: [
            "Car Accident", "Motorcycle Accident", "Truck Accident", "Pedestrian Accident",
            "Bicycle Accident", "Workplace Accident", "Construction Accident", "Industrial Accident",
            "Slip and Fall", "Equipment Accident", "Sports Injury", "Recreational Accident"
        ],
        security: [
            "Burglary", "Robbery", "Theft", "Vandalism", "Assault", "Fight", "Disturbance",
            "Trespassing", "Suspicious Activity", "Security Breach", "Unauthorized Access",
            "Threat", "Harassment", "Domestic Incident"
        ],
        environmental: [
            "Flood", "Landslide", "Earthquake", "Storm Damage", "Tree Down", "Power Outage",
            "Water Main Break", "Gas Leak", "Chemical Spill", "Oil Spill", "Air Quality Alert",
            "Severe Weather", "Tsunami Warning", "Volcanic Activity"
        ],
        other: [
            "Missing Person", "Lost Property", "Animal Rescue", "Water Rescue", "Mountain Rescue",
            "Structure Collapse", "Hazardous Materials", "Public Nuisance", "Noise Complaint",
            "Utility Emergency", "Traffic Hazard", "Road Closure"
        ]
    };

    // Location data
    const locationData = {
        region: "SOCCSKSARGEN (Region XII)",
        province: "South Cotabato",
        municipalities: {
            "Koronadal City": [
                "Assumption (Bulol)", "Avanceña (Barrio III)", "Cacub", "Caloocan", "Carpenter Hill", 
                "Concepcion (Barrio VI)", "Esperanza", "General Paulino Santos (Barrio I)", "Mabini", 
                "Magsaysay", "Mambucal", "Morales", "Namnama", "New Pangasinan (Barrio IV)", 
                "Paraiso", "Rotonda", "San Isidro", "San Jose (Barrio V)", "San Roque", "Santa Cruz", 
                "Santo Niño (Barrio II)", "Sarabia", "Zone I (Poblacion)", "Zone II (Poblacion)", 
                "Zone III (Poblacion)", "Zone IV (Poblacion)", "Zulueta"
            ],
            "Banga": [
                "Benitez", "Cabudian", "Cabuling", "Cinco", "Derilon", "El Nonok", "Improgo Village", 
                "Kusan", "Lam-apos", "Lamba", "Lambingi", "Lampari", "Liwanay", "Malaya", 
                "Punong Grande", "Rang-ay", "Reyes", "Rizal", "Rizal Poblacion", "San Jose", 
                "San Vicente", "Yangco Poblacion"
            ],
            "Norala": [
                "Benigno Aquino, Jr.", "Dumaguil", "Esperanza", "Kibid", "Lapuz", "Liberty", 
                "Lopez Jaena", "Matapol", "Poblacion", "Puti", "San Jose", "San Miguel", 
                "Simsiman", "Tinago"
            ],
            "Polomolok": [
                "Bentung", "Cannery Site", "Crossing Palkan", "Glamang", "Kinilis", "Klinan 6", 
                "Koronadal Proper", "Lam-Caliaf", "Landan", "Lapu", "Lumakil", "Magsaysay", 
                "Maligo", "Pagalungan", "Palkan", "Poblacion", "Polo", "Rubber", "Silway 7", 
                "Silway 8", "Sulit", "Sumbakil", "Upper Klinan"
            ],
            "Surallah": [
                "Buenavista", "Canahay", "Centrala", "Colongulo", "Dajay", "Duengas", 
                "Lambontong", "Lamian", "Lamsugod", "Libertad (Poblacion)", "Little Baguio", 
                "Moloy", "Naci (Doce)", "Talahik", "Tubiala", "Upper Sepaka", "Veterans"
            ],
            "T'Boli": [
                "Aflek", "Afus", "Basag", "Datal Bob", "Desawo", "Dlanag", "Edwards", 
                "Kematu", "Laconon", "Lambangan", "Lambuling", "Lamhako", "Lamsalome", 
                "Lemsnolon", "Maan", "Malugong", "Mongocayo", "New Dumangas", "Poblacion", 
                "Salacafe", "Sinolon", "T'bolok", "Talcon", "Talufo", "Tudok"
            ],
            "Tampakan": [
                "Albagan", "Buto", "Danlag", "Kipalbig", "Lambayong", "Lampitak", "Liberty", 
                "Maltana", "Palo", "Poblacion", "Pula-bato", "San Isidro", "Santa Cruz", "Tablu"
            ],
            "Tantangan": [
                "Bukay Pait", "Cabuling", "Dumadalig", "Libas", "Magon", "Maibo", "Mangilala", 
                "New Cuyapo", "New Iloilo", "New Lambunao", "Poblacion", "San Felipe", "Tinongcop"
            ],
            "Tupi": [
                "Acmonan", "Bololmala", "Bunao", "Cebuano", "Crossing Rubber", "Kablon", 
                "Kalkam", "Linan", "Lunen", "Miasong", "Palian", "Poblacion", "Polonuling", 
                "Simbo", "Tubeng", "Juan-Loreto Tamayo"
            ],
            "Santo Niño": [
                "Ambalgan", "Guinsang-an", "Katipunan", "Manuel Roxas", "Panay", "Poblacion", 
                "Sajaneba", "San Isidro", "San Vicente", "Teresita"
            ],
            "Lake Sebu": [
                "Bacdulong", "Denlag", "Halilan", "Hanoon", "Klubi", "Lake Lahit", "Lamcade", 
                "Lamdalag", "Lamfugon", "Lamlahak", "Lower Maculan", "Luhib", "Ned", "Poblacion", 
                "Siluton", "Takunel", "Talisay", "Tasiman", "Upper Maculan"
            ]
        }
    };

    let currentStep = 1;
    let selectedCategory = '';
    let selectedType = '';
    let selectedRegion = '';
    let selectedMunicipality = '';
    let selectedBarangay = '';
    let useCustomTitle = false;

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

    // Initialize character count
    charCount.textContent = `${descriptionTextarea.value.length} characters`;

    // Title Picker Functionality
    document.getElementById('titlePickerBtn').addEventListener('click', function() {
        showCategoryModal();
    });

    document.getElementById('clearTitleBtn').addEventListener('click', function() {
        clearTitleSelection();
    });

    // Category Modal
    document.getElementById('closeCategoryModal').addEventListener('click', function() {
        hideCategoryModal();
    });

    // Type Modal
    document.getElementById('closeTypeModal').addEventListener('click', function() {
        hideTypeModal();
    });

    // Category selection
    document.querySelectorAll('.category-option').forEach(option => {
        option.addEventListener('click', function() {
            selectedCategory = this.getAttribute('data-category');
            updateTitleProgress();
            hideCategoryModal();
            showTypeModal();
        });
    });

    // Custom title button
    document.getElementById('useCustomTitleBtn').addEventListener('click', function() {
        useCustomTitle = true;
        hideTypeModal();
        showCustomTitleInput();
    });

    function showCategoryModal() {
        document.getElementById('categoryModal').classList.remove('hidden');
    }

    function hideCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
    }

    function showTypeModal() {
        const typeList = document.getElementById('typeList');
        typeList.innerHTML = '';
        
        if (titleData[selectedCategory]) {
            titleData[selectedCategory].forEach(type => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'type-option w-full text-left p-4 rounded-lg border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200';
                button.innerHTML = `
                    <div class="font-medium text-gray-900">${type}</div>
                    <div class="text-sm text-gray-600 mt-1">${getCategoryDisplayName(selectedCategory)} Incident</div>
                `;
                button.addEventListener('click', function() {
                    selectedType = type;
                    useCustomTitle = false;
                    updateTitleProgress();
                    hideTypeModal();
                    updateTitleDisplay();
                });
                typeList.appendChild(button);
            });
        }
        
        document.getElementById('typeModal').classList.remove('hidden');
    }

    function hideTypeModal() {
        document.getElementById('typeModal').classList.add('hidden');
    }

    function showCustomTitleInput() {
        document.getElementById('customTitleContainer').classList.remove('hidden');
        document.getElementById('customTitle').focus();
    }

    function hideCustomTitleInput() {
        document.getElementById('customTitleContainer').classList.add('hidden');
    }

    function getCategoryDisplayName(category) {
        const displayNames = {
            fire: 'Fire',
            medical: 'Medical',
            accident: 'Accident',
            security: 'Security',
            environmental: 'Environmental',
            other: 'Other'
        };
        return displayNames[category] || category;
    }

    function updateTitleProgress() {
        const categoryStatus = document.getElementById('categoryStatus');
        const typeStatus = document.getElementById('typeStatus');

        if (selectedCategory) {
            categoryStatus.innerHTML = `<i class="fas fa-check text-green-500 mr-1"></i> ${getCategoryDisplayName(selectedCategory)}`;
            categoryStatus.className = 'text-green-600 font-medium';
        } else {
            categoryStatus.textContent = '1. Select Category';
            categoryStatus.className = 'text-gray-500';
        }

        if (selectedType || useCustomTitle) {
            const statusText = useCustomTitle ? 'Custom Title' : selectedType;
            typeStatus.innerHTML = `<i class="fas fa-check text-green-500 mr-1"></i> ${statusText}`;
            typeStatus.className = 'text-green-600 font-medium';
        } else {
            typeStatus.textContent = '2. Select Incident Type';
            typeStatus.className = 'text-gray-500';
        }
    }

    function updateTitleDisplay() {
        const titleDisplay = document.getElementById('titleDisplay');
        const clearTitleContainer = document.getElementById('clearTitleContainer');
        
        if (useCustomTitle) {
            const customTitle = document.getElementById('customTitle').value;
            if (customTitle) {
                titleDisplay.textContent = customTitle;
                titleDisplay.className = 'text-gray-900 font-medium';
                clearTitleContainer.classList.remove('hidden');
            } else {
                titleDisplay.textContent = 'Enter custom title below';
                titleDisplay.className = 'text-gray-500';
                clearTitleContainer.classList.add('hidden');
            }
        } else if (selectedType && selectedCategory) {
            titleDisplay.textContent = selectedType;
            titleDisplay.className = 'text-gray-900 font-medium';
            clearTitleContainer.classList.remove('hidden');
            hideCustomTitleInput();
        } else {
            titleDisplay.textContent = 'Select incident category and type';
            titleDisplay.className = 'text-gray-500';
            clearTitleContainer.classList.add('hidden');
            hideCustomTitleInput();
        }
    }

    function clearTitleSelection() {
        selectedCategory = '';
        selectedType = '';
        useCustomTitle = false;
        document.getElementById('customTitle').value = '';
        updateTitleProgress();
        updateTitleDisplay();
    }

    // Custom title input handler
    document.getElementById('customTitle').addEventListener('input', function() {
        updateTitleDisplay();
    });

    // Location Picker Functionality (existing code)
    document.getElementById('locationPickerBtn').addEventListener('click', function() {
        showRegionModal();
    });

    document.getElementById('clearLocationBtn').addEventListener('click', function() {
        clearLocationSelection();
    });

    // Region Modal
    document.getElementById('closeRegionModal').addEventListener('click', function() {
        hideRegionModal();
    });

    // Municipality Modal
    document.getElementById('closeMunicipalityModal').addEventListener('click', function() {
        hideMunicipalityModal();
    });

    // Barangay Modal
    document.getElementById('closeBarangayModal').addEventListener('click', function() {
        hideBarangayModal();
    });

    // Region selection
    document.querySelectorAll('.location-option[data-region]').forEach(option => {
        option.addEventListener('click', function() {
            selectedRegion = this.getAttribute('data-region');
            updateLocationProgress();
            hideRegionModal();
            showMunicipalityModal();
        });
    });

    function showRegionModal() {
        document.getElementById('regionModal').classList.remove('hidden');
    }

    function hideRegionModal() {
        document.getElementById('regionModal').classList.add('hidden');
    }

    function showMunicipalityModal() {
        const municipalityList = document.getElementById('municipalityList');
        municipalityList.innerHTML = '';
        
        Object.keys(locationData.municipalities).forEach(municipality => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'location-option w-full text-left p-4 rounded-lg border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200';
            button.innerHTML = `
                <div class="font-medium text-gray-900">${municipality}</div>
                <div class="text-sm text-gray-600 mt-1">${locationData.municipalities[municipality].length} barangays</div>
            `;
            button.addEventListener('click', function() {
                selectedMunicipality = municipality;
                updateLocationProgress();
                hideMunicipalityModal();
                showBarangayModal();
            });
            municipalityList.appendChild(button);
        });
        
        document.getElementById('municipalityModal').classList.remove('hidden');
    }

    function hideMunicipalityModal() {
        document.getElementById('municipalityModal').classList.add('hidden');
    }

    function showBarangayModal() {
        const barangayList = document.getElementById('barangayList');
        barangayList.innerHTML = '';
        
        locationData.municipalities[selectedMunicipality].forEach(barangay => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'location-option w-full text-left p-4 rounded-lg border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200';
            button.innerHTML = `
                <div class="font-medium text-gray-900">${barangay}</div>
                <div class="text-sm text-gray-600 mt-1">Barangay</div>
            `;
            button.addEventListener('click', function() {
                selectedBarangay = barangay;
                updateLocationProgress();
                hideBarangayModal();
                updateLocationDisplay();
            });
            barangayList.appendChild(button);
        });
        
        document.getElementById('barangayModal').classList.remove('hidden');
    }

    function hideBarangayModal() {
        document.getElementById('barangayModal').classList.add('hidden');
    }

    function updateLocationProgress() {
        const regionStatus = document.getElementById('regionStatus');
        const municipalityStatus = document.getElementById('municipalityStatus');
        const barangayStatus = document.getElementById('barangayStatus');

        if (selectedRegion) {
            regionStatus.innerHTML = `<i class="fas fa-check text-green-500 mr-1"></i> ${selectedRegion}`;
            regionStatus.className = 'text-green-600 font-medium';
        } else {
            regionStatus.textContent = '1. Select Region';
            regionStatus.className = 'text-gray-500';
        }

        if (selectedMunicipality) {
            municipalityStatus.innerHTML = `<i class="fas fa-check text-green-500 mr-1"></i> ${selectedMunicipality}`;
            municipalityStatus.className = 'text-green-600 font-medium';
        } else {
            municipalityStatus.textContent = '2. Select Municipality';
            municipalityStatus.className = 'text-gray-500';
        }

        if (selectedBarangay) {
            barangayStatus.innerHTML = `<i class="fas fa-check text-green-500 mr-1"></i> ${selectedBarangay}`;
            barangayStatus.className = 'text-green-600 font-medium';
        } else {
            barangayStatus.textContent = '3. Select Barangay';
            barangayStatus.className = 'text-gray-500';
        }
    }

    function updateLocationDisplay() {
        const locationDisplay = document.getElementById('locationDisplay');
        const clearLocationContainer = document.getElementById('clearLocationContainer');
        
        if (selectedBarangay && selectedMunicipality && selectedRegion) {
            const fullLocation = `${selectedBarangay}, ${selectedMunicipality}, ${selectedRegion}, ${locationData.province}`;
            locationDisplay.textContent = fullLocation;
            locationDisplay.className = 'text-gray-900 font-medium';
            clearLocationContainer.classList.remove('hidden');
        } else {
            locationDisplay.textContent = 'Select location (Region → Municipality → Barangay)';
            locationDisplay.className = 'text-gray-500';
            clearLocationContainer.classList.add('hidden');
        }
    }

    function clearLocationSelection() {
        selectedRegion = '';
        selectedMunicipality = '';
        selectedBarangay = '';
        updateLocationProgress();
        updateLocationDisplay();
    }

    // Step Navigation
    document.getElementById('nextToReviewBtn').addEventListener('click', function() {
        if (validateStep1()) {
            updateReviewDetails();
            goToStep(2);
        }
    });

    document.getElementById('backToDetailsBtn').addEventListener('click', function() {
        goToStep(1);
    });

    document.getElementById('submitIncidentBtn').addEventListener('click', function() {
        submitIncident();
    });

    function validateStep1() {
        const requiredFields = ['status', 'reported_by', 'priority', 'type'];
        let isValid = true;

        // Check if title is selected or custom title is provided
        if (useCustomTitle) {
            const customTitle = document.getElementById('customTitle').value.trim();
            if (!customTitle) {
                showToast('error', 'Please enter a custom title or select from categories');
                document.getElementById('customTitle').classList.add('border-red-300', 'bg-red-50');
                isValid = false;
            } else {
                document.getElementById('customTitle').classList.remove('border-red-300', 'bg-red-50');
            }
        } else if (!selectedType || !selectedCategory) {
            showToast('error', 'Please select an incident category and type');
            document.getElementById('titlePickerBtn').classList.add('border-red-300', 'bg-red-50');
            isValid = false;
        } else {
            document.getElementById('titlePickerBtn').classList.remove('border-red-300', 'bg-red-50');
        }

        // Check if location is selected
        if (!selectedBarangay || !selectedMunicipality || !selectedRegion) {
            showToast('error', 'Please select a complete location (Region → Municipality → Barangay)');
            document.getElementById('locationPickerBtn').classList.add('border-red-300', 'bg-red-50');
            isValid = false;
        } else {
            document.getElementById('locationPickerBtn').classList.remove('border-red-300', 'bg-red-50');
        }

        requiredFields.forEach(field => {
            const element = document.getElementById(field);
            if (!element.value.trim()) {
                element.classList.add('border-red-300', 'bg-red-50');
                isValid = false;
                
                // Show toast error
                showToast('error', `Please fill in the ${field.replace('_', ' ')} field`);
            } else {
                element.classList.remove('border-red-300', 'bg-red-50');
            }
        });

        return isValid;
    }

    function updateReviewDetails() {
        // Basic Information
        let titleText = '';
        if (useCustomTitle) {
            titleText = document.getElementById('customTitle').value;
        } else {
            titleText = selectedType;
        }
        document.getElementById('review-title').textContent = titleText;
        
        // Location
        const fullLocation = `${selectedBarangay}, ${selectedMunicipality}, ${selectedRegion}, ${locationData.province}`;
        document.getElementById('review-location').textContent = fullLocation;
        
        document.getElementById('review-status').textContent = document.getElementById('status').options[document.getElementById('status').selectedIndex].text;
        
        // Additional Details
        document.getElementById('review-priority').textContent = document.getElementById('priority').options[document.getElementById('priority').selectedIndex].text;
        document.getElementById('review-type').textContent = document.getElementById('type').options[document.getElementById('type').selectedIndex].text;
        document.getElementById('review-reported-by').textContent = document.getElementById('reported_by').options[document.getElementById('reported_by').selectedIndex].text;
        
        // Description
        const description = document.getElementById('description').value || 'No description provided';
        document.getElementById('review-description').textContent = description;
    }

    function goToStep(step) {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(content => {
            content.classList.remove('active');
            content.classList.add('hidden');
        });

        // Show current step
        document.getElementById(`step${step}`).classList.remove('hidden');
        document.getElementById(`step${step}`).classList.add('active');

        // Update progress indicators
        updateProgressIndicators(step);

        currentStep = step;
    }

    function updateProgressIndicators(step) {
        // Reset all indicators
        document.getElementById('step1-indicator').className = 'w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-semibold transition-all duration-300';
        document.getElementById('step2-indicator').className = 'w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-semibold transition-all duration-300';
        document.getElementById('step3-indicator').className = 'w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-semibold transition-all duration-300';
        
        document.getElementById('step1-line').className = 'flex-1 h-1 bg-gray-300 mx-2 transition-all duration-300';
        document.getElementById('step2-line').className = 'flex-1 h-1 bg-gray-300 mx-2 transition-all duration-300';

        // Update based on current step
        if (step >= 1) {
            document.getElementById('step1-indicator').className = 'w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-semibold shadow-lg transition-all duration-300';
        }
        if (step >= 2) {
            document.getElementById('step2-indicator').className = 'w-10 h-10 bg-yellow-600 text-white rounded-full flex items-center justify-center font-semibold shadow-lg transition-all duration-300';
            document.getElementById('step1-line').className = 'flex-1 h-1 bg-yellow-600 mx-2 transition-all duration-300';
        }
        if (step >= 3) {
            document.getElementById('step3-indicator').className = 'w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-semibold shadow-lg transition-all duration-300';
            document.getElementById('step2-line').className = 'flex-1 h-1 bg-green-600 mx-2 transition-all duration-300';
        }
    }

    function submitIncident() {
        const submitBtn = document.getElementById('submitIncidentBtn');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = `
            <div class="loader mr-2"></div>
            Submitting...
        `;
        submitBtn.disabled = true;

        // Populate hidden form
        let titleValue = '';
        if (useCustomTitle) {
            titleValue = document.getElementById('customTitle').value;
        } else {
            titleValue = selectedType;
        }
        document.getElementById('form-title').value = titleValue;
        
        // Set the full location
        const fullLocation = `${selectedBarangay}, ${selectedMunicipality}, ${selectedRegion}, ${locationData.province}`;
        document.getElementById('form-location').value = fullLocation;
        
        document.getElementById('form-description').value = document.getElementById('description').value;
        document.getElementById('form-status').value = document.getElementById('status').value;
        document.getElementById('form-reported_by').value = document.getElementById('reported_by').value;
        document.getElementById('form-priority').value = document.getElementById('priority').value;
        document.getElementById('form-type').value = document.getElementById('type').value;

        // Submit the form
        setTimeout(() => {
            document.getElementById('incidentForm').submit();
            
            // Show success step
            goToStep(3);
            
            // Show success toast
            showToast('success', 'Incident created successfully!');
            
            // Redirect after delay
            setTimeout(() => {
                window.location.href = "{{ route('admin.incidents.index') }}";
            }, 3000);
            
        }, 1500);
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
    const formInputs = document.querySelectorAll('.form-input');
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

    // Initialize progress indicators
    updateProgressIndicators(1);
</script>
@endsection