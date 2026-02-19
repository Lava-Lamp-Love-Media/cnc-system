<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - CNC System</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">

    <!-- Page Loader -->
    <style>
    #globalPageLoader {
        position:fixed; inset:0; background:rgba(255,255,255,.92);
        z-index:99999; display:flex; flex-direction:column;
        align-items:center; justify-content:center;
        transition:opacity .35s ease; pointer-events:none;
    }
    #globalPageLoader.hidden { opacity:0; }
    #globalPageLoader .gpl-spinner {
        width:48px; height:48px;
        border:5px solid #e9ecef;
        border-top-color:#667eea;
        border-radius:50%;
        animation:gplSpin .75s linear infinite;
    }
    #globalPageLoader .gpl-text {
        margin-top:12px; font-size:13px; font-weight:600;
        color:#495057; letter-spacing:.4px;
        font-family:'Source Sans Pro',sans-serif;
    }
    @keyframes gplSpin { to { transform:rotate(360deg); } }
    </style>

    @yield('style')

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --info-gradient: linear-gradient(135deg, #0093E9 0%, #80D0C7 100%);
            --warning-gradient: linear-gradient(135deg, #FFB75E 0%, #ED8F03 100%);
            --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
        }

        body {
            font-family: 'Source Sans Pro', sans-serif;
        }

        /* ✅ TOP MENU BAR - Dark Navy Style */
        .top-menubar {
            background: #4a5f7f;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
            padding: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 1030;
            height: 50px;
            transition: left 0.3s ease-in-out;
        }

        .top-menubar .navbar-nav {
            flex-direction: row;
            height: 50px;
        }

        .top-menubar .nav-item {
            position: relative;
        }

        .top-menubar .nav-link {
            color: #fff !important;
            padding: 0 1.2rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            height: 50px;
            transition: all 0.3s;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .top-menubar .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .top-menubar .nav-link i {
            margin-right: 0.5rem;
            font-size: 0.875rem;
        }

        /* ✅ Hamburger Menu Button */
        .hamburger-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hamburger-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .hamburger-btn i {
            font-size: 1.1rem;
        }

        .top-menubar .dropdown-menu {
            border: 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            border-radius: 0;
            margin-top: 0;
            min-width: 200px;
        }

        .top-menubar .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .top-menubar .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .top-menubar .dropdown-item i {
            width: 20px;
            margin-right: 0.5rem;
        }

        /* Brand */
        .brand-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-bottom: 0;
            padding: 1rem 0.5rem;
        }

        .brand-text {
            color: #fff !important;
            font-weight: 600;
            font-size: 1.2rem;
        }

        /* Sidebar */
        .main-sidebar {
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 5px rgba(102, 126, 234, 0.4);
        }

        .sidebar-dark-primary .nav-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-header {
            color: #adb5bd;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        /* User Panel */
        .user-panel {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-panel .info a {
            color: #fff;
            font-weight: 500;
        }

        /* Content */
        .content-wrapper {
            background: #f4f6f9;
            margin-top: 50px;
            transition: margin-left 0.3s ease-in-out;
        }

        .content-header h1 {
            font-weight: 600;
            color: #343a40;
        }

        /* Cards */
        .card {
            border: 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            border-radius: 10px;
            margin-bottom: 1.5rem;
            overflow: visible !important;
        }
        .card .card-footer {
            border-radius: 0 0 10px 10px;
            background: #fff;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
            border-radius: 10px 10px 0 0;
        }

        .card-title {
            font-weight: 600;
            color: #343a40;
            font-size: 1.1rem;
        }

        /* Small Boxes (Stats) */
        .small-box {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .small-box.bg-gradient-primary {
            background: var(--primary-gradient) !important;
        }

        .small-box.bg-gradient-success {
            background: var(--success-gradient) !important;
        }

        .small-box.bg-gradient-info {
            background: var(--info-gradient) !important;
        }

        .small-box.bg-gradient-warning {
            background: var(--warning-gradient) !important;
        }

        .small-box.bg-gradient-danger {
            background: var(--danger-gradient) !important;
        }

        /* Buttons */
        .btn {
            border-radius: 5px;
            font-weight: 500;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: 0;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Tables */
        .table {
            background: #fff;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }

        /* Badges */
        .badge {
            padding: 0.4em 0.8em;
            font-weight: 500;
            border-radius: 5px;
        }

        /* Alerts */
        .alert {
            border: 0;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Navbar - Hide default navbar */
        .main-header {
            display: none;
        }

        .dropdown-menu {
            border: 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Footer */
        .main-footer {
            background: #fff;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            transition: margin-left 0.3s ease-in-out;
        }

        /* Form Controls */
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        /* Pagination */
        .pagination .page-link {
            color: #667eea;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
        }

        /* ✅ Adjust for collapsed sidebar */
        .sidebar-collapse .top-menubar {
            left: 4.6rem;
        }

        /* ✅ Top menu right section */
        .top-menubar .ml-auto {
            margin-left: auto !important;
        }

        .top-menubar .user-dropdown .nav-link {
            border-right: none;
        }

        .top-menubar .nav-link .badge {
            position: absolute;
            top: 10px;
            right: 8px;
            padding: 0.25em 0.5em;
            font-size: 0.7rem;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Global Page Loader -->
    <div id="globalPageLoader">
        <div class="gpl-spinner"></div>
        <div class="gpl-text">Loading...</div>
    </div>

    <div class="wrapper">

        <!-- ✅ TOP MENUBAR -->
        @if(Auth::user()->isCompanyAdmin())
        <nav class="navbar navbar-expand top-menubar">
            <!-- ✅ Hamburger Menu Button -->
            <button class="hamburger-btn" data-widget="pushmenu" role="button">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="navbar-nav">
                <!-- CNC Quote -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('company.quotes.create') }}">
                        <i class="fas fa-file-invoice"></i> CNC Quote
                    </a>
                </li>

                <!-- Customer -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('company.customers.index') }}">
                        <i class="fas fa-user-tie"></i> Customer
                    </a>
                </li>

                <!-- Vendor -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('company.vendors.index') }}">
                        <i class="fas fa-truck"></i> Vendor
                    </a>
                </li>

         <!-- ✅ Purchase Orders (Updated) -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-shopping-cart"></i> Purchase
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('company.purchase-orders.create') }}">
                    <i class="fas fa-plus"></i> New Purchase Order
                </a>
                <a class="dropdown-item" href="{{ route('company.purchase-orders.index') }}">
                    <i class="fas fa-list"></i> Purchase Order List
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('company.items.create') }}">
                    <i class="fas fa-box"></i> Add Item
                </a>
                <a class="dropdown-item" href="{{ route('company.items.index') }}">
                    <i class="fas fa-boxes"></i> Items List
                </a>
            </div>
        </li>

        <!-- ✅ Inventory (Updated) -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-boxes"></i> Inventory
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('company.inventory.index') }}">
                    <i class="fas fa-warehouse"></i> Inventory List
                </a>
                <a class="dropdown-item" href="{{ route('company.inventory.transactions') }}">
                    <i class="fas fa-history"></i> Transactions
                </a>
            </div>
        </li>

                <!-- Order -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fas fa-clipboard-list"></i> Order
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="fas fa-plus"></i> New Order</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-list"></i> Order List</a>
                    </div>
                </li>

                <!-- Quote -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fas fa-file-contract"></i> Quote
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('company.quotes.create') }}"><i class="fas fa-plus"></i> New Quote</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-list"></i> Quote List</a>
                    </div>
                </li>

                <!-- Shop -->
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-store"></i> Shop
                    </a>
                </li>

                <!-- Receiving -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fas fa-dolly"></i> Receiving
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="fas fa-plus"></i> New Receipt</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-list"></i> Receipt List</a>
                    </div>
                </li>

                <!-- Shipping -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fas fa-shipping-fast"></i> Shipping
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="fas fa-plus"></i> New Shipment</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-list"></i> Shipment List</a>
                    </div>
                </li>
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">3 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 2 new messages
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 1 new user
                        </a>
                    </div>
                </li>

                <!-- User Menu -->
                <li class="nav-item dropdown user-dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="far fa-user-circle"></i>
                        <span class="d-none d-md-inline ml-1">{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>{{ Auth::user()->name }}</strong>
                            <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> My Profile
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        @endif

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('home') }}" class="brand-link text-center">
                <i class="fas fa-industry fa-lg"></i>
                <span class="brand-text">CNC System</span>
            </a>

            <div class="sidebar">
                <!-- User Panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="fas fa-user-circle fa-2x text-white"></i>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                        <small class="text-muted">
                            <i class="fas fa-circle text-success" style="font-size: 0.5rem;"></i>
                            {{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}
                        </small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        @if(Auth::user()->isSuperAdmin())
                        <!-- Super Admin Section -->
                        <li class="nav-header">SUPER ADMIN</li>

                        <li class="nav-item">
                            <a href="{{ route('superadmin.trial_requests.index') }}" class="nav-link {{ request()->routeIs('superadmin.trial_requests.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-inbox"></i>
                                <p>Trial Requests</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('superadmin.companies.index') }}" class="nav-link {{ request()->routeIs('superadmin.companies.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Companies</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('superadmin.plans.index') }}" class="nav-link {{ request()->routeIs('superadmin.plans.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-crown"></i>
                                <p>Plans</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('superadmin.features.index') }}" class="nav-link {{ request()->routeIs('superadmin.features.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>Features</p>
                            </a>
                        </li>
                        @endif

                        @if(Auth::user()->isCompanyAdmin())
                        <!-- User Management -->
                        <li class="nav-item">
                            <a href="{{ route('company.users.index') }}" class="nav-link {{ request()->routeIs('company.users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Manage Users
                                    @if(Auth::user()->company)
                                    <span class="badge badge-info right">{{ Auth::user()->company->users()->count() }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('company.machines.index') }}" class="nav-link {{ request()->routeIs('company.machines.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-industry"></i>
                                <p>
                                    Machines
                                    @if(Auth::user()->company)
                                    <span class="badge badge-info right">{{ Auth::user()->company->machines()->count() }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('company.operators.index') }}" class="nav-link {{ request()->routeIs('company.operators.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>
                                    Operators
                                    @if(Auth::user()->company)
                                    <span class="badge badge-info right">{{ \App\Models\Operator::where('company_id', Auth::user()->company_id)->count() }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('company.operations.index') }}" class="nav-link {{ request()->routeIs('company.operations.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Operations
                                    @if(Auth::user()->company)
                                    <span class="badge badge-info right">{{ \App\Models\Operation::where('company_id', Auth::user()->company_id)->count() }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('company.warehouses.index') }}" class="nav-link {{ request()->routeIs('company.warehouses.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>
                                    Warehouses
                                    @if(Auth::user()->company)
                                    <span class="badge badge-info right">{{ \App\Models\Warehouse::where('company_id', Auth::user()->company_id)->count() }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('company.customers.index') }}" class="nav-link {{ request()->routeIs('company.customers.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    Customers
                                    @if(Auth::user()->company)
                                    <span class="badge badge-success right">{{ \App\Models\Customer::where('company_id', Auth::user()->company_id)->count() }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('company.vendors.index') }}" class="nav-link {{ request()->routeIs('company.vendors.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>
                                    Vendors
                                    @if(Auth::user()->company)
                                    <span class="badge badge-warning right">{{ \App\Models\Vendor::where('company_id', Auth::user()->company_id)->count() }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>

                        <!-- Settings Menu -->
                        <li class="nav-header">SETTINGS & CONFIGURATION</li>

                        <li class="nav-item has-treeview {{ request()->routeIs('company.holes.*') || request()->routeIs('company.chamfers.*') || request()->routeIs('company.deburs.*') || request()->routeIs('company.taps.*') || request()->routeIs('company.threads.*') || request()->routeIs('company.materials.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('company.holes.*') || request()->routeIs('company.chamfers.*') || request()->routeIs('company.deburs.*') || request()->routeIs('company.taps.*') || request()->routeIs('company.threads.*') || request()->routeIs('company.materials.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Specifications
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('company.materials.index') }}" class="nav-link {{ request()->routeIs('company.materials.*') ? 'active' : '' }}">
                                        <i class="fas fa-layer-group nav-icon text-info"></i>
                                        <p>
                                            Materials
                                            <span class="badge badge-info right">{{ \App\Models\Material::where('company_id', Auth::user()->company_id)->count() }}</span>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('company.holes.index') }}" class="nav-link {{ request()->routeIs('company.holes.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon text-primary"></i>
                                        <p>
                                            Holes
                                            <span class="badge badge-primary right">{{ \App\Models\Hole::where('company_id', Auth::user()->company_id)->count() }}</span>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('company.chamfers.index') }}" class="nav-link {{ request()->routeIs('company.chamfers.*') ? 'active' : '' }}">
                                        <i class="fas fa-draw-polygon nav-icon text-warning"></i>
                                        <p>
                                            Chamfers
                                            <span class="badge badge-warning right">{{ \App\Models\Chamfer::where('company_id', Auth::user()->company_id)->count() }}</span>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('company.deburs.index') }}" class="nav-link {{ request()->routeIs('company.deburs.*') ? 'active' : '' }}">
                                        <i class="fas fa-cut nav-icon text-success"></i>
                                        <p>
                                            Deburs
                                            <span class="badge badge-success right">{{ \App\Models\Debur::where('company_id', Auth::user()->company_id)->count() }}</span>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('company.taps.index') }}" class="nav-link {{ request()->routeIs('company.taps.*') ? 'active' : '' }}">
                                        <i class="fas fa-screwdriver nav-icon text-danger"></i>
                                        <p>
                                            Taps
                                            <span class="badge badge-danger right">{{ \App\Models\Tap::where('company_id', Auth::user()->company_id)->count() }}</span>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('company.threads.index') }}" class="nav-link {{ request()->routeIs('company.threads.*') ? 'active' : '' }}">
                                        <i class="fas fa-spinner nav-icon" style="color: #6f42c1;"></i>
                                        <p>
                                            Threads
                                            <span class="badge right" style="background-color: #6f42c1;">{{ \App\Models\Thread::where('company_id', Auth::user()->company_id)->count() }}</span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Purchase Orders -->
                            <li class="nav-item">
                                <a href="{{ route('company.purchase-orders.index') }}" 
                                class="nav-link {{ request()->routeIs('company.purchase-orders.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>Purchase Orders</p>
                                </a>
                            </li>

                            <!-- Items -->
                            <li class="nav-item">
                                <a href="{{ route('company.items.index') }}" 
                                class="nav-link {{ request()->routeIs('company.items.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-box"></i>
                                    <p>Items</p>
                                </a>
                            </li>

                            <!-- Inventory -->
                            <li class="nav-item">
                                <a href="{{ route('company.inventory.index') }}" 
                                class="nav-link {{ request()->routeIs('company.inventory.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-warehouse"></i>
                                    <p>Inventory</p>
                                </a>
                            </li>

                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield('page-title', 'Dashboard')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="#">CNC System</a>.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Toastr Configuration
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if(session('toast_success'))
        toastr.success("{{ session('toast_success') }}");
        @endif

        @if(session('toast_error'))
        toastr.error("{{ session('toast_error') }}");
        @endif

        @if(session('toast_info'))
        toastr.info("{{ session('toast_info') }}");
        @endif

        @if(session('toast_warning'))
        toastr.warning("{{ session('toast_warning') }}");
        @endif

        @if(session('admin_credentials'))
        @php $creds = session('admin_credentials'); @endphp
        @if($creds['password'])
        Swal.fire({
            icon: 'success',
            title: 'Admin Credentials',
            html: `
                <div class="text-left">
                    <p><strong>Email:</strong> <code>{{ $creds['email'] }}</code></p>
                    <p><strong>Password:</strong> <code>{{ $creds['password'] }}</code></p>
                    <hr>
                    <small class="text-muted">Please save these credentials securely!</small>
                </div>
            `,
            confirmButtonText: 'Got it!',
            confirmButtonColor: '#667eea'
        });
        @endif
        @endif

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>

    @stack('scripts')

    <script>
    // ── Global Page Loader ──────────────────────────────
    (function(){
        var loader = document.getElementById('globalPageLoader');

        // Hide loader when page is fully loaded
        function hideGlobalLoader(){
            if(!loader) return;
            loader.classList.add('hidden');
            setTimeout(function(){ loader.style.display='none'; }, 400);
        }

        // Show loader
        function showGlobalLoader(msg){
            if(!loader) return;
            var t = loader.querySelector('.gpl-text');
            if(t) t.textContent = msg || 'Loading...';
            loader.style.display = 'flex';
            loader.classList.remove('hidden');
        }

        // Hide after page load
        if(document.readyState === 'complete'){
            hideGlobalLoader();
        } else {
            window.addEventListener('load', hideGlobalLoader);
        }

        // Show on any link click (excluding anchors, modals, dropdowns)
        document.addEventListener('click', function(e){
            var a = e.target.closest('a[href]');
            if(!a) return;
            var href = a.getAttribute('href');
            if(!href || href === '#' || href.startsWith('javascript') || href.startsWith('mailto')) return;
            if(a.getAttribute('data-toggle') || a.getAttribute('data-dismiss')) return;
            if(a.getAttribute('target') === '_blank') return;
            showGlobalLoader('Loading...');
        });

        // Show on form submit (except AJAX forms)
        document.addEventListener('submit', function(e){
            var form = e.target;
            // Don't show for AJAX / modal forms
            if(form.id && (form.id === 'logout-form' || form.id.startsWith('quick'))) return;
            showGlobalLoader('Saving...');
        });

        // Expose globally
        window.showPageLoader = showGlobalLoader;
        window.hidePageLoader = hideGlobalLoader;
    })();
    </script>
</body>

</html>