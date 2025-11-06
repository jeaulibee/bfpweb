<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
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

    input[type="email"] {
      width: 100%;
      padding: 15px;
      margin: 10px 0;
      border: 2px solid #eee;
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    input[type="email"]:focus {
      border-color: #d32f2f;
      box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
      outline: none;
    }

    button {
      width: 100%;
      background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
      border: none;
      padding: 15px;
      color: #fff;
      border-radius: 10px;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(211, 47, 47, 0.3);
      position: relative;
      overflow: hidden;
    }

    button:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(211, 47, 47, 0.4);
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

    .back-link {
      text-align: center;
      display: block;
      margin-top: 15px;
      color: #d32f2f;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      position: relative;
      padding: 5px 0;
    }

    .back-link:hover {
      color: #b71c1c;
    }

    .back-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: #d32f2f;
      transition: all 0.3s ease;
    }

    .back-link:hover::after {
      width: 100%;
      left: 0;
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
      <h1>Reset Your Password</h1>
      <p>Enter your email address and we'll send you a One-Time Password (OTP) to reset your password and regain access to your account.</p>
      <div class="icon-container">
        <div class="icon">
          <i class="fas fa-shield-alt fa-lg"></i>
        </div>
        <div class="icon">
          <i class="fas fa-lock fa-lg"></i>
        </div>
        <div class="icon">
          <i class="fas fa-key fa-lg"></i>
        </div>
      </div>
    </div>
    
    <div class="card">
      <div class="logo">SecureAuth</div>
      <h2>Forgot Password</h2>
      <form method="POST" action="{{ route('password.sendOtp') }}">
        @csrf
        <input type="email" name="email" placeholder="Enter your Gmail" required>
        <button type="submit">Send OTP</button>
      </form>
      <a href="{{ route('admin.login') }}" class="back-link">Back to Login</a>
    </div>
  </div>
</body>
</html>