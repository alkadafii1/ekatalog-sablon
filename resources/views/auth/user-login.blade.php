<x-user-auth>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="flex w-[900px] h-[500px] shadow-lg rounded-2xl overflow-hidden">
            <!-- Sidebar kiri dengan logo -->
            <div class="w-2/5 bg-[#F4C97F] flex flex-col items-center justify-center p-6 rounded-l-2xl">
                <img src="{{ asset('assets/victory1.png') }}" alt="Victory Logo" class="w-48 h-48">
            </div>

            <!-- Form login -->
            <div class="w-3/5 bg-white p-10 flex flex-col justify-center rounded-r-2xl">
                <h2 class="text-2xl font-bold text-gray-900">Welcome</h2>
                <p class="text-gray-600 mb-4">Login</p>

                <!-- Status sukses -->
                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-500 text-white rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Error validasi -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-500 text-white rounded-lg">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <input id="email" type="email" name="email" placeholder="Email"
                               value="{{ old('email') }}"
                               class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                               required autofocus autocomplete="username">
                    </div>

                    <div class="mb-4">
                        <input id="password" type="password" name="password" placeholder="Password"
                               class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                               required autocomplete="current-password">
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <label class="flex items-center text-gray-600">
                            <input id="remember_me" type="checkbox" name="remember" class="mr-2">
                            {{ __('Remember Me') }}
                        </label>

                        <a href="" class="inline-block px-6 py-2 text-white bg-red-600 rounded-lg shadow">Login with Google</a>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-blue-600 text-sm">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                            class="w-full bg-black text-white py-3 rounded-lg hover:bg-gray-800">
                        {{ __('Login') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-user-auth>
