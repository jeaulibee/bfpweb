@extends('layouts.app')

@section('title', 'Edit Incident Report')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-white to-red-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center" data-aos="fade-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-3xl shadow-2xl mb-6 transform transition-all duration-500 hover:scale-110 hover:shadow-2xl hover:from-red-700 hover:to-red-800">
                <i class="fas fa-edit text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-black text-gray-900 mb-4 bg-gradient-to-r from-red-700 to-red-600 bg-clip-text text-transparent">
                Edit Incident Report
            </h1>
            <p class="text-lg text-gray-600 max-w-md mx-auto leading-relaxed">
                Update incident details and track resolution progress
            </p>
            <div class="w-24 h-1.5 bg-gradient-to-r from-red-500 to-red-400 rounded-full mx-auto mt-4 shadow-sm"></div>
        </div>

        <!-- Incident Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8" data-aos="fade-up">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Incident ID</p>
                        <p class="text-2xl font-bold text-gray-900">#{{ $incident->id }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-hashtag text-red-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Reported</p>
                        <p class="text-lg font-bold text-gray-900">{{ $incident->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar text-blue-600 text-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Last Updated</p>
                        <p class="text-lg font-bold text-gray-900">{{ $incident->updated_at->diffForHumans() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-green-600 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-red-100 overflow-hidden transform hover:shadow-3xl transition-all duration-500"
             data-aos="fade-up" data-aos-delay="200">
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-fire text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Update Incident Details</h2>
                            <p class="text-red-100">Modify incident information and status</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-2xl px-4 py-2 border border-white/30">
                        <i class="fas fa-history text-white text-sm"></i>
                        <span class="text-white text-sm font-medium">Last edited {{ $incident->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8">
                {{-- Display Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl shadow-sm" data-aos="shake">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                            <h3 class="font-bold text-red-800">Please fix the following errors:</h3>
                        </div>
                        <ul class="list-disc pl-6 text-red-700 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('staff.incidents.update', $incident->id) }}" method="POST" class="space-y-6" id="editIncidentForm">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="space-y-2" data-aos="fade-up" data-aos-delay="300">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                            <i class="fas fa-heading text-red-500 text-sm"></i>
                            Incident Title
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            value="{{ old('title', $incident->title) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md"
                            placeholder="Enter a clear and concise title"
                            required
                        >
                        @error('title') 
                            <div class="flex items-center gap-2 text-red-600 text-sm mt-1">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div class="space-y-2" data-aos="fade-up" data-aos-delay="350">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-red-500 text-sm"></i>
                            Location
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="location" 
                                value="{{ old('location', $incident->location) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md pr-10"
                                placeholder="Where did this incident occur?"
                            >
                            <i class="fas fa-search absolute right-3 top-3.5 text-gray-400 text-sm"></i>
                        </div>
                        @error('location') 
                            <div class="flex items-center gap-2 text-red-600 text-sm mt-1">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="space-y-2" data-aos="fade-up" data-aos-delay="400">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                            <i class="fas fa-align-left text-red-500 text-sm"></i>
                            Description
                        </label>
                        <textarea 
                            name="description" 
                            rows="6"
                            class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md resize-vertical"
                            placeholder="Provide detailed information about the incident..."
                        >{{ old('description', $incident->description) }}</textarea>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>Provide comprehensive details for better tracking</span>
                            <span id="charCount">{{ strlen(old('description', $incident->description)) }} characters</span>
                        </div>
                        @error('description') 
                            <div class="flex items-center gap-2 text-red-600 text-sm mt-1">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="space-y-2" data-aos="fade-up" data-aos-delay="450">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                            <i class="fas fa-tasks text-red-500 text-sm"></i>
                            Status
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="relative">
                                <input type="radio" name="status" value="pending" {{ old('status', $incident->status) == 'pending' ? 'checked' : '' }} class="hidden peer" required>
                                <div class="p-4 border-2 border-gray-300 rounded-2xl text-center cursor-pointer transition-all duration-300 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 peer-checked:shadow-md hover:shadow-md">
                                    <i class="fas fa-hourglass-half text-yellow-500 text-lg mb-2"></i>
                                    <div class="font-semibold text-gray-700">Pending</div>
                                    <div class="text-xs text-gray-500 mt-1">Initial report</div>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" name="status" value="in-progress" {{ old('status', $incident->status) == 'in-progress' ? 'checked' : '' }} class="hidden peer">
                                <div class="p-4 border-2 border-gray-300 rounded-2xl text-center cursor-pointer transition-all duration-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-md hover:shadow-md">
                                    <i class="fas fa-spinner text-blue-500 text-lg mb-2 fa-spin"></i>
                                    <div class="font-semibold text-gray-700">In Progress</div>
                                    <div class="text-xs text-gray-500 mt-1">Being handled</div>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" name="status" value="resolved" {{ old('status', $incident->status) == 'resolved' ? 'checked' : '' }} class="hidden peer">
                                <div class="p-4 border-2 border-gray-300 rounded-2xl text-center cursor-pointer transition-all duration-300 peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:shadow-md hover:shadow-md">
                                    <i class="fas fa-check-circle text-green-500 text-lg mb-2"></i>
                                    <div class="font-semibold text-gray-700">Resolved</div>
                                    <div class="text-xs text-gray-500 mt-1">Completed</div>
                                </div>
                            </label>
                        </div>
                        @error('status') 
                            <div class="flex items-center gap-2 text-red-600 text-sm mt-1">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div class="space-y-2" data-aos="fade-up" data-aos-delay="500">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle text-red-500 text-sm"></i>
                            Priority Level
                        </label>
                        <select 
                            name="priority" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md"
                        >
                            <option value="low" {{ old('priority', $incident->priority ?? 'medium') == 'low' ? 'selected' : '' }}>🔵 Low Priority</option>
                            <option value="medium" {{ old('priority', $incident->priority ?? 'medium') == 'medium' ? 'selected' : '' }}>🟡 Medium Priority</option>
                            <option value="high" {{ old('priority', $incident->priority ?? 'medium') == 'high' ? 'selected' : '' }}>🟠 High Priority</option>
                            <option value="critical" {{ old('priority', $incident->priority ?? 'medium') == 'critical' ? 'selected' : '' }}>🔴 Critical</option>
                        </select>
                    </div>

                    {{-- Resolution Notes (Visible when status is resolved) --}}
                    <div class="space-y-2 hidden" id="resolutionNotes" data-aos="fade-up" data-aos-delay="550">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                            <i class="fas fa-clipboard-check text-green-500 text-sm"></i>
                            Resolution Notes
                        </label>
                        <textarea 
                            name="resolution_notes" 
                            rows="3"
                            class="w-full px-4 py-3 border border-green-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 bg-green-50 shadow-sm hover:shadow-md resize-vertical"
                            placeholder="Describe how the incident was resolved..."
                        >{{ old('resolution_notes', $incident->resolution_notes ?? '') }}</textarea>
                        <div class="text-xs text-green-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            These notes will be visible in the incident history
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200" data-aos="fade-up" data-aos-delay="600">
                        <a href="{{ route('staff.incidents.index') }}" 
                           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-2xl border border-gray-300 shadow-sm hover:shadow-md transition-all duration-300 font-semibold hover:scale-105 transform group flex-1 text-center">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-300"></i>
                            Back to Incidents
                        </a>

                        <button 
                            type="button"
                            onclick="confirmReset()"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-500 text-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 font-semibold hover:scale-105 transform group flex-1 sm:flex-none"
                        >
                            <i class="fas fa-undo group-hover:rotate-180 transition-transform duration-300"></i>
                            Reset Changes
                        </button>
                        
                        <button 
                            type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 font-bold hover:scale-105 transform group flex-1"
                            id="submitBtn"
                        >
                            <i class="fas fa-save group-hover:scale-110 transition-transform duration-300"></i>
                            Update Incident
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change History -->
        <div class="mt-8 bg-white rounded-3xl shadow-2xl border border-red-100 overflow-hidden" data-aos="fade-up" data-aos-delay="700">
            <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Update History</h2>
                        <p class="text-gray-200 text-sm">Track changes made to this incident</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-plus text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Incident Created</p>
                            <p class="text-sm text-gray-500">by {{ $incident->reporter->name ?? 'System' }}</p>
                        </div>
                        <span class="text-sm text-gray-500">{{ $incident->created_at->format('M d, Y g:i A') }}</span>
                    </div>
                    
                    <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-2xl">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-edit text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Last Updated</p>
                            <p class="text-sm text-gray-500">by {{ auth()->user()->name }}</p>
                        </div>
                        <span class="text-sm text-gray-500">{{ $incident->updated_at->format('M d, Y g:i A') }}</span>
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
    
    /* Shake animation for errors */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    [data-aos="shake"] {
        animation: shake 0.5s ease-in-out;
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
        
        // Character count for description
        const descriptionTextarea = document.querySelector('textarea[name="description"]');
        const charCount = document.getElementById('charCount');
        
        descriptionTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length + ' characters';
        });
        
        // Show/hide resolution notes based on status
        const statusRadios = document.querySelectorAll('input[name="status"]');
        const resolutionNotes = document.getElementById('resolutionNotes');
        
        function toggleResolutionNotes() {
            const selectedStatus = document.querySelector('input[name="status"]:checked').value;
            if (selectedStatus === 'resolved') {
                resolutionNotes.classList.remove('hidden');
                resolutionNotes.style.display = 'block';
            } else {
                resolutionNotes.classList.add('hidden');
                resolutionNotes.style.display = 'none';
            }
        }
        
        statusRadios.forEach(radio => {
            radio.addEventListener('change', toggleResolutionNotes);
        });
        
        // Initialize on page load
        toggleResolutionNotes();
        
        // Form submission handling
        const form = document.getElementById('editIncidentForm');
        const submitBtn = document.getElementById('submitBtn');
        
        form.addEventListener('submit', function(e) {
            // Add loading state
            submitBtn.innerHTML = `
                <i class="fas fa-spinner fa-spin"></i>
                Updating...
            `;
            submitBtn.disabled = true;
        });
        
        // Track form changes
        let formChanged = false;
        const formInputs = form.querySelectorAll('input, textarea, select');
        
        formInputs.forEach(input => {
            const originalValue = input.value;
            
            input.addEventListener('input', function() {
                formChanged = true;
                // Add visual indicator for changed fields
                this.classList.add('border-blue-500', 'bg-blue-50');
            });
        });
        
        // Warn before leaving if changes exist
        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    });
    
    // Confirm reset function
    function confirmReset() {
        if (confirm('Are you sure you want to reset all changes? This cannot be undone.')) {
            document.getElementById('editIncidentForm').reset();
            // Remove visual indicators
            document.querySelectorAll('.border-blue-500, .bg-blue-50').forEach(el => {
                el.classList.remove('border-blue-500', 'bg-blue-50');
            });
        }
    }
    
    // Real-time validation
    function validateField(field) {
        const value = field.value.trim();
        const errorDiv = field.parentElement.querySelector('.text-red-600');
        
        if (field.hasAttribute('required') && !value) {
            if (errorDiv) {
                errorDiv.textContent = 'This field is required';
            }
            field.classList.add('border-red-500');
            return false;
        } else {
            if (errorDiv) {
                errorDiv.textContent = '';
            }
            field.classList.remove('border-red-500');
            return true;
        }
    }
    
    // Add real-time validation to required fields
    document.addEventListener('DOMContentLoaded', function() {
        const requiredFields = document.querySelectorAll('input[required], textarea[required]');
        requiredFields.forEach(field => {
            field.addEventListener('blur', function() {
                validateField(this);
            });
            
            field.addEventListener('input', function() {
                validateField(this);
            });
        });
    });
</script>
@endsection