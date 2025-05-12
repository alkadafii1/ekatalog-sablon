<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="flex w-[900px] h-[550px] shadow-lg rounded-2xl overflow-hidden">
        <!-- Sidebar Kiri -->
        <div class="w-2/5 bg-[#F4C97F] flex items-center justify-center p-6 rounded-l-2xl">
            <img src="{{ asset('assets/victory1.png') }}" class="w-48 h-48" alt="Victory Logo">
        </div>

        <!-- Form -->
        <div class="w-3/5 bg-white p-10 flex flex-col justify-center rounded-r-2xl">
            <h2 class="text-2xl font-bold mb-2">Create Account</h2>
            <p class="text-gray-600 mb-4">Please fill your details</p>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-500 text-white rounded-lg">
                    <ul class="text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Name"
                    class="w-full p-3 border border-gray-300 rounded-lg mb-4" required>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                    class="w-full p-3 border border-gray-300 rounded-lg mb-4" required>
                <input type="password" name="password" placeholder="Password"
                    class="w-full p-3 border border-gray-300 rounded-lg mb-4" required>
                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                    class="w-full p-3 border border-gray-300 rounded-lg mb-4" required>
                <button type="submit"
                    class="w-full bg-black text-white py-3 rounded-lg hover:bg-gray-800">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
