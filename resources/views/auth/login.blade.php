\
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
        .login-page {
            background: linear-gradient(135deg, #065A82 0%, #1C7293 100%);
        }

        .login-box {
            width: 420px;
        }

        .test-account {
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 6px;
            background: #f4f6f9;
            margin-bottom: 6px;
            transition: all 0.2s ease;
            font-size: 14px;
        }

        .test-account:hover {
            background: #d1ecf1;
            transform: scale(1.02);
        }

        .login-logo a {
            color: #fff;
            font-weight: bold;
        }

        .login-card-body {
            border-radius: 8px;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">

        <div class="login-logo">
            <a href="/"><i class="fas fa-industry"></i> <b>CNC</b> System</a>
        </div>

        <div class="card shadow">
            <div class="card-body login-card-body">

                <p class="login-box-msg font-weight-bold">Sign in to start your session</p>

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
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
                            placeholder="Email"
                            value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password"
                            class="form-control"
                            placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </div>
                    </div>
                </form>

                <hr>

                <div>
                    <small class="text-muted font-weight-bold">Quick Test Login (Click to Use):</small>

                    <div class="test-account" onclick="fillLogin('superadmin@cnc.com')">
                        <i class="fas fa-user-shield text-primary"></i>
                        Super Admin → superadmin@cnc.com
                    </div>

                    <div class="test-account" onclick="fillLogin('admin1@cnc.com')">
                        <i class="fas fa-user-cog text-success"></i>
                        Company Admin → admin1@cnc.com
                    </div>

                    <div class="test-account" onclick="fillLogin('user1@cnc.com')">
                        <i class="fas fa-user text-warning"></i>
                        Normal User → user1@cnc.com
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script>
        function fillLogin(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password123';
        }
    </script>

</body>

</html>