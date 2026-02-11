<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Trial Request Submitted</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #065A82 0%, #1C7293 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-card {
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #28a745;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
    </style>
</head>

<body>

    <div class="card success-card p-5 text-center" style="max-width: 520px; width: 100%;">

        <div class="icon-circle">
            <i class="fas fa-check fa-2x text-white"></i>
        </div>

        <h3 class="font-weight-bold">Request Submitted Successfully!</h3>

        <p class="text-muted mt-3">
            Thank you for requesting a trial of <b>CNC Manufacture System</b>.
            Our team will review your request and create your company account shortly.
        </p>

        <div class="alert alert-info mt-4">
            <strong>Next Steps:</strong><br>
            ✔ Company account will be created<br>
            ✔ Company Admin login will be emailed<br>
            ✔ Trial plan activated automatically
        </div>

        <div class="mt-4">
            <a href="{{ route('landing') }}" class="btn btn-outline-secondary mr-2">
                Back to Home
            </a>

            <a href="{{ route('login') }}" class="btn btn-primary">
                Go to Login
            </a>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</body>

</html>