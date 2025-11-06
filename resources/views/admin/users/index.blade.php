@extends('layouts.app')
@section('title', 'Users Management')

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
    }

    /* Modern Card */
    .modern-card {
        background: #ffffff;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        animation: cardSlideIn 0.4s ease-out;
    }

    @keyframes cardSlideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Modern Header */
    .modern-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-200);
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    }

    .modern-header h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-header h2 i {
        color: var(--primary-red);
        font-size: 1.75rem;
    }

    .header-stats {
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
    }

    .stat-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }

    .stat-icon.total { background: var(--gray-100); color: var(--gray-700); }
    .stat-icon.online { background: var(--success-green); color: white; }
    .stat-icon.admin { background: var(--primary-red-light); color: var(--primary-red); }
    .stat-icon.staff { background: var(--info-blue); color: white; }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--gray-900);
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Online Indicator */
    .online-indicator {
        font-size: 0.875rem;
        font-weight: 600;
        background: var(--success-green);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-left: 1rem;
    }

    .online-indicator .pulse-dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background: white;
        animation: pulse 2s infinite;
    }

    /* Modern Table */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
    }

    .modern-table thead {
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
    }

    .modern-table th {
        padding: 1rem 1.25rem;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: white;
        border: none;
        position: relative;
    }

    .modern-table th:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background: rgba(255, 255, 255, 0.3);
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid var(--gray-100);
    }

    .modern-table tbody tr:last-child {
        border-bottom: none;
    }

    .modern-table tbody tr:hover {
        background: var(--gray-50);
        transform: translateX(4px);
        box-shadow: var(--shadow-sm);
    }

    .modern-table td {
        padding: 1rem 1.25rem;
        border: none;
        font-size: 0.875rem;
        color: var(--gray-700);
    }

    /* User Avatar with Profile Picture */
    .user-avatar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .avatar-container {
        position: relative;
        display: inline-block;
    }

    .avatar-img {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--gray-200);
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .avatar-img:hover {
        border-color: var(--primary-red);
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    .avatar-initials {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
        border: 2px solid var(--gray-200);
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .avatar-initials:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    .status-indicator {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 50%;
        border: 2px solid white;
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
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        color: var(--gray-900);
    }

    .user-email {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    /* Modern Status Badge */
    .modern-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 500;
        font-size: 0.75rem;
        text-transform: capitalize;
        transition: all 0.3s ease;
    }

    .modern-status.online {
        background: #f0fdf4;
        color: var(--success-green);
        border: 1px solid #bbf7d0;
    }

    .modern-status.away {
        background: #fffbeb;
        color: var(--warning-orange);
        border: 1px solid #fed7aa;
    }

    .modern-status.offline {
        background: #f8fafc;
        color: var(--gray-500);
        border: 1px solid var(--gray-200);
    }

    .status-dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .modern-status.online .status-dot {
        background: var(--success-green);
    }

    .modern-status.away .status-dot {
        background: var(--warning-orange);
        animation: none;
    }

    .modern-status.offline .status-dot {
        background: var(--gray-400);
        animation: none;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Last Seen Text */
    .last-seen {
        font-size: 0.7rem;
        color: var(--gray-400);
        margin-top: 0.25rem;
        text-align: center;
    }

    .last-seen.active {
        color: var(--success-green);
        font-weight: 600;
    }

    .last-seen.away {
        color: var(--warning-orange);
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

    /* Modern Action Buttons */
    .modern-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: var(--radius-lg);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .modern-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .modern-action-btn:hover::before {
        left: 100%;
    }

    .modern-action-btn:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .modern-action-btn:active {
        transform: translateY(0) scale(0.98);
    }

    .modern-action-btn.view {
        background: var(--gray-100);
        color: var(--gray-700);
    }

    .modern-action-btn.view:hover {
        background: var(--gray-200);
    }

    .modern-action-btn.edit {
        background: var(--info-blue);
        color: white;
    }

    .modern-action-btn.edit:hover {
        background: #1d4ed8;
    }

    .modern-action-btn.delete {
        background: var(--primary-red-light);
        color: var(--primary-red);
    }

    .modern-action-btn.delete:hover {
        background: var(--primary-red);
        color: white;
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

    /* Empty State */
    .modern-empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--gray-500);
    }

    .modern-empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .modern-empty-state p {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .modern-empty-state .subtext {
        font-size: 0.875rem;
        color: var(--gray-400);
    }

    /* Loading Animation */
    .loading-row {
        opacity: 0.6;
        pointer-events: none;
    }

    .loading-row td {
        position: relative;
        overflow: hidden;
    }

    .loading-row td::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .header-stats {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .modern-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .modern-table {
            font-size: 0.75rem;
        }
        
        .modern-table th,
        .modern-table td {
            padding: 0.75rem 0.5rem;
        }
        
        .modern-action-btn {
            width: 2rem;
            height: 2rem;
            font-size: 0.75rem;
        }
        
        .user-avatar {
            flex-direction: column;
            gap: 0.25rem;
            text-align: center;
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
</style>

<div id="modern-toast" class="modern-toast">✅ Action completed successfully</div>

<div class="modern-card">
    <!-- Header with Stats -->
    <div class="modern-header">
        <h2>
            <i class="fas fa-users"></i>
            Users Management
            <span class="online-indicator">
                <span class="pulse-dot"></span>
                <span id="online-count">0</span> online
            </span>
        </h2>
        <div class="header-stats">
            <div class="stat-item">
                <div class="stat-icon total">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $users->count() }}</div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon online">
                    <i class="fas fa-signal"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number" id="live-online-count">0</div>
                    <div class="stat-label">Online Now</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon admin">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $users->where('role', 'admin')->count() }}</div>
                    <div class="stat-label">Admins</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon staff">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $users->where('role', 'staff')->count() }}</div>
                    <div class="stat-label">Staff</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Active</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="user-table-body">
                @forelse($users as $user)
                    @php
                        $lastSeen = $user->last_seen;
                        $diffSeconds = $lastSeen ? now()->diffInSeconds($lastSeen) : 999999;
                        $initialStatus = $diffSeconds < 300 ? 'online' : ($diffSeconds < 600 ? 'away' : 'offline');
                        $lastSeenText = $lastSeen ? $lastSeen->diffForHumans() : 'Never';
                    @endphp
                    <tr id="user-row-{{ $user->id }}" class="user-row" data-last-seen="{{ $user->last_seen }}">
                        <td>
                            <div class="user-avatar">
                                <div class="avatar-container">
                                    @if($user->profile_picture)
                                        <img 
                                            src="{{ Storage::url($user->profile_picture) }}" 
                                            alt="{{ $user->name }}" 
                                            class="avatar-img"
                                            onerror="handleImageError(this, {{ $user->id }})"
                                            data-user-id="{{ $user->id }}"
                                        >
                                        <div class="avatar-initials" style="display: none;" id="initials-{{ $user->id }}">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @else
                                        <div class="avatar-initials">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="status-indicator {{ $initialStatus }}" id="status-indicator-{{ $user->id }}"></div>
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="role-badge {{ $user->role }}">
                                <i class="fas fa-{{ $user->role === 'admin' ? 'shield' : ($user->role === 'staff' ? 'user-tie' : 'user') }}"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <div class="modern-status {{ $initialStatus }}" id="status-{{ $user->id }}">
                                <span class="status-dot"></span>
                                <span class="status-text">{{ ucfirst($initialStatus) }}</span>
                            </div>
                            <div class="last-seen {{ $initialStatus === 'online' ? 'active' : ($initialStatus === 'away' ? 'away' : '') }}" id="last-seen-{{ $user->id }}">
                                {{ $lastSeenText }}
                            </div>
                        </td>
                        <td>
                            <div class="text-sm text-center">
                                <div class="font-medium text-gray-900" id="last-active-{{ $user->id }}">
                                    @if($lastSeen)
                                        {{ $lastSeen->format('M d, Y') }}
                                    @else
                                        Never
                                    @endif
                                </div>
                                <div class="text-gray-500 text-xs" id="last-active-time-{{ $user->id }}">
                                    @if($lastSeen)
                                        {{ $lastSeen->format('h:i A') }}
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-sm">
                                <div class="font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
                                <div class="text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="modern-action-btn view" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="modern-action-btn edit" title="Edit User">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="modern-action-btn delete" title="Delete User" onclick="deleteUser({{ $user->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="modern-empty-state">
                            <i class="fas fa-users"></i>
                            <p>No users found</p>
                            <p class="subtext">Users will appear here once they register</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// Modern Toast System
function showToast(message, isError = false) {
    const toast = document.getElementById('modern-toast');
    toast.textContent = message;
    toast.className = `modern-toast ${isError ? 'error' : ''}`;
    toast.style.display = 'block';
    
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

// Image error handling
function handleImageError(img, userId) {
    console.log('Image failed to load for user ID:', userId, 'URL:', img.src);
    const initialsDiv = document.getElementById(`initials-${userId}`);
    if (initialsDiv) {
        img.style.display = 'none';
        initialsDiv.style.display = 'flex';
    }
}

// Delete User Function - FIXED VERSION
async function deleteUser(id) {
    if (!confirm("Are you sure you want to delete this user? This action cannot be undone.")) return;
    
    try {
        // Add loading state
        const row = document.getElementById(`user-row-${id}`);
        row.classList.add('loading-row');
        
        // FIXED: Use the correct Laravel route with proper headers
        const response = await fetch(`/admin/users/${id}`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            // Animate removal
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '0';
            row.style.transform = 'translateX(-100%)';
            
            setTimeout(() => {
                row.remove();
                showToast(data.message || 'User deleted successfully.');
                
                // Update stats after deletion
                updateUserStats();
                
                // Check if table is empty
                if (!document.querySelector('.user-row')) {
                    location.reload(); // Reload to show empty state
                }
            }, 300);
        } else {
            row.classList.remove('loading-row');
            showToast(data.message || 'Failed to delete user.', true);
        }
    } catch (error) {
        console.error('Delete error:', error);
        document.getElementById(`user-row-${id}`).classList.remove('loading-row');
        showToast('Something went wrong. Please try again.', true);
    }
}

// Update user stats after deletion
function updateUserStats() {
    const totalUsers = document.querySelectorAll('.user-row').length;
    const totalStat = document.querySelector('.stat-item .stat-number');
    if (totalStat) {
        totalStat.textContent = totalUsers;
    }
}

// Real-time Status Update System
function updateStatus() {
    document.querySelectorAll('#user-table-body .user-row').forEach(row => {
        const lastSeen = row.dataset.lastSeen ? new Date(row.dataset.lastSeen) : null;
        const userId = row.id.replace('user-row-', '');
        const statusDiv = document.getElementById(`status-${userId}`);
        const statusText = statusDiv?.querySelector('.status-text');
        const statusIndicator = document.getElementById(`status-indicator-${userId}`);
        const lastSeenElement = document.getElementById(`last-seen-${userId}`);

        if (!lastSeen) {
            if (statusDiv) {
                statusDiv.className = 'modern-status offline';
                statusText.textContent = 'Offline';
            }
            if (statusIndicator) statusIndicator.className = 'status-indicator offline';
            if (lastSeenElement) {
                lastSeenElement.textContent = 'Never';
                lastSeenElement.className = 'last-seen';
            }
            return;
        }

        const diffSeconds = Math.floor((new Date() - lastSeen) / 1000);
        const diffMinutes = Math.floor(diffSeconds / 60);

        let newStatus = 'offline';
        let newStatusText = 'Offline';
        let lastSeenClass = '';
        let lastSeenDisplay = 'Never';

        if (diffSeconds < 300) { // 5 minutes
            newStatus = 'online';
            newStatusText = 'Active';
            lastSeenClass = 'active';
            lastSeenDisplay = 'Just now';
        } else if (diffMinutes < 10) { // 10 minutes
            newStatus = 'away';
            newStatusText = 'Away';
            lastSeenClass = 'away';
            lastSeenDisplay = `${diffMinutes}m ago`;
        } else {
            newStatus = 'offline';
            newStatusText = 'Offline';
            lastSeenDisplay = `${diffMinutes}m ago`;
        }

        // Update status badge
        if (statusDiv) {
            statusDiv.className = `modern-status ${newStatus}`;
            if (statusText) statusText.textContent = newStatusText;
        }
        
        // Update status indicator
        if (statusIndicator) {
            statusIndicator.className = `status-indicator ${newStatus}`;
        }

        // Update last seen text
        if (lastSeenElement) {
            lastSeenElement.textContent = lastSeenDisplay;
            lastSeenElement.className = `last-seen ${lastSeenClass}`;
        }
    });

    // Update online count
    updateOnlineCount();
}

// Update online count
function updateOnlineCount() {
    const onlineCount = document.querySelectorAll('.modern-status.online').length;
    const onlineStat = document.getElementById('live-online-count');
    const onlineIndicator = document.getElementById('online-count');
    
    if (onlineStat) onlineStat.textContent = onlineCount;
    if (onlineIndicator) onlineIndicator.textContent = onlineCount;
    
    // Update page title
    document.title = onlineCount > 0 ? `(${onlineCount}) Users Management` : 'Users Management';
}

// Heartbeat system
function sendHeartbeat() {
    fetch('{{ route("user.heartbeat") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).catch(err => console.log('Heartbeat failed:', err));
}

// Initialize all systems
document.addEventListener('DOMContentLoaded', function() {
    // Add image error handlers
    document.querySelectorAll('.avatar-img').forEach(img => {
        img.addEventListener('error', function() {
            const userId = this.getAttribute('data-user-id');
            handleImageError(this, userId);
        });
    });

    // Add hover effects to table rows
    const rows = document.querySelectorAll('.user-row');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Initial status update
    updateStatus();
    
    // Start real-time status updates (every 10 seconds)
    setInterval(updateStatus, 10000);
    
    // Start heartbeat system (every 30 seconds)
    setInterval(sendHeartbeat, 30000);
    sendHeartbeat();

    console.log('Users management system initialized');
    console.log('✓ Profile picture support');
    console.log('✓ Real-time status updates');
    console.log('✓ Online/away/offline status tracking');
    console.log('✓ Delete functionality enabled');
});
</script>
@endsection