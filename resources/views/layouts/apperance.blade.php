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
        /* Layout agar footer selalu di bawah */
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
            background-color: #f1f3f4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #4E71FF;
        }

        .navbar a {
            color: white;
            font-weight: bold;
        }

        .product-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: scale(1.02);
        }

        .product-img {
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .section-title {
            margin-top: 30px;
            font-weight: bold;
        }

        footer {
            background-color: #4E71FF;
            color: white;
            padding: 20px 0;
        }

        footer a {
            color: white;
            text-decoration: underline;
        }
        .gambar {
            object-fit: contain;
        }

    </style>
</head>
<body>

<div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand text-white">
                <a href="{{ route('home') }}" class="nav-link">Toko Victory</a>
                </a>
            
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('wishlist.index') }}" class="nav-link">Wishlist</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link">Akun Saya</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('wishlist.index') }}" class="nav-link">Wishlist</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.login') }}" class="nav-link">Login</a>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</div>

<footer class="text-center">
    <div class="container">
        <p><strong>Alamat:</strong> Jl Kepiting, Sobo, Kec. Banyuwangi 68418</p>
        <p><strong>WhatsApp:</strong> <a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a></p>
        <p>&copy; {{ date('Y') }} Toko Victory. All rights reserved.</p>
    </div>
</footer>

<!-- Bootstrap JS dan jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
