<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Agri</title>
        <link rel="icon" type="image/png" href="/favicon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

<div class="min-h-screen bg-cover bg-center relative"
     style="background-image: url('/farmer-bg.jpg');">

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/40"></div>

    <!-- Page Content -->
    <div class="relative">

        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-green-100 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main>
            {{ $slot }}
        </main>

    </div>

</div>

<!-- Footer -->
<footer class="bg-green-700 text-white">

    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">

        <div>
            <h2 class="text-2xl font-bold mb-2">🌱 FarmFresh Finds</h2>
            <p class="text-sm text-green-100">
                Connecting farmers directly with customers for fresh and organic produce.
            </p>
        </div>

        <div>
            <h3 class="font-semibold mb-3">Quick Links</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Home</a></li>
                <li><a href="#products" class="hover:underline">Products</a></li>
                <li><a href="{{ route('seller.register') }}" class="hover:underline">Become a Seller</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-semibold mb-3">Contact</h3>
            <p class="text-sm text-green-100">
                Email: support@farmfresh.com
            </p>
            <p class="text-sm text-green-100">
                Phone: +91 9876543210
            </p>
        </div>

    </div>

    <div class="bg-green-800 text-center py-4 text-sm">
        © 2026 FarmFresh Finds. All rights reserved.
    </div>

</footer>

</body>

</html>
