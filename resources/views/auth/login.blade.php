<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - CNC System</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 450px;
        }

        .login-logo a {
            color: #fff;
            font-weight: bold;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            border: 0;
        }

        .login-card-body {
            border-radius: 15px;
            padding: 30px;
        }

        .login-box-msg {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #495057;
        }

        .form-control {
            border-radius: 8px;
            height: 45px;
            font-size: 0.95rem;
        }

        .input-group-text {
            border-radius: 0 8px 8px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: 0;
            border-radius: 8px;
            height: 45px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .test-accounts-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }

        .test-account-header {
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .test-account {
            cursor: pointer;
            padding: 12px 15px;
            border-radius: 8px;
            background: white;
            margin-bottom: 8px;
            transition: all 0.2s ease;
            font-size: 14px;
            border: 2px solid transparent;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .test-account:hover {
            background: #e8f4f8;
            border-color: #667eea;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
        }

        .test-account i {
            font-size: 1.2rem;
            width: 25px;
            text-align: center;
        }

        .test-account .role-name {
            font-weight: 600;
            color: #495057;
        }

        .test-account .email-text {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .role-badge {
            margin-left: auto;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        .alert {
            border-radius: 8px;
            border: 0;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider span {
            padding: 0 10px;
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .company-section {
            margin-bottom: 15px;
        }

        .company-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
            padding-left: 5px;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">

        <div class="login-logo mb-4">
            <a href="/">
                <i class="fas fa-industry"></i>
                <b>CNC</b> System
            </a>
        </div>

        <div class="card shadow-lg">
            <div class="card-body login-card-body">

                <p class="login-box-msg">
                    <i class="fas fa-lock mr-2"></i>
                    <strong>Sign in to your account</strong>
                </p>

                @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Error!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" id="email" name="email"
                            class="form-control"
                            placeholder="Email Address"
                            value="{{ old('email') }}" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password"
                            class="form-control"
                            placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-7">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-sign-in-alt"></i> Sign In
                            </button>
                        </div>
                    </div>
                </form>

                <div class="divider">
                    <span>Quick Test Login</span>
                </div>

                <div class="test-accounts-section">
                    <div class="test-account-header">
                        <i class="fas fa-vial mr-1"></i> Development Test Accounts
                    </div>

                    <!-- Super Admin -->
                    <div class="test-account" onclick="fillLogin('superadmin@cnc.com')">
                        <i class="fas fa-crown text-danger"></i>
                        <div style="flex: 1;">
                            <div class="role-name">Super Admin</div>
                            <div class="email-text">superadmin@cnc.com</div>
                        </div>
                        <span class="badge badge-danger role-badge">ADMIN</span>
                    </div>

                    <div class="divider mt-3 mb-2">
                        <span style="font-size: 0.75rem;">Company 1 (CNC)</span>
                    </div>

                    <!-- Company Admin -->
                    <div class="test-account" onclick="fillLogin('admin1@cnc.com')">
                        <i class="fas fa-user-shield text-primary"></i>
                        <div style="flex: 1;">
                            <div class="role-name">Company Admin</div>
                            <div class="email-text">admin1@cnc.com</div>
                        </div>
                        <span class="badge badge-primary role-badge">ADMIN</span>
                    </div>

                    <!-- Shop Manager -->
                    <div class="test-account" onclick="fillLogin('shop@cnc.com')">
                        <i class="fas fa-tools text-success"></i>
                        <div style="flex: 1;">
                            <div class="role-name">Shop Manager</div>
                            <div class="email-text">shop@cnc.com</div>
                        </div>
                        <span class="badge badge-success role-badge">SHOP</span>
                    </div>

                    <!-- Engineer -->
                    <div class="test-account" onclick="fillLogin('engineer@cnc.com')">
                        <i class="fas fa-drafting-compass text-info"></i>
                        <div style="flex: 1;">
                            <div class="role-name">Engineer</div>
                            <div class="email-text">engineer@cnc.com</div>
                        </div>
                        <span class="badge badge-info role-badge">ENGINEER</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-center mt-3">
            <small class="text-white">
                <i class="fas fa-copyright"></i> {{ date('Y') }} CNC System. All rights reserved.
            </small>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script>
        function fillLogin(email) {
            // Fill the form
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password123';

            // Add visual feedback
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            emailInput.style.background = '#d4edda';
            passwordInput.style.background = '#d4edda';

            // Reset background after animation
            setTimeout(() => {
                emailInput.style.background = '';
                passwordInput.style.background = '';
            }, 1000);

            // Focus on submit button
            document.querySelector('button[type="submit"]').focus();
        }

        // Add enter key support for test accounts
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && document.activeElement.classList.contains('test-account')) {
                document.activeElement.click();
            }
        });
    </script>

</body>

</html>