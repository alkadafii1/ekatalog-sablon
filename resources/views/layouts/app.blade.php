<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-brown: #8B4513;
            --secondary-brown: #A0522D;
            --light-brown: #D2B48C;
            --cream: #F5F5DC;
            --dark-brown: #654321;
            --white: #FFFFFF;
            --gray-light: #F8F9FA;
            --gray-medium: #E9ECEF;
            --gray-dark: #6C757D;
            --shadow: 0 2px 12px rgba(139, 69, 19, 0.1);
            --shadow-hover: 0 4px 20px rgba(139, 69, 19, 0.15);
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--cream) 0%, var(--gray-light) 100%);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: var(--dark-brown);
            line-height: 1.6;
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, var(--primary-brown) 0%, var(--secondary-brown) 100%);
            box-shadow: var(--shadow);
            padding: 1rem 0;
            border: none;
            backdrop-filter: blur(10px);
        }

        .navbar .navbar-brand {
            color: var(--white) !important;
            font-weight: 600;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar .navbar-brand i {
            font-size: 1.2rem;
        }

        /* Sidebar Styles */
        .sidebar {
            background: var(--white);
            box-shadow: var(--shadow);
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            padding: 2rem 0;
            z-index: 1000;
            transition: var(--transition);
            border-right: 1px solid var(--gray-medium);
        }

        .sidebar .logo {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid var(--gray-medium);
            margin-bottom: 1.5rem;
        }

        .sidebar .logo h4 {
            color: var(--primary-brown);
            font-weight: 700;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }

        .sidebar .logo i {
            color: var(--secondary-brown);
            font-size: 1.4rem;
        }

        .sidebar .nav-menu {
            padding: 0 1rem;
        }

        .sidebar .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--dark-brown);
            padding: 0.875rem 1rem;
            text-decoration: none;
            border-radius: var(--border-radius);
            margin-bottom: 0.5rem;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .sidebar .nav-item:hover {
            background: linear-gradient(135deg, var(--light-brown) 0%, var(--cream) 100%);
            color: var(--primary-brown);
            text-decoration: none;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(139, 69, 19, 0.1);
        }

        .sidebar .nav-item.active {
            background: linear-gradient(135deg, var(--primary-brown) 0%, var(--secondary-brown) 100%);
            color: var(--white);
            box-shadow: var(--shadow);
        }

        .sidebar .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: var(--white);
            border-radius: 0 4px 4px 0;
        }

        .sidebar .nav-item i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .logout-section {
            position: absolute;
            bottom: 2rem;
            left: 1rem;
            right: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-medium);
        }

        .logout-button {
            background: none;
            border: none;
            color: #dc3545;
            padding: 0.875rem 1rem;
            width: 100%;
            text-align: left;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logout-button:hover {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.1);
        }

        .logout-button i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .content {
            margin-left: 260px;
            padding: 2rem;
            min-height: 100vh;
            padding-top: 100px;
            transition: var(--transition);
        }

        .content-header {
            background: var(--white);
            padding: 1.5rem 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-brown);
        }

        .content-header h1 {
            color: var(--primary-brown);
            font-weight: 600;
            margin: 0;
            font-size: 1.8rem;
        }

        .content-header .breadcrumb {
            background: none;
            padding: 0;
            margin: 0.5rem 0 0 0;
        }

        .content-header .breadcrumb-item {
            color: var(--gray-dark);
        }

        .content-header .breadcrumb-item.active {
            color: var(--primary-brown);
            font-weight: 500;
        }

        .content-body {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            min-height: 400px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .navbar {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .mobile-toggle {
                display: block;
                background: none;
                border: none;
                color: var(--white);
                font-size: 1.2rem;
                padding: 0.5rem;
                border-radius: 4px;
                transition: var(--transition);
            }
            
            .mobile-toggle:hover {
                background: rgba(255, 255, 255, 0.1);
            }
            
            .content-header {
                padding: 1rem 1.5rem;
            }
            
            .content-body {
                padding: 1.5rem;
            }
        }

        @media (min-width: 769px) {
            .mobile-toggle {
                display: none;
            }
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: var(--gray-light);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--light-brown);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-brown);
        }

        /* Animation for page load */
        .sidebar, .content {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-brown) 0%, var(--secondary-brown) 100%);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-brown) 0%, var(--primary-brown) 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--cream) 0%, var(--gray-light) 100%);
            border-bottom: 1px solid var(--gray-medium);
            font-weight: 600;
            color: var(--primary-brown);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <button class="mobile-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-chart-line"></i>
                @yield('page-title', 'Dashboard Admin')
            </a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h4>
                <i class="fas fa-cogs"></i>
                Admin Panel
            </h4>
        </div>
        
        <div class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('products.index') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i>
                <span>Manajemen Produk</span>
            </a>

            <a href="{{ route('sales.index') }}" class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Penjualan</span>
            </a>

        </div>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Content Header -->
        <div class="content-header">
            <h1>@yield('page-title', 'Dashboard')</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>

        <!-- Content Body -->
        <div class="content-body">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
            }
        });

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '1';
        });
    </script>
    
    @stack('scripts')
</body>
</html>