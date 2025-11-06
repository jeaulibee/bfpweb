@extends('layouts.app')

@section('title', $announcement->title . ' - Announcements')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-white to-red-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-8" data-aos="fade-down">
            <a href="{{ route('staff.announcements.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-red-700 font-semibold group transition-all duration-300 transform hover:-translate-x-2">
                <svg class="w-6 h-6 mr-3 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Announcements
            </a>
        </div>

        <!-- Main Announcement Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-100 transform hover:shadow-3xl transition-all duration-500"
             data-aos="fade-up"
             data-aos-duration="800">
            
            <!-- Header Section with Red Gradient -->
            <div class="relative bg-gradient-to-br from-red-600 to-red-700 p-8 lg:p-12 text-white">
                <!-- Animated Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>
                
                <div class="relative z-10">
                    <!-- Announcement Header -->
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-8">
                        <div class="flex items-start gap-6 flex-1">
                            <!-- Icon -->
                            <div class="flex-shrink-0 w-20 h-20 bg-white/20 rounded-3xl flex items-center justify-center backdrop-blur-sm shadow-2xl border border-white/30 transform hover:scale-110 transition-all duration-500">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                </svg>
                            </div>
                            
                            <!-- Title & Badge -->
                            <div class="flex-1">
                                <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-2xl px-4 py-2 mb-4 border border-white/30">
                                    <span class="text-sm font-semibold uppercase tracking-wider">Important Announcement</span>
                                </div>
                                <h1 class="text-4xl lg:text-5xl font-black leading-tight bg-gradient-to-r from-white to-red-100 bg-clip-text text-transparent">
                                    {{ $announcement->title }}
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Information Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-8 border-t border-white/20">
                        <!-- Author -->
                        <div class="flex items-center gap-4 p-4 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 hover:bg-white/15 transition-all duration-300">
                            <div class="w-12 h-12 bg-gradient-to-br from-white to-red-100 rounded-2xl flex items-center justify-center shadow-lg">
                                <span class="text-lg font-bold text-red-700">
                                    {{ strtoupper(substr($announcement->creator ? $announcement->creator->name : 'Admin', 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-red-100 text-sm font-medium">Posted by</p>
                                <p class="font-bold text-white text-lg">{{ $announcement->creator ? $announcement->creator->name : 'Admin' }}</p>
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="flex items-center gap-4 p-4 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 hover:bg-white/15 transition-all duration-300">
                            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-red-100 text-sm font-medium">Published on</p>
                                <p class="font-bold text-white text-lg">{{ $announcement->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>

                        <!-- Time -->
                        <div class="flex items-center gap-4 p-4 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 hover:bg-white/15 transition-all duration-300">
                            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-red-100 text-sm font-medium">At</p>
                                <p class="font-bold text-white text-lg">{{ $announcement->created_at->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-8 lg:p-12">
                <!-- Announcement Message -->
                <div class="mb-12" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-gray-800 leading-relaxed text-lg space-y-8">
                        @foreach(explode("\n", $announcement->message) as $paragraph)
                            @if(trim($paragraph))
                                <p class="text-gray-800 text-xl leading-relaxed border-l-4 border-red-500 pl-6 py-2 bg-red-50 rounded-r-2xl">
                                    {{ $paragraph }}
                                </p>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Additional Information Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="400">
                    <!-- Last Updated -->
                    <div class="bg-gradient-to-br from-red-50 to-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center shadow-inner">
                                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Last Updated</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $announcement->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Announcement ID -->
                    <div class="bg-gradient-to-br from-red-50 to-white rounded-2xl p-6 shadow-lg border border-red-100 transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center shadow-inner">
                                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Announcement ID</p>
                                <p class="text-2xl font-bold text-gray-900">#{{ $announcement->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-12 flex flex-col sm:flex-row gap-6 justify-between items-center" data-aos="fade-up" data-aos-delay="600">
            <!-- Back to List -->
            <a href="{{ route('staff.announcements.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-white text-gray-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-red-200 hover:border-red-300 font-bold group w-full sm:w-auto justify-center transform hover:-translate-x-2">
                <svg class="w-6 h-6 mr-3 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to All Announcements
            </a>

            <!-- Share Button -->
            <button onclick="shareAnnouncement()"
                    class="inline-flex items-center px-8 py-4 bg-gradient-to-br from-red-600 to-red-700 text-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 font-bold w-full sm:w-auto justify-center group">
                <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
                Share Announcement
            </button>
        </div>

        <!-- Related Announcements -->
        @if($relatedAnnouncements && $relatedAnnouncements->count() > 0)
        <div class="mt-16" data-aos="fade-up" data-aos-delay="800">
            <div class="bg-white rounded-3xl shadow-2xl border border-red-100 p-8">
                <h2 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    Related Announcements
                </h2>
                
                <div class="grid gap-6">
                    @foreach($relatedAnnouncements as $related)
                        @if($related->id != $announcement->id)
                        <a href="{{ route('staff.announcements.show', $related->id) }}" 
                           class="block p-6 bg-red-50 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-red-200 hover:border-red-300 group transform hover:-translate-y-1">
                            <div class="flex justify-between items-start gap-6">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-700 transition-colors duration-300 mb-3">
                                        {{ $related->title }}
                                    </h3>
                                    <p class="text-gray-600 text-lg line-clamp-2 mb-4 leading-relaxed">
                                        {{ Str::limit($related->message, 120) }}
                                    </p>
                                    <div class="flex items-center gap-6 text-sm text-gray-500">
                                        <span class="flex items-center gap-2 font-semibold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $related->created_at->diffForHumans() }}
                                        </span>
                                        <span class="font-semibold">By: {{ $related->creator ? $related->creator->name : 'Admin' }}</span>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 transform group-hover:translate-x-2 transition-all duration-300 flex-shrink-0 mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                        @endif
                    @endforeach
                </div>
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
    
    /* Enhanced transitions */
    .transition-all {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Shadow enhancements */
    .shadow-3xl {
        box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
    }
    
    /* Gradient text */
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
        
        // Add smooth scrolling to top when page loads
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Add loading animation
        const content = document.querySelector('.max-w-4xl');
        if (content) {
            content.style.opacity = '0';
            content.style.transform = 'translateY(20px)';
            setTimeout(() => {
                content.style.transition = 'all 0.6s ease-out';
                content.style.opacity = '1';
                content.style.transform = 'translateY(0)';
            }, 200);
        }
        
        // Add floating animation to header icon
        const headerIcon = document.querySelector('.bg-white\\/20');
        if (headerIcon) {
            headerIcon.style.animation = 'float 3s ease-in-out infinite';
        }
    });
    
    // Share functionality
    function shareAnnouncement() {
        const shareData = {
            title: '{{ $announcement->title }}',
            text: '{{ Str::limit(strip_tags($announcement->message), 100) }}',
            url: window.location.href
        };
        
        if (navigator.share) {
            navigator.share(shareData)
                .then(() => console.log('Announcement shared successfully'))
                .catch((error) => console.log('Error sharing:', error));
        } else {
            // Fallback: Copy to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                // Show success message
                const button = document.querySelector('button[onclick="shareAnnouncement()"]');
                const originalText = button.innerHTML;
                button.innerHTML = `
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Link Copied!
                `;
                button.classList.remove('from-red-600', 'to-red-700');
                button.classList.add('from-green-600', 'to-green-700');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('from-green-600', 'to-green-700');
                    button.classList.add('from-red-600', 'to-red-700');
                }, 2000);
            });
        }
    }
    
    // Enhanced parallax effect
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const header = document.querySelector('.bg-gradient-to-br');
        const content = document.querySelector('.p-8');
        
        if (header) {
            header.style.transform = `translateY(${scrolled * 0.08}px)`;
        }
        
        if (content) {
            content.style.transform = `translateY(${scrolled * 0.03}px)`;
        }
    });
    
    // Add ripple effect to buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('button, a')) {
            const button = e.target.closest('button, a');
            const ripple = document.createElement('div');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(220, 38, 38, 0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            button.style.position = 'relative';
            button.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        }
    });
</script>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-10px) scale(1.05); }
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>
@endsection