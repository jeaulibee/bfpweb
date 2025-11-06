// resources/js/theme.js
class GlobalThemeManager {
    constructor() {
        this.currentTheme = this.getStoredTheme() || 'light';
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
        this.currentTheme = theme;
        
        if (theme === 'auto') {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', prefersDark);
        } else {
            document.documentElement.classList.toggle('dark', theme === 'dark');
        }
        
        this.setStoredTheme(theme);
        this.dispatchThemeChangeEvent();
    }

    toggleTheme() {
        const newTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
        return newTheme;
    }

    dispatchThemeChangeEvent() {
        document.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme: this.currentTheme }
        }));
    }

    init() {
        // Set initial theme
        this.setTheme(this.getPreferredTheme());

        // Watch for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (this.currentTheme === 'auto') {
                this.setTheme('auto');
            }
        });
    }
}

// Initialize global theme manager
window.globalThemeManager = new GlobalThemeManager();

// Make it available globally
export default GlobalThemeManager;