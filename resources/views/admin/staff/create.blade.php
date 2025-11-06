@extends('layouts.app')
@section('title', 'Add Staff')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    /* Modern Design System */
    :root {
        --primary-red: #dc2626;
        --primary-red-dark: #b91c1c;
        --primary-red-light: #fef2f2;
        --success-green: #16a34a;
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
        max-width: 32rem;
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
        position: relative;
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

    .input-with-icon .modern-input {
        padding-left: 3rem;
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

    .modern-toast i {
        font-size: 1.25rem;
    }

    /* Password Strength Indicator */
    .password-strength {
        margin-top: 0.5rem;
        height: 4px;
        background: var(--gray-200);
        border-radius: 2px;
        overflow: hidden;
        position: relative;
    }

    .password-strength-bar {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .strength-weak { background: #ef4444; width: 33%; }
    .strength-medium { background: #f59e0b; width: 66%; }
    .strength-strong { background: #10b981; width: 100%; }

    .password-hint {
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    /* Image Upload Styles */
    .image-preview-container {
        position: relative;
        margin-top: 1rem;
        display: inline-block;
        animation: fadeIn 0.3s ease;
    }

    .image-preview {
        width: 120px;
        height: 120px;
        border-radius: var(--radius-xl);
        object-fit: cover;
        border: 3px solid var(--gray-200);
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }

    .image-preview:hover {
        border-color: var(--primary-red);
        transform: scale(1.05);
    }

    .remove-image-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary-red);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
    }

    .remove-image-btn:hover {
        background: var(--primary-red-dark);
        transform: scale(1.1);
    }

    /* File Input Styling */
    .modern-input[type="file"] {
        padding: 0.75rem 1rem 0.75rem 3rem;
        cursor: pointer;
        background: white;
    }

    .modern-input[type="file"]::file-selector-button {
        display: none;
    }

    .upload-area {
        border: 2px dashed var(--gray-300);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: var(--gray-50);
        margin-top: 0.5rem;
    }

    .upload-area:hover {
        border-color: var(--primary-red);
        background: var(--primary-red-light);
    }

    .upload-area.dragover {
        border-color: var(--primary-red);
        background: var(--primary-red-light);
        transform: scale(1.02);
    }

    .upload-icon {
        font-size: 2rem;
        color: var(--gray-400);
        margin-bottom: 0.75rem;
    }

    .upload-area:hover .upload-icon {
        color: var(--primary-red);
    }

    .file-info {
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-top: 0.5rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Responsive Design */
    @media (max-width: 640px) {
        .modern-bg {
            padding: 1rem 0.5rem;
        }
        
        .modern-card {
            margin: 0 0.5rem;
            max-width: 100%;
        }
        
        .modern-form {
            padding: 1.5rem;
        }
        
        .modern-button-group {
            flex-direction: column;
        }
        
        .modern-toast {
            right: 1rem;
            left: 1rem;
            transform: translateY(-100%);
        }
        
        .modern-toast.show {
            transform: translateY(0);
        }

        .upload-area {
            padding: 1rem;
        }

        .image-preview {
            width: 100px;
            height: 100px;
        }
    }
</style>

<div class="modern-bg">
    <div class="modern-card">
        <!-- Header -->
        <div class="modern-header">
            <h2>
                <i class="fas fa-user-plus"></i>
                Add Staff Member
            </h2>
            <p>Create a new staff account for your team</p>
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

        <!-- Form - UPDATED with enctype for file upload -->
        <form method="POST" action="{{ route('admin.staff.store') }}" class="modern-form" enctype="multipart/form-data">
            @csrf

            <!-- Profile Picture -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-camera"></i>
                    Profile Picture
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-image input-icon"></i>
                    <input 
                        type="file" 
                        name="profile_picture" 
                        id="profile_picture"
                        class="modern-input" 
                        accept="image/*"
                        onchange="previewImage(this)"
                    >
                </div>
                
                <!-- Upload Area -->
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div style="color: var(--gray-600); font-size: 0.875rem;">
                        <strong>Click to upload</strong> or drag and drop
                    </div>
                    <div style="color: var(--gray-500); font-size: 0.75rem; margin-top: 0.5rem;">
                        PNG, JPG, JPEG, WEBP up to 2MB
                    </div>
                </div>
                
                <!-- Image Preview -->
                <div id="image-preview" class="image-preview-container" style="display: none;">
                    <img id="preview" class="image-preview">
                    <button type="button" class="remove-image-btn" onclick="removeImage()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="file-info" id="file-info"></div>
            </div>

            <!-- Name -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-user"></i>
                    Full Name
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-user input-icon"></i>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="modern-input" 
                        placeholder="Enter full name" 
                        required
                        autofocus
                    >
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-envelope"></i>
                    Email Address
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope input-icon"></i>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="modern-input" 
                        placeholder="Enter email address" 
                        required
                    >
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-lock"></i>
                    Password
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-lock input-icon"></i>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        class="modern-input" 
                        placeholder="Create a secure password" 
                        required
                        oninput="checkPasswordStrength(this.value)"
                    >
                </div>
                <div class="password-strength">
                    <div class="password-strength-bar" id="password-strength-bar"></div>
                </div>
                <div class="password-hint" id="password-hint">
                    Use at least 8 characters with letters and numbers
                </div>
            </div>

            <!-- Buttons -->
            <div class="modern-button-group">
                <a href="{{ route('admin.staff.index') }}" class="modern-secondary-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Staff
                </a>
                <button type="submit" class="modern-primary-btn">
                    <i class="fas fa-user-plus"></i>
                    Create Staff
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Notification -->
@if(session('success'))
    <div id="modern-toast" class="modern-toast">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Toast Notification
    const toast = document.getElementById('modern-toast');
    if (toast) {
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        setTimeout(() => {
            toast.classList.remove('show');
        }, 4000);
    }

    // Form animations
    const inputs = document.querySelectorAll('.modern-input');
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

    // Initialize drag and drop
    initializeDragAndDrop();
});

// Password Strength Checker
function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('password-strength-bar');
    const hint = document.getElementById('password-hint');
    
    if (!password) {
        strengthBar.className = 'password-strength-bar';
        strengthBar.style.width = '0%';
        hint.textContent = 'Use at least 8 characters with letters and numbers';
        return;
    }

    let strength = 0;
    
    // Length check
    if (password.length >= 8) strength += 1;
    if (password.length >= 12) strength += 1;
    
    // Character variety
    if (/[a-z]/.test(password)) strength += 1;
    if (/[A-Z]/.test(password)) strength += 1;
    if (/[0-9]/.test(password)) strength += 1;
    if (/[^a-zA-Z0-9]/.test(password)) strength += 1;

    // Update UI
    if (strength <= 2) {
        strengthBar.className = 'password-strength-bar strength-weak';
        hint.textContent = 'Weak password - try adding more characters and numbers';
        hint.style.color = '#ef4444';
    } else if (strength <= 4) {
        strengthBar.className = 'password-strength-bar strength-medium';
        hint.textContent = 'Medium strength - good start, but could be stronger';
        hint.style.color = '#f59e0b';
    } else {
        strengthBar.className = 'password-strength-bar strength-strong';
        hint.textContent = 'Strong password - excellent!';
        hint.style.color = '#10b981';
    }
}

// Image Preview Function
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('image-preview');
    const fileInfo = document.getElementById('file-info');
    const uploadArea = document.getElementById('uploadArea');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            showError('File size must be less than 2MB');
            input.value = '';
            return;
        }
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            showError('Please select a valid image file (JPEG, PNG, JPG, GIF, WEBP)');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'inline-block';
            uploadArea.style.display = 'none';
            fileInfo.textContent = `Selected: ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
            fileInfo.style.color = 'var(--success-green)';
        }
        
        reader.onerror = function() {
            showError('Error reading file. Please try again.');
        }
        
        reader.readAsDataURL(file);
    }
}

// Remove Image Function
function removeImage() {
    const input = document.getElementById('profile_picture');
    const previewContainer = document.getElementById('image-preview');
    const uploadArea = document.getElementById('uploadArea');
    const fileInfo = document.getElementById('file-info');
    
    input.value = '';
    previewContainer.style.display = 'none';
    uploadArea.style.display = 'block';
    fileInfo.textContent = '';
}

// Drag and Drop functionality
function initializeDragAndDrop() {
    const fileInput = document.getElementById('profile_picture');
    const uploadArea = document.getElementById('uploadArea');
    
    if (!uploadArea) return;
    
    // Upload area click event
    uploadArea.addEventListener('click', function() {
        fileInput.click();
    });
    
    // Drag and drop events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        uploadArea.classList.add('dragover');
    }
    
    function unhighlight() {
        uploadArea.classList.remove('dragover');
    }
    
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            previewImage(fileInput);
        }
    }
}

// Show error message
function showError(message) {
    const errorMsg = document.createElement('div');
    errorMsg.className = 'modern-error-container';
    errorMsg.innerHTML = `<ul><li>${message}</li></ul>`;
    document.querySelector('.modern-form').prepend(errorMsg);
    
    // Auto-remove error after 3 seconds
    setTimeout(() => {
        errorMsg.remove();
    }, 3000);
}

// Enhanced form validation
const form = document.querySelector('form');
form.addEventListener('submit', (e) => {
    const inputs = form.querySelectorAll('input[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.style.borderColor = '#ef4444';
            input.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
        }
    });

    if (!isValid) {
        e.preventDefault();
        showError('Please fill in all required fields');
    }
});

// Input focus effects
document.querySelectorAll('.modern-input').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'translateY(-2px)';
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'translateY(0)';
    });
});
</script>
@endsection