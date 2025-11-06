@extends('layouts.app')
@section('title', 'Create Announcement')

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
        max-width: 48rem;
        margin: 0 auto;
        animation: cardSlideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .modern-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
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
        text-align: center;
        border-bottom: 1px solid var(--gray-200);
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    }

    .modern-header h2 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .modern-header h2 i {
        color: var(--primary-red);
        font-size: 2rem;
    }

    .modern-header p {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    /* Modern Form */
    .modern-form {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: var(--primary-red);
        font-size: 0.875rem;
    }

    .modern-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-lg);
        font-size: 0.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
    }

    .modern-input:focus {
        outline: none;
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        transform: translateY(-1px);
    }

    .modern-input:hover {
        border-color: var(--gray-300);
    }

    .modern-textarea {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-lg);
        font-size: 0.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
        line-height: 1.5;
    }

    .modern-textarea:focus {
        outline: none;
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        transform: translateY(-1px);
    }

    .modern-textarea:hover {
        border-color: var(--gray-300);
    }

    .modern-select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-lg);
        font-size: 0.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
    }

    .modern-select:focus {
        outline: none;
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        transform: translateY(-1px);
    }

    .modern-select:hover {
        border-color: var(--gray-300);
    }

    .input-with-icon {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        font-size: 1rem;
        pointer-events: none;
    }

    .input-with-icon .modern-input,
    .input-with-icon .modern-select {
        padding-left: 3rem;
    }

    /* Character Counter */
    .char-counter {
        text-align: right;
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    .char-counter.warning {
        color: var(--warning-orange);
    }

    .char-counter.error {
        color: var(--primary-red);
    }

    /* Status Options */
    .status-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem;
    }

    .status-icon {
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }

    .status-icon.active {
        background: var(--success-green);
        color: white;
    }

    .status-icon.inactive {
        background: var(--gray-300);
        color: var(--gray-700);
    }

    /* Preview Section */
    .preview-section {
        background: var(--gray-50);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-top: 1rem;
        border: 1px solid var(--gray-200);
    }

    .preview-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .preview-header i {
        color: var(--primary-red);
        font-size: 1.25rem;
    }

    .preview-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .preview-content {
        background: white;
        border-radius: var(--radius-md);
        padding: 1rem;
        border: 1px solid var(--gray-200);
        min-height: 80px;
        line-height: 1.6;
        color: var(--gray-700);
    }

    .preview-placeholder {
        color: var(--gray-400);
        font-style: italic;
    }

    /* Modern Buttons */
    .modern-button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
    }

    .modern-secondary-btn {
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

    .modern-secondary-btn:hover {
        background: var(--gray-200);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .modern-primary-btn {
        flex: 1;
        background: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
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

    /* Modern Error Display */
    .modern-error-container {
        background: var(--primary-red-light);
        border: 1px solid #fecaca;
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        animation: slideDown 0.3s ease-out;
    }

    .modern-error-container ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .modern-error-container li {
        color: var(--primary-red-dark);
        font-size: 0.875rem;
        padding: 0.25rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modern-error-container li::before {
        content: '⚠️';
        font-size: 0.75rem;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .modern-bg {
            padding: 1rem 0.5rem;
        }
        
        .modern-card {
            margin: 0 0.5rem;
        }
        
        .modern-form {
            padding: 1.5rem;
        }
        
        .modern-button-group {
            flex-direction: column;
        }
        
        .preview-section {
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .modern-header h2 {
            font-size: 1.5rem;
        }
        
        .modern-header {
            padding: 1.5rem;
        }
    }
</style>

<div class="modern-bg">
    <div class="modern-card">
        <!-- Header -->
        <div class="modern-header">
            <h2>
                <i class="fas fa-bullhorn"></i>
                Create Announcement
            </h2>
            <p>Share important updates and information with your team</p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="modern-error-container">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.announcements.store') }}" method="POST" class="modern-form" id="announcementForm">
            @csrf

            <!-- Title -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-heading"></i>
                    Announcement Title
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-heading input-icon"></i>
                    <input 
                        type="text" 
                        name="title" 
                        class="modern-input" 
                        placeholder="Enter a clear and concise title"
                        value="{{ old('title') }}" 
                        required
                        maxlength="255"
                        id="titleInput"
                        oninput="updatePreview()"
                    >
                </div>
                <div class="char-counter" id="titleCounter">
                    <span id="titleCount">0</span>/255 characters
                </div>
            </div>

            <!-- Message -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-align-left"></i>
                    Announcement Message
                </label>
                <textarea 
                    name="message" 
                    class="modern-textarea" 
                    placeholder="Write your detailed announcement message here. You can include important details, instructions, or updates."
                    required
                    maxlength="2000"
                    id="messageInput"
                    oninput="updatePreview()"
                >{{ old('message') }}</textarea>
                <div class="char-counter" id="messageCounter">
                    <span id="messageCount">0</span>/2000 characters
                </div>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-toggle-on"></i>
                    Announcement Status
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-toggle-on input-icon"></i>
                    <select name="status" class="modern-select" required id="statusSelect" onchange="updatePreview()">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                            Active - Visible to all users
                        </option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                            Inactive - Hidden from users
                        </option>
                    </select>
                </div>
            </div>

            <!-- Live Preview -->
            <div class="preview-section">
                <div class="preview-header">
                    <i class="fas fa-eye"></i>
                    <div class="preview-title">Live Preview</div>
                </div>
                <div class="preview-content" id="previewContent">
                    <div class="preview-placeholder" id="previewPlaceholder">
                        Start typing to see a live preview of your announcement...
                    </div>
                    <div id="previewTitle" style="display: none;">
                        <strong id="previewTitleText"></strong>
                    </div>
                    <div id="previewMessage" style="display: none; margin-top: 0.5rem;">
                        <span id="previewMessageText"></span>
                    </div>
                    <div id="previewStatus" style="display: none; margin-top: 1rem; font-size: 0.875rem; color: var(--gray-500);">
                        Status: <span id="previewStatusText"></span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="modern-button-group">
                <a href="{{ route('admin.announcements.index') }}" class="modern-secondary-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Announcements
                </a>
                <button type="submit" class="modern-primary-btn" id="submitBtn">
                    <i class="fas fa-paper-plane"></i>
                    Publish Announcement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize character counters
    updateCharacterCounters();
    
    // Form animations
    const inputs = document.querySelectorAll('.modern-input, .modern-textarea, .modern-select');
    inputs.forEach((input, index) => {
        input.style.animationDelay = `${index * 0.1}s`;
    });

    // Auto-hide errors after 5 seconds
    const errorContainer = document.querySelector('.modern-error-container');
    if (errorContainer) {
        setTimeout(() => {
            errorContainer.style.opacity = '0';
            errorContainer.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                errorContainer.remove();
            }, 300);
        }, 5000);
    }

    // Enhanced form validation
    const form = document.getElementById('announcementForm');
    form.addEventListener('submit', function(e) {
        const requiredInputs = this.querySelectorAll('input[required], textarea[required], select[required]');
        let isValid = true;

        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderColor = '#ef4444';
                input.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
            }
        });

        if (!isValid) {
            e.preventDefault();
            // Show error message
            const errorMsg = document.createElement('div');
            errorMsg.className = 'modern-error-container';
            errorMsg.innerHTML = '<ul><li>Please fill in all required fields</li></ul>';
            form.prepend(errorMsg);
            
            // Auto-remove error after 3 seconds
            setTimeout(() => {
                errorMsg.remove();
            }, 3000);
        } else {
            // Add loading state to submit button
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Publishing...';
            submitBtn.disabled = true;
            
            // Re-enable after 3 seconds if form doesn't submit
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        }
    });

    // Input focus effects
    document.querySelectorAll('.modern-input, .modern-textarea, .modern-select').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });
});

// Update character counters
function updateCharacterCounters() {
    const titleInput = document.getElementById('titleInput');
    const messageInput = document.getElementById('messageInput');
    const titleCount = document.getElementById('titleCount');
    const messageCount = document.getElementById('messageCount');
    const titleCounter = document.getElementById('titleCounter');
    const messageCounter = document.getElementById('messageCounter');

    if (titleInput && titleCount) {
        titleCount.textContent = titleInput.value.length;
        if (titleInput.value.length > 200) {
            titleCounter.className = 'char-counter warning';
        } else {
            titleCounter.className = 'char-counter';
        }
    }

    if (messageInput && messageCount) {
        messageCount.textContent = messageInput.value.length;
        if (messageInput.value.length > 1800) {
            messageCounter.className = 'char-counter warning';
        } else if (messageInput.value.length > 1900) {
            messageCounter.className = 'char-counter error';
        } else {
            messageCounter.className = 'char-counter';
        }
    }
}

// Update live preview
function updatePreview() {
    updateCharacterCounters();
    
    const titleInput = document.getElementById('titleInput');
    const messageInput = document.getElementById('messageInput');
    const statusSelect = document.getElementById('statusSelect');
    const previewPlaceholder = document.getElementById('previewPlaceholder');
    const previewTitle = document.getElementById('previewTitle');
    const previewMessage = document.getElementById('previewMessage');
    const previewStatus = document.getElementById('previewStatus');
    const previewTitleText = document.getElementById('previewTitleText');
    const previewMessageText = document.getElementById('previewMessageText');
    const previewStatusText = document.getElementById('previewStatusText');

    const hasContent = titleInput.value.trim() || messageInput.value.trim();

    if (hasContent) {
        previewPlaceholder.style.display = 'none';
        previewTitle.style.display = 'block';
        previewMessage.style.display = 'block';
        previewStatus.style.display = 'block';

        previewTitleText.textContent = titleInput.value || 'No title provided';
        previewMessageText.textContent = messageInput.value || 'No message provided';
        
        const statusText = statusSelect.value === 'active' ? 
            '<span style="color: var(--success-green);">🟢 Active</span>' : 
            '<span style="color: var(--gray-500);">⚫ Inactive</span>';
        previewStatusText.innerHTML = statusText;
    } else {
        previewPlaceholder.style.display = 'block';
        previewTitle.style.display = 'none';
        previewMessage.style.display = 'none';
        previewStatus.style.display = 'none';
    }
}

// Auto-save draft (local storage)
function autoSaveDraft() {
    const titleInput = document.getElementById('titleInput');
    const messageInput = document.getElementById('messageInput');
    const statusSelect = document.getElementById('statusSelect');

    if (titleInput && messageInput && statusSelect) {
        const draft = {
            title: titleInput.value,
            message: messageInput.value,
            status: statusSelect.value,
            timestamp: new Date().toISOString()
        };
        localStorage.setItem('announcementDraft', JSON.stringify(draft));
    }
}

// Load draft from local storage
function loadDraft() {
    const draft = localStorage.getItem('announcementDraft');
    if (draft) {
        const draftData = JSON.parse(draft);
        const titleInput = document.getElementById('titleInput');
        const messageInput = document.getElementById('messageInput');
        const statusSelect = document.getElementById('statusSelect');

        if (titleInput && messageInput && statusSelect) {
            titleInput.value = draftData.title || '';
            messageInput.value = draftData.message || '';
            statusSelect.value = draftData.status || 'active';
            updatePreview();
        }
    }
}

// Auto-save every 10 seconds
setInterval(autoSaveDraft, 10000);

// Load draft on page load
window.addEventListener('load', loadDraft);

// Clear draft when form is successfully submitted
document.getElementById('announcementForm').addEventListener('submit', function() {
    localStorage.removeItem('announcementDraft');
});
</script>
@endsection