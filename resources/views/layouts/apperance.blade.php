<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Homepage')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSS Bootstrap dan FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-brown: #8B4513;
            --secondary-brown: #A0522D;
            --accent-gold: #D4AF37;
            --light-gold: #B8860B;
            --cream: #FFF8DC;
            --light-cream: #FAEBD7;
            --beige: #F5DEB3;
            --dark-text: #3E2723;
            --shadow-primary: rgba(139, 69, 19, 0.25);
            --shadow-light: rgba(139, 69, 19, 0.15);
            --shadow-gold: rgba(212, 175, 55, 0.4);
        }

        /* ===== LAYOUT DASAR ===== */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            flex: 1;
        }

        body {
            background: rgb(255, 251, 248);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* ===== NAVBAR STYLING ===== */
        .navbar {
            background: #E6D1A0;
            padding: 15px 0;
            box-shadow: 0 4px 20px var(--shadow-primary);
            border-bottom: 3px solid rgba(212, 175, 55, 0.3);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-brown) !important;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--accent-gold) !important;
            transform: scale(1.05);
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.6);
        }

        .navbar .nav-link {
            color: var(--primary-brown) !important;
            font-weight: 500;
            margin: 0 8px;
            padding: 8px 16px !important;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar .nav-link:hover {
            background: rgba(212, 175, 55, 0.2);
            color: var(--accent-gold) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px var(--shadow-gold);
        }

        .navbar-toggler {
            border: 2px solid rgba(139, 69, 19, 0.3);
            border-radius: 8px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2833, 37, 41, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .star-rating .fa-star {
            font-size: 24px;
            cursor: pointer;
            color: #ccc;
            transition: color 0.2s;
            }
        .star-rating .fa-star.selected {
            color: #ffc107;
        }


        /* ===== CONTAINER UTAMA ===== */
        .container {
            background: linear-gradient(145deg, var(--cream) 0%, var(--light-cream) 50%, var(--beige) 100%);
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 50px var(--shadow-primary);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        /* ===== CARD PRODUK ===== */
        .product-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px var(--shadow-light);
            transition: all 0.3s ease;
            background: linear-gradient(145deg, #FFFAF0 0%, var(--cream) 100%);
            overflow: hidden;
            margin-bottom: 20px;
            border: 1px solid rgba(184, 134, 11, 0.2);
            animation: fadeInUp 0.6s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px var(--shadow-primary);
            border: 1px solid var(--shadow-gold);
        }

        .product-img {
            height: 220px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-weight: 600;
            color: var(--primary-brown);
            margin-bottom: 10px;
        }

        .card-text {
            color: var(--secondary-brown);
            font-size: 0.9rem;
        }

        /* ===== JUDUL SECTION ===== */
        .section-title {
            margin: 40px 0 25px 0;
            font-weight: 700;
            color: var(--primary-brown);
            position: relative;
            padding-bottom: 10px;
            text-shadow: 0 2px 4px rgba(139, 69, 19, 0.2);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(135deg, var(--accent-gold) 0%, var(--light-gold) 100%);
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
        }

        /* ===== BUTTON STYLING ===== */
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-gold) 0%, var(--light-gold) 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            box-shadow: 0 4px 15px var(--shadow-gold);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.6);
            background: linear-gradient(135deg, var(--light-gold) 0%, var(--accent-gold) 100%);
            color: white;
        }

        /* ===== FOOTER STYLING ===== */
        footer {
            background: #E6D1A0;
            color: var(--dark-text);
            padding: 30px 0;
            margin-top: auto;
            border-top: 3px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 -4px 20px var(--shadow-light);
        }

        footer p {
            margin-bottom: 8px;
            font-size: 0.95rem;
            color: var(--dark-text);
            font-weight: 500;
        }

        footer a {
            color: var(--primary-brown);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        footer a:hover {
            color: #5D4037;
            text-decoration: underline;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        footer hr {
            border-color: rgba(212, 175, 55, 0.3);
            margin: 20px 0;
        }

        /* ===== UTILITY CLASSES ===== */
        .gambar {
            object-fit: contain;
        }

        .nav-item {
            margin: 0 5px;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== MEDIA QUERIES ===== */
        @media (max-width: 768px) {
            .container {
                margin: 15px;
                padding: 20px;
                border-radius: 15px;
            }
            
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .product-img {
                height: 180px;
            }
        }

        @media (min-width: 992px) {
            .navbar-nav .nav-item:last-child .nav-link {
                background: rgba(212, 175, 55, 0.2);
                border: 1px solid var(--accent-gold);
            }
            
            .navbar-nav .nav-item:last-child .nav-link:hover {
                background: var(--accent-gold);
                color: white !important;
                box-shadow: 0 0 15px rgba(212, 175, 55, 0.6);
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- ===== NAVIGATION BAR ===== -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-store me-2"></i>Toko Victory
                </a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
                    <ul class="navbar-nav">
                @auth
                <li class="nav-item">
                    <a href="{{ route('wishlist.index') }}" class="nav-link position-relative">
                        <i class="fas fa-heart me-1"></i>
                        Keranjang
                        @if(isset($wishlistCount) && $wishlistCount > 0)
                            <span class="badge badge-danger position-absolute" style="top: 0; right: 0; transform: translate(50%, -50%);">
                                {{ $wishlistCount }}
                            </span>
                        @endif
                    </a>
                </li>

                <!-- Ulasan Toko -->
                <li class="nav-item">
                    <a href="{{ route('reviews.index') }}" class="nav-link">
                        <i class="fas fa-star me-1"></i> Ulasan Toko
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown">
                        <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-id-badge me-2"></i> Profil
                        </a>
                        <a class="dropdown-item" href="{{ route('wishlist.index') }}">
                            <i class="fas fa-heart me-2"></i> Keranjang ({{ $wishlistCount ?? 0 }})
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route('wishlist.index') }}" class="nav-link">
                        <i class="fas fa-heart me-1"></i>Keranjang
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.login') }}" class="nav-link">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                </li>
            @endauth

                    </ul>
                </div>
            </div>
        </nav>

        <!-- ===== MAIN CONTENT ===== -->
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- ===== FOOTER ===== -->
    <footer class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <strong>Alamat:</strong> Jl Kepiting, Sobo, Kec. Banyuwangi 68418
                    </p>
                    <p>
                        <i class="fab fa-whatsapp me-2"></i>
                        <strong>WhatsApp:</strong> 
                        <a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a>
                    </p>
                    <hr>
                    <p>&copy; {{ date('Y') }} Toko Victory. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===== JAVASCRIPT ===== -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>