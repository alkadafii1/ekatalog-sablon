<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --white: #F6F6F6;
            --brown-dark: #2F2F2F;
            --brown-light: #FFCB74;
            --red: #DC3545;
            --blue: #578FCA;
        }

        body {
            background-color: var(--white);
            font-family: Arial, sans-serif;
            color: var(--blue);
            overflow-x: hidden;
            padding-top: 60px;
        }

        .navbar {
            background-color: #4E71FF;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            height: 60px;
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--brown-dark);
            margin-left: 60px;
        }

        /* Sidebar */
        .sidebar {
            background-color: #fff;
            border-right: 1px solid #ccc;
            position: fixed;
            top: 0;
            left: 0;
            width: 60px;
            height: 100vh;
            transition: all 0.3s ease;
            z-index: 1001;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar.expanded {
            width: 220px;
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-footer {
            border-top: 1px solid #eee;
            padding: 10px 0;
        }

        .sidebar .logo {
            display: block;
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--brown-dark);
            white-space: nowrap;
        }

        .sidebar .nav-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: var(--blue);
            text-decoration: none;
            white-space: nowrap;
        }

        .sidebar .nav-item:hover {
            background-color: #f1f1f1;
        }

        .sidebar .nav-icon {
            min-width: 30px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar .nav-text {
            margin-left: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar.expanded .nav-text {
            opacity: 1;
        }

        .logout-button {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background-color: transparent;
            border: none;
            color: var(--brown-dark);
            text-align: left;
            width: 100%;
            white-space: nowrap;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #f1f1f1;
        }

        /* Tombol Toggle Sidebar */
        .toggle-sidebar-btn {
            position: fixed;
            top: 10px;
            left: 10px;
            background-color: var(--blue);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 5px;
            color: var(--white);
            font-size: 18px;
            z-index: 1002;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Konten */
        .content {
            padding: 20px;
            margin-left: 60px;
            transition: margin-left 0.3s ease;
            overflow-y: auto;
        }

        .content.expanded {
            margin-left: 220px;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -220px;
                width: 220px;
            }

            .sidebar.expanded {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .content.expanded {
                margin-left: 0;
            }

            .navbar-brand {
                margin-left: 15px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Tombol Toggle Sidebar -->
    <button class="toggle-sidebar-btn" id="toggleSidebarBtn">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            @yield('page-title', 'Dashboard')
        </a>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-content">
            <div class="logo">
                <i class="fas fa-cogs"></i> <span class="nav-text">Admi Panel</span>
            </div>
            <a href="{{ route('dashboard') }}" class="nav-item">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span class="nav-text">Dashboard</span>
            </a>
            <a href="{{ route('products.index') }}" class="nav-item">
                <span class="nav-icon"><i class="fas fa-boxes"></i></span>
                <span class="nav-text">Manajemen Produk</span>
            </a>
        </div>

        <!-- Footer Sidebar dengan Logout -->
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="nav-text">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Konten utama -->
    <div class="content" id="content">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Toggle sidebar
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        toggleSidebarBtn.addEventListener('click', () => {
            sidebar.classList.toggle('expanded');
            content.classList.toggle('expanded');
            
            // Simpan state sidebar di localStorage
            const isExpanded = sidebar.classList.contains('expanded');
            localStorage.setItem('sidebarExpanded', isExpanded);
        });

        // Cek state sidebar saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            const savedState = localStorage.getItem('sidebarExpanded');
            if (savedState === 'true') {
                sidebar.classList.add('expanded');
                content.classList.add('expanded');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>