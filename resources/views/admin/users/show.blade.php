@extends('layouts.app')
@section('title', 'User Details')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    /* Modern Design System */
    :root {
        --primary-red: #dc2626;
        --primary-red-dark: #b91c1c;
        --primary-red-light: #fef2f2;
        --success-green: #16a34a;
        --warning-orange: #ea580c;
        --info-blue: #2563eb;
        --purple: #7c3aed;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --radius-2xl: 1.5rem;
    }

    /* Modern Background */
    .modern-bg {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem 1rem;
    }

    /* Modern Card */
    .modern-card {
        background: white;
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        animation: cardSlideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes cardSlideIn {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Modern Header */
    .modern-header {
        padding: 2rem 2rem 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        position: relative;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .user-avatar {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: 700;
        border: 4px solid white;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .user-avatar .initials {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
        color: white;
        font-weight: 700;
        font-size: 2.5rem;
    }

    .status-indicator {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: var(--shadow-sm);
    }

    .status-indicator.online {
        background: var(--success-green);
    }

    .status-indicator.away {
        background: var(--warning-orange);
    }

    .status-indicator.offline {
        background: var(--gray-400);
    }

    .user-info {
        flex: 1;
    }

    .user-name {
        font-size: 2rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .user-email {
        font-size: 1.125rem;
        color: var(--gray-600);
        margin-bottom: 1rem;
    }

    .user-meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .meta-item i {
        color: var(--primary-red);
        font-size: 1rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
    }

    .modern-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .modern-action-btn.back {
        background: var(--gray-100);
        color: var(--gray-700);
    }

    .modern-action-btn.back:hover {
        background: var(--gray-200);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .modern-action-btn.edit {
        background: var(--info-blue);
        color: white;
    }

    .modern-action-btn.edit:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Content Grid */
    .content-grid {
        padding: 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    /* Info Section */
    .info-section {
        background: var(--gray-50);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        border: 1px solid var(--gray-200);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary-red);
        font-size: 1.5rem;
    }

    .info-grid {
        display: grid;
        gap: 1rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: white;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-200);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateX(4px);
        box-shadow: var(--shadow-sm);
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        color: var(--gray-700);
    }

    .info-label i {
        color: var(--primary-red);
        font-size: 1rem;
        width: 1rem;
        text-align: center;
    }

    .info-value {
        font-weight: 600;
        color: var(--gray-900);
    }

    /* Role Badge */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: capitalize;
    }

    .role-badge.admin {
        background: var(--primary-red-light);
        color: var(--primary-red);
        border: 1px solid #fecaca;
    }

    .role-badge.staff {
        background: #dbeafe;
        color: var(--info-blue);
        border: 1px solid #bfdbfe;
    }

    .role-badge.citizen {
        background: var(--gray-100);
        color: var(--gray-600);
        border: 1px solid var(--gray-300);
    }

    /* Activity Section */
    .activity-section {
        background: var(--gray-50);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        border: 1px solid var(--gray-200);
    }

    .status-display {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: white;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-200);
    }

    .status-indicator-large {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .status-dot.online {
        background: var(--success-green);
    }

    .status-dot.offline {
        background: var(--gray-400);
    }

    .status-dot.away {
        background: var(--warning-orange);
    }

    .status-text {
        font-weight: 600;
        font-size: 1rem;
    }

    .status-text.online {
        color: var(--success-green);
    }

    .status-text.offline {
        color: var(--gray-600);
    }

    .status-text.away {
        color: var(--warning-orange);
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Activity Stats */
    .activity-stats {
        display: grid;
        gap: 1rem;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: white;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-200);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateX(4px);
        box-shadow: var(--shadow-sm);
    }

    .stat-label {
        font-weight: 600;
        color: var(--gray-700);
    }

    .stat-value {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--gray-900);
        font-family: 'Courier New', monospace;
    }

    /* Modern Toast */
    .modern-toast {
        position: fixed;
        top: 2rem;
        right: 2rem;
        background: var(--success-green);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        font-weight: 600;
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .modern-toast.show {
        transform: translateX(0);
        opacity: 1;
    }

    .modern-toast.error {
        background: var(--primary-red);
    }

    .modern-toast i {
        font-size: 1.25rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .modern-bg {
            padding: 1rem 0.5rem;
        }
        
        .modern-header {
            padding: 1.5rem;
        }
        
        .header-content {
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .user-profile {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        .user-meta {
            justify-content: center;
        }
        
        .action-buttons {
            width: 100%;
            justify-content: center;
        }
        
        .content-grid {
            padding: 1.5rem;
        }
        
        .modern-toast {
            right: 1rem;
            left: 1rem;
            transform: translateY(-100%);
        }
        
        .modern-toast.show {
            transform: translateY(0);
        }
    }

    @media (max-width: 480px) {
        .user-name {
            font-size: 1.5rem;
        }
        
        .user-email {
            font-size: 1rem;
        }
        
        .user-meta {
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .modern-action-btn {
            justify-content: center;
        }
    }
</style>

<div class="modern-bg">
    <div class="modern-card">
        <!-- Header -->
        <div class="modern-header">
            <div class="header-content">
                <div class="user-profile">
                    <div class="user-avatar">
                        @if($user->profile_picture)
                            <img 
                                src="{{ Storage::url($user->profile_picture) }}" 
                                alt="{{ $user->name }}" 
                                onerror="handleImageError(this)"
                            >
                            <div class="initials" style="display: none;">{{ substr($user->name, 0, 1) }}</div>
                        @else
                            <div class="initials">{{ substr($user->name, 0, 1) }}</div>
                        @endif
                        <div class="status-indicator offline" id="status-indicator"></div>
                    </div>
                    <div class="user-info">
                        <h1 class="user-name">{{ $user->name }}</h1>
                        <p class="user-email">{{ $user->email }}</p>
                        <div class="user-meta">
                            <div class="meta-item">
                                <i class="fas fa-id-card"></i>
                                <span>ID: #{{ $user->id }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-user-tag"></i>
                                <span class="role-badge {{ $user->role }}">
                                    <i class="fas fa-{{ $user->role === 'admin' ? 'shield' : ($user->role === 'staff' ? 'user-tie' : 'user') }}"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Joined {{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('admin.users.index') }}" class="modern-action-btn back">
                        <i class="fas fa-arrow-left"></i>
                        Back to Users
                    </a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="modern-action-btn edit">
                        <i class="fas fa-edit"></i>
                        Edit User
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- User Information -->
            <div class="info-section">
                <h2 class="section-title">
                    <i class="fas fa-user-circle"></i>
                    User Information
                </h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user"></i>
                            <span>Full Name</span>
                        </div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            <span>Email Address</span>
                        </div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-shield-alt"></i>
                            <span>Account Role</span>
                        </div>
                        <div class="info-value">
                            <span class="role-badge {{ $user->role }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calendar-check"></i>
                            <span>Member Since</span>
                        </div>
                        <div class="info-value">{{ $user->created_at->format('F d, Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-clock"></i>
                            <span>Last Updated</span>
                        </div>
                        <div class="info-value">{{ $user->updated_at->diffForHumans() }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-check-circle"></i>
                            <span>Email Verified</span>
                        </div>
                        <div class="info-value">
                            @if($user->email_verified_at)
                                <span style="color: var(--success-green);">
                                    <i class="fas fa-check"></i> Verified
                                </span>
                            @else
                                <span style="color: var(--primary-red);">
                                    <i class="fas fa-times"></i> Not Verified
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Real-Time Activity -->
            <div class="activity-section">
                <h2 class="section-title">
                    <i class="fas fa-chart-line"></i>
                    Real-Time Activity
                </h2>
                
                <div class="status-display">
                    <div class="status-indicator-large">
                        <div class="status-dot offline" id="status-dot"></div>
                        <div class="status-text offline" id="status-text">Checking Status...</div>
                    </div>
                </div>

                <div class="activity-stats">
                    <div class="stat-item">
                        <span class="stat-label">Active Time</span>
                        <span class="stat-value" id="active-time">00:00:00</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Offline Time</span>
                        <span class="stat-value" id="offline-time">00:00:00</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Last Active</span>
                        <span class="stat-value" id="last-seen">
                            {{ $user->last_seen ? \Carbon\Carbon::parse($user->last_seen)->diffForHumans() : 'Never' }}
                        </span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Session Duration</span>
                        <span class="stat-value" id="session-duration">00:00:00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="modern-toast" class="modern-toast">
    <i class="fas fa-bell"></i>
    <span id="toast-message"></span>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const statusDot = document.getElementById("status-dot");
    const statusText = document.getElementById("status-text");
    const statusIndicator = document.getElementById("status-indicator");
    const lastSeenEl = document.getElementById("last-seen");
    const activeTimeEl = document.getElementById("active-time");
    const offlineTimeEl = document.getElementById("offline-time");
    const sessionDurationEl = document.getElementById("session-duration");
    const toast = document.getElementById("modern-toast");
    const toastMessage = document.getElementById("toast-message");

    let currentStatus = null;
    let activeSeconds = 0;
    let offlineSeconds = 0;
    let sessionStart = null;

    // Image error handling (same as your index page)
    function handleImageError(img) {
        console.log('Image failed to load, showing initials');
        const initialsDiv = img.nextElementSibling;
        if (initialsDiv && initialsDiv.classList.contains('initials')) {
            img.style.display = 'none';
            initialsDiv.style.display = 'flex';
        }
    }

    function formatTime(seconds) {
        const hrs = String(Math.floor(seconds / 3600)).padStart(2, "0");
        const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, "0");
        const secs = String(seconds % 60).padStart(2, "0");
        return `${hrs}:${mins}:${secs}`;
    }

    function showToast(message, isError = false) {
        toastMessage.textContent = message;
        toast.className = `modern-toast ${isError ? 'error' : ''}`;
        toast.style.display = 'flex';
        
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.style.display = 'none';
            }, 500);
        }, 3000);
    }

    // Counter update every 1s
    setInterval(() => {
        if (currentStatus === "online") {
            activeSeconds++;
            if (sessionStart) {
                const sessionSeconds = Math.floor((Date.now() - sessionStart) / 1000);
                sessionDurationEl.textContent = formatTime(sessionSeconds);
            }
        } else {
            offlineSeconds++;
        }
        activeTimeEl.textContent = formatTime(activeSeconds);
        offlineTimeEl.textContent = formatTime(offlineSeconds);
    }, 1000);

    // Real-time status fetch
    async function checkUserStatus() {
        try {
            const res = await fetch(`/admin/users/{{ $user->id }}/status`);
            if (!res.ok) return;
            const data = await res.json();
            
            let newStatus = data.status;

            if (newStatus !== currentStatus) {
                if (newStatus === "online" && currentStatus !== "online") {
                    sessionStart = Date.now();
                    showToast(`${data.user_name} is now online`, false);
                } else if (newStatus === "offline" && currentStatus === "online") {
                    showToast(`${data.user_name} went offline`, true);
                    sessionStart = null;
                }
                
                currentStatus = newStatus;
                updateStatusDisplay(newStatus, data.last_seen_human || 'Unknown');
            }
        } catch (err) {
            console.error("Failed to fetch user status:", err);
        }
    }

    function updateStatusDisplay(status, lastSeenHuman) {
        // Update status dot and text
        statusDot.className = `status-dot ${status}`;
        statusText.className = `status-text ${status}`;
        
        // Update avatar status indicator
        if (statusIndicator) {
            statusIndicator.className = `status-indicator ${status}`;
        }
        
        switch (status) {
            case "online":
                statusText.textContent = "Active Now";
                break;
            case "away":
                statusText.textContent = "Away";
                break;
            case "offline":
                statusText.textContent = "Offline";
                lastSeenEl.textContent = lastSeenHuman;
                break;
        }
    }

    // Initialize
    checkUserStatus();
    setInterval(checkUserStatus, 10000); // Check every 10 seconds

    // Add hover effects to info items
    document.querySelectorAll('.info-item, .stat-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Handle image errors on page load
    document.querySelectorAll('.user-avatar img').forEach(img => {
        if (img.complete && img.naturalHeight === 0) {
            handleImageError(img);
        }
    });
});
</script>
@endsection