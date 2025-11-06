<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BFP Smart Fire Detection & Mapping</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; }

        /* Scroll / Fade Animations */
        .fade-in, .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s ease;
        }
        .fade-in.visible, .scroll-animate.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Button hover glow */
        .glow-hover:hover {
            box-shadow: 0 0 25px rgba(220, 38, 38, 0.5);
        }

        /* Navbar blur */
        .navbar-blur {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.85);
        }

        /* Floating animation for hero icon */
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .floating { animation: floating 3s ease-in-out infinite; }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(90deg, #ff4b1f, #ff9068);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(139,0,0,0.7)),
                        url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=2074&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>

    <script>
        // Dropdown toggle
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            menu.classList.toggle('hidden');
        }

        // Close dropdown outside
        document.addEventListener('click', function (e) {
            const menu = document.getElementById('dropdownMenu');
            const btn = document.getElementById('accessBtn');
            if (menu && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // Scroll animations
        document.addEventListener("DOMContentLoaded", () => {
            const elements = document.querySelectorAll(".scroll-animate, .fade-in");
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add("show", "visible");
                });
            }, { threshold: 0.2 });
            elements.forEach(el => observer.observe(el));
        });
    </script>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- 🌐 Navbar -->
    <nav class="fixed top-0 left-0 w-full navbar-blur shadow-md z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/bfp.jpg') }}" alt="BFP Logo" class="w-10 h-10 rounded-full shadow-md">
                <h1 class="text-2xl font-bold gradient-text tracking-tight">
                    Smart Fire Detection
                </h1>
            </div>

            <!-- Access Dropdown -->
            <div class="relative">
                <button id="accessBtn" onclick="toggleDropdown()"
                        class="bg-red-700 hover:bg-red-800 text-white px-5 py-2 rounded-lg font-medium transition glow-hover flex items-center">
                    <i class="fas fa-user-shield mr-2"></i> Access
                    <i class="fas fa-chevron-down ml-2 text-xs"></i>
                </button>

                <div id="dropdownMenu"
                     class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-100 rounded-lg shadow-lg transition-all duration-200 overflow-hidden z-50">
                    <a href="{{ route('admin.login') }}" class="block px-4 py-2 text-sm hover:bg-red-50 transition flex items-center">
                        🔑 Admin Login
                    </a>
                    <a href="{{ route('staff.login') }}" class="block px-4 py-2 text-sm hover:bg-red-50 border-t transition flex items-center">
                        👷 Staff Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- 🏠 Hero Section -->
    <section class="hero-bg flex flex-col justify-center items-center text-center min-h-screen px-6 text-white fade-in">
        <div class="floating mb-6">
            <div class="w-20 h-20 bg-red-500/30 rounded-full flex items-center justify-center mx-auto">
                <i class="fas fa-fire-flame-curved text-4xl"></i>
            </div>
        </div>
        <h2 class="text-5xl md:text-6xl font-extrabold mb-4">Smart Fire Detection System</h2>
        <p class="max-w-2xl text-lg md:text-xl text-gray-200 mb-8">
            Empowering the Bureau of Fire Protection - Koronadal with IoT-based detection and intelligent fire response mapping.
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="#features" class="px-8 py-3 bg-red-600 hover:bg-red-700 rounded-lg font-semibold glow-hover">
                <i class="fas fa-info-circle mr-2"></i> Learn More
            </a>
            <a href="#contact" class="px-8 py-3 bg-white/20 hover:bg-white/30 rounded-lg font-semibold backdrop-blur-sm">
                <i class="fas fa-phone-alt mr-2"></i> Contact Us
            </a>
        </div>
    </section>

    <!-- ⚙️ Features -->
    <section id="features" class="py-24 bg-gray-50 fade-in">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h3 class="text-4xl font-bold text-red-700 mb-8">Advanced Fire Protection Features</h3>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-8 bg-gradient-to-br from-red-500 to-red-600 text-white rounded-2xl shadow-lg hover:from-red-600 hover:to-red-700 transition-all scroll-animate">
                    <i class="fas fa-satellite-dish text-3xl mb-4"></i>
                    <h4 class="text-2xl font-semibold mb-2">IoT Detection</h4>
                    <p>Real-time fire alerts powered by interconnected IoT sensors strategically deployed across the city.</p>
                </div>
                <div class="p-8 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all scroll-animate">
                    <i class="fas fa-map-marked-alt text-3xl mb-4"></i>
                    <h4 class="text-2xl font-semibold mb-2">Smart Mapping</h4>
                    <p>Instantly visualize fire alerts on an interactive map with live tracking and optimal response routing.</p>
                </div>
                <div class="p-8 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-2xl shadow-lg hover:from-green-600 hover:to-green-700 transition-all scroll-animate">
                    <i class="fas fa-shield-alt text-3xl mb-4"></i>
                    <h4 class="text-2xl font-semibold mb-2">Secure Access</h4>
                    <p>Role-based dashboards for Admins and Staff with robust authentication and encrypted data handling.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 📞 Contact -->
    <section id="contact" class="py-24 bg-gradient-to-r from-gray-100 to-red-100 fade-in">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h3 class="text-4xl font-bold text-red-700 mb-6">Contact Us</h3>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                Need assistance or want to learn more about our Smart Fire Detection System? Reach out to us anytime.
            </p>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-md scroll-animate">
                    <i class="fas fa-envelope text-red-600 text-2xl mb-3"></i>
                    <h4 class="font-semibold text-gray-800 mb-1">Email</h4>
                    <a href="mailto:support@bfp-koronadal.gov.ph" class="text-red-600 hover:underline text-sm">
                        support@bfp-koronadal.gov.ph
                    </a>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md scroll-animate">
                    <i class="fas fa-phone-alt text-red-600 text-2xl mb-3"></i>
                    <h4 class="font-semibold text-gray-800 mb-1">Phone</h4>
                    <p class="text-gray-700 text-sm">(083) 228-1234</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md scroll-animate">
                    <i class="fas fa-map-marker-alt text-red-600 text-2xl mb-3"></i>
                    <h4 class="font-semibold text-gray-800 mb-1">Address</h4>
                    <p class="text-gray-700 text-sm">BFP Koronadal, South Cotabato</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ⚫ Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 fade-in">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-fire text-white text-sm"></i>
                </div>
                <span class="text-white font-semibold">BFP Smart Fire Detection</span>
            </div>
            <div class="text-center md:text-right">
                <p class="text-sm">&copy; {{ date('Y') }} Bureau of Fire Protection - Koronadal | All Rights Reserved</p>
                <p class="text-xs mt-1">Protecting our community through innovation and technology</p>
            </div>
        </div>
    </footer>

</body>
</html>
