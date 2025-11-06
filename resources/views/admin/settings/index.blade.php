@extends('layouts.app')
@section('title', 'Settings')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8 transition-colors duration-300">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Toast Container -->
        <div id="toast" class="toast"></div>

        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 dark:bg-red-900 rounded-2xl shadow-lg mb-4 transition-colors duration-300">
                <i class="fa-solid fa-gear text-red-600 dark:text-red-300 text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2 transition-colors duration-300">System Settings</h1>
            <p class="text-gray-600 dark:text-gray-300 text-lg transition-colors duration-300">Configure your fire detection system preferences</p>
        </div>

        <!-- Settings Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center gap-3">
                    <i class="fa-solid fa-sliders"></i>
                    Configuration Panel
                </h2>
            </div>

            <!-- Settings Form -->
            <form method="POST" action="{{ route('admin.settings.update') }}" class="p-6 space-y-6" id="settingsForm">
                @csrf
                @method('PUT')

                <!-- General Settings Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2 mb-4 transition-colors duration-300">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center transition-colors duration-300">
                            <i class="fa-solid fa-building text-blue-600 dark:text-blue-300 text-sm"></i>
                        </div>
                        General Settings
                    </h3>

                    <!-- Site Name -->
                    <div class="space-y-2">
                        <label for="site_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 transition-colors duration-300">
                            <i class="fa-solid fa-building text-red-500 text-sm"></i>
                            Site Name
                        </label>
                        <div class="relative">
                            <input type="text" id="site_name" name="site_name"
                                value="{{ $settings->site_name ?? 'BFP Smart Fire Detection' }}"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 shadow-sm">
                            <i class="fa-solid fa-signature absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">This name will appear across the system</p>
                    </div>

                    <!-- Notification Email -->
                    <div class="space-y-2">
                        <label for="notification_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 transition-colors duration-300">
                            <i class="fa-solid fa-envelope text-red-500 text-sm"></i>
                            Notification Email
                        </label>
                        <div class="relative">
                            <input type="email" id="notification_email" name="notification_email"
                                value="{{ $settings->notification_email ?? '' }}"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 shadow-sm"
                                placeholder="email@example.com">
                            <i class="fa-solid fa-at absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">Important alerts will be sent to this address</p>
                    </div>
                </div>

                <!-- System Preferences Section -->
                <div class="space-y-6 pt-6 border-t border-gray-200 dark:border-gray-600 transition-colors duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2 mb-4 transition-colors duration-300">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center transition-colors duration-300">
                            <i class="fa-solid fa-bell text-green-600 dark:text-green-300 text-sm"></i>
                        </div>
                        System Preferences
                    </h3>

                    <!-- Alert Threshold -->
                    <div class="space-y-2">
                        <label for="alert_threshold" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 transition-colors duration-300">
                            <i class="fa-solid fa-gauge-high text-red-500 text-sm"></i>
                            Alert Sensitivity
                        </label>
                        <div class="relative">
                            <select id="alert_threshold" name="alert_threshold"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 shadow-sm appearance-none">
                                <option value="low" {{ ($settings->alert_threshold ?? 'medium') == 'low' ? 'selected' : '' }}>🟢 Low Sensitivity</option>
                                <option value="medium" {{ ($settings->alert_threshold ?? 'medium') == 'medium' ? 'selected' : '' }}>🟡 Medium Sensitivity</option>
                                <option value="high" {{ ($settings->alert_threshold ?? 'medium') == 'high' ? 'selected' : '' }}>🔴 High Sensitivity</option>
                            </select>
                            <i class="fa-solid fa-arrow-up-wide-short absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            <i class="fa-solid fa-caret-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">Adjust how sensitive the system is to fire alerts</p>
                    </div>

                    <!-- Auto Refresh -->
                    <div class="space-y-2">
                        <label for="auto_refresh" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 transition-colors duration-300">
                            <i class="fa-solid fa-rotate text-red-500 text-sm"></i>
                            Auto Refresh Interval
                        </label>
                        <div class="relative">
                            <select id="auto_refresh" name="auto_refresh"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 shadow-sm appearance-none">
                                <option value="30" {{ ($settings->auto_refresh ?? '60') == '30' ? 'selected' : '' }}>30 seconds</option>
                                <option value="60" {{ ($settings->auto_refresh ?? '60') == '60' ? 'selected' : '' }}>1 minute</option>
                                <option value="300" {{ ($settings->auto_refresh ?? '60') == '300' ? 'selected' : '' }}>5 minutes</option>
                                <option value="600" {{ ($settings->auto_refresh ?? '60') == '600' ? 'selected' : '' }}>10 minutes</option>
                            </select>
                            <i class="fa-solid fa-clock absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                            <i class="fa-solid fa-caret-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">How often the dashboard refreshes data</p>
                    </div>
                </div>

                <!-- Advanced Settings Section -->
                <div class="space-y-6 pt-6 border-t border-gray-200 dark:border-gray-600 transition-colors duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2 mb-4 transition-colors duration-300">
                        <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center transition-colors duration-300">
                            <i class="fa-solid fa-microchip text-purple-600 dark:text-purple-300 text-sm"></i>
                        </div>
                        Advanced Configuration
                    </h3>

                    <!-- Other Configurations -->
                    <div class="space-y-2">
                        <label for="other_config" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 transition-colors duration-300">
                            <i class="fa-solid fa-code text-red-500 text-sm"></i>
                            Custom Configuration
                        </label>
                        <div class="relative">
                            <textarea id="other_config" name="other_config" rows="4"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 shadow-sm resize-vertical"
                                placeholder="Enter any additional configuration in JSON format...">{{ $settings->other_config ?? '' }}</textarea>
                            <i class="fa-solid fa-file-code absolute left-3 top-3.5 text-gray-400 text-sm"></i>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">Advanced system configuration in JSON format</p>
                    </div>

                    <!-- System Theme -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 transition-colors duration-300">
                            <i class="fa-solid fa-palette text-red-500 text-sm"></i>
                            Interface Theme
                        </label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="theme" value="light" 
                                    class="w-4 h-4 text-red-600 focus:ring-red-500" 
                                    {{ ($settings->theme ?? 'light') == 'light' ? 'checked' : '' }}>
                                <div class="flex items-center gap-2 p-3 rounded-lg border border-gray-300 dark:border-gray-600 group-hover:border-red-300 transition-colors duration-200">
                                    <i class="fa-solid fa-sun text-yellow-500"></i>
                                    <span class="text-sm font-medium">Light Mode</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="theme" value="dark" 
                                    class="w-4 h-4 text-red-600 focus:ring-red-500"
                                    {{ ($settings->theme ?? 'light') == 'dark' ? 'checked' : '' }}>
                                <div class="flex items-center gap-2 p-3 rounded-lg border border-gray-300 dark:border-gray-600 group-hover:border-red-300 transition-colors duration-200">
                                    <i class="fa-solid fa-moon text-indigo-500"></i>
                                    <span class="text-sm font-medium">Dark Mode</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="theme" value="auto" 
                                    class="w-4 h-4 text-red-600 focus:ring-red-500"
                                    {{ ($settings->theme ?? 'light') == 'auto' ? 'checked' : '' }}>
                                <div class="flex items-center gap-2 p-3 rounded-lg border border-gray-300 dark:border-gray-600 group-hover:border-red-300 transition-colors duration-200">
                                    <i class="fa-solid fa-circle-half-stroke text-blue-500"></i>
                                    <span class="text-sm font-medium">Auto</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-600 transition-colors duration-300">
                    <a href="{{ url()->previous() }}" 
                       class="flex-1 px-6 py-3.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to Dashboard
                    </a>
                    <button type="submit" id="submitBtn"
                            class="flex-1 px-6 py-3.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-save group-hover:scale-110 transition-transform duration-200"></i>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Tips -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-6 transition-colors duration-300">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors duration-300">
                    <i class="fa-solid fa-lightbulb text-blue-600 dark:text-blue-300"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2 transition-colors duration-300">Settings Tips</h4>
                    <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1 transition-colors duration-300">
                        <li>• Save your changes to apply new configurations immediately</li>
                        <li>• Higher sensitivity may generate more alerts</li>
                        <li>• Custom configurations require valid JSON format</li>
                        <li>• Theme changes will apply after page refresh</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ====== Toast Styles ====== */
    .toast {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-20px);
        background: #1f2937;
        color: #fff;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        opacity: 0;
        transition: all 0.4s ease;
        z-index: 1000;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    .toast.error { 
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        border-left: 4px solid #fca5a5;
    }
    .toast.success { 
        background: linear-gradient(135deg, #16a34a, #15803d);
        border-left: 4px solid #86efac;
    }

    /* ====== Loading Animation ====== */
    .loader {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #dc2626;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 0.8s linear infinite;
        display: inline-block;
    }
    @keyframes spin { 
        to { transform: rotate(360deg); } 
    }

    /* ====== Custom Select Styling ====== */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* ====== Radio Button Styling ====== */
    input[type="radio"] {
        border-radius: 50%;
    }
    input[type="radio"]:checked {
        background-color: #dc2626;
        border-color: #dc2626;
    }

    /* ====== Smooth transitions for all elements ====== */
    * {
        transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
    }
</style>

<script>
    // Professional Dark Mode Management
    class ThemeManager {
        constructor() {
            this.theme = this.getPreferredTheme();
            this.init();
        }

        getStoredTheme() {
            return localStorage.getItem('theme');
        }

        setStoredTheme(theme) {
            localStorage.setItem('theme', theme);
        }

        getPreferredTheme() {
            const storedTheme = this.getStoredTheme();
            if (storedTheme) {
                return storedTheme;
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        setTheme(theme) {
            this.theme = theme;
            
            if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            } else if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            
            this.setStoredTheme(theme);
            this.updateRadioButtons(theme);
            
            // Dispatch custom event for other components
            document.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme } }));
        }

        updateRadioButtons(theme) {
            const themeRadios = document.querySelectorAll('input[name="theme"]');
            themeRadios.forEach(radio => {
                radio.checked = radio.value === theme;
            });
        }

        init() {
            // Set initial theme
            this.setTheme(this.theme);

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (this.theme === 'auto') {
                    this.setTheme('auto');
                }
            });

            // Listen for radio button changes
            document.querySelectorAll('input[name="theme"]').forEach(radio => {
                radio.addEventListener('change', (e) => {
                    this.setTheme(e.target.value);
                });
            });
        }
    }

    // Form handling with AJAX
    class SettingsForm {
        constructor() {
            this.form = document.getElementById('settingsForm');
            this.submitBtn = document.getElementById('submitBtn');
            this.init();
        }

        init() {
            this.form.addEventListener('submit', this.handleSubmit.bind(this));
            this.initRealTimeValidation();
            this.initCharacterCounter();
        }

        async handleSubmit(e) {
            e.preventDefault();
            
            const originalText = this.submitBtn.innerHTML;
            this.showLoadingState();

            try {
                const formData = new FormData(this.form);
                
                // Send AJAX request
                const response = await fetch(this.form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    this.showToast('success', result.message || 'Settings updated successfully! 🎉');
                    
                    // Update theme if it was changed
                    const newTheme = formData.get('theme');
                    themeManager.setTheme(newTheme);
                    
                } else {
                    throw new Error(result.message || 'Failed to update settings');
                }
            } catch (error) {
                this.showToast('error', error.message || 'An error occurred while saving settings');
            } finally {
                this.resetButtonState(originalText);
            }
        }

        showLoadingState() {
            this.submitBtn.innerHTML = `
                <div class="loader mr-2"></div>
                Saving Settings...
            `;
            this.submitBtn.disabled = true;
        }

        resetButtonState(originalText) {
            setTimeout(() => {
                this.submitBtn.innerHTML = originalText;
                this.submitBtn.disabled = false;
            }, 1000);
        }

        initRealTimeValidation() {
            const formInputs = document.querySelectorAll('input, select, textarea');
            
            formInputs.forEach(input => {
                input.addEventListener('blur', () => this.validateField(input));
                input.addEventListener('focus', () => this.clearFieldStyles(input));
            });
        }

        validateField(field) {
            this.clearFieldStyles(field);

            if (field.hasAttribute('required') && !field.value.trim()) {
                this.markFieldInvalid(field, 'This field is required');
                return false;
            }

            if (field.type === 'email' && field.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(field.value)) {
                    this.markFieldInvalid(field, 'Please enter a valid email address');
                    return false;
                }
            }

            if (field.name === 'other_config' && field.value) {
                try {
                    JSON.parse(field.value);
                    this.markFieldValid(field);
                } catch (e) {
                    this.markFieldInvalid(field, 'Please enter valid JSON format');
                    return false;
                }
            }

            this.markFieldValid(field);
            return true;
        }

        markFieldInvalid(field, message) {
            field.classList.add('border-red-300', 'bg-red-50', 'dark:border-red-700', 'dark:bg-red-900/20');
            this.showFieldError(field, message);
        }

        markFieldValid(field) {
            field.classList.add('border-green-300', 'bg-green-50', 'dark:border-green-700', 'dark:bg-green-900/20');
            
            setTimeout(() => {
                this.clearFieldStyles(field);
            }, 2000);
        }

        clearFieldStyles(field) {
            field.classList.remove(
                'border-red-300', 'bg-red-50', 'dark:border-red-700', 'dark:bg-red-900/20',
                'border-green-300', 'bg-green-50', 'dark:border-green-700', 'dark:bg-green-900/20'
            );
            
            // Remove any existing error message
            const existingError = field.parentNode.querySelector('.field-error');
            if (existingError) {
                existingError.remove();
            }
        }

        showFieldError(field, message) {
            this.clearFieldStyles(field);
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'field-error text-xs text-red-600 dark:text-red-400 mt-1 flex items-center gap-1';
            errorDiv.innerHTML = `
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>${message}</span>
            `;
            
            field.parentNode.appendChild(errorDiv);
        }

        initCharacterCounter() {
            const textarea = document.querySelector('textarea[name="other_config"]');
            if (!textarea) return;

            const charCount = document.createElement('div');
            charCount.className = 'text-xs text-gray-500 dark:text-gray-400 text-right mt-1';
            this.updateCharCount(charCount, textarea.value.length);
            
            textarea.parentNode.appendChild(charCount);
            
            textarea.addEventListener('input', (e) => {
                this.updateCharCount(charCount, e.target.value.length);
            });
        }

        updateCharCount(element, count) {
            element.textContent = `${count} characters`;
            
            if (count > 500) {
                element.className = 'text-xs text-green-600 font-semibold text-right mt-1';
            } else if (count > 100) {
                element.className = 'text-xs text-blue-600 text-right mt-1';
            } else {
                element.className = 'text-xs text-gray-500 dark:text-gray-400 text-right mt-1';
            }
        }

        showToast(type, message) {
            const toast = document.getElementById('toast');
            const icon = type === 'success' ? 'fa-solid fa-check-circle' : 'fa-solid fa-exclamation-triangle';
            
            toast.innerHTML = `
                <i class="${icon}"></i>
                <span>${message}</span>
            `;
            toast.className = `toast show ${type}`;
            
            setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);
        }
    }

    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize theme manager
        window.themeManager = new ThemeManager();
        
        // Initialize settings form
        window.settingsForm = new SettingsForm();

        // Check for flash messages
        @if (session('success'))
            window.settingsForm.showToast('success', '{{ session('success') }}');
        @endif

        @if (session('error'))
            window.settingsForm.showToast('error', '{{ session('error') }}');
        @endif

        // Add keyboard shortcut for theme toggle (Ctrl/Cmd + D)
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                e.preventDefault();
                const currentTheme = themeManager.theme;
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                themeManager.setTheme(newTheme);
                
                // Update radio buttons
                const themeRadios = document.querySelectorAll('input[name="theme"]');
                themeRadios.forEach(radio => {
                    if (radio.value === newTheme) {
                        radio.checked = true;
                    }
                });
                
                window.settingsForm.showToast('success', `Theme changed to ${newTheme} mode`);
            }
        });
    });

    // Export for global access
    window.ThemeManager = ThemeManager;
    window.SettingsForm = SettingsForm;
</script>
@endsection