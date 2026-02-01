<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">

    <!-- Navigation Bar -->
    <nav class="bg-white dark:bg-gray-800 shadow px-6 py-4 flex justify-between items-center">
        <!-- Left side: App Name / Logo -->
        <div>
            <span class="text-xl font-bold text-gray-800 dark:text-gray-200">FarmFresh Finds</span>
        </div>

        <!-- Right side: Login / Register Buttons -->
        <div class="flex space-x-3">
    <a href="{{ route('login') }}" 
       class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-black font-semibold rounded-md transition">
        Login
    </a>
    <a href="{{ route('register') }}" 
       class="px-4 py-2 bg-green-500 hover:bg-green-700 text-black font-semibold rounded-md transition">
        Register
    </a>
</div>

    </nav>

    <!-- Main Content -->
    <main class="flex flex-col items-center justify-center mt-20 px-6 text-center">
        <h1 class="text-5xl font-bold text-gray-800 dark:text-gray-100 mb-6">
            Welcome to FarmFresh Finds!
        </h1>
        
    </main>
    <div class="mt-6 text-center">
    <a href="{{ route('seller.auth') }}" 
       class="px-6 py-3 bg-green-600 text-black rounded hover:bg-green-700">
       Want to Sell?
    </a>
</div>



</body>
</html>
