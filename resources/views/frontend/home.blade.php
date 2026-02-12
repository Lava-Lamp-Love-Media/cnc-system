<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CNC System - Manufacturing Management Software</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }

        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .features {
            padding: 80px 0;
        }

        .feature-box {
            text-align: center;
            padding: 40px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }

        .pricing {
            background: #f8f9fa;
            padding: 80px 0;
        }

        .price-card {
            background: white;
            border-radius: 10px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .price-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .price {
            font-size: 3rem;
            font-weight: 700;
            color: #667eea;
            margin: 20px 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: 0;
            padding: 12px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-light {
            border: 2px solid white;
            padding: 12px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-industry"></i> <strong>CNC System</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white ml-3" href="{{ route('home') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white ml-3" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Manufacturing Management Made Simple</h1>
            <p>Complete CNC Order Management System for Modern Manufacturing</p>
            <div>
                <a href="#pricing" class="btn btn-primary btn-lg mr-3">
                    <i class="fas fa-rocket"></i> Start Free Trial
                </a>
                <a href="#features" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-info-circle"></i> Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Powerful Features for Your Business</h2>
                <p class="text-muted">Everything you need to manage your manufacturing operations</p>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-file-alt feature-icon"></i>
                        <h4>Quote Management</h4>
                        <p class="text-muted">Create, track, and manage customer quotes efficiently</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-shopping-cart feature-icon"></i>
                        <h4>Order Processing</h4>
                        <p class="text-muted">Streamline your order workflow from start to finish</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-boxes feature-icon"></i>
                        <h4>Inventory Control</h4>
                        <p class="text-muted">Real-time inventory tracking and management</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-file-invoice-dollar feature-icon"></i>
                        <h4>Invoicing</h4>
                        <p class="text-muted">Generate professional invoices automatically</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-truck feature-icon"></i>
                        <h4>Shipping & Receiving</h4>
                        <p class="text-muted">Track shipments and manage receiving operations</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h4>Reports & Analytics</h4>
                        <p class="text-muted">Gain insights with comprehensive reporting</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing" id="pricing">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Simple, Transparent Pricing</h2>
                <p class="text-muted">Choose the plan that fits your business needs</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="price-card">
                        <h3>Basic</h3>
                        <div class="price">$29<small>/mo</small></div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Quotes</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Orders</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Invoices</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> 5 Users</li>
                        </ul>
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#trialModal">
                            Start Free Trial
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="price-card" style="transform: scale(1.05); border: 3px solid #667eea;">
                        <span class="badge badge-primary mb-2">Most Popular</span>
                        <h3>Pro</h3>
                        <div class="price">$99<small>/mo</small></div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success"></i> All Basic Features</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Inventory</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Purchase Orders</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> 20 Users</li>
                        </ul>
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#trialModal">
                            Start Free Trial
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="price-card">
                        <h3>Enterprise</h3>
                        <div class="price">$299<small>/mo</small></div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success"></i> All Pro Features</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Shipping & Receiving</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Advanced Reports</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Unlimited Users</li>
                        </ul>
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#trialModal">
                            Start Free Trial
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trial Request Modal -->
    <div class="modal fade" id="trialModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Free Trial</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('trial.request.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Company Name *</label>
                            <input type="text" name="company_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Company Email *</label>
                            <input type="email" name="company_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Contact Name *</label>
                            <input type="text" name="contact_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Contact Email *</label>
                            <input type="email" name="contact_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Preferred Plan</label>
                            <select name="plan_slug" class="form-control">
                                <option value="">Select Plan</option>
                                <option value="basic">Basic - $29/mo</option>
                                <option value="pro">Pro - $99/mo</option>
                                <option value="enterprise">Enterprise - $299/mo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4" id="contact">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} CNC System. All rights reserved.</p>
            <p class="mb-0">
                <a href="#" class="text-white">Privacy Policy</a> |
                <a href="#" class="text-white">Terms of Service</a>
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>