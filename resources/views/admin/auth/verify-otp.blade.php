<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify OTP</title>
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
      text-align: center;
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
      color: #333;
      margin-bottom: 1rem;
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

    /* OTP Box Styles */
    .otp-container {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin: 25px 0;
    }

    .otp-box {
      width: 55px;
      height: 55px;
      border: 3px solid #e0e0e0;
      border-radius: 12px;
      font-size: 1.5rem;
      font-weight: bold;
      text-align: center;
      background: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .otp-box:focus {
      border-color: #d32f2f;
      box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.2);
      outline: none;
      transform: scale(1.05);
    }

    .otp-box.filled {
      border-color: #4CAF50;
      background-color: #f8fff8;
    }

    .otp-box.error {
      border-color: #d32f2f;
      background-color: #fff5f5;
      animation: vibrate 0.5s ease-in-out, glowRed 1.5s ease-in-out;
    }

    .otp-box.success {
      border-color: #4CAF50;
      background-color: #f8fff8;
    }

    .otp-success .otp-box {
      animation: wave 0.6s ease-in-out;
      animation-fill-mode: both;
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
      margin-top: 10px;
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

    .resend-btn {
      background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .resend-btn:hover {
      box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    }

    .disabled {
      background: #ccc !important;
      cursor: not-allowed !important;
      box-shadow: none !important;
    }

    .disabled:hover {
      transform: none !important;
      box-shadow: none !important;
    }

    .timer {
      margin-top: 10px;
      color: #666;
      font-size: 14px;
    }

    /* Animations */
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

    @keyframes vibrate {
      0%, 100% { transform: translateX(0); }
      10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
      20%, 40%, 60%, 80% { transform: translateX(3px); }
    }

    @keyframes glowRed {
      0%, 100% { box-shadow: 0 0 5px rgba(211, 47, 47, 0.5); }
      50% { box-shadow: 0 0 20px rgba(211, 47, 47, 0.8); }
    }

    @keyframes wave {
      0% { transform: translateY(0); }
      25% { transform: translateY(-8px); }
      50% { transform: translateY(0); }
      75% { transform: translateY(-4px); }
      100% { transform: translateY(0); }
    }

    /* Apply wave animation with delays for each box */
    .otp-success .otp-box:nth-child(1) { animation-delay: 0.1s; }
    .otp-success .otp-box:nth-child(2) { animation-delay: 0.2s; }
    .otp-success .otp-box:nth-child(3) { animation-delay: 0.3s; }
    .otp-success .otp-box:nth-child(4) { animation-delay: 0.4s; }
    .otp-success .otp-box:nth-child(5) { animation-delay: 0.5s; }
    .otp-success .otp-box:nth-child(6) { animation-delay: 0.6s; }

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
      
      .otp-box {
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left-panel">
      <h1>Verify Your Identity</h1>
      <p>Enter the 6-digit verification code that was sent to your email address. This code will expire in 3 minutes for security purposes.</p>
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
      <h2>Enter OTP</h2>
      
      <div class="email-display">
        <i class="fas fa-envelope"></i>
        <span id="userEmail">{{ $email }}</span>
      </div>
      
      <form method="POST" action="{{ route('password.verifyOtp') }}" id="otpForm">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="otp" id="otpValue">
        
        <div class="otp-container" id="otpContainer">
          <input type="text" class="otp-box" maxlength="1" data-index="0">
          <input type="text" class="otp-box" maxlength="1" data-index="1">
          <input type="text" class="otp-box" maxlength="1" data-index="2">
          <input type="text" class="otp-box" maxlength="1" data-index="3">
          <input type="text" class="otp-box" maxlength="1" data-index="4">
          <input type="text" class="otp-box" maxlength="1" data-index="5">
        </div>
        
        <button type="submit" id="verifyBtn">Verify</button>
      </form>

      <form id="resendForm" method="POST" action="{{ route('password.resendOtp') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <button id="resendBtn" class="resend-btn disabled" disabled>Resend OTP</button>
        <div id="timer" class="timer">You can resend after <span id="countdown">3:00</span></div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const otpBoxes = document.querySelectorAll('.otp-box');
      const otpValue = document.getElementById('otpValue');
      const otpContainer = document.getElementById('otpContainer');
      const verifyBtn = document.getElementById('verifyBtn');
      const otpForm = document.getElementById('otpForm');
      
      // 3 minutes countdown
      let remaining = 180;
      const countdown = document.getElementById('countdown');
      const resendBtn = document.getElementById('resendBtn');

      const interval = setInterval(() => {
        remaining--;
        const mins = Math.floor(remaining / 60);
        const secs = remaining % 60;
        countdown.textContent = `${mins}:${secs.toString().padStart(2, '0')}`;

        if (remaining <= 0) {
          clearInterval(interval);
          resendBtn.disabled = false;
          resendBtn.classList.remove('disabled');
          document.getElementById('timer').textContent = 'You can resend now.';
        }
      }, 1000);

      // OTP input handling
      otpBoxes.forEach((box, index) => {
        box.addEventListener('input', function() {
          // Auto-advance to next box
          if (this.value.length === 1 && index < otpBoxes.length - 1) {
            otpBoxes[index + 1].focus();
          }
          
          updateOtpValue();
          updateBoxStyles();
        });
        
        box.addEventListener('keydown', function(e) {
          // Handle backspace
          if (e.key === 'Backspace' && this.value === '' && index > 0) {
            otpBoxes[index - 1].focus();
          }
        });
        
        box.addEventListener('paste', function(e) {
          // Handle paste
          e.preventDefault();
          const pasteData = e.clipboardData.getData('text').slice(0, 6);
          pasteData.split('').forEach((char, i) => {
            if (otpBoxes[i]) {
              otpBoxes[i].value = char;
            }
          });
          updateOtpValue();
          updateBoxStyles();
          otpBoxes[Math.min(5, pasteData.length - 1)].focus();
        });
      });
      
      function updateOtpValue() {
        otpValue.value = Array.from(otpBoxes).map(box => box.value).join('');
      }
      
      function updateBoxStyles() {
        otpBoxes.forEach(box => {
          if (box.value) {
            box.classList.add('filled');
          } else {
            box.classList.remove('filled');
          }
        });
      }
      
      // Form submission with animation
      otpForm.addEventListener('submit', function(e) {
        const otp = otpValue.value;
        
        // Validate OTP length
        if (otp.length !== 6) {
          e.preventDefault();
          showErrorAnimation();
          return;
        }
        
        // Show success animation but don't prevent form submission
        showSuccessAnimation();
        // Let the form submit normally to your backend
        // The backend will handle the actual OTP validation
      });
      
      function showErrorAnimation() {
        // Add error class to all boxes
        otpBoxes.forEach(box => {
          box.classList.add('error');
        });
        
        // Remove error class after animation
        setTimeout(() => {
          otpBoxes.forEach(box => {
            box.classList.remove('error');
          });
        }, 1500);
      }
      
      function showSuccessAnimation() {
        // Add success class to container for wave animation
        otpContainer.classList.add('otp-success');
        
        // Add success class to individual boxes
        otpBoxes.forEach(box => {
          box.classList.add('success');
        });
        
        // Change button to show success
        verifyBtn.innerHTML = '<i class="fas fa-check"></i> Verifying...';
        verifyBtn.style.background = 'linear-gradient(135deg, #28a745 0%, #1e7e34 100%)';
        verifyBtn.disabled = true;
      }
    });
  </script>
</body>
</html>