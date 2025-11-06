@extends('layouts.app')
@section('title', 'Incident Reports')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Toast Container -->
        <div id="toast" class="toast"></div>

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                        <div class="p-2 bg-red-100 rounded-xl">
                            <i class="fas fa-fire text-red-600 text-2xl"></i>
                        </div>
                        Incident Reports
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">Manage and track all incident reports in one place</p>
                </div>
                <div class="flex items-center space-x-3 mt-4 sm:mt-0">
                    <!-- Mark Button -->
                    <button id="markButton" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm">
                        <i class="fas fa-check-square mr-2"></i>
                        Mark
                    </button>
                    <a href="{{ route('admin.incidents.create') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 shadow-sm transition-all duration-200 transform hover:-translate-y-0.5">
                        <i class="fas fa-plus mr-2"></i>
                        Create Incident
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-red-50">
                        <i class="fas fa-fire text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Incidents</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalIncidentsCount }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-yellow-50">
                        <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900" id="pending-count">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-50">
                        <i class="fas fa-tasks text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">In Progress</p>
                        <p class="text-2xl font-bold text-gray-900" id="in-progress-count">{{ $inProgressCount }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-50">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Resolved</p>
                        <p class="text-2xl font-bold text-gray-900" id="resolved-count">{{ $resolvedCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Bulk Actions Bar -->
            <div id="bulkActionsBar" class="hidden px-6 py-3 bg-gradient-to-r from-red-50 to-orange-50 border-b border-red-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-red-800" id="selectedCount">
                            <span id="selectedCountNumber">0</span> incidents selected
                        </span>
                        <button onclick="showBulkDeleteModal()" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Selected
                        </button>
                        <button onclick="markSelectedComplete()" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm">
                            <i class="fas fa-check mr-2"></i>
                            Mark Complete
                        </button>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Select All -->
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="selectAll" class="hidden">
                            <label for="selectAll" class="flex items-center space-x-2 cursor-pointer text-sm text-gray-600 hover:text-gray-800 transition-colors duration-200">
                                <div class="w-5 h-5 border-2 border-gray-300 rounded-md flex items-center justify-center transition-all duration-200 hover:border-red-400" id="selectAllBox">
                                    <i class="fas fa-check text-white text-xs transition-all duration-200" id="selectAllCheck"></i>
                                </div>
                                <span>Select All</span>
                            </label>
                        </div>
                        <button onclick="clearSelection()" 
                                class="text-sm text-red-600 hover:text-red-800 transition-colors duration-200">
                            <i class="fas fa-times mr-1"></i>
                            Clear Selection
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Incident Management</h2>
                    <div class="mt-2 sm:mt-0">
                        <div class="relative">
                            <input type="text" 
                                   id="searchInput"
                                   placeholder="Search incidents..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200 w-full sm:w-64">
                            <i class="fas fa-search text-gray-400 absolute left-3 top-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-red-600 to-red-700 text-white">
                            <th class="py-4 px-6 text-left font-semibold uppercase text-sm w-12 mark-column hidden">
                                <!-- Checkbox column header -->
                            </th>
                            <th class="py-4 px-6 text-left font-semibold uppercase text-sm">
                                <div class="flex items-center">
                                    <span>ID</span>
                                    <i class="fas fa-sort ml-1 text-xs opacity-70"></i>
                                </div>
                            </th>
                            <th class="py-4 px-6 text-left font-semibold uppercase text-sm">Title</th>
                            <th class="py-4 px-6 text-left font-semibold uppercase text-sm">Location</th>
                            <th class="py-4 px-6 text-left font-semibold uppercase text-sm">Date Reported</th>
                            <th class="py-4 px-6 text-left font-semibold uppercase text-sm">Priority</th>
                            <th class="py-4 px-6 text-left font-semibold uppercase text-sm">Status</th>
                            <th class="py-4 px-6 text-left font-semibold uppercase text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="incidentsTable">
                        @forelse($incidents as $incident)
                            <tr id="incident-row-{{ $incident->id }}" class="hover:bg-gray-50 transition-colors duration-150 incident-row" 
                                data-title="{{ strtolower($incident->title) }}" 
                                data-location="{{ strtolower($incident->location) }}" 
                                data-status="{{ $incident->status }}"
                                data-priority="{{ strtolower($incident->priority) }}">
                                <!-- Checkbox Cell - Hidden by default -->
                                <td class="py-4 px-6 mark-column hidden">
                                    <input type="checkbox" 
                                           id="incident-{{ $incident->id }}" 
                                           class="incident-checkbox hidden"
                                           value="{{ $incident->id }}">
                                    <label for="incident-{{ $incident->id }}" 
                                           class="flex items-center justify-center cursor-pointer group">
                                        <div class="w-5 h-5 border-2 border-gray-300 rounded-md flex items-center justify-center transition-all duration-200 group-hover:border-red-400 incident-checkbox-box">
                                            <i class="fas fa-check text-white text-xs transition-all duration-200 incident-checkbox-check"></i>
                                        </div>
                                    </label>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        #{{ $incident->id }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-red-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-fire text-red-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $incident->title }}</div>
                                            <div class="text-sm text-gray-500">Incident Report</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-sm text-gray-900">{{ $incident->location ?? '—' }}</div>
                                    <div class="text-sm text-gray-500">Location</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-sm text-gray-900">{{ $incident->created_at->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $incident->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold 
                                        {{ $incident->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                           ($incident->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($incident->priority === 'critical' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800')) }}">
                                        <i class="fas {{ $incident->priority === 'high' || $incident->priority === 'critical' ? 'fa-exclamation-triangle' : 'fa-flag' }} mr-1 text-xs"></i>
                                        {{ $incident->priority ? ucfirst($incident->priority) : 'Medium' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6" id="status-{{ $incident->id }}">
                                    @if($incident->status === 'resolved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Resolved
                                        </span>
                                    @elseif($incident->status === 'in_progress')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-tasks mr-1"></i>
                                            In Progress
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-hourglass-half mr-1"></i>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-2" id="actions-{{ $incident->id }}">
                                        <a href="{{ route('admin.incidents.show', $incident->id) }}" 
                                           class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors duration-200 group"
                                           title="View">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ route('admin.incidents.edit', $incident->id) }}" 
                                           class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors duration-200 group"
                                           title="Edit">
                                            <i class="fas fa-pen text-sm"></i>
                                        </a>
                                        @if($incident->status !== 'resolved')
                                            <button onclick="showConfirmModal('{{ $incident->id }}')" 
                                                    class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center hover:bg-yellow-200 transition-colors duration-200 group mark-complete-btn"
                                                    title="Mark Complete">
                                                <i class="fas fa-check text-sm"></i>
                                            </button>
                                        @endif
                                        <button onclick="showDeleteModal('{{ $incident->id }}')" 
                                                class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors duration-200 group"
                                                title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="no-incidents-row">
                                <td colspan="8" class="py-12 text-center">
                                    <div class="text-gray-400 mb-3">
                                        <i class="fas fa-inbox text-4xl"></i>
                                    </div>
                                    <p class="text-gray-500 text-lg">No incidents found</p>
                                    <p class="text-gray-400 text-sm mt-1">Get started by creating your first incident report</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            @if($incidents->count() > 0)
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-gray-600 mb-4 sm:mb-0">
                        Showing <span class="font-medium" id="showing-count">{{ $incidents->firstItem() }}</span> to 
                        <span class="font-medium" id="showing-end">{{ $incidents->lastItem() }}</span> of 
                        <span class="font-medium" id="total-count">{{ $incidents->total() }}</span> results
                    </div>
                    <div class="flex space-x-2">
                        <!-- Previous Button -->
                        @if($incidents->onFirstPage())
                            <button class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed" disabled>
                                Previous
                            </button>
                        @else
                            <a href="{{ $incidents->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                Previous
                            </a>
                        @endif

                        <!-- Page Numbers -->
                        @foreach($incidents->getUrlRange(1, $incidents->lastPage()) as $page => $url)
                            @if($page == $incidents->currentPage())
                                <span class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-lg">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        <!-- Next Button -->
                        @if($incidents->hasMorePages())
                            <a href="{{ $incidents->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                Next
                            </a>
                        @else
                            <button class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed" disabled>
                                Next
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endif
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
                <h3 class="text-xl font-bold text-gray-900 mb-2">Mark as Completed?</h3>
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

<!-- ====== Delete Modal ====== -->
<div id="deleteModal" class="modal">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
        <div class="relative top-20 mx-auto p-4 border w-96 shadow-2xl rounded-2xl bg-white transform transition-all duration-300 scale-95 hover:scale-100">
            <div class="text-center">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors duration-300 hover:bg-red-200">
                    <i class="fas fa-exclamation text-red-600 text-3xl transition-transform duration-300 hover:scale-110"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Incident?</h3>
                <p class="text-gray-600 mb-6">This action cannot be undone. All incident data will be permanently removed.</p>
                
                <div id="loaderDelete" class="hidden mb-4">
                    <div class="loader mx-auto"></div>
                </div>
                
                <div class="flex justify-center gap-3">
                    <button onclick="hideModal('deleteModal')" 
                            class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                        Cancel
                    </button>
                    <button id="deleteBtn" onclick="deleteIncident()" 
                            class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====== Bulk Delete Modal ====== -->
<div id="bulkDeleteModal" class="modal">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300">
        <div class="relative top-20 mx-auto p-4 border w-96 shadow-2xl rounded-2xl bg-white transform transition-all duration-300 scale-95 hover:scale-100">
            <div class="text-center">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors duration-300 hover:bg-red-200">
                    <i class="fas fa-exclamation-triangle text-red-600 text-3xl transition-transform duration-300 hover:scale-110"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Selected Incidents?</h3>
                <p class="text-gray-600 mb-6">You are about to delete <span id="bulkDeleteCount" class="font-bold">0</span> incidents. This action cannot be undone.</p>
                
                <div id="loaderBulkDelete" class="hidden mb-4">
                    <div class="loader mx-auto"></div>
                </div>
                
                <div class="flex justify-center gap-3">
                    <button onclick="hideModal('bulkDeleteModal')" 
                            class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                        Cancel
                    </button>
                    <button id="bulkDeleteBtn" onclick="deleteSelectedIncidents()" 
                            class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                        Delete Selected
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ====== Modern Clean Design ====== */
    .card {
        background: #fff;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ====== Toasts ====== */
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

    /* ====== Search Highlight ====== */
    .highlight {
        background-color: #fef3c7;
        padding: 2px 4px;
        border-radius: 4px;
    }

    /* ====== Hidden State ====== */
    .hidden {
        display: none !important;
    }

    /* ====== Checkbox Styles ====== */
    .incident-checkbox:checked + label .incident-checkbox-box {
        background: #dc2626;
        border-color: #dc2626;
    }

    .incident-checkbox:checked + label .incident-checkbox-check {
        color: white;
        opacity: 1;
        transform: scale(1);
    }

    #selectAll:checked + label #selectAllBox {
        background: #dc2626;
        border-color: #dc2626;
    }

    #selectAll:checked + label #selectAllCheck {
        color: white;
        opacity: 1;
        transform: scale(1);
    }

    /* Initially hide the checkmark */
    .incident-checkbox-check, #selectAllCheck {
        opacity: 0;
        transform: scale(0.5);
    }

    /* Mark column animation */
    .mark-column {
        transition: all 0.3s ease;
    }

    /* Active mark mode */
    .mark-mode-active #markButton {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
    }
</style>

<script>
    let selectedId = null;
    let selectedIncidents = new Set();
    let isMarkMode = false;

    // Toggle Mark Mode
    function toggleMarkMode() {
        isMarkMode = !isMarkMode;
        const markButton = document.getElementById('markButton');
        const markColumns = document.querySelectorAll('.mark-column');
        const bulkActionsBar = document.getElementById('bulkActionsBar');

        if (isMarkMode) {
            // Enter mark mode
            document.body.classList.add('mark-mode-active');
            markButton.innerHTML = '<i class="fas fa-times mr-2"></i>Cancel Mark';
            
            // Show checkboxes
            markColumns.forEach(column => column.classList.remove('hidden'));
            
            // Show bulk actions if items are selected
            if (selectedIncidents.size > 0) {
                bulkActionsBar.classList.remove('hidden');
            }
        } else {
            // Exit mark mode
            document.body.classList.remove('mark-mode-active');
            markButton.innerHTML = '<i class="fas fa-check-square mr-2"></i>Mark';
            
            // Hide checkboxes
            markColumns.forEach(column => column.classList.add('hidden'));
            
            // Hide bulk actions and clear selection
            bulkActionsBar.classList.add('hidden');
            clearSelection();
        }
    }

    // Selection Management
    function updateSelection() {
        const checkboxes = document.querySelectorAll('.incident-checkbox:checked');
        selectedIncidents = new Set(Array.from(checkboxes).map(cb => cb.value));
        
        // Update selected count
        document.getElementById('selectedCountNumber').textContent = selectedIncidents.size;
        
        // Show/hide bulk actions bar
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        if (selectedIncidents.size > 0 && isMarkMode) {
            bulkActionsBar.classList.remove('hidden');
        } else {
            bulkActionsBar.classList.add('hidden');
        }
        
        // Update select all state
        updateSelectAllState();
    }

    function updateSelectAllState() {
        const visibleCheckboxes = document.querySelectorAll('.incident-checkbox:not(.hidden)');
        const checkedCheckboxes = document.querySelectorAll('.incident-checkbox:checked:not(.hidden)');
        const selectAllCheckbox = document.getElementById('selectAll');
        const selectAllBox = document.getElementById('selectAllBox');
        const selectAllCheck = document.getElementById('selectAllCheck');
        
        if (checkedCheckboxes.length === 0) {
            // None selected
            selectAllCheckbox.checked = false;
            selectAllBox.style.background = 'white';
            selectAllBox.style.borderColor = '#d1d5db';
            selectAllCheck.style.opacity = '0';
            selectAllCheck.style.transform = 'scale(0.5)';
        } else if (checkedCheckboxes.length === visibleCheckboxes.length) {
            // All selected
            selectAllCheckbox.checked = true;
            selectAllBox.style.background = '#dc2626';
            selectAllBox.style.borderColor = '#dc2626';
            selectAllCheck.style.opacity = '1';
            selectAllCheck.style.transform = 'scale(1)';
        } else {
            // Some selected (indeterminate state)
            selectAllCheckbox.checked = false;
            selectAllBox.style.background = '#dc2626';
            selectAllBox.style.borderColor = '#dc2626';
            selectAllCheck.style.opacity = '0.5';
            selectAllCheck.style.transform = 'scale(0.8)';
        }
    }

    function selectAllIncidents() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.incident-checkbox:not(.hidden)');
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
            updateCheckboxVisual(checkbox);
        });
        
        updateSelection();
    }

    function updateCheckboxVisual(checkbox) {
        const box = checkbox.nextElementSibling.querySelector('.incident-checkbox-box');
        const check = checkbox.nextElementSibling.querySelector('.incident-checkbox-check');
        
        if (checkbox.checked) {
            box.style.background = '#dc2626';
            box.style.borderColor = '#dc2626';
            check.style.opacity = '1';
            check.style.transform = 'scale(1)';
        } else {
            box.style.background = 'white';
            box.style.borderColor = '#d1d5db';
            check.style.opacity = '0';
            check.style.transform = 'scale(0.5)';
        }
    }

    function clearSelection() {
        const checkboxes = document.querySelectorAll('.incident-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
            updateCheckboxVisual(checkbox);
        });
        updateSelection();
    }

    // Bulk Actions
    function showBulkDeleteModal() {
        document.getElementById('bulkDeleteCount').textContent = selectedIncidents.size;
        document.getElementById('bulkDeleteModal').style.display = 'block';
        setTimeout(() => {
            document.querySelector('#bulkDeleteModal .bg-gray-600').style.opacity = '1';
            document.querySelector('#bulkDeleteModal .scale-95').style.transform = 'scale(1)';
        }, 10);
    }

    async function deleteSelectedIncidents() {
        const loader = document.getElementById('loaderBulkDelete');
        const deleteBtn = document.getElementById('bulkDeleteBtn');
        
        loader.classList.remove('hidden');
        deleteBtn.disabled = true;
        
        try {
            const incidentIds = Array.from(selectedIncidents);
            const res = await fetch('/admin/incidents/bulk-delete', {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ ids: incidentIds })
            });
            
            const data = await res.json();
            
            if (data.success) {
                // Remove selected rows
                incidentIds.forEach(id => {
                    const row = document.getElementById(`incident-row-${id}`);
                    if (row) row.remove();
                });
                
                // Update stats counters
                updateStatsCounters();
                
                // Update showing count
                updateShowingCount();
                
                // Clear selection and exit mark mode
                clearSelection();
                toggleMarkMode();
                
                showToast('success', `${incidentIds.length} incidents deleted successfully!`);
            } else {
                showToast('error', data.message || 'Failed to delete incidents.');
            }
        } catch (err) {
            console.error('Error:', err);
            showToast('error', 'Something went wrong. Please try again.');
        } finally {
            loader.classList.add('hidden');
            deleteBtn.disabled = false;
            hideModal('bulkDeleteModal');
        }
    }

    async function markSelectedComplete() {
        const incidentIds = Array.from(selectedIncidents);
        
        try {
            const res = await fetch('/admin/incidents/bulk-complete', {
                method: 'PUT',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ ids: incidentIds })
            });
            
            const data = await res.json();
            
            if (data.success) {
                // Update status for each incident
                incidentIds.forEach(id => {
                    const statusCell = document.getElementById(`status-${id}`);
                    const actionsContainer = document.getElementById(`actions-${id}`);
                    const row = document.getElementById(`incident-row-${id}`);
                    
                    if (statusCell) {
                        statusCell.innerHTML = 
                            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">' +
                            '<i class="fas fa-check-circle mr-1"></i>Resolved</span>';
                    }
                    
                    // Remove mark complete button
                    if (actionsContainer) {
                        const markCompleteBtn = actionsContainer.querySelector('.mark-complete-btn');
                        if (markCompleteBtn) markCompleteBtn.remove();
                    }
                    
                    // Update row data status
                    if (row) {
                        row.setAttribute('data-status', 'resolved');
                    }
                });
                
                // Update stats counters
                updateStatsCounters();
                
                // Clear selection and exit mark mode
                clearSelection();
                toggleMarkMode();
                
                showToast('success', `${incidentIds.length} incidents marked as resolved!`);
            } else {
                showToast('error', data.message || 'Failed to update incidents.');
            }
        } catch (err) {
            console.error('Error:', err);
            showToast('error', 'Something went wrong. Please try again.');
        }
    }

    // Existing functions (keep all your existing functions as they are)
    function showConfirmModal(id) {
        selectedId = id;
        document.getElementById('confirmModal').style.display = 'block';
        setTimeout(() => {
            document.querySelector('#confirmModal .bg-gray-600').style.opacity = '1';
            document.querySelector('#confirmModal .scale-95').style.transform = 'scale(1)';
        }, 10);
    }

    function showDeleteModal(id) {
        selectedId = id;
        document.getElementById('deleteModal').style.display = 'block';
        setTimeout(() => {
            document.querySelector('#deleteModal .bg-gray-600').style.opacity = '1';
            document.querySelector('#deleteModal .scale-95').style.transform = 'scale(1)';
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
                // Update status badge
                document.getElementById(`status-${selectedId}`).innerHTML =
                    '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">' +
                    '<i class="fas fa-check-circle mr-1"></i>Resolved</span>';
                
                // Remove the mark complete button
                const actionsContainer = document.getElementById(`actions-${selectedId}`);
                const markCompleteBtn = actionsContainer.querySelector('.mark-complete-btn');
                if (markCompleteBtn) {
                    markCompleteBtn.remove();
                }

                // Update the row data status
                const row = document.getElementById(`incident-row-${selectedId}`);
                row.setAttribute('data-status', 'resolved');
                
                // Update stats counters
                updateStatsCounters();
                
                showToast('success', 'Incident marked as resolved successfully!');
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

    async function deleteIncident() {
        const loader = document.getElementById('loaderDelete');
        const deleteBtn = document.getElementById('deleteBtn');
        
        loader.classList.remove('hidden');
        deleteBtn.disabled = true;
        
        try {
            const res = await fetch(`/admin/incidents/${selectedId}`, {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            const data = await res.json();
            
            if (data.success) {
                const row = document.getElementById(`incident-row-${selectedId}`);
                row.remove();
                
                // Update stats counters
                updateStatsCounters();
                
                // Update showing count
                updateShowingCount();
                
                showToast('success', 'Incident deleted successfully!');
            } else {
                showToast('error', data.message || 'Failed to delete incident.');
            }
        } catch (err) {
            console.error('Error:', err);
            showToast('error', 'Something went wrong. Please try again.');
        } finally {
            loader.classList.add('hidden');
            deleteBtn.disabled = false;
            hideModal('deleteModal');
        }
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
        }, 4000);
    }

    function updateStatsCounters() {
        const rows = document.querySelectorAll('.incident-row:not(.hidden)');
        let pending = 0, inProgress = 0, resolved = 0;
        
        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            if (status === 'pending') pending++;
            else if (status === 'in_progress') inProgress++;
            else if (status === 'resolved') resolved++;
        });
        
        document.getElementById('pending-count').textContent = pending;
        document.getElementById('in-progress-count').textContent = inProgress;
        document.getElementById('resolved-count').textContent = resolved;
    }

    function updateShowingCount() {
        const visibleRows = document.querySelectorAll('.incident-row:not(.hidden)').length;
        const totalRows = document.querySelectorAll('.incident-row').length;
        
        document.getElementById('showing-count').textContent = visibleRows;
        document.getElementById('total-count').textContent = totalRows;
        
        // Show/hide no incidents message
        const noIncidentsRow = document.getElementById('no-incidents-row');
        const originalEmptyState = '{{ $incidents->count() === 0 ? "true" : "false" }}';
        
        if (visibleRows === 0 && totalRows > 0) {
            // Show search empty state
            if (!noIncidentsRow) {
                const tbody = document.getElementById('incidentsTable');
                tbody.innerHTML = `
                    <tr id="no-incidents-row">
                        <td colspan="8" class="py-12 text-center">
                            <div class="text-gray-400 mb-3">
                                <i class="fas fa-search text-4xl"></i>
                            </div>
                            <p class="text-gray-500 text-lg">No incidents match your search</p>
                            <p class="text-gray-400 text-sm mt-1">Try adjusting your search terms</p>
                        </td>
                    </tr>
                `;
            }
        } else if (visibleRows === 0 && originalEmptyState) {
            // Keep the original empty state (no incidents at all)
            if (!noIncidentsRow) {
                const tbody = document.getElementById('incidentsTable');
                tbody.innerHTML = `
                    <tr id="no-incidents-row">
                        <td colspan="8" class="py-12 text-center">
                            <div class="text-gray-400 mb-3">
                                <i class="fas fa-inbox text-4xl"></i>
                            </div>
                            <p class="text-gray-500 text-lg">No incidents found</p>
                            <p class="text-gray-400 text-sm mt-1">Get started by creating your first incident report</p>
                        </td>
                    </tr>
                `;
            }
        } else {
            // Remove any empty state messages when there are visible rows
            if (noIncidentsRow) {
                noIncidentsRow.remove();
            }
        }
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.incident-row');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const title = row.getAttribute('data-title');
            const location = row.getAttribute('data-location');
            const status = row.getAttribute('data-status');
            const priority = row.getAttribute('data-priority');
            
            const matchesSearch = title.includes(searchTerm) || 
                                location.includes(searchTerm) || 
                                status.includes(searchTerm) ||
                                priority.includes(searchTerm);
            
            if (matchesSearch || searchTerm === '') {
                row.classList.remove('hidden');
                visibleCount++;
                
                // Highlight matching text
                if (searchTerm !== '') {
                    highlightText(row, searchTerm);
                } else {
                    removeHighlights(row);
                }
            } else {
                row.classList.add('hidden');
                removeHighlights(row);
            }
        });
        
        updateShowingCount();
        updateSelection(); // Update selection state after search
    });

    function highlightText(row, searchTerm) {
        const cells = row.querySelectorAll('td');
        cells.forEach(cell => {
            const text = cell.textContent || cell.innerText;
            const regex = new RegExp(`(${searchTerm})`, 'gi');
            const highlighted = text.replace(regex, '<span class="highlight">$1</span>');
            
            // Only update if there's a match to avoid unnecessary DOM updates
            if (highlighted !== text) {
                cell.innerHTML = highlighted;
            }
        });
    }

    function removeHighlights(row) {
        const highlights = row.querySelectorAll('.highlight');
        highlights.forEach(highlight => {
            const parent = highlight.parentNode;
            parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
            parent.normalize();
        });
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal') || event.target.classList.contains('fixed')) {
            hideModal('confirmModal');
            hideModal('deleteModal');
            hideModal('bulkDeleteModal');
        }
    }

    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Mark button functionality
        document.getElementById('markButton').addEventListener('click', toggleMarkMode);
        
        // Select All functionality
        document.getElementById('selectAll').addEventListener('change', selectAllIncidents);
        
        // Individual checkbox functionality
        document.querySelectorAll('.incident-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateCheckboxVisual(this);
                updateSelection();
            });
            
            // Initialize checkbox visual state
            updateCheckboxVisual(checkbox);
        });
        
        // Initialize stats counters
        updateStatsCounters();
    });
</script>
@endsection