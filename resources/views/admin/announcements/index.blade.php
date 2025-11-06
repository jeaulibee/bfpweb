@extends('layouts.app')
@section('title', 'Announcements')

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
    .stat-icon.active { background: var(--success-green); color: white; }
    .stat-icon.inactive { background: var(--gray-300); color: var(--gray-700); }

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
        text-decoration: none;
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

    /* Announcement Content */
    .announcement-content {
        max-width: 300px;
    }

    .announcement-title {
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
        line-height: 1.4;
    }

    .announcement-excerpt {
        font-size: 0.75rem;
        color: var(--gray-500);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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

    .modern-status.active {
        background: #f0fdf4;
        color: var(--success-green);
        border: 1px solid #bbf7d0;
    }

    .modern-status.inactive {
        background: #f8fafc;
        color: var(--gray-500);
        border: 1px solid var(--gray-200);
    }

    .modern-status.scheduled {
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

    .modern-status.inactive .status-dot {
        background: var(--gray-400);
    }

    .modern-status.scheduled .status-dot {
        background: var(--warning-orange);
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Creator Info */
    .creator-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .creator-avatar {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.75rem;
        border: 2px solid var(--gray-200);
    }

    .creator-details {
        display: flex;
        flex-direction: column;
    }

    .creator-name {
        font-weight: 600;
        color: var(--gray-900);
        font-size: 0.875rem;
    }

    .creator-role {
        font-size: 0.75rem;
        color: var(--gray-500);
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

    .modern-action-btn.view {
        background: var(--gray-100);
        color: var(--gray-700);
    }

    .modern-action-btn.view:hover {
        background: var(--gray-200);
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
        
        .announcement-content {
            max-width: 200px;
        }
        
        .creator-info {
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

    @media (max-width: 640px) {
        .modern-bg {
            padding: 1rem 0.5rem;
        }
        
        .announcement-content {
            max-width: 150px;
        }
        
        .modern-table th:nth-child(3),
        .modern-table td:nth-child(3) {
            display: none;
        }
    }
</style>

<div class="modern-bg">
    <div class="modern-card">
        <!-- Header with Stats -->
        <div class="modern-header">
            <h2>
                <i class="fas fa-bullhorn"></i>
                Announcements Management
            </h2>
            <div class="header-stats">
                <div class="stat-item">
                    <div class="stat-icon total">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $announcements->count() }}</div>
                        <div class="stat-label">Total</div>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon active">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $announcements->where('status', 'active')->count() }}</div>
                        <div class="stat-label">Active</div>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon inactive">
                        <i class="fas fa-eye-slash"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $announcements->where('status', 'inactive')->count() }}</div>
                        <div class="stat-label">Inactive</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.announcements.create') }}" class="modern-primary-btn">
                <i class="fas fa-plus"></i>
                Create Announcement
            </a>
        </div>

        <!-- Announcements Table -->
        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Announcement</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="announcements-table-body">
                    @forelse($announcements as $announcement)
                        <tr id="announcement-row-{{ $announcement->id }}" class="announcement-row">
                            <td>
                                <div class="announcement-content">
                                    <div class="announcement-title">{{ $announcement->title }}</div>
                                    <div class="announcement-excerpt">
                                        {{ Str::limit(strip_tags($announcement->content), 100) }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="modern-status {{ strtolower($announcement->status ?? 'inactive') }}">
                                    <span class="status-dot"></span>
                                    <span class="status-text">{{ ucfirst($announcement->status ?? 'Inactive') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="creator-info">
                                    <div class="creator-avatar">
                                        {{ substr($announcement->creator->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div class="creator-details">
                                        <div class="creator-name">{{ $announcement->creator->name ?? 'Admin' }}</div>
                                        <div class="creator-role">{{ $announcement->creator->role ?? 'System' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900">{{ $announcement->created_at->format('M d, Y') }}</div>
                                    <div class="text-gray-500">{{ $announcement->created_at->format('h:i A') }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="modern-action-btn view" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="modern-action-btn edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" class="modern-action-btn delete" title="Delete" onclick="deleteAnnouncement('{{ $announcement->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="modern-empty-state">
                                <i class="fas fa-bullhorn"></i>
                                <p>No announcements found</p>
                                <p class="subtext">Get started by creating your first announcement</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($announcements, 'links'))
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Toast Notification -->
<div id="modern-toast" class="modern-toast">
    <i class="fas fa-check-circle"></i>
    <span id="toast-message"></span>
</div>

<script>
// Modern Toast System
function showToast(message, isError = false) {
    const toast = document.getElementById('modern-toast');
    const toastMessage = document.getElementById('toast-message');
    
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

// Delete Announcement Function
async function deleteAnnouncement(id) {
    if (!confirm("Are you sure you want to delete this announcement? This action cannot be undone.")) return;
    
    try {
        // Add loading state
        const row = document.getElementById(`announcement-row-${id}`);
        row.classList.add('loading-row');
        
        const response = await fetch(`/admin/announcements/${id}`, {
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
                showToast('Announcement deleted successfully.');
                
                // Check if table is empty
                if (!document.querySelector('.announcement-row')) {
                    location.reload(); // Reload to show empty state
                }
            }, 300);
        } else {
            row.classList.remove('loading-row');
            showToast('Failed to delete announcement.', true);
        }
    } catch (error) {
        document.getElementById(`announcement-row-${id}`).classList.remove('loading-row');
        showToast('Something went wrong. Please try again.', true);
    }
}

// Add smooth interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to table rows
    const rows = document.querySelectorAll('.announcement-row');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Update stats in real-time (simulated)
    function updateStats() {
        const totalStats = document.querySelectorAll('.stat-number');
        if (totalStats.length >= 3) {
            // Simulate real-time updates
            const activeCount = Math.floor(Math.random() * 5) + 1;
            totalStats[1].textContent = activeCount;
            totalStats[2].textContent = totalStats[0].textContent - activeCount;
        }
    }

    // Update stats every 30 seconds
    setInterval(updateStats, 30000);

    // Add click animations to action buttons
    document.querySelectorAll('.modern-action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
});
</script>
@endsection