@extends('layouts.app')
@section('title', 'Staff Management')

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
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
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

    /* Modern Card Design */
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

    /* Modern Table Design */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
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

    /* Profile Picture Styles */
    .profile-picture {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--gray-200);
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .profile-picture:hover {
        border-color: var(--primary-red);
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    .profile-initials {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
        border: 3px solid var(--gray-200);
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .profile-initials:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    .staff-avatar {
        position: relative;
        display: inline-block;
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

    .status-indicator.offline {
        background: var(--gray-400);
    }

    .status-indicator.away {
        background: var(--warning-orange);
    }

    .status-indicator.busy {
        background: var(--primary-red);
    }

    /* Modern Toast */
    .modern-toast {
        position: fixed;
        top: 30px;
        left: 50%;
        transform: translateX(-50%) translateY(-20px);
        background: var(--success-green);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        font-weight: 500;
        display: none;
        z-index: 1000;
        animation: toastSlideIn 0.4s ease-out;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .modern-toast.error {
        background: var(--primary-red);
    }

    @keyframes toastSlideIn {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
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

    /* Modern Status Badges */
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

    .modern-status.active {
        background: #f0fdf4;
        color: var(--success-green);
        border: 1px solid #bbf7d0;
    }

    .modern-status.offline {
        background: #f8fafc;
        color: var(--gray-600);
        border: 1px solid var(--gray-200);
    }

    .modern-status.busy {
        background: #fef2f2;
        color: var(--primary-red);
        border: 1px solid #fecaca;
    }

    .modern-status.away {
        background: #fffbeb;
        color: var(--warning-orange);
        border: 1px solid #fed7aa;
    }

    .status-dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .modern-status.active .status-dot {
        background: var(--success-green);
    }

    .modern-status.offline .status-dot {
        background: var(--gray-400);
    }

    .modern-status.busy .status-dot {
        background: var(--primary-red);
    }

    .modern-status.away .status-dot {
        background: var(--warning-orange);
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
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
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-header h2 i {
        color: var(--primary-red);
        font-size: 1.75rem;
    }

    /* Modern Primary Button */
    .modern-primary-btn {
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }

    .modern-primary-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .modern-primary-btn:hover::before {
        left: 100%;
    }

    .modern-primary-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .modern-primary-btn:active {
        transform: translateY(0);
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
    @media (max-width: 768px) {
        .modern-table {
            font-size: 0.75rem;
        }
        
        .modern-table th,
        .modern-table td {
            padding: 0.75rem 0.5rem;
        }
        
        .modern-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .modern-action-btn {
            width: 2rem;
            height: 2rem;
            font-size: 0.75rem;
        }

        .profile-picture,
        .profile-initials {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 0.875rem;
        }

        .status-indicator {
            width: 0.625rem;
            height: 0.625rem;
        }
    }
</style>

<div id="modern-toast" class="modern-toast">✅ Action completed successfully</div>

<div class="modern-card">
    <div class="modern-header">
        <h2>
            <i class="fas fa-user-shield"></i>
            Staff Management
        </h2>
        <a href="{{ route('admin.staff.create') }}" class="modern-primary-btn">
            <i class="fas fa-plus"></i>
            Add Staff Member
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Staff Member</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Last Activity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="staff-table-body">
                @forelse($staffs as $staff)
                    <tr id="staff-row-{{ $staff->id }}" data-last-seen="{{ $staff->last_seen }}" class="staff-row">
                        <td class="font-mono text-sm text-gray-600">#{{ $staff->id }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="staff-avatar">
                                    @if($staff->profile_picture)
                                        <img 
                                            src="{{ Storage::url($staff->profile_picture) }}" 
                                            alt="{{ $staff->name }}" 
                                            class="profile-picture"
                                            onerror="handleImageError(this, {{ $staff->id }})"
                                        >
                                        <div class="profile-initials" style="display: none;" id="initials-{{ $staff->id }}">
                                            {{ substr($staff->name, 0, 1) }}
                                        </div>
                                    @else
                                        <div class="profile-initials">
                                            {{ substr($staff->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="status-indicator {{ strtolower($staff->status) }}"></div>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $staff->name }}</div>
                                    <div class="text-xs text-gray-500">{{ ucfirst($staff->role) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-sm">
                                <div class="font-medium text-gray-900">{{ $staff->email }}</div>
                                <div class="text-gray-500">{{ $staff->phone ?? 'No phone' }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="modern-status {{ strtolower($staff->status) }}">
                                <span class="status-dot"></span>
                                <span class="status-text">{{ ucfirst($staff->status) }}</span>
                            </div>
                        </td>
                        <td class="last-seen-text">
                            <div class="text-sm">
                                <div class="font-medium text-gray-900">
                                    {{ $staff->last_seen ? $staff->last_seen->diffForHumans() : 'Never' }}
                                </div>
                                <div class="text-xs text-gray-500">Last active</div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.staff.show', $staff->id) }}" class="modern-action-btn view" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.staff.edit', $staff->id) }}" class="modern-action-btn edit" title="Edit Staff">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="modern-action-btn delete" title="Delete Staff" onclick="deleteStaff('{{ $staff->id }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="modern-empty-state">
                            <i class="fas fa-users"></i>
                            <p>No staff members found</p>
                            <p class="subtext">Get started by adding your first staff member</p>
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
        toast.style.display = 'none';
    }, 3000);
}

// Delete Staff Function
async function deleteStaff(id) {
    if (!confirm("Are you sure you want to delete this staff member? This action cannot be undone.")) return;
    
    try {
        // Add loading state
        const row = document.getElementById(`staff-row-${id}`);
        row.classList.add('loading-row');
        
        const response = await fetch(`/admin/staff/${id}`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
        });
        
        if (response.ok) {
            // Animate removal
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '0';
            row.style.transform = 'translateX(-100%)';
            
            setTimeout(() => {
                row.remove();
                showToast('Staff member deleted successfully.');
                
                // Check if table is empty
                if (!document.querySelector('.staff-row')) {
                    location.reload(); // Reload to show empty state
                }
            }, 300);
        } else {
            row.classList.remove('loading-row');
            showToast('Failed to delete staff member.', true);
        }
    } catch (error) {
        document.getElementById(`staff-row-${id}`).classList.remove('loading-row');
        showToast('Something went wrong. Please try again.', true);
    }
}

// Image error handling
function handleImageError(img, staffId) {
    console.log('Image failed to load for staff ID:', staffId, 'URL:', img.src);
    const initialsDiv = document.getElementById(`initials-${staffId}`);
    if (initialsDiv) {
        img.style.display = 'none';
        initialsDiv.style.display = 'flex';
    }
}

// Real-time Status Update System
function updateStatus() {
    document.querySelectorAll('#staff-table-body .staff-row').forEach(row => {
        const lastSeen = row.dataset.lastSeen ? new Date(row.dataset.lastSeen) : null;
        const statusDiv = row.querySelector('.modern-status');
        const statusText = row.querySelector('.status-text');
        const statusIndicator = row.querySelector('.status-indicator');
        const lastSeenElement = row.querySelector('.last-seen-text .font-medium');

        if (!lastSeen) {
            statusDiv.className = 'modern-status offline';
            statusText.textContent = 'Offline';
            if (statusIndicator) statusIndicator.className = 'status-indicator offline';
            if (lastSeenElement) lastSeenElement.textContent = 'Never';
            return;
        }

        const diffSeconds = Math.floor((new Date() - lastSeen) / 1000);
        const diffMinutes = Math.floor(diffSeconds / 60);
        const diffHours = Math.floor(diffMinutes / 60);

        if (diffSeconds < 60) { // 1 minute (using your model's logic)
            statusDiv.className = 'modern-status active';
            statusText.textContent = 'Active';
            if (statusIndicator) statusIndicator.className = 'status-indicator active';
        } else {
            statusDiv.className = 'modern-status offline';
            statusText.textContent = 'Offline';
            if (statusIndicator) statusIndicator.className = 'status-indicator offline';
        }

        if (lastSeenElement) {
            if (diffSeconds < 60) {
                lastSeenElement.textContent = 'Just now';
            } else if (diffMinutes < 60) {
                lastSeenElement.textContent = `${diffMinutes}m ago`;
            } else if (diffHours < 24) {
                lastSeenElement.textContent = `${diffHours}h ago`;
            } else {
                lastSeenElement.textContent = lastSeen.toLocaleDateString();
            }
        }
    });
}

// Initialize real-time updates
setInterval(updateStatus, 30000); // Update every 30 seconds
updateStatus(); // Initial call

// Auto-refresh staff list (optional)
async function fetchStaff() {
    try {
        const res = await fetch("{{ route('admin.staff.fetch') }}");
        if (!res.ok) return;
        const staffData = await res.json();
        
        // Implementation for dynamic updates would go here
        // This is a placeholder for real-time staff list updates
    } catch (e) {
        console.error('Failed to fetch staff:', e);
    }
}

// Add smooth scrolling and modern interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to table rows
    const rows = document.querySelectorAll('.staff-row');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Add image error handlers
    document.querySelectorAll('.profile-picture').forEach(img => {
        img.addEventListener('error', function() {
            // Extract staff ID from the row
            const row = this.closest('.staff-row');
            const staffId = row.id.replace('staff-row-', '');
            handleImageError(this, staffId);
        });
        
        // Pre-load test for debugging
        const testImage = new Image();
        testImage.src = img.src;
        testImage.onload = function() {
            console.log('Image loaded successfully:', img.src);
        };
        testImage.onerror = function() {
            console.error('Image failed to load:', img.src);
            const row = img.closest('.staff-row');
            const staffId = row.id.replace('staff-row-', '');
            handleImageError(img, staffId);
        };
    });

    // Debug: Log profile picture information
    console.log('Staff profile pictures:');
    document.querySelectorAll('.staff-row').forEach(row => {
        const staffId = row.id.replace('staff-row-', '');
        const img = row.querySelector('.profile-picture');
        if (img) {
            console.log(`Staff ${staffId}:`, img.src);
        }
    });
});
</script>
@endsection