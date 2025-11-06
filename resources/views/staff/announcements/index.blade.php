@extends('layouts.app')

@section('title', 'Announcements')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-white to-red-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-12 text-center" data-aos="fade-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-3xl shadow-2xl mb-6 transform transition-all duration-500 hover:scale-110 hover:shadow-2xl hover:from-red-700 hover:to-red-800">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
            </div>
            <h1 class="text-5xl font-black text-gray-900 mb-4 bg-gradient-to-r from-red-700 to-red-600 bg-clip-text text-transparent">
                Announcements
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Stay informed with the latest updates and important news from your organization
            </p>
            <div class="w-32 h-1.5 bg-gradient-to-r from-red-500 to-red-400 rounded-full mx-auto mt-6 shadow-sm"></div>
        </div>

        @if($announcements->count() > 0)
            <!-- Stats Bar -->
            <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4" data-aos="fade-up">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $announcements->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Showing</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $announcements->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Latest</p>
                            <p class="text-lg font-bold text-gray-900">{{ $announcements->first()->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Announcements Grid -->
            <div class="grid gap-6 lg:gap-8">
                @foreach($announcements as $index => $announcement)
                    <a href="{{ route('staff.announcements.show', $announcement->id) }}" 
                       class="group block bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-red-100 overflow-hidden relative"
                       data-aos="fade-up"
                       data-aos-delay="{{ $index * 100 }}"
                       data-aos-duration="600">
                        
                        <!-- Red Accent Bar -->
                        <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-red-600 to-red-500 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                        
                        <!-- Hover Glow Effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-red-500/5 to-red-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                        
                        <div class="relative p-8 lg:p-10">
                            <!-- Header -->
                            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start mb-6 gap-4">
                                <div class="flex items-start gap-4 flex-1">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-all duration-500 border border-red-200">
                                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                        </svg>
                                    </div>
                                    
                                    <!-- Title & Content -->
                                    <div class="flex-1 min-w-0">
                                        <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 group-hover:text-red-700 transition-colors duration-300 mb-3 leading-tight">
                                            {{ $announcement->title }}
                                        </h2>
                                        
                                        <!-- Message Preview -->
                                        <p class="text-gray-600 leading-relaxed line-clamp-3 group-hover:text-gray-700 transition-colors duration-300 text-lg mb-4">
                                            {{ $announcement->message }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Date Badge -->
                                <div class="flex-shrink-0">
                                    <div class="inline-flex flex-col items-center bg-gradient-to-br from-red-600 to-red-700 text-white rounded-2xl p-4 shadow-lg transform group-hover:scale-105 transition-all duration-300">
                                        <span class="text-sm font-semibold uppercase tracking-wide opacity-90">
                                            {{ $announcement->created_at->format('M') }}
                                        </span>
                                        <span class="text-2xl font-black">
                                            {{ $announcement->created_at->format('d') }}
                                        </span>
                                        <span class="text-xs font-medium opacity-90">
                                            {{ $announcement->created_at->format('Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 pt-6 border-t border-gray-100">
                                <!-- Author & Meta -->
                                <div class="flex items-center gap-4">
                                    <!-- Author Avatar -->
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                                            <span class="text-sm font-bold text-white">
                                                {{ strtoupper(substr($announcement->creator ? $announcement->creator->name : 'Admin', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-semibold text-gray-700 block">
                                                {{ $announcement->creator ? $announcement->creator->name : 'Admin' }}
                                            </span>
                                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $announcement->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Read More -->
                                <div class="flex items-center text-red-600 font-semibold group-hover:text-red-700 transition-all duration-300 transform group-hover:translate-x-2">
                                    <span class="text-base">View Details</span>
                                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Enhanced Pagination -->
            <div class="mt-16" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-6">
                    {{ $announcements->links() }}
                </div>
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-24" data-aos="zoom-in" data-aos-duration="600">
                <div class="max-w-md mx-auto">
                    <div class="w-32 h-32 bg-gradient-to-br from-red-100 to-red-50 rounded-3xl flex items-center justify-center shadow-2xl mx-auto mb-8 border border-red-200">
                        <svg class="w-16 h-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-black text-gray-800 mb-4 bg-gradient-to-r from-red-700 to-red-600 bg-clip-text text-transparent">
                        No Announcements Yet
                    </h3>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        There are no announcements at the moment. Check back later for important updates and news!
                    </p>
                    <div class="w-32 h-1.5 bg-gradient-to-r from-red-400 to-red-300 rounded-full mx-auto shadow-sm"></div>
                </div>
            </div>
        @endif
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
    
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #b91c1c, #991b1b);
    }
    
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Enhanced Pagination Styles */
    .pagination {
        @apply flex justify-center items-center space-x-3;
    }
    
    .pagination li:not(.disabled):not(.active) a {
        @apply inline-flex items-center justify-center w-12 h-12 bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-red-200 hover:border-red-300 text-gray-700 hover:text-red-600 font-semibold transform hover:scale-110;
    }
    
    .pagination li.active a {
        @apply bg-gradient-to-br from-red-600 to-red-700 text-white shadow-lg border-transparent transform scale-110;
    }
    
    .pagination li.disabled a {
        @apply bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200;
    }
    
    .pagination li a {
        @apply transition-all duration-300;
    }
    
    /* Smooth transitions */
    .transition-all {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Custom animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .float-animation {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Gradient text animation */
    .gradient-text {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
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
        
        // Enhanced card hover effects
        const announcementCards = document.querySelectorAll('a[href*="announcements"]');
        announcementCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-12px) scale(1.02)';
                this.style.boxShadow = '0 25px 50px -12px rgba(220, 38, 38, 0.25)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '';
            });
        });
        
        // Add loading animation with fade in
        const grid = document.querySelector('.grid');
        if (grid) {
            grid.style.opacity = '0';
            grid.style.transform = 'translateY(20px)';
            setTimeout(() => {
                grid.style.transition = 'all 0.6s ease-out';
                grid.style.opacity = '1';
                grid.style.transform = 'translateY(0)';
            }, 200);
        }
        
        // Add floating animation to header icon
        const headerIcon = document.querySelector('.text-center .inline-flex');
        if (headerIcon) {
            headerIcon.classList.add('float-animation');
        }
    });
    
    // Enhanced parallax effect
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const header = document.querySelector('.text-center');
        const stats = document.querySelector('.grid-cols-3');
        
        if (header) {
            header.style.transform = `translateY(${scrolled * 0.08}px)`;
        }
        
        if (stats) {
            stats.style.transform = `translateY(${scrolled * 0.05}px)`;
        }
    });
    
    // Add ripple effect to cards
    document.addEventListener('click', function(e) {
        const card = e.target.closest('a[href*="announcements"]');
        if (card) {
            const ripple = document.createElement('div');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(220, 38, 38, 0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            const rect = card.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            card.style.position = 'relative';
            card.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        }
    });
</script>

<style>
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>
@endsection