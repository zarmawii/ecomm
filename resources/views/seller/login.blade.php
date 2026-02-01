<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-extrabold text-blue-700 text-center mb-4">Welcome Back, Seller!</h1>
        <p class="text-center text-gray-600 mb-6">Login to manage your products and sales</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('seller.login.store') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                       required autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" name="password" id="password" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                       required>
            </div>

            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">Forgot password?</a>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Login
            </button>
        </form>

        <p class="mt-6 text-center text-gray-600">
            Don't have an account? 
            <a href="{{ route('seller.register') }}" class="text-green-600 font-semibold hover:underline">
                Register here
            </a>
        </p>
    </div>

</body>
</html>
