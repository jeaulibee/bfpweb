@extends('layouts.app')
@section('title', 'Incident Details')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Toast Container -->
        <div id="toast" class="toast"></div>

        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-2xl shadow-lg mb-4">
                <i class="fas fa-fire text-red-600 text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Incident Details</h1>
            <p class="text-gray-600 text-lg">Complete incident information and reporting details</p>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Incident Information Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                            <i class="fas fa-clipboard-list"></i>
                            Incident Information
                        </h2>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <!-- Incident Header -->
                        <div class="flex items-center gap-4 mb-6 p-4 bg-red-50 rounded-xl border border-red-100">
                            <div class="flex-shrink-0 w-16 h-16 bg-white rounded-xl shadow-sm flex items-center justify-center">
                                <i class="fas fa-fire text-red-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">#{{ $incident->id }} - {{ $incident->title }}</h3>
                                <p class="text-gray-600 mt-1">Smart Fire Detection & Mapping System</p>
                            </div>
                        </div>

                        <!-- Incident Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h4 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-info-circle text-red-500"></i>
                                    Basic Information
                                </h4>
                                
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-600">Incident ID</span>
                                        <span class="text-sm font-semibold text-gray-900">#{{ $incident->id }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-600">Title</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $incident->title }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-600">Location</span>
                                        <span class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-red-500 text-xs"></i>
                                            {{ $incident->location ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Reporting -->
                            <div class="space-y-4">
                                <h4 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-chart-line text-red-500"></i>
                                    Status & Reporting
                                </h4>
                                
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-600">Status</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $incident->status === 'resolved' ? 'bg-green-100 text-green-800' : 
                                               ($incident->status === 'in-progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            <i class="fas {{ $incident->status === 'resolved' ? 'fa-check-circle' : 
                                                           ($incident->status === 'in-progress' ? 'fa-tasks' : 'fa-hourglass-half') }} mr-1"></i>
                                            {{ ucfirst($incident->status) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-600">Priority</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $incident->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                               ($incident->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($incident->priority === 'critical' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800')) }}">
                                            <i class="fas {{ $incident->priority === 'high' || $incident->priority === 'critical' ? 'fa-exclamation-triangle' : 'fa-flag' }} mr-1"></i>
                                            {{ ucfirst($incident->priority ?? 'Not set') }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-600">Reported By</span>
                                        <span class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                                            <i class="fas fa-user text-red-500 text-xs"></i>
                                            {{ $incident->reporter->name ?? 'Unknown' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-600">Incident Type</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ ucfirst($incident->type ?? 'Not specified') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-align-left text-red-500"></i>
                                Description
                            </h4>
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $incident->description ?? 'No description provided for this incident.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Cards -->
            <div class="space-y-6">
                <!-- Timeline Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-clock"></i>
                            Timeline
                            <span id="timelineRefresh" class="cursor-pointer hover:scale-110 transition-transform duration-200" title="Refresh Timeline">
                                <i class="fas fa-sync-alt text-xs ml-1"></i>
                            </span>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4" id="timelineContent">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <i class="fas fa-plus text-green-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Incident Created</p>
                                    <p class="text-xs text-gray-500" id="createdAt">{{ $incident->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mt-1">
                                    <i class="fas fa-edit text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Last Updated</p>
                                    <p class="text-xs text-gray-500" id="updatedAt">{{ $incident->updated_at->format('M d, Y h:i A') }}</p>
                                    <p class="text-xs text-blue-600 font-medium" id="lastUpdateText">{{ $incident->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if($incident->status === 'resolved')
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Resolved</p>
                                    <p class="text-xs text-gray-500" id="resolvedAt">{{ $incident->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span id="lastChecked">Last checked: Just now</span>
                                <button onclick="refreshTimeline()" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                    <i class="fas fa-sync-alt text-xs"></i>
                                    Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-bolt"></i>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <a href="{{ route('admin.incidents.edit', $incident->id) }}" 
                               class="w-full flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition-all duration-200 group">
                                <i class="fas fa-edit text-blue-600 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Edit Incident</span>
                            </a>
                            
                            @if($incident->status !== 'resolved')
                            <button onclick="showConfirmModal('{{ $incident->id }}')"
                                    class="w-full flex items-center gap-3 px-4 py-3 bg-yellow-50 text-yellow-700 rounded-xl hover:bg-yellow-100 transition-all duration-200 group">
                                <i class="fas fa-check text-yellow-600 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Mark as Resolved</span>
                            </button>
                            @endif
                            
                            <a href="{{ route('admin.incidents.index') }}" 
                               class="w-full flex items-center gap-3 px-4 py-3 bg-gray-50 text-gray-700 rounded-xl hover:bg-gray-100 transition-all duration-200 group">
                                <i class="fas fa-arrow-left text-gray-600 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Back to List</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Incident Metrics -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-chart-bar"></i>
                            Incident Metrics
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900" id="timeSinceReport">{{ $incident->created_at->diffForHumans() }}</div>
                                <div class="text-sm text-gray-500">Time Since Report</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-3 bg-red-50 rounded-lg">
                                    <div class="text-lg font-bold text-red-600">{{ $incident->id }}</div>
                                    <div class="text-xs text-gray-600">Incident ID</div>
                                </div>
                                <div class="text-center p-3 bg-blue-50 rounded-lg">
                                    <div class="text-lg font-bold text-blue-600">{{ ucfirst($incident->priority ?? 'N/A') }}</div>
                                    <div class="text-xs text-gray-600">Priority Level</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====== Confirm Modal ====== -->
<div id="confirmModal" class="modal">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
        <div class="relative top-20 mx-auto p-4 border w-96 shadow-2xl rounded-2xl bg-white transform transition-all duration-300 scale-95 hover:scale-100">
            <div class="text-center">
                <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors duration-300 hover:bg-yellow-200">
                    <i class="fas fa-check text-yellow-600 text-3xl transition-transform duration-300 hover:scale-110"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Mark as Resolved?</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to mark this incident as resolved?</p>
                
                <div id="loaderConfirm" class="hidden mb-4">
                    <div class="loader mx-auto"></div>
                </div>
                
                <div class="flex justify-center gap-3">
                    <button onclick="hideModal('confirmModal')" 
                            class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                        Cancel
                    </button>
                    <button id="confirmBtn" onclick="markComplete()" 
                            class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                        Confirm
                    </button>
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

    /* ====== Modal ====== */
    .modal {
        display: none;
    }

    /* ====== Loader ====== */
    .loader {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #facc15;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        animation: spin 0.8s linear infinite;
        display: inline-block;
    }
    @keyframes spin { 
        to { transform: rotate(360deg); } 
    }

    /* ====== Refresh Animation ====== */
    .refresh-spin {
        animation: spin 1s linear infinite;
    }
</style>

<script>
    let selectedId = "{{ $incident->id }}";
    let lastUpdateTime = "{{ $incident->updated_at }}";
    let autoRefreshInterval;

    function showConfirmModal(id) {
        selectedId = id;
        document.getElementById('confirmModal').style.display = 'block';
        setTimeout(() => {
            document.querySelector('#confirmModal .bg-gray-600').style.opacity = '1';
            document.querySelector('#confirmModal .scale-95').style.transform = 'scale(1)';
        }, 10);
    }

    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        const overlay = modal.querySelector('.bg-gray-600');
        const content = modal.querySelector('.scale-95');
        
        overlay.style.opacity = '0';
        content.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    async function markComplete() {
        const loader = document.getElementById('loaderConfirm');
        const confirmBtn = document.getElementById('confirmBtn');
        
        loader.classList.remove('hidden');
        confirmBtn.disabled = true;
        
        try {
            const res = await fetch(`/admin/incidents/${selectedId}/complete`, {
                method: 'PUT',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            
            const data = await res.json();
            
            if (data.success) {
                showToast('success', 'Incident marked as resolved successfully!');
                
                // Refresh timeline to show updated status
                refreshTimeline();
                
                // Reload page after a short delay to show the updated status everywhere
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showToast('error', data.message || 'Failed to update status.');
            }
        } catch (err) {
            console.error('Error:', err);
            showToast('error', 'Something went wrong. Please try again.');
        } finally {
            loader.classList.add('hidden');
            confirmBtn.disabled = false;
            hideModal('confirmModal');
        }
    }

    async function refreshTimeline() {
        const refreshBtn = document.querySelector('#timelineRefresh i');
        const lastChecked = document.getElementById('lastChecked');
        
        // Add spinning animation
        refreshBtn.classList.add('refresh-spin');
        lastChecked.textContent = 'Checking for updates...';
        
        try {
            const response = await fetch(`/admin/incidents/${selectedId}/timeline`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                updateTimeline(data.incident);
                showToast('success', 'Timeline updated successfully!');
            } else {
                showToast('error', 'Failed to update timeline.');
            }
        } catch (error) {
            console.error('Error fetching timeline:', error);
            showToast('error', 'Failed to check for updates.');
        } finally {
            // Remove spinning animation
            setTimeout(() => {
                refreshBtn.classList.remove('refresh-spin');
                lastChecked.textContent = `Last checked: ${new Date().toLocaleTimeString()}`;
            }, 500);
        }
    }

    function updateTimeline(incident) {
        // Update last updated time
        const updatedAt = new Date(incident.updated_at);
        document.getElementById('updatedAt').textContent = formatDate(updatedAt);
        document.getElementById('lastUpdateText').textContent = getTimeAgo(updatedAt);
        
        // Update time since report
        const createdAt = new Date(incident.created_at);
        document.getElementById('timeSinceReport').textContent = getTimeAgo(createdAt);
        
        // Update resolved time if applicable
        if (incident.status === 'resolved') {
            const resolvedAtElement = document.getElementById('resolvedAt');
            if (resolvedAtElement) {
                resolvedAtElement.textContent = formatDate(updatedAt);
            } else {
                // Add resolved timeline item if it doesn't exist
                addResolvedTimelineItem(updatedAt);
            }
        }
        
        lastUpdateTime = incident.updated_at;
    }

    function formatDate(date) {
        return date.toLocaleDateString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true 
        });
    }

    function getTimeAgo(date) {
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        
        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
        return `${Math.floor(diffInSeconds / 86400)} days ago`;
    }

    function addResolvedTimelineItem(resolvedDate) {
        const timelineContent = document.getElementById('timelineContent');
        const resolvedHtml = `
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                    <i class="fas fa-check text-green-600 text-xs"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Resolved</p>
                    <p class="text-xs text-gray-500" id="resolvedAt">${formatDate(resolvedDate)}</p>
                </div>
            </div>
        `;
        timelineContent.innerHTML += resolvedHtml;
    }

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
        }, 3000);
    }

    // Auto-refresh timeline every 30 seconds
    function startAutoRefresh() {
        autoRefreshInterval = setInterval(() => {
            checkForUpdates();
        }, 30000); // 30 seconds
    }

    async function checkForUpdates() {
        try {
            const response = await fetch(`/admin/incidents/${selectedId}/check-updates?last_update=${lastUpdateTime}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.has_updates) {
                updateTimeline(data.incident);
                document.getElementById('lastChecked').textContent = `Last checked: ${new Date().toLocaleTimeString()} (Updated)`;
            } else {
                document.getElementById('lastChecked').textContent = `Last checked: ${new Date().toLocaleTimeString()}`;
            }
        } catch (error) {
            console.error('Error checking for updates:', error);
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal') || event.target.classList.contains('fixed')) {
            hideModal('confirmModal');
        }
    }

    // Initialize auto-refresh when page loads
    document.addEventListener('DOMContentLoaded', function() {
        startAutoRefresh();
        
        // Add click event to refresh button
        document.getElementById('timelineRefresh').addEventListener('click', refreshTimeline);
    });

    // Clean up interval when page is unloaded
    window.addEventListener('beforeunload', function() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
    });
</script>
@endsection