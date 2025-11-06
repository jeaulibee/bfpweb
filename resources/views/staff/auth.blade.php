<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Authentication | Smart Fire Detection</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        .auth-card {
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }
        
        .form-input {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }
        
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
            border-color: #ef4444;
            background: white;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-google {
            background: white;
            border: 1px solid #d1d5db;
            transition: all 0.3s ease;
        }
        
        .btn-google:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        
        .btn-primary:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        
        .tab-active {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        }
        
        .form-container {
            position: relative;
            overflow: hidden;
            min-height: 420px;
        }
        
        .form-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }
        
        .form-slide.active {
            opacity: 1;
            transform: translateX(0);
            pointer-events: all;
        }
        
        .form-slide.inactive-left {
            opacity: 0;
            transform: translateX(-30px);
        }
        
        .form-slide.inactive-right {
            opacity: 0;
            transform: translateX(30px);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.1);
            animation: float 15s infinite linear;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.3s ease;
        }
        
        .form-input:focus + .input-icon {
            color: #ef4444;
        }
        
        .form-input.has-icon {
            padding-left: 46px;
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #ef4444;
        }
        
        .checkbox-custom {
            position: relative;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        
        .checkbox-custom::after {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            background: #ef4444;
            border-radius: 2px;
            transform: scale(0);
            transition: transform 0.2s ease;
        }
        
        input[type="checkbox"]:checked + .checkbox-custom {
            border-color: #ef4444;
        }
        
        input[type="checkbox"]:checked + .checkbox-custom::after {
            transform: scale(1);
        }
        
        input[type="checkbox"] {
            position: absolute;
            opacity: 0;
        }
        
        .alert {
            transition: all 0.4s ease;
            overflow: hidden;
            max-height: 200px;
        }
        
        .alert.hidden {
            max-height: 0;
            opacity: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
            border: 0;
        }
        
        .password-strength-meter {
            height: 6px;
            border-radius: 3px;
            margin-top: 8px;
            transition: all 0.3s ease;
            background-color: #f3f4f6;
            overflow: hidden;
        }
        
        .password-strength-meter .strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
        }
        
        .password-hints {
            margin-top: 8px;
            font-size: 0.75rem;
            color: #6b7280;
        }
        
        .password-hint {
            display: flex;
            align-items: center;
            margin-bottom: 4px;
            transition: all 0.3s ease;
        }
        
        .password-hint.valid {
            color: #10b981;
        }
        
        .password-hint i {
            margin-right: 6px;
            font-size: 0.6rem;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: #e5e7eb;
        }
        
        .divider-text {
            padding: 0 12px;
            color: #6b7280;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background particles -->
    <div id="particles"></div>
    
    <div class="w-full max-w-md relative z-10">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="floating inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-500 to-red-700 text-white rounded-full text-2xl font-bold mb-4 shadow-lg">
                <i class="fas fa-fire-extinguisher"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Staff Portal</h1>
            <p class="text-gray-600 mt-2">Smart Fire Detection System</p>
        </div>

        <!-- Auth Card -->
        <div class="auth-card bg-white/90 backdrop-blur-lg rounded-2xl p-8 border border-white/50">
            <!-- Tabs -->
            <div class="flex mb-6 bg-gray-100/80 backdrop-blur-sm rounded-xl p-1">
                <button 
                    id="loginTab" 
                    class="flex-1 py-3 px-4 rounded-xl font-semibold transition-all duration-300 tab-active relative"
                    onclick="switchTab('login')"
                >
                    <span class="relative z-10">Login</span>
                </button>
                <button 
                    id="registerTab" 
                    class="flex-1 py-3 px-4 rounded-xl font-semibold text-gray-600 transition-all duration-300 relative"
                    onclick="switchTab('register')"
                >
                    <span class="relative z-10">Register</span>
                </button>
            </div>

            <!-- Alert Messages -->
            <div id="alertContainer">
                @if(session('success'))
                    <div class="alert mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl text-sm">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Please fix the following errors:
                        </div>
                        <ul class="list-disc ml-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Forms Container -->
            <div class="form-container">
                <!-- Login Form -->
                <form 
                    id="loginForm" 
                    method="POST" 
                    action="{{ route('staff.login.submit') }}"
                    class="form-slide active space-y-5"
                >
                    @csrf
                    
                    <div class="input-group">
                        <label for="loginEmail" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <input 
                                type="email" 
                                id="loginEmail" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="w-full form-input has-icon border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-500"
                                required
                                placeholder="Enter your email"
                            >
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="loginPassword" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                id="loginPassword" 
                                name="password" 
                                class="w-full form-input has-icon border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-500 pr-12"
                                required
                                placeholder="Enter your password"
                            >
                            <div 
                                class="password-toggle"
                                onclick="togglePassword('loginPassword')"
                            >
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="remember" class="hidden">
                            <span class="checkbox-custom"></span>
                            Remember me
                        </label>
                        <a href="#" class="text-sm text-red-600 hover:text-red-800 transition-colors">
                            Forgot Password?
                        </a>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full btn-primary text-white font-semibold py-3 rounded-xl transition-all duration-300"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login to Account
                    </button>

                    <!-- Divider -->
                    <div class="divider">
                        <span class="divider-text">Or continue with</span>
                    </div>

                    <!-- Google Login Button -->
                    <a 
                        href="{{ route('staff.google.login') }}" 
                        class="w-full btn-google text-gray-700 font-medium py-3 rounded-xl transition-all duration-300 flex items-center justify-center"
                    >
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="w-5 h-5 mr-3">
                        Continue with Google
                    </a>
                </form>

                <!-- Register Form -->
                <form 
                    id="registerForm" 
                    method="POST" 
                    action="{{ route('staff.register.submit') }}"
                    class="form-slide space-y-5"
                >
                    @csrf
                    
                    <div class="input-group">
                        <label for="registerName" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name
                        </label>
                        <div class="relative">
                            <i class="fas fa-user input-icon"></i>
                            <input 
                                type="text" 
                                id="registerName" 
                                name="name" 
                                value="{{ old('name') }}"
                                class="w-full form-input has-icon border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-500"
                                required
                                placeholder="Enter your full name"
                            >
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="registerEmail" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <i class="fas fa-envelope input-icon"></i>
                            <input 
                                type="email" 
                                id="registerEmail" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="w-full form-input has-icon border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-500"
                                required
                                placeholder="Enter your email"
                            >
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="registerPassword" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                id="registerPassword" 
                                name="password" 
                                class="w-full form-input has-icon border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-500 pr-12"
                                required
                                placeholder="Create a password"
                                oninput="checkPasswordStrength(this.value)"
                            >
                            <div 
                                class="password-toggle"
                                onclick="togglePassword('registerPassword')"
                            >
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                        
                        <!-- Password Strength Meter -->
                        <div class="password-strength-meter">
                            <div id="strengthBar" class="strength-bar"></div>
                        </div>
                        
                        <!-- Password Hints -->
                        <div id="passwordHints" class="password-hints hidden">
                            <div id="lengthHint" class="password-hint">
                                <i class="fas fa-circle"></i>
                                At least 8 characters
                            </div>
                            <div id="uppercaseHint" class="password-hint">
                                <i class="fas fa-circle"></i>
                                One uppercase letter
                            </div>
                            <div id="lowercaseHint" class="password-hint">
                                <i class="fas fa-circle"></i>
                                One lowercase letter
                            </div>
                            <div id="numberHint" class="password-hint">
                                <i class="fas fa-circle"></i>
                                One number
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="registerPasswordConfirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                id="registerPasswordConfirmation" 
                                name="password_confirmation" 
                                class="w-full form-input has-icon border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-red-500 pr-12"
                                required
                                placeholder="Confirm your password"
                            >
                            <div 
                                class="password-toggle"
                                onclick="togglePassword('registerPasswordConfirmation')"
                            >
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full btn-primary text-white font-semibold py-3 rounded-xl transition-all duration-300"
                    >
                        <i class="fas fa-user-plus mr-2"></i>
                        Create Account
                    </button>

                    <!-- Divider -->
                    <div class="divider">
                        <span class="divider-text">Or continue with</span>
                    </div>

                    <!-- Google Login Button -->
                    <a 
                        href="{{ route('staff.google.login') }}" 
                        class="w-full btn-google text-gray-700 font-medium py-3 rounded-xl transition-all duration-300 flex items-center justify-center"
                    >
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="w-5 h-5 mr-3">
                        Continue with Google
                    </a>
                </form>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6 pt-6 border-t border-gray-200/50">
                <a 
                    href="{{ route('landing') }}" 
                    class="inline-flex items-center text-gray-500 hover:text-gray-700 transition-colors text-sm"
                >
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>

    <script>
        // Create background particles
        function createParticles() {
            const container = document.getElementById('particles');
            const particleCount = 20;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size between 5 and 20px
                const size = Math.random() * 15 + 5;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                particle.style.left = `${Math.random() * 100}vw`;
                particle.style.top = `${Math.random() * 100}vh`;
                
                // Random animation delay and duration
                const delay = Math.random() * 15;
                const duration = Math.random() * 10 + 15;
                particle.style.animationDelay = `${delay}s`;
                particle.style.animationDuration = `${duration}s`;
                
                container.appendChild(particle);
            }
        }
        
        // Tab switching functionality with smooth transitions
        function switchTab(tab) {
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            
            // Hide alerts when switching tabs
            hideAlerts();
            
            if (tab === 'login') {
                // Update tabs
                loginTab.classList.add('tab-active');
                loginTab.classList.remove('text-gray-600');
                registerTab.classList.remove('tab-active');
                registerTab.classList.add('text-gray-600');
                
                // Animate forms
                registerForm.classList.remove('active');
                registerForm.classList.add('inactive-right');
                
                setTimeout(() => {
                    loginForm.classList.remove('inactive-left');
                    loginForm.classList.add('active');
                }, 300);
            } else {
                // Update tabs
                registerTab.classList.add('tab-active');
                registerTab.classList.remove('text-gray-600');
                loginTab.classList.remove('tab-active');
                loginTab.classList.add('text-gray-600');
                
                // Animate forms
                loginForm.classList.remove('active');
                loginForm.classList.add('inactive-left');
                
                setTimeout(() => {
                    registerForm.classList.remove('inactive-right');
                    registerForm.classList.add('active');
                }, 300);
            }
        }
        
        // Hide alert messages with animation
        function hideAlerts() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.classList.add('hidden');
            });
        }
        
        // Password visibility toggle
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.parentElement.querySelector('.password-toggle i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('strengthBar');
            const passwordHints = document.getElementById('passwordHints');
            const lengthHint = document.getElementById('lengthHint');
            const uppercaseHint = document.getElementById('uppercaseHint');
            const lowercaseHint = document.getElementById('lowercaseHint');
            const numberHint = document.getElementById('numberHint');
            
            // Reset hints
            lengthHint.classList.remove('valid');
            uppercaseHint.classList.remove('valid');
            lowercaseHint.classList.remove('valid');
            numberHint.classList.remove('valid');
            
            // Check password criteria
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            
            // Update hints
            if (hasMinLength) lengthHint.classList.add('valid');
            if (hasUppercase) uppercaseHint.classList.add('valid');
            if (hasLowercase) lowercaseHint.classList.add('valid');
            if (hasNumber) numberHint.classList.add('valid');
            
            // Calculate strength score
            let strength = 0;
            if (hasMinLength) strength += 25;
            if (hasUppercase) strength += 25;
            if (hasLowercase) strength += 25;
            if (hasNumber) strength += 25;
            
            // Update strength bar
            strengthBar.style.width = `${strength}%`;
            
            // Update strength bar color
            if (strength < 50) {
                strengthBar.style.backgroundColor = '#ef4444'; // red
            } else if (strength < 75) {
                strengthBar.style.backgroundColor = '#f59e0b'; // amber
            } else {
                strengthBar.style.backgroundColor = '#10b981'; // green
            }
            
            // Show hints if password is not empty
            if (password.length > 0) {
                passwordHints.classList.remove('hidden');
            } else {
                passwordHints.classList.add('hidden');
            }
        }
        
        // Form submission loading states
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            
            const forms = document.querySelectorAll('form');
            
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('button[type="submit"]');
                    const originalText = button.innerHTML;
                    
                    // Add loading state
                    button.innerHTML = `
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Processing...
                    `;
                    button.disabled = true;
                    
                    // Re-enable button after 5 seconds if still disabled (fallback)
                    setTimeout(() => {
                        if (button.disabled) {
                            button.innerHTML = originalText;
                            button.disabled = false;
                        }
                    }, 5000);
                });
            });
            
            // Auto-switch to register if there are registration errors
            @if($errors->has('name') || $errors->has('password_confirmation') || $errors->has('terms'))
                setTimeout(() => {
                    switchTab('register');
                }, 500);
            @endif
        });
    </script>
</body>
</html>