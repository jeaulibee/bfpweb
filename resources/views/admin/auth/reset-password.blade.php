<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
      overflow-x: hidden;
    }

    .container {
      display: flex;
      width: 900px;
      height: 550px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      border-radius: 20px;
      overflow: hidden;
      animation: fadeIn 0.8s ease-out;
    }

    .left-panel {
      flex: 1;
      background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
      color: white;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .left-panel::before {
      content: '';
      position: absolute;
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      top: -100px;
      right: -100px;
    }

    .left-panel::after {
      content: '';
      position: absolute;
      width: 200px;
      height: 200px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      bottom: -80px;
      left: -80px;
    }

    .left-panel h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      position: relative;
      z-index: 1;
    }

    .left-panel p {
      font-size: 1.1rem;
      line-height: 1.6;
      opacity: 0.9;
      position: relative;
      z-index: 1;
    }

    .icon-container {
      display: flex;
      gap: 20px;
      margin-top: 30px;
      position: relative;
      z-index: 1;
    }

    .icon {
      width: 50px;
      height: 50px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .icon:hover {
      transform: translateY(-5px);
      background: rgba(255, 255, 255, 0.3);
    }

    .card {
      flex: 1;
      background: white;
      padding: 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
    }

    .logo {
      position: absolute;
      top: 30px;
      right: 30px;
      font-weight: bold;
      font-size: 1.2rem;
      color: #d32f2f;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 1.5rem;
      font-size: 2rem;
    }

    .email-display {
      background: #f9f9f9;
      padding: 12px 15px;
      border-radius: 8px;
      margin-bottom: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-left: 4px solid #d32f2f;
    }

    .email-display i {
      color: #d32f2f;
      margin-right: 10px;
    }

    .form-group {
      position: relative;
      margin-bottom: 20px;
    }

    .form-group i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
      transition: all 0.3s ease;
      z-index: 2;
    }

    .form-group .toggle-password {
      left: auto;
      right: 15px;
      cursor: pointer;
    }

    input[type="password"] {
      width: 100%;
      padding: 15px 45px;
      border: 2px solid #eee;
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    input[type="password"]:focus {
      border-color: #d32f2f;
      box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
      outline: none;
    }

    input[type="password"]:focus + i:not(.toggle-password) {
      color: #d32f2f;
    }

    button {
      width: 100%;
      background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
      border: none;
      padding: 15px;
      color: #fff;
      border-radius: 10px;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
      position: relative;
      overflow: hidden;
      margin-top: 10px;
    }

    button:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    }

    button:active {
      transform: translateY(0);
    }

    button::after {
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

    button:focus:not(:active)::after {
      animation: ripple 1s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
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

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        height: auto;
        width: 100%;
      }
      
      .left-panel {
        padding: 30px;
      }
      
      .card {
        padding: 30px 25px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left-panel">
      <h1>Create New Password</h1>
      <p>Your new password must be different from previously used passwords. Make sure it's strong and secure to protect your account.</p>
      <div class="icon-container">
        <div class="icon">
          <i class="fas fa-lock fa-lg"></i>
        </div>
        <div class="icon">
          <i class="fas fa-shield-alt fa-lg"></i>
        </div>
        <div class="icon">
          <i class="fas fa-key fa-lg"></i>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="logo">SecureAuth</div>
      <h2>Reset Password</h2>
      
      <div class="email-display">
        <i class="fas fa-envelope"></i>
        <span id="userEmail">{{ $email }}</span>
      </div>
      
      <form method="POST" action="{{ route('password.resetPassword') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        
        <div class="form-group">
          <input type="password" name="password" id="password" placeholder="New Password" required>
          <i class="fas fa-lock"></i>
          <i class="fas fa-eye toggle-password" id="togglePassword"></i>
        </div>
        
        <div class="form-group">
          <input type="password" name="password_confirmation" id="confirmPassword" placeholder="Confirm Password" required>
          <i class="fas fa-lock"></i>
          <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"></i>
        </div>
        
        <button type="submit">Reset Password</button>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const togglePassword = document.getElementById('togglePassword');
      const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
      const passwordInput = document.getElementById('password');
      const confirmPasswordInput = document.getElementById('confirmPassword');
      
      // Toggle password visibility
      togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
      
      toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    });
  </script>
</body>
</html>