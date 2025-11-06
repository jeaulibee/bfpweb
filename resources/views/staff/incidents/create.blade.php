@extends('layouts.app')

@section('title', 'Add Incident Report')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-white to-red-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center" data-aos="fade-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-3xl shadow-2xl mb-6 transform transition-all duration-500 hover:scale-110 hover:shadow-2xl hover:from-red-700 hover:to-red-800">
                <i class="fas fa-plus text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-black text-gray-900 mb-4 bg-gradient-to-r from-red-700 to-red-600 bg-clip-text text-transparent">
                Report New Incident
            </h1>
            <p class="text-lg text-gray-600 max-w-md mx-auto leading-relaxed">
                Quickly document and submit incident reports with all necessary details
            </p>
            <div class="w-24 h-1.5 bg-gradient-to-r from-red-500 to-red-400 rounded-full mx-auto mt-4 shadow-sm"></div>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8" data-aos="fade-up">
            <div class="flex items-center justify-between max-w-md mx-auto">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center font-bold shadow-lg">
                        1
                    </div>
                    <span class="text-sm font-medium text-gray-700 mt-2">Details</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300 mx-2">
                    <div class="h-full bg-red-500 rounded-full w-1/2"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-bold">
                        2
                    </div>
                    <span class="text-sm font-medium text-gray-500 mt-2">Review</span>
                </div>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-red-100 overflow-hidden transform hover:shadow-3xl transition-all duration-500"
             data-aos="fade-up" data-aos-delay="200">
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-fire text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Incident Details</h2>
                        <p class="text-red-100 text-sm">Fill in all required information</p>
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

                <form action="{{ route('staff.incidents.store') }}" method="POST" class="space-y-6" id="incidentForm">
                    @csrf

                    {{-- Reporter Info (Display only) --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4" data-aos="fade-up">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-blue-800">Reporting as</p>
                                <p class="text-blue-700">{{ Auth::user()->name }} ({{ Auth::user()->email }})</p>
                            </div>
                        </div>
                    </div>

                    {{-- Title --}}
                    <div class="space-y-2" data-aos="fade-up" data-aos-delay="300">
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                            <i class="fas fa-heading text-red-500 text-sm"></i>
                            Incident Title
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            value="{{ old('title') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md"
                            placeholder="Enter a clear and concise title"
                            required
                            autofocus
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
                        <input 
                            type="text" 
                            name="location" 
                            value="{{ old('location') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md"
                            placeholder="Where did this incident occur?"
                        >
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
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="description" 
                            rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300 bg-white shadow-sm hover:shadow-md resize-vertical"
                            placeholder="Provide detailed information about the incident..."
                            required
                        >{{ old('description') }}</textarea>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>Be as detailed as possible</span>
                            <span id="charCount">0 characters</span>
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
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="relative">
                                <input type="radio" name="status" value="pending" {{ old('status', 'pending') == 'pending' ? 'checked' : '' }} class="hidden peer" required>
                                <div class="p-4 border-2 border-gray-300 rounded-2xl text-center cursor-pointer transition-all duration-300 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-md hover:shadow-md">
                                    <i class="fas fa-hourglass-half text-yellow-500 text-lg mb-2"></i>
                                    <div class="font-semibold text-gray-700">Pending</div>
                                    <div class="text-xs text-gray-500 mt-1">Initial report</div>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" name="status" value="in-progress" {{ old('status') == 'in-progress' ? 'checked' : '' }} class="hidden peer">
                                <div class="p-4 border-2 border-gray-300 rounded-2xl text-center cursor-pointer transition-all duration-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-md hover:shadow-md">
                                    <i class="fas fa-spinner text-blue-500 text-lg mb-2"></i>
                                    <div class="font-semibold text-gray-700">In Progress</div>
                                    <div class="text-xs text-gray-500 mt-1">Being handled</div>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" name="status" value="resolved" {{ old('status') == 'resolved' ? 'checked' : '' }} class="hidden peer">
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
                            <option value="low" {{ old('priority', 'medium') == 'low' ? 'selected' : '' }}>🔵 Low Priority</option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>🟡 Medium Priority</option>
                            <option value="high" {{ old('priority', 'medium') == 'high' ? 'selected' : '' }}>🟠 High Priority</option>
                            <option value="critical" {{ old('priority', 'medium') == 'critical' ? 'selected' : '' }}>🔴 Critical</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200" data-aos="fade-up" data-aos-delay="550">
                        <a href="{{ route('staff.incidents.index') }}" 
                           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-2xl border border-gray-300 shadow-sm hover:shadow-md transition-all duration-300 font-semibold hover:scale-105 transform group flex-1 text-center">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-300"></i>
                            Back to Incidents
                        </a>
                        
                        <button 
                            type="submit" 
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 font-bold hover:scale-105 transform group flex-1"
                            id="submitBtn"
                        >
                            <i class="fas fa-paper-plane group-hover:scale-110 transition-transform duration-300"></i>
                            Submit Incident Report
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center" data-aos="fade-up" data-aos-delay="600">
            <div class="inline-flex items-center gap-2 text-gray-500 text-sm">
                <i class="fas fa-info-circle"></i>
                Need help? Contact support if you have questions about incident reporting
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
        
        // Trigger input event to update count on page load
        descriptionTextarea.dispatchEvent(new Event('input'));
        
        // Form submission handling
        const form = document.getElementById('incidentForm');
        const submitBtn = document.getElementById('submitBtn');
        
        form.addEventListener('submit', function(e) {
            // Add loading state
            submitBtn.innerHTML = `
                <i class="fas fa-spinner fa-spin"></i>
                Submitting...
            `;
            submitBtn.disabled = true;
        });
    });
</script>
@endsection