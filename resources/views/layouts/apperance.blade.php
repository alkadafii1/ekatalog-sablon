<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Homepage')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f1f3f4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #FFCB74;
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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white" href="#">Toko Victory</a>
        <div class="ml-auto">
            <a href="{{ route('login') }}" class="btn btn-warning btn-sm">Login</a>
            <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Register</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>