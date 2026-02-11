<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CNC System — Quotes, Orders, Inventory (SaaS)</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        .hero {
            background: radial-gradient(1200px circle at 20% 10%, rgba(255, 255, 255, .18), transparent 40%),
                linear-gradient(135deg, #065A82 0%, #1C7293 55%, #0b3b56 100%);
            color: #fff;
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, .12);
            padding: 8px 14px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid rgba(255, 255, 255, .18);
        }

        .hero h1 {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .hero p {
            color: rgba(255, 255, 255, .85);
            font-size: 18px;
        }

        .hero-card {
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 14px;
            backdrop-filter: blur(8px);
        }

        .section {
            padding: 60px 0;
        }

        .section-title {
            font-weight: 700;
            letter-spacing: -.3px;
        }

        .muted {
            color: #6c757d;
        }

        .feature-card {
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, .06);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        }

        .pricing-card {
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, .06);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .pricing-top {
            background: linear-gradient(135deg, rgba(28, 114, 147, .12), rgba(6, 90, 130, .04));
        }

        .price {
            font-size: 38px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .btn-hero {
            border-radius: 10px;
            padding: 12px 16px;
            font-weight: 700;
        }

        .nav-shadow {
            box-shadow: 0 8px 30px rgba(0, 0, 0, .08);
        }

        .footer {
            background: #0b2230;
            color: rgba(255, 255, 255, .8);
            padding: 35px 0;
        }

        .footer a {
            color: rgba(255, 255, 255, .85);
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        {{-- Top Navbar --}}
        <nav class="main-header navbar navbar-expand-md navbar-white navbar-light nav-shadow">
            <div class="container">
                <a href="{{ route('landing') }}" class="navbar-brand">
                    <i class="fas fa-industry text-info"></i>
                    <span class="brand-text font-weight-bold ml-2">CNC Manufacture System</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a href="#features" class="nav-link">Features</a></li>
                        <li class="nav-item"><a href="#pricing" class="nav-link">Pricing</a></li>
                        <li class="nav-item"><a href="#contact" class="nav-link">Request</a></li>
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm ml-md-2">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- HERO --}}
        <section class="hero">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-7">
                        <div class="hero-badge mb-3">
                            <i class="fas fa-sparkles"></i>
                            Multi-Tenant SaaS for CNC Operations
                        </div>

                        <h1 class="display-4 mb-3">Run Quotes, Orders & Production — in one system.</h1>
                        <p class="mb-4">
                            Manage your CNC workflow: quotes → orders → job tracking → inventory → reports.
                            Start a free trial or request a demo for your company.
                        </p>

                        <div class="d-flex flex-wrap" style="gap: 12px;">
                            <a href="#pricing" class="btn btn-light btn-hero">
                                <i class="fas fa-bolt"></i> Start Free Trial
                            </a>
                            <a href="#contact" class="btn btn-outline-light btn-hero">
                                <i class="fas fa-calendar-check"></i> Request Demo
                            </a>
                        </div>

                        <div class="mt-4 d-flex flex-wrap" style="gap: 16px;">
                            <div><i class="fas fa-check-circle"></i> Fast setup</div>
                            <div><i class="fas fa-check-circle"></i> Role based access</div>
                            <div><i class="fas fa-check-circle"></i> Plan based features</div>
                        </div>
                    </div>

                    <div class="col-lg-5 mt-4 mt-lg-0">
                        <div class="card hero-card">
                            <div class="card-body">
                                <h5 class="font-weight-bold mb-3">
                                    <i class="fas fa-gauge-high"></i> What you can manage
                                </h5>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="p-3 bg-white rounded" style="border-radius: 12px;">
                                            <div class="text-info font-weight-bold"><i class="fas fa-file-alt"></i> Quotes</div>
                                            <div class="text-muted small">Price, materials, margin</div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="p-3 bg-white rounded" style="border-radius: 12px;">
                                            <div class="text-info font-weight-bold"><i class="fas fa-shopping-cart"></i> Orders</div>
                                            <div class="text-muted small">Track status & delivery</div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="p-3 bg-white rounded" style="border-radius: 12px;">
                                            <div class="text-info font-weight-bold"><i class="fas fa-boxes"></i> Inventory</div>
                                            <div class="text-muted small">Stock, receiving, cost</div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="p-3 bg-white rounded" style="border-radius: 12px;">
                                            <div class="text-info font-weight-bold"><i class="fas fa-chart-line"></i> Reports</div>
                                            <div class="text-muted small">Profit & performance</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="small text-muted">
                                    Built for multi-company SaaS: Super Admin → Company Admin → Users.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- FEATURES --}}
        <section id="features" class="section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Features your CNC team will actually use</h2>
                    <p class="muted mb-0">Simple screens, fast workflow, role-based access, plan-based features.</p>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <div class="mb-3 text-info"><i class="fas fa-file-alt fa-2x"></i></div>
                                <h5 class="font-weight-bold">Quotes & Margin</h5>
                                <p class="muted mb-0">Create quotes, calculate margin, and convert to orders easily.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <div class="mb-3 text-info"><i class="fas fa-user-shield fa-2x"></i></div>
                                <h5 class="font-weight-bold">Roles & Permissions</h5>
                                <p class="muted mb-0">Super Admin, Company Admin, Engineer, QC, Shop and more.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <div class="mb-3 text-info"><i class="fas fa-crown fa-2x"></i></div>
                                <h5 class="font-weight-bold">Plans & Trials</h5>
                                <p class="muted mb-0">Enable features by plan, trial period, and upgrades later.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <div class="mb-3 text-info"><i class="fas fa-boxes fa-2x"></i></div>
                                <h5 class="font-weight-bold">Inventory & Receiving</h5>
                                <p class="muted mb-0">Track stock, receiving batches, average cost, movement history.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <div class="mb-3 text-info"><i class="fas fa-tasks fa-2x"></i></div>
                                <h5 class="font-weight-bold">Job Tracking</h5>
                                <p class="muted mb-0">Monitor progress for shop floor and QC status.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <div class="mb-3 text-info"><i class="fas fa-chart-line fa-2x"></i></div>
                                <h5 class="font-weight-bold">Reports</h5>
                                <p class="muted mb-0">Profit, performance, pending orders and key business metrics.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- PRICING --}}
        <section id="pricing" class="section" style="background:#f6f8fb;">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Simple pricing</h2>
                    <p class="muted mb-0">Start trial now. Upgrade anytime.</p>
                </div>

                <div class="row">
                    {{-- Basic --}}
                    <div class="col-md-4 mb-4">
                        <div class="card pricing-card h-100">
                            <div class="card-body pricing-top">
                                <h5 class="font-weight-bold mb-1">Basic</h5>
                                <div class="muted">Small team</div>
                                <div class="price mt-3">$19<span class="h6 muted">/mo</span></div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-2"><i class="fas fa-check text-success"></i> Quotes</li>
                                    <li class="mb-2"><i class="fas fa-check text-success"></i> Orders</li>
                                    <li class="mb-2"><i class="fas fa-check text-success"></i> Basic Reports</li>
                                </ul>
                                <a href="#contact" class="btn btn-outline-primary btn-block">Start Free Trial</a>
                            </div>
                        </div>
                    </div>

                    {{-- Pro --}}
                    <div class="col-md-4 mb-4">
                        <div class="card pricing-card h-100 border-primary">
                            <div class="card-body pricing-top">
                                <span class="badge badge-primary">Most Popular</span>
                                <h5 class="font-weight-bold mt-2 mb-1">Pro</h5>
                                <div class="muted">Growing CNC shop</div>
                                <div class="price mt-3">$49<span class="h6 muted">/mo</span></div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-2"><i class="fas fa-check text-success"></i> Everything in Basic</li>
                                    <li class="mb-2"><i class="fas fa-check text-success"></i> Inventory</li>
                                    <li class="mb-2"><i class="fas fa-check text-success"></i> Job Tracking</li>
                                </ul>
                                <a href="#contact" class="btn btn-primary btn-block">Start Free Trial</a>
                            </div>
                        </div>
                    </div>

                    {{-- Enterprise --}}
                    <div class="col-md-4 mb-4">
                        <div class="card pricing-card h-100">
                            <div class="card-body pricing-top">
                                <h5 class="font-weight-bold mb-1">Enterprise</h5>
                                <div class="muted">Multi-site, custom</div>
                                <div class="price mt-3">$99<span class="h6 muted">/mo</span></div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-2"><i class="fas fa-check text-success"></i> Everything in Pro</li>
                                    <li class="mb-2"><i class="fas fa-check text-success"></i> Advanced Reports</li>
                                    <li class="mb-2"><i class="fas fa-check text-success"></i> Priority Support</li>
                                </ul>
                                <a href="#contact" class="btn btn-outline-primary btn-block">Request Demo</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- CONTACT / REQUEST --}}
        <section id="contact" class="section">
            <div class="container">
                <div class="row align-items-start">

                    <div class="col-lg-5 mb-4">
                        <h2 class="section-title">Request trial / demo</h2>
                        <p class="muted">
                            Tell us about your company. We’ll create your trial account and send credentials by email.
                            (Later you can automate this with queue + mail.)
                        </p>

                        <div class="callout callout-info">
                            <p class="mb-0">
                                <b>What you’ll get:</b> Company account + Company Admin user + plan features enabled.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">

                                {{-- For now: just UI. Later you will connect route + store into DB --}}
                                <form method="POST" action="{{ route('trial.request.store') }}">
                                    @csrf

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Company Name</label>
                                            <input type="text" class="form-control" name="company_name" placeholder="Your Company" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Company Email</label>
                                            <input type="email" class="form-control" name="company_email" placeholder="company@email.com" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Your Name</label>
                                            <input type="text" class="form-control" name="contact_name" placeholder="Your Name" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Your Email</label>
                                            <input type="email" class="form-control" name="contact_email" placeholder="you@email.com" required>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Preferred Plan</label>
                                            <select class="form-control" name="plan_slug">
                                                <option value="basic">Basic (Trial)</option>
                                                <option value="pro">Pro (Trial)</option>
                                                <option value="enterprise">Enterprise (Demo)</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Phone (Optional)</label>
                                            <input type="text" class="form-control" name="phone" placeholder="+880...">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Message (Optional)</label>
                                        <textarea class="form-control" rows="4" name="message" placeholder="Tell us what modules you need..."></textarea>
                                    </div>

                                    <button class="btn btn-primary btn-block">
                                        <i class="fas fa-paper-plane"></i> Submit Request
                                    </button>

                                    <div class="text-muted small mt-3">
                                        By submitting, you agree to be contacted about your trial/demo.
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="footer">
            <div class="container d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <strong>CNC System</strong> — Multi-Tenant SaaS
                    <div class="small">© {{ date('Y') }} All rights reserved.</div>
                </div>
                <div class="small">
                    <a href="{{ route('login') }}">Login</a>
                    <span class="mx-2">•</span>
                    <a href="#contact">Request</a>
                </div>
            </div>
        </footer>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>