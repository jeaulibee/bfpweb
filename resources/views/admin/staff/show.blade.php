@extends('layouts.app')
@section('title', 'Staff ID Card')

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

    /* Modern ID Container */
    .modern-id-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem 1rem;
        position: relative;
        overflow: hidden;
    }

    .modern-id-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    /* Modern ID Card */
    .modern-id-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-xl);
        width: 420px;
        padding: 0;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: cardSlideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 10;
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

    /* ID Header with Security Pattern */
    .modern-id-header {
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
        padding: 2rem 2rem 1.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        border-bottom: 3px solid rgba(255, 255, 255, 0.3);
    }

    .modern-id-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
            linear-gradient(45deg, transparent 49%, rgba(255,255,255,0.1) 50%, transparent 51%);
        background-size: 100% 100%, 100% 100%, 20px 20px;
    }

    .modern-id-header::after {
        content: 'OFFICIAL IDENTIFICATION';
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.8);
        letter-spacing: 2px;
        font-weight: 600;
    }

    .agency-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        border: 3px solid rgba(255, 255, 255, 0.3);
        background: white;
        padding: 8px;
        box-shadow: var(--shadow-lg);
        position: relative;
        z-index: 2;
    }

    .agency-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: white;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 2;
    }

    .agency-subtitle {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.9);
        margin-top: 0.25rem;
        position: relative;
        z-index: 2;
    }

    /* Staff Photo Section with Security Border */
    .staff-photo-section {
        text-align: center;
        padding: 2rem 2rem 1rem;
        position: relative;
        background: linear-gradient(to bottom, #f8fafc, #ffffff);
    }

    .staff-photo-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, 
            transparent 0%, 
            var(--primary-red) 20%, 
            var(--primary-red-dark) 50%, 
            var(--primary-red) 80%, 
            transparent 100%);
    }

    .staff-avatar {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .photo-frame {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        padding: 8px;
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark), var(--info-blue));
        position: relative;
        margin: 0 auto;
        box-shadow: 
            0 8px 25px rgba(0, 0, 0, 0.15),
            inset 0 2px 4px rgba(255, 255, 255, 0.8);
    }

    .modern-staff-photo {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 3px solid white;
        object-fit: cover;
        background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
        display: block;
    }

    .profile-initials {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 2.5rem;
        color: white;
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
        border: 3px solid white;
    }

    .staff-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .staff-role {
        font-size: 0.875rem;
        color: var(--primary-red);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        background: var(--primary-red-light);
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        display: inline-block;
        border: 1px solid var(--primary-red);
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
    }

    /* ID Details with Security Background */
    .modern-id-details {
        padding: 1.5rem 2rem 2rem;
        background: 
            linear-gradient(45deg, transparent 49%, rgba(220, 38, 38, 0.03) 50%, transparent 51%),
            linear-gradient(-45deg, transparent 49%, rgba(220, 38, 38, 0.03) 50%, transparent 51%);
        background-size: 20px 20px;
        position: relative;
    }

    .modern-id-details::before {
        content: '';
        position: absolute;
        top: 0;
        left: 2rem;
        right: 2rem;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--gray-300), transparent);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 0.875rem;
        color: var(--gray-600);
        font-weight: 500;
        flex: 1;
    }

    .detail-value {
        font-size: 0.875rem;
        color: var(--gray-800);
        font-weight: 600;
        text-align: right;
        flex: 1;
    }

    /* Modern Status Badge */
    .modern-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: capitalize;
        border: 1px solid;
    }

    .modern-status-badge.active {
        background: #f0fdf4;
        color: var(--success-green);
        border-color: #bbf7d0;
    }

    .modern-status-badge.offline {
        background: #f8fafc;
        color: var(--gray-600);
        border-color: var(--gray-200);
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .modern-status-badge.active .status-dot {
        background: var(--success-green);
    }

    .modern-status-badge.offline .status-dot {
        background: var(--gray-400);
    }

    /* Action Buttons */
    .modern-action-buttons {
        display: flex;
        gap: 1rem;
        padding: 1.5rem 2rem 2rem;
        border-top: 1px solid var(--gray-200);
        background: var(--gray-50);
    }

    .modern-back-btn {
        flex: 1;
        background: var(--gray-100);
        color: var(--gray-700);
        padding: 0.875rem 1.5rem;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 0.875rem;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .modern-back-btn:hover {
        background: var(--gray-200);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .modern-print-btn {
        flex: 1;
        background: linear-gradient(135deg, var(--info-blue), #1d4ed8);
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .modern-print-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* ID Card Footer with Security Features */
    .id-card-footer {
        background: var(--gray-50);
        padding: 1rem 2rem;
        text-align: center;
        border-top: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
    }

    .id-card-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: repeating-linear-gradient(
            90deg,
            transparent,
            transparent 5px,
            var(--primary-red) 5px,
            var(--primary-red) 10px
        );
    }

    .id-number {
        font-family: 'Courier New', monospace;
        font-size: 0.875rem;
        color: var(--gray-600);
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .valid-until {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    /* Security Watermark */
    .security-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        font-size: 5rem;
        font-weight: 900;
        color: rgba(0, 0, 0, 0.03);
        pointer-events: none;
        user-select: none;
        z-index: 0;
        white-space: nowrap;
    }

    /* Holographic Effect */
    .holographic-strip {
        position: absolute;
        top: 120px;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255,255,255,0.8), 
            rgba(255,255,255,0.4), 
            rgba(255,255,255,0.8), 
            transparent);
        z-index: 1;
    }

    /* Responsive Design */
    @media (max-width: 480px) {
        .modern-id-container {
            padding: 1rem 0.5rem;
        }
        
        .modern-id-card {
            width: 95%;
        }
        
        .modern-id-header,
        .staff-photo-section,
        .modern-id-details,
        .modern-action-buttons {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        .staff-name {
            font-size: 1.25rem;
        }
        
        .modern-action-buttons {
            flex-direction: column;
        }

        .photo-frame {
            width: 120px;
            height: 120px;
        }

        .profile-initials {
            font-size: 2rem;
        }

        .security-watermark {
            font-size: 3rem;
        }
    }

    /* Enhanced Print Styles */
    @media print {
        @page {
            margin: 0;
            size: auto;
        }

        body {
            margin: 0;
            padding: 0;
            background: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .modern-id-container {
            background: white !important;
            padding: 0 !important;
            min-height: auto !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .modern-id-container::before {
            display: none !important;
        }

        .modern-id-card {
            box-shadow: none !important;
            border: 3px solid #000 !important;
            width: 85mm !important;
            height: 54mm !important;
            margin: 0 !important;
            background: white !important;
            backdrop-filter: none !important;
            border-radius: 8px !important;
            position: relative;
            page-break-inside: avoid;
        }

        .modern-action-buttons {
            display: none !important;
        }

        .modern-id-header {
            padding: 0.5rem 1rem !important;
            background: linear-gradient(135deg, #dc2626, #b91c1c) !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .agency-logo {
            width: 40px !important;
            height: 40px !important;
            margin-bottom: 0.25rem !important;
        }

        .agency-name {
            font-size: 0.8rem !important;
        }

        .agency-subtitle {
            font-size: 0.6rem !important;
        }

        .staff-photo-section {
            padding: 0.5rem 1rem !important;
        }

        .photo-frame {
            width: 60px !important;
            height: 60px !important;
        }

        .modern-staff-photo,
        .profile-initials {
            width: 100% !important;
            height: 100% !important;
            font-size: 1rem !important;
        }

        .staff-name {
            font-size: 0.9rem !important;
            margin-bottom: 0.1rem !important;
        }

        .staff-role {
            font-size: 0.6rem !important;
            padding: 0.2rem 0.8rem !important;
        }

        .modern-id-details {
            padding: 0.5rem 1rem !important;
            background: transparent !important;
        }

        .detail-row {
            padding: 0.3rem 0 !important;
        }

        .detail-label,
        .detail-value {
            font-size: 0.6rem !important;
        }

        .modern-status-badge {
            padding: 0.2rem 0.5rem !important;
            font-size: 0.5rem !important;
        }

        .id-card-footer {
            padding: 0.5rem 1rem !important;
        }

        .id-number {
            font-size: 0.6rem !important;
        }

        .valid-until {
            font-size: 0.5rem !important;
        }

        .security-watermark {
            font-size: 2rem !important;
            opacity: 0.1 !important;
        }

        .holographic-strip {
            display: none !important;
        }

        /* Hide interactive elements */
        .modern-id-header::before,
        .modern-id-header::after,
        .staff-photo-section::before,
        .id-card-footer::before {
            display: none !important;
        }

        /* Ensure text is readable */
        * {
            color: black !important;
            text-shadow: none !important;
        }
    }

    /* Print-specific ID Card Size */
    @media print and (width: 85mm) and (height: 54mm) {
        .modern-id-card {
            width: 85mm !important;
            height: 54mm !important;
        }
    }
</style>

<div class="modern-id-container">
    <div class="modern-id-card">
        <!-- Security Watermark -->
        <div class="security-watermark">BFP OFFICIAL</div>
        
        <!-- Holographic Strip -->
        <div class="holographic-strip"></div>

        <!-- ID Header -->
        <div class="modern-id-header">
            <img src="{{ asset('images/bfp.jpg') }}" alt="BFP Logo" class="agency-logo" onerror="this.style.display='none'">
            <div class="agency-name">Bureau of Fire Protection</div>
            <div class="agency-subtitle">Republic of the Philippines</div>
        </div>

        <!-- Staff Photo & Basic Info -->
        <div class="staff-photo-section">
            <div class="staff-avatar">
                <div class="photo-frame">
                    @if($staff->profile_picture)
                        <img src="{{ Storage::url($staff->profile_picture) }}" 
                             alt="{{ $staff->name }}" 
                             class="modern-staff-photo"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="profile-initials" style="display: none;">
                            {{ substr($staff->name, 0, 1) }}
                        </div>
                    @else
                        <div class="profile-initials">
                            {{ substr($staff->name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>
            
            <h2 class="staff-name">{{ $staff->name ?? 'N/A' }}</h2>
            <div class="staff-role">{{ strtoupper($staff->role ?? 'STAFF MEMBER') }}</div>
        </div>

        <!-- ID Details -->
        <div class="modern-id-details">
            <div class="detail-row">
                <span class="detail-label">Staff ID</span>
                <span class="detail-value">#{{ $staff->id ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $staff->email ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="modern-status-badge {{ strtolower($staff->status ?? 'offline') }}">
                    <span class="status-dot"></span>
                    {{ ucfirst($staff->status ?? 'Offline') }}
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Date Issued</span>
                <span class="detail-value">{{ $staff->created_at ? $staff->created_at->format('M d, Y') : 'Unknown' }}</span>
            </div>
        </div>

        <!-- Action Buttons (Hidden when printing) -->
        <div class="modern-action-buttons">
            <a href="{{ route('admin.staff.index') }}" class="modern-back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Staff
            </a>
            <button onclick="printIDCard()" class="modern-print-btn">
                <i class="fas fa-print"></i>
                Print ID Card
            </button>
        </div>

        <!-- ID Card Footer -->
        <div class="id-card-footer">
            <div class="id-number">ID: BFP-{{ str_pad($staff->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="valid-until">
                Valid until: {{ $staff->created_at ? $staff->created_at->addYears(2)->format('M Y') : 'N/A' }}
            </div>
        </div>
    </div>
</div>

<script>
function printIDCard() {
    const printBtn = document.querySelector('.modern-print-btn');
    const originalText = printBtn.innerHTML;
    
    // Show loading state
    printBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing ID Card...';
    printBtn.disabled = true;

    // Wait a moment for any images to load, then print
    setTimeout(() => {
        window.print();
        
        // Restore button after a short delay
        setTimeout(() => {
            printBtn.innerHTML = originalText;
            printBtn.disabled = false;
        }, 1000);
    }, 500);
}

document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects
    const idCard = document.querySelector('.modern-id-card');
    if (idCard) {
        idCard.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        idCard.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    }

    // Handle image loading errors
    const staffPhoto = document.querySelector('.modern-staff-photo');
    if (staffPhoto) {
        staffPhoto.addEventListener('error', function() {
            const initialsDiv = this.nextElementSibling;
            if (initialsDiv) {
                this.style.display = 'none';
                initialsDiv.style.display = 'flex';
            }
        });
    }

    // Pre-load images for better print quality
    window.addEventListener('beforeprint', function() {
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            const tempImg = new Image();
            tempImg.src = img.src;
        });
    });
});
</script>
@endsection