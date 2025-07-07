<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Platform Pelatihan ASN BKPSDM Surakarta</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Familjen+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        :root {
            /* Modern Color Palette - Matching hasil-registrasi.blade.php */
            --primary-color: #0f172a;
            --secondary-color: #3b82f6;
            --accent-color: #6366f1;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;

            /* Text Colors */
            --text-color: #1e293b;
            --text-light: #64748b;
            --text-muted: #94a3b8;

            /* Background Colors */
            --bg-white: #ffffff;
            --bg-primary: #f8fafc;
            --bg-secondary: #f1f5f9;

            /* Border Colors */
            --border-light: #e2e8f0;
            --border-color: #cbd5e1;

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            --gradient-accent: linear-gradient(135deg, var(--secondary-color) 0%, var(--accent-color) 100%);
            --overlay-dark: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(30, 41, 59, 0.9) 100%);

            /* Transitions */
            --transition-fast: all 0.15s ease;
            --transition-normal: all 0.3s ease;
            --transition-slow: all 0.5s ease;

            /* Container */
            --container-width: 1200px;
            --header-height: 80px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background: var(--bg-primary);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Dramatic Background */
        .login-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('images/balkot.jpg') }}') center/cover no-repeat;
            z-index: 0;
        }

        .login-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.4) 0%, rgba(30, 41, 59, 0.5) 100%);
            z-index: 1;
        }

        .login-background::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 70%, rgba(59, 130, 246, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 70% 30%, rgba(99, 102, 241, 0.1) 0%, transparent 50%);
            z-index: 2;
        }

        /* Animated Background Elements */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 3;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.3;
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
                opacity: 0.6;
            }
        }

        /* Main Container */
        .login-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-container {
            width: 100%;
            max-width: 480px;
            position: relative;
        }

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-xl);
            backdrop-filter: blur(20px);
            padding: 3rem;
            position: relative;
            overflow: hidden;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.8s ease forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-container {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .logo-container::after {
            content: '';
            position: absolute;
            inset: -8px;
            background: var(--gradient-accent);
            border-radius: 50%;
            opacity: 0.2;
            z-index: -1;
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.2;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.1;
            }
        }

        .logo-image {
            height: 100px;
            width: auto;
            object-fit: contain;
            border-radius: 1rem;
            /* box-shadow: var(--shadow-md);
            background: var(--bg-white); */
            padding: 0.5rem;
        }

        .login-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--text-light);
            font-size: 1rem;
            margin: 0;
        }

        /* Form Styles */
        .login-form {
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            color: var(--text-color);
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-label i {
            font-size: 1rem;
            color: var(--secondary-color);
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--border-light);
            border-radius: 0.75rem;
            font-size: 1rem;
            transition: var(--transition-normal);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: var(--bg-white);
            transform: translateY(-1px);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1.125rem;
            z-index: 2;
            transition: var(--transition-normal);
        }

        .form-control:focus+.input-icon {
            color: var(--secondary-color);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            font-size: 1.125rem;
            z-index: 2;
            transition: var(--transition-normal);
        }

        .password-toggle:hover {
            color: var(--secondary-color);
        }

        /* reCAPTCHA Styling */
        .captcha-wrapper {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: center;
        }

        .g-recaptcha {
            transform: scale(0.9);
            transform-origin: center;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 0.75rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-danger::before {
            content: '\f071';
            font-family: 'Bootstrap Icons';
            font-size: 1.125rem;
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .invalid-feedback::before {
            content: '\f33a';
            font-family: 'Bootstrap Icons';
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: var(--gradient-accent);
            color: var(--bg-white);
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition-normal);
            position: relative;
            overflow: hidden;
            margin-top: 1rem;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Loading State */
        .btn-loading {
            position: relative;
        }

        .btn-loading .btn-text {
            opacity: 0;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Footer Info */
        .login-footer {
            margin-top: 2rem;
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-light);
        }

        .footer-text {
            color: var(--text-light);
            font-size: 0.875rem;
            margin: 0;
        }

        .footer-links {
            margin-top: 1rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .footer-link {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition-normal);
        }

        .footer-link:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-wrapper {
                padding: 1rem;
            }

            .login-card {
                padding: 2rem 1.5rem;
                border-radius: 1.25rem;
            }

            .login-title {
                font-size: 2rem;
            }

            .logo-image {
                height: 80px;
            }

            .g-recaptcha {
                transform: scale(0.8);
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem 1rem;
                margin: 0.5rem;
            }

            .login-title {
                font-size: 1.75rem;
            }

            .form-control {
                padding-left: 2.5rem;
            }

            .g-recaptcha {
                transform: scale(0.75);
            }

            .footer-links {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Dramatic Background -->
    <div class="login-background"></div>

    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <!-- Main Login Wrapper -->
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-card">
                <!-- Logo Section -->
                <div class="logo-section">
                    <div class="logo-container">
                        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/3d7d95f3e27be9563e72c788b4df012492ef3a2d?placeholderIfAbsent=true"
                            alt="BKPSDM Surakarta" class="logo-image"
                            onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iNTAiIGN5PSI1MCIgcj0iNTAiIGZpbGw9IiMzYjgyZjYiLz48dGV4dCB4PSI1MCIgeT0iNTUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxOCIgZmlsbD0id2hpdGUiIHRleHQtYW5jaG9yPSJtaWRkbGUiPkJLUFNETTwvdGV4dD48L3N2Zz4='; this.alt='BKPSDM Logo';" />
                    </div>
                    <h1 class="login-title">Platform Pelatihan ASN</h1>
                    <p class="login-subtitle">BKPSDM Kota Surakarta</p>
                </div>

                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="alert alert-danger" id="errorAlert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login.pelatihan.post') }}" class="login-form" id="loginForm">
                    @csrf

                    <!-- Email/NIP Field -->
                    <div class="form-group">
                        <label for="login" class="form-label">
                            <i class="bi bi-person-circle"></i>
                            Email atau NIP
                        </label>
                        <div class="input-wrapper">
                            <input type="text" class="form-control" id="login" name="login" required autofocus
                                placeholder="Masukkan email atau NIP Anda" value="{{ old('login') }}">
                            <i class="bi bi-person input-icon"></i>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-shield-lock"></i>
                            Password
                        </label>
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Masukkan password Anda">
                            <i class="bi bi-lock input-icon"></i>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- reCAPTCHA Field -->
                    <div class="form-group">
                        <div class="captcha-wrapper">
                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                        </div>
                        @if ($errors->has('g-recaptcha-response'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="btn-text">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Masuk ke Platform
                        </span>
                    </button>
                </form>

                <!-- Footer -->
                <div class="login-footer">
                    <p class="footer-text">
                        © 2025 BKPSDM Kota Surakarta. Hak cipta dilindungi.
                    </p>
                    <div class="footer-links">
                        <a href="#" class="footer-link">Bantuan</a>
                        <a href="#" class="footer-link">Kebijakan Privasi</a>
                        <a href="#" class="footer-link">Kontak</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');

            if (togglePassword && passwordField) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);

                    const icon = this.querySelector('i');
                    icon.classList.toggle('bi-eye');
                    icon.classList.toggle('bi-eye-slash');
                });
            }

            // Form submission with loading state
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');

            if (loginForm && submitBtn) {
                loginForm.addEventListener('submit', function(e) {
                    // Add loading state
                    submitBtn.classList.add('btn-loading');
                    submitBtn.disabled = true;

                    // Check reCAPTCHA
                    const recaptchaResponse = grecaptcha.getResponse();
                    if (!recaptchaResponse) {
                        e.preventDefault();
                        showAlert('Silakan verifikasi bahwa Anda bukan robot.', 'danger');
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.disabled = false;
                        return false;
                    }
                });
            }

            // Enhanced input focus effects
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Auto-hide error alerts
            const errorAlert = document.getElementById('errorAlert');
            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.opacity = '0';
                    errorAlert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        errorAlert.style.display = 'none';
                    }, 300);
                }, 5000);
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Enter key on login field focuses password
                if (e.key === 'Enter' && e.target.id === 'login') {
                    e.preventDefault();
                    passwordField.focus();
                }
            });

            // Background image fallback
            const loginBg = document.querySelector('.login-background');
            const img = new Image();
            img.onload = function() {
                loginBg.style.backgroundImage = `url('{{ asset('images/balkot.jpg') }}')`;
            };
            img.onerror = function() {
                // Fallback to gradient if image fails to load
                loginBg.style.background = 'linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%)';
            };
            img.src = '{{ asset('images/balkot.jpg') }}';
        });

        // Alert function
        function showAlert(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.textContent = message;

            const form = document.querySelector('.login-form');
            form.insertBefore(alertDiv, form.firstChild);

            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Enhanced form validation
        function validateForm() {
            const login = document.getElementById('login').value.trim();
            const password = document.getElementById('password').value;

            if (!login) {
                showAlert('Email atau NIP harus diisi.', 'danger');
                return false;
            }

            if (login.includes('@')) {
                // Email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(login)) {
                    showAlert('Format email tidak valid.', 'danger');
                    return false;
                }
            } else {
                // NIP validation (assuming 18 digits)
                if (!/^\d{18}$/.test(login)) {
                    showAlert('NIP harus berupa 18 digit angka.', 'danger');
                    return false;
                }
            }

            if (password.length < 6) {
                showAlert('Password minimal 6 karakter.', 'danger');
                return false;
            }

            return true;
        }

        // Smooth animations for interactive elements
        function addRippleEffect(e) {
            const button = e.currentTarget;
            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            button.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        }

        // Add ripple effect to submit button
        document.getElementById('submitBtn')?.addEventListener('click', addRippleEffect);
    </script>

    <style>
        /* Ripple effect */
        .btn-submit {
            position: relative;
            overflow: hidden;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</body>

</html>
