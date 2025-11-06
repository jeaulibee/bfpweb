@extends('layouts.app')
@section('title', 'Live Alerts Monitor')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/30 p-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8">
        <div class="mb-4 lg:mb-0">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-bell text-white text-lg"></i>
                    </div>
                    <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full border-2 border-white animate-pulse"></div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Live Alerts Monitor
                    </h1>
                    <p class="text-gray-500 mt-1">Real-time monitoring of system alerts and notifications</p>
                </div>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-2xl shadow-sm border border-white/20">
                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-gray-700">Live Updates</span>
            </div>
            <button id="refresh-alerts" class="bg-white/80 backdrop-blur-sm hover:bg-white transition-all duration-300 px-4 py-2 rounded-2xl shadow-sm border border-white/20 group">
                <i class="fas fa-sync-alt text-gray-600 group-hover:text-blue-600 transition-all duration-300 group-hover:rotate-180"></i>
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Alerts</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $alerts->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Today's Alerts</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $alerts->where('created_at', '>=', today())->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Active Devices</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $alerts->pluck('device_id')->unique()->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-microchip text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-sm border border-white/20 hover:shadow-md transition-all duration-300 group hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Response Rate</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">98%</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 rounded-2xl shadow-lg animate-fade-in">
            <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-lg"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-sm border border-white/20 overflow-hidden">
        <!-- Table Header -->
        <div class="border-b border-gray-100/50 bg-gradient-to-r from-gray-50 to-gray-100/30 px-6 py-4">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <h2 class="text-xl font-semibold text-gray-800">Recent Alerts</h2>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search alerts..." class="pl-10 pr-4 py-2 bg-white/50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                    </div>
                    <select class="bg-white/50 border border-gray-200 rounded-2xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                        <option>All Types</option>
                        <option>Fire</option>
                        <option>Temperature</option>
                        <option>Smoke</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Alerts Table -->
        <div class="overflow-hidden" id="alerts-table">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100/50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alert</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Device</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100/30">
                        @forelse($alerts as $alert)
                            <tr class="group hover:bg-blue-50/30 transition-all duration-300 animate-slide-in" style="animation-delay: {{ $loop->index * 0.05 }}s">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                                        <span class="text-sm font-semibold text-gray-900">#{{ $alert->id }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-microchip text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm text-gray-700">{{ $alert->device->name ?? 'Unknown Device' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $typeConfig = [
                                            'fire' => ['color' => 'bg-red-100 text-red-800', 'icon' => 'fa-fire'],
                                            'temperature' => ['color' => 'bg-orange-100 text-orange-800', 'icon' => 'fa-thermometer-half'],
                                            'smoke' => ['color' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-smog'],
                                            'system' => ['color' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-cog']
                                        ];
                                        $config = $typeConfig[strtolower($alert->type)] ?? ['color' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-bell'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['color'] }}">
                                        <i class="fas {{ $config['icon'] }} mr-1.5"></i>
                                        {{ strtoupper($alert->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 max-w-xs truncate group-hover:max-w-none transition-all duration-300">
                                        {{ $alert->message ?? 'No message provided' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        {{ $alert->created_at->format('M j, Y') }}
                                        <div class="text-xs text-gray-400">{{ $alert->created_at->format('H:i:s') }}</div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                        </div>
                                        <div class="text-gray-500">
                                            <p class="font-medium">No alerts received yet</p>
                                            <p class="text-sm mt-1">Alerts will appear here when detected</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table Footer -->
        <div class="border-t border-gray-100/50 bg-gray-50/30 px-6 py-4">
            <div class="flex items-center justify-between text-sm text-gray-500">
                <div>
                    Showing <span class="font-semibold">{{ $alerts->count() }}</span> alerts
                </div>
                <div class="flex items-center space-x-4">
                    <button class="hover:text-gray-700 transition-colors duration-200">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="font-semibold">1</span>
                    <button class="hover:text-gray-700 transition-colors duration-200">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-8">
        <button class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-2xl shadow-lg flex items-center justify-center text-white transition-all duration-300 hover:scale-110 hover:shadow-xl group">
            <i class="fas fa-plus text-lg group-hover:rotate-90 transition-transform duration-300"></i>
        </button>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slide-in {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
        }
        50% {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.8);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }

    .animate-slide-in {
        animation: slide-in 0.5s ease-out both;
    }

    .animate-pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Glass morphism effect */
    .glass {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    /* Hover effects */
    .hover-lift:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const refreshBtn = document.getElementById('refresh-alerts');
    
    // Refresh button animation
    refreshBtn.addEventListener('click', function() {
        const icon = this.querySelector('i');
        icon.classList.add('rotate-180');
        setTimeout(() => {
            icon.classList.remove('rotate-180');
        }, 500);
        
        loadAlerts();
    });

    // Auto-refresh every 5 seconds
    setInterval(loadAlerts, 5000);

    // Table row hover effects
    document.addEventListener('mouseover', function(e) {
        if (e.target.closest('tbody tr')) {
            const row = e.target.closest('tbody tr');
            row.style.transform = 'translateX(8px)';
        }
    });

    document.addEventListener('mouseout', function(e) {
        if (e.target.closest('tbody tr')) {
            const row = e.target.closest('tbody tr');
            row.style.transform = 'translateX(0)';
        }
    });

    function loadAlerts() {
        fetch("{{ route('admin.alerts.index') }}")
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, "text/html");
                const newTable = doc.querySelector("#alerts-table").innerHTML;
                const oldTable = document.querySelector("#alerts-table");
                
                // Add fade out effect
                oldTable.style.opacity = '0.5';
                oldTable.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    oldTable.innerHTML = newTable;
                    oldTable.style.opacity = '1';
                    oldTable.style.transform = 'translateY(0)';
                    
                    // Add animation to new rows
                    const newRows = oldTable.querySelectorAll('tbody tr');
                    newRows.forEach((row, index) => {
                        row.style.animationDelay = `${index * 0.05}s`;
                        row.classList.add('animate-slide-in');
                    });
                }, 300);
            })
            .catch(err => console.error("Auto-refresh error:", err));
    }

    // Initialize animations
    const initialRows = document.querySelectorAll('tbody tr');
    initialRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
    });
});
</script>
@endsection