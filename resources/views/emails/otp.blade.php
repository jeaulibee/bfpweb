<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BFP OTP Verification</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, #0c0c0c 0%, #2c2c2c 100%);
      font-family: 'Segoe UI', 'Montserrat', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 60px 20px;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .email-container {
      max-width: 700px;
      margin: 0 auto;
      background: linear-gradient(165deg, #ffffff 0%, #f8f9fa 100%);
      border-radius: 25px;
      overflow: hidden;
      box-shadow: 
        0 25px 60px rgba(179, 0, 0, 0.25),
        0 15px 35px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
      animation: slideUp 0.8s cubic-bezier(0.23, 1, 0.32, 1);
      position: relative;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .email-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #b30000, #ff4444, #b30000);
      z-index: 10;
    }

    .header {
      background: linear-gradient(145deg, #b30000 0%, #8b0000 50%, #660000 100%);
      color: white;
      text-align: center;
      padding: 50px 40px;
      position: relative;
      overflow: hidden;
      clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
    }

    .header::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: float 6s ease-in-out infinite;
    }

    .header-content {
      position: relative;
      z-index: 2;
    }

    .logo-badge {
      width: 120px;
      height: 120px;
      margin: 0 auto 25px;
      background: linear-gradient(135deg, #ffffff 0%, #ffe6e6 100%);
      border-radius: 50%;
      padding: 8px;
      box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.3),
        inset 0 2px 0 rgba(255, 255, 255, 0.8);
      border: 3px solid rgba(255, 255, 255, 0.5);
      transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .logo-badge:hover {
      transform: scale(1.08) rotate(5deg);
      box-shadow: 
        0 20px 45px rgba(0, 0, 0, 0.4),
        inset 0 2px 0 rgba(255, 255, 255, 0.9);
    }

    .logo-badge img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #b30000;
    }

    .header h1 {
      font-size: 2.8rem;
      margin-bottom: 12px;
      font-weight: 800;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
      letter-spacing: -0.5px;
    }

    .header p {
      font-size: 1.3rem;
      opacity: 0.95;
      font-weight: 300;
      letter-spacing: 0.5px;
    }

    .content {
      padding: 60px 50px;
      text-align: center;
      background: #ffffff;
      position: relative;
    }

    .content::before {
      content: '';
      position: absolute;
      top: -2px;
      left: 5%;
      right: 5%;
      height: 3px;
      background: linear-gradient(90deg, transparent, #b30000, transparent);
      border-radius: 3px;
    }

    .verification-title {
      color: #b30000;
      font-size: 2.4rem;
      margin-bottom: 30px;
      font-weight: 700;
      position: relative;
      display: inline-block;
    }

    .verification-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 25%;
      right: 25%;
      height: 3px;
      background: linear-gradient(90deg, transparent, #b30000, transparent);
      border-radius: 3px;
    }

    .content p {
      color: #444;
      font-size: 1.2rem;
      line-height: 1.7;
      margin-bottom: 25px;
      max-width: 550px;
      margin-left: auto;
      margin-right: auto;
    }

    .otp-section {
      margin: 45px 0;
      position: relative;
    }

    .otp-badge {
      position: absolute;
      top: -15px;
      left: 50%;
      transform: translateX(-50%);
      background: #b30000;
      color: white;
      padding: 8px 25px;
      border-radius: 25px;
      font-size: 0.9rem;
      font-weight: 600;
      box-shadow: 0 5px 15px rgba(179, 0, 0, 0.3);
      z-index: 2;
    }

    .otp-display {
      font-size: 3.5rem;
      letter-spacing: 15px;
      background: linear-gradient(145deg, #ffffff 0%, #fff5f5 100%);
      display: inline-block;
      padding: 35px 50px;
      border-radius: 20px;
      color: #b30000;
      font-weight: 900;
      margin: 20px 0;
      border: 2px solid #ffe6e6;
      box-shadow: 
        0 15px 35px rgba(179, 0, 0, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.8);
      position: relative;
      overflow: hidden;
      transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
      font-family: 'Courier New', monospace;
    }

    .otp-display::before {
      content: '';
      position: absolute;
      top: 0;
      left: -150%;
      width: 150%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
      transform: skewX(-25deg);
      transition: left 1s;
    }

    .otp-display:hover::before {
      left: 150%;
    }

    .otp-display:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 
        0 25px 50px rgba(179, 0, 0, 0.25),
        inset 0 1px 0 rgba(255, 255, 255, 0.9);
    }

    .timer-section {
      background: linear-gradient(145deg, #fff5f5 0%, #ffe6e6 100%);
      padding: 25px;
      border-radius: 18px;
      margin: 40px 0;
      border-left: 5px solid #b30000;
      box-shadow: 0 8px 25px rgba(179, 0, 0, 0.1);
    }

    .timer {
      font-size: 1.4rem;
      color: #b30000;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }

    .timer i {
      animation: pulseGlow 2s ease-in-out infinite;
    }

    .security-section {
      background: linear-gradient(145deg, #f0f8ff 0%, #e6f2ff 100%);
      padding: 30px;
      border-radius: 18px;
      margin: 40px 0;
      border-left: 5px solid #007bff;
      box-shadow: 0 8px 25px rgba(0, 123, 255, 0.1);
      text-align: left;
    }

    .security-header {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 20px;
    }

    .security-header i {
      font-size: 1.8rem;
      color: #007bff;
      background: white;
      padding: 12px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
    }

    .security-header h4 {
      color: #007bff;
      font-size: 1.4rem;
      font-weight: 700;
    }

    .security-list {
      list-style: none;
      padding: 0;
    }

    .security-list li {
      color: #444;
      margin-bottom: 15px;
      padding-left: 35px;
      position: relative;
      line-height: 1.6;
      font-size: 1.1rem;
    }

    .security-list li::before {
      content: '✓';
      position: absolute;
      left: 0;
      top: 0;
      color: #007bff;
      font-weight: 900;
      font-size: 1.1rem;
      background: white;
      width: 25px;
      height: 25px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 3px 10px rgba(0, 123, 255, 0.2);
    }

    .action-section {
      margin: 50px 0 30px;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      background: linear-gradient(145deg, #b30000 0%, #8b0000 100%);
      color: white;
      padding: 18px 40px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 700;
      font-size: 1.2rem;
      margin: 0 12px;
      transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
      box-shadow: 
        0 10px 25px rgba(179, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
      border: none;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 
        0 15px 35px rgba(179, 0, 0, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
    }

    .btn-secondary {
      background: linear-gradient(145deg, #2c3e50 0%, #34495e 100%);
      box-shadow: 0 10px 25px rgba(44, 62, 80, 0.3);
    }

    .btn-secondary:hover {
      box-shadow: 0 15px 35px rgba(44, 62, 80, 0.4);
    }

    .footer {
      background: linear-gradient(145deg, #1a1a1a 0%, #2d2d2d 100%);
      color: #ecf0f1;
      padding: 50px 40px 30px;
      text-align: center;
      clip-path: polygon(0 10%, 100% 0, 100% 100%, 0 100%);
      margin-top: 40px;
    }

    .footer-content {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 40px;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
    }

    .footer-brand {
      display: flex;
      align-items: center;
      gap: 20px;
      text-align: left;
    }

    .footer-logo {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      border: 3px solid #b30000;
      padding: 3px;
      background: white;
    }

    .footer-logo img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
    }

    .footer-info h4 {
      color: #fff;
      font-size: 1.4rem;
      margin-bottom: 8px;
      font-weight: 700;
    }

    .footer-info p {
      color: #bbb;
      font-size: 1rem;
      line-height: 1.5;
    }

    .footer-copyright {
      grid-column: 1 / -1;
      margin-top: 30px;
      padding-top: 25px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      color: #999;
      font-size: 0.95rem;
    }

    /* Animations */
    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(40px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0) rotate(0deg);
      }
      50% {
        transform: translateY(-10px) rotate(180deg);
      }
    }

    @keyframes pulseGlow {
      0%, 100% {
        transform: scale(1);
        text-shadow: 0 0 10px rgba(179, 0, 0, 0.5);
      }
      50% {
        transform: scale(1.1);
        text-shadow: 0 0 20px rgba(179, 0, 0, 0.8);
      }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      body {
        padding: 30px 15px;
      }

      .email-container {
        margin: 0 10px;
      }

      .header {
        padding: 40px 25px;
      }

      .header h1 {
        font-size: 2.2rem;
      }

      .content {
        padding: 40px 25px;
      }

      .otp-display {
        font-size: 2.5rem;
        letter-spacing: 10px;
        padding: 25px 35px;
      }

      .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 25px;
      }

      .footer-brand {
        justify-content: center;
        text-align: center;
      }

      .btn {
        display: block;
        margin: 15px 0;
        width: 100%;
        max-width: 300px;
      }
    }

    @media (max-width: 480px) {
      .otp-display {
        font-size: 2rem;
        letter-spacing: 8px;
        padding: 20px 25px;
      }

      .header h1 {
        font-size: 1.8rem;
      }

      .verification-title {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <div class="header-content">
        <div class="logo-badge">
          <img src="{{ asset('public/images/bfp.jpg') }}" alt="BFP Logo">
        </div>
        <h1>Koronadal Bureau of Fire Protection</h1>
        <p>Smart Fire Detection & Mapping System</p>
      </div>
    </div>

    <div class="content">
      <h2 class="verification-title">
        <i class="fas fa-shield-alt"></i> SECURE OTP VERIFICATION
      </h2>
      
      <p>Your security is our priority. Use the verification code below to reset your password for the Smart Fire Detection & Mapping System:</p>

      <div class="otp-section">
        <div class="otp-badge">VERIFICATION CODE</div>
        <div class="otp-display">{{ $otp }}</div>
      </div>

      <div class="timer-section">
        <p class="timer">
          <i class="fas fa-clock"></i> 
          <span>This security code expires in <strong>10 minutes</strong></span>
        </p>
      </div>

      <div class="security-section">
        <div class="security-header">
          <i class="fas fa-user-shield"></i>
          <h4>SECURITY PROTOCOL</h4>
        </div>
        <ul class="security-list">
          <li>This OTP is strictly confidential - do not share with anyone</li>
          <li>BFP personnel will never request your verification code</li>
          <li>Single-use code - expires after first use or 10 minutes</li>
          <li>Immediately report any suspicious activity to system administrators</li>
        </ul>
      </div>

      <div class="action-section">
        <a href="#" class="btn">
          <i class="fas fa-key"></i> Reset Password Now
        </a>
        <a href="#" class="btn btn-secondary">
          <i class="fas fa-headset"></i> Contact Support
        </a>
      </div>

      <p style="margin-top: 35px; color: #666; font-size: 1rem; font-style: italic;">
        For your protection, this verification code will automatically expire after 10 minutes of issuance.
      </p>
    </div>

    <div class="footer">
      <div class="footer-content">
        <div class="footer-brand">
          <div class="footer-logo">
            <img src="{{ asset('public/images/bfp.jpg') }}" alt="BFP Logo">
          </div>
          <div class="footer-info">
            <h4>Koronadal Bureau of Fire Protection</h4>
            <p>Advanced Fire Safety & Emergency Response System</p>
          </div>
        </div>
        <div class="footer-copyright">
          &copy; {{ date('Y') }} Koronadal Bureau of Fire Protection. All rights reserved.<br>
          <strong>Dedicated to community safety through innovative fire protection technology.</strong>
        </div>
      </div>
    </div>
  </div>
</body>
</html>