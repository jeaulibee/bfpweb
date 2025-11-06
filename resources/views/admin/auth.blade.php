<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Fire Detection System - Authentication</title>
    
    <!-- TailwindCSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Toastify CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <style>
        :root {
            --primary-color: #dc2626; /* red-600 */
            --secondary-color: #ef4444; /* red-500 */
            --black: #000000;
            --white: #ffffff;
            --gray: #f3f4f6; /* gray-100 */
            --gray-2: #6b7280; /* gray-500 */
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .nav-link { @apply hover:text-red-600 transition-colors; }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .auth-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .auth-row {
            display: flex;
            flex-wrap: wrap;
            height: 100vh;
        }

        .auth-col {
            width: 50%;
            height: 100vh;
        }

        .align-items-center {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .flex-col {
            flex-direction: column;
        }

        .form-wrapper {
            width: 100%;
            max-width: 28rem;
            padding: 2rem;
        }

        .form {
            padding: 2rem;
            background-color: var(--white);
            border-radius: 1.5rem;
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 40px;
            transform: scale(0);
            transition: .5s ease-in-out;
            transition-delay: 0.8s;
        }

        .input-group {
            position: relative;
            width: 100%;
            margin: 1.5rem 0;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: var(--gray-2);
            transition: all 0.3s ease;
        }

        .input-group input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            background-color: var(--gray);
            border-radius: .75rem;
            border: 0.125rem solid var(--white);
            outline: none;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border: 0.125rem solid var(--primary-color);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .input-group input:focus + i {
            color: var(--primary-color);
        }

        .form button {
            cursor: pointer;
            width: 100%;
            padding: 1rem 0;
            border-radius: .75rem;
            border: none;
            background-color: var(--primary-color);
            color: var(--white);
            font-size: 1.1rem;
            font-weight: 600;
            outline: none;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .form button:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.3);
        }

        .form p {
            margin: 1.5rem 0;
            font-size: 0.9rem;
            color: var(--gray-2);
        }

        .pointer {
            cursor: pointer;
            color: var(--primary-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pointer:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .content-row {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 6;
            width: 100%;
            height: 100%;
        }

        .auth-text {
            margin: 2rem;
            color: var(--white);
            z-index: 10;
        }

        .auth-text h2 {
            font-size: 3rem;
            font-weight: 800;
            margin: 1.5rem 0;
            transition: 1s ease-in-out;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .auth-text p {
            font-weight: 500;
            transition: 1s ease-in-out;
            transition-delay: .2s;
            font-size: 1.2rem;
            max-width: 500px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .auth-img {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 1s ease-in-out;
            transition-delay: .4s;
        }

        .auth-img i {
            font-size: 12rem;
            color: var(--white);
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.3));
        }

        .text-login h2,
        .text-login p,
        .img-login {
            transform: translateX(-250%);
        }

        .text-register h2,
        .text-register p,
        .img-register {
            transform: translateX(250%);
        }

        .auth-container.login .form.login,
        .auth-container.register .form.register {
            transform: scale(1);
        }

        .auth-container.login .text-login h2,
        .auth-container.login .text-login p,
        .auth-container.login .img-login,
        .auth-container.register .text-register h2,
        .auth-container.register .text-register p,
        .auth-container.register .img-register {
            transform: translateX(0);
        }

        /* BACKGROUND */
        .auth-container::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            height: 100vh;
            width: 300vw;
            transform: translate(35%, 0);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            transition: 1s ease-in-out;
            z-index: 5;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 40px;
            border-bottom-right-radius: max(50vw, 50vh);
            border-top-left-radius: max(50vw, 50vh);
        }

        .auth-container.login::before {
            transform: translate(0, 0);
            right: 50%;
        }

        .auth-container.register::before {
            transform: translate(100%, 0);
            right: 50%;
        }

        /* Hide header and footer for fullscreen effect */
        header, footer {
            display: none;
        }

        /* RESPONSIVE */
        @media only screen and (max-width: 768px) {
            .auth-container::before,
            .auth-container.login::before,
            .auth-container.register::before {
                height: 100vh;
                border-bottom-right-radius: 0;
                border-top-left-radius: 0;
                z-index: 0;
                transform: none;
                right: 0;
            }

            .content-row {
                align-items: flex-start !important;
            }

            .auth-col {
                width: 100%;
                position: absolute;
                padding: 1rem;
                background-color: var(--white);
                border-top-left-radius: 2rem;
                border-top-right-radius: 2rem;
                transform: translateY(100%);
                transition: 1s ease-in-out;
                z-index: 10;
                height: auto;
                min-height: 70vh;
            }

            .auth-row {
                align-items: flex-end;
                justify-content: flex-end;
            }

            .form {
                box-shadow: none;
                margin: 0;
                padding: 1.5rem;
            }

            .auth-text {
                margin: 1rem;
            }

            .auth-text p {
                display: none;
            }

            .auth-text h2 {
                margin: .5rem;
                font-size: 2.2rem;
            }
            
            .auth-img i {
                font-size: 8rem;
            }
            
            .auth-container.login .auth-col.login,
            .auth-container.register .auth-col.register {
                transform: translateY(0);
            }
        }

        /* Back to home button */
        .back-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 20;
        }

        .back-home button {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .back-home button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 320px;
            background-color: white;
            color: #555;
            border: 1px solid #ddd;
            border-radius: 50px;
            padding: 10px 15px;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }

        .google-btn:hover {
            background-color: #f5f5f5;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        .google-icon-wrapper {
            background-color: white;
            border-radius: 50%;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .google-icon {
            width: 24px;
            height: 24px;
        }

        .btn-text {
            color: #444;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Back to Home Button -->
    <div class="back-home">
        <button onclick="window.location.href='{{ route('landing') }}';">
            <i class="fas fa-arrow-left"></i>
            Back to Home
        </button>
    </div>

    <!-- Full Screen Auth Container -->
    <div id="authContainer" class="auth-container login">
        <!-- FORM SECTION -->
        <div class="auth-row">
            <!-- REGISTER -->
            <div class="auth-col align-items-center flex-col register">
                <div class="form-wrapper align-items-center">
                    <form method="POST" action="{{ route('admin.register.submit') }}" class="form register">
                        @csrf
                        <div class="flex items-center justify-center mb-6">
                            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-fire text-white"></i>
                            </div>
                            <h1 class="text-xl font-bold text-red-700">Smart Fire Detection</h1>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Create Account</h3>
                        <p class="text-gray-600 mb-6">Join our fire safety network</p>
                        
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" placeholder="Full Name" required>
                        </div>
                        <div class="input-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                        </div>
                        <button type="submit">Register</button>
                        <p>
                            <span>
                                Already have an account?
                            </span>
                            <b onclick="toggleAuth()" class="pointer">Login here</b>
                        </p>
                    </form>
                </div>
            </div>
            <!-- END REGISTER -->
            
            <!-- LOGIN -->
            <div class="auth-col align-items-center flex-col login">
                <div class="form-wrapper align-items-center">
                    <form method="POST" action="{{ route('admin.login.submit') }}" class="form login">
                        @csrf
                        <div class="flex items-center justify-center mb-6">
                            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-fire text-white"></i>
                            </div>
                            <h1 class="text-xl font-bold text-red-700">Smart Fire Detection</h1>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back</h3>
                        <p class="text-gray-600 mb-6">Login to your account</p>
                        
                        <div class="input-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="remember">
                                <span>Remember Me</span>
                            </label>
                           <a href="{{ route('forgot.password.form') }}" class="nav-link">Forgot Password?</a>
                        </div>
                         <!-- PLACE GOOGLE LOGIN BUTTON HERE -->
                        <div class="mb-4">
                            <a href="{{ route('google.redirect.admin') }}" class="google-btn">
                                <div class="google-icon-wrapper">
                                    <img class="google-icon" src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" />
                                </div>
                                <span class="btn-text">Continue with Google</span>
                            </a>
                        </div>
                        <!-- END GOOGLE LOGIN BUTTON -->
                        <button type="submit">Login</button>
                        <p>
                            <span>Don't have an account?</span>
                            <b onclick="toggleAuth()" class="pointer">Register here</b>
                        </p>
                    </form>
                </div>
            </div>
            <!-- END LOGIN -->
        </div>
        <!-- END FORM SECTION -->
        
        <!-- CONTENT SECTION -->
        <div class="auth-row content-row">
            <!-- LOGIN CONTENT -->
            <div class="auth-col align-items-center flex-col">
                <div class="auth-text text-login">
                    <h2>Welcome Back</h2>
                    <p>
                        Login to access the Smart Fire Detection System and monitor safety alerts in real-time. Protect your community with our advanced fire detection technology.
                    </p>
                </div>
                <div class="auth-img img-login">
                    <i class="fas fa-fire-extinguisher"></i>
                </div>
            </div>
            <!-- END LOGIN CONTENT -->
            
            <!-- REGISTER CONTENT -->
            <div class="auth-col align-items-center flex-col">
                <div class="auth-img img-register">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="auth-text text-register">
                    <h2>Join With Us</h2>
                    <p>
                        Create an account to get started with our advanced fire detection and alert system. Together, we can build a safer community.
                    </p>
                </div>
            </div>
            <!-- END REGISTER CONTENT -->
        </div>
        <!-- END CONTENT SECTION -->
    </div>

    <script>
        // Auth toggle function
        let authContainer = document.getElementById('authContainer');
        function toggleAuth() {
            authContainer.classList.toggle('login');
            authContainer.classList.toggle('register');
        }
        setTimeout(() => {
            authContainer.classList.add('login');
        }, 100);

        // Toast function
        function showToast(message, type = "info") {
            let bgColor = "#333";
            if (type === "success") bgColor = "#16a34a"; // green
            if (type === "error") bgColor = "#dc2626";   // red
            if (type === "warning") bgColor = "#f59e0b"; // yellow

            Toastify({
                text: message,
                duration: 3000,
                gravity: "top", // top or bottom
                position: "right", // left, center or right
                backgroundColor: bgColor,
                close: true,
                stopOnFocus: true,
                style: {
                    borderRadius: "10px",
                    fontWeight: "500",
                    color: "#fff",
                    boxShadow: "0 3px 8px rgba(0,0,0,0.15)"
                }
            }).showToast();
        }

        // Laravel session messages (Blade)
        @if (session('success'))
            showToast("{{ session('success') }}", "success");
        @endif

        @if (session('error'))
            showToast("{{ session('error') }}", "error");
        @endif

        @if ($errors->any())
            showToast("{{ $errors->first() }}", "error");
        @endif
    </script>
</body>
</html>