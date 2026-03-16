<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 font-sans">

<!-- Top Navbar -->
<nav class="bg-green-700 text-white shadow">
    <div class="flex justify-between items-center max-w-7xl mx-auto px-6 py-4">

        <!-- Logo -->
        <a href="{{ route('seller.dashboard') }}" class="font-bold text-xl">
            🌱 Seller Panel
        </a>

        <!-- Navigation -->
        <div class="flex items-center space-x-6">

            <a href="{{ route('seller.dashboard') }}"
               class="hover:text-green-200 transition">
               Dashboard
            </a>

            <a href="{{ route('seller.products.create') }}"
               class="hover:text-green-200 transition">
               Add Product
            </a>

            <a href="#"
               class="hover:text-green-200 transition">
               My Products
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('seller.logout') }}">
                @csrf
                <button type="submit"
                    class="bg-red-500 px-4 py-2 rounded hover:bg-red-600 transition">
                    Logout
                </button>
            </form>

        </div>
    </div>
</nav>


<!-- Main Content -->
<main class="py-10">
    <div class="max-w-7xl mx-auto px-6">
        @yield('content')
    </div>
</main>

</body>
</html>
