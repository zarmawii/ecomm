<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agri</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-b from-green-50 to-green-200">

    <!-- Navigation Bar -->
    <nav class="bg-green-100 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo -->
        <span class="text-2xl font-bold text-green-600 tracking-wide">
        🌱 FarmFresh Finds
        </span>

        <!-- Right side buttons -->
        <div class="flex items-center space-x-4">

            <a href="{{ route('login') }}"
               class="px-4 py-2 bg-white text-green-600 rounded-lg hover:bg-gray-200 transition shadow">
                Login
            </a>

            <a href="{{ route('register') }}"
               class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow">
                Register
            </a>

        </div>

    </div>
</nav>



    <!-- Hero Section -->
<section class="relative text-white py-28 text-center bg-cover bg-center"
style="background-image: url('/farm-bg.jpg');">

    <div class="absolute inset-0 bg-green-900 opacity-20"></div>

    <div class="relative z-10">
        <h1 class="text-5xl font-bold mb-4">
            Fresh From the Farm 🌱
        </h1>

        <p class="text-lg mb-6">
            Buy fresh vegetables, fruits and farm products directly from farmers.
        </p>

        <div class="flex justify-center gap-4 mt-6">

    <a href="/products"
       class="bg-white text-green-700 px-6 py-3 rounded-lg font-semibold shadow hover:bg-green-100 transition">
        Browse Products
    </a>

    <a href="{{ route('seller.register') }}"
       class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-green-700 transition">
        Want to Sell?
    </a>

</div>

    </div>

</section>


</div>
<div class="max-w-7xl mx-auto px-6 bg-white py-10 rounded-lg shadow">

    <h2 id="products" class="text-3xl font-bold text-center mt-10 mb-5 text-gray-800 dark:text-black">
    Fresh Products
</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-6">

        @foreach($products as $product)

        <div class="bg-white rounded-2xl shadow-md hover:shadow-2xl hover:-translate-y-1 transition duration-300 overflow-hidden">


            <!-- Image -->
            <div class="w-full h-48 bg-gray-100 overflow-hidden">

                <img 
                    src="{{ asset('storage/' . $product->image) }}"
                    class="w-full h-full object-cover"
                    alt="{{ $product->name }}"
                >
            </div>

            <!-- Content -->
            <div class="p-4">

                <a href="{{ route('products.show', $product->id) }}">
                    <h3 class="font-bold text-lg hover:text-green-600 transition">
                        {{ $product->name }}
                    </h3>
                </a>

                <p class="text-sm text-gray-500 capitalize mt-1">
                    {{ $product->category }}
                </p>

                <p class="font-bold text-green-700 text-lg mt-2">
                    ₹{{ $product->price }}
                </p>

                <!-- Buttons -->
                <div class="mt-4 flex gap-2">

                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf
                        <button class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm shadow transition">
                            Add to Cart
                        </button>
                    </form>

                    <form method="POST" action="{{ route('buy.now', $product->id) }}">
                        @csrf
                        <button class="flex-1 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm shadow transition">
                            Buy Now
                        </button>
                    </form>

                </div>

            </div>
        </div>

        @endforeach

    </div>
</div>



<!-- Footer -->
<footer class="bg-green-700 text-white mt-16">

    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Brand -->
        <div>
            <h2 class="text-2xl font-bold mb-2">🌱 FarmFresh Finds</h2>
            <p class="text-sm text-green-100">
                Connecting farmers directly with customers for fresh and organic produce.
            </p>
        </div>

        <!-- Links -->
        <div>
            <h3 class="font-semibold mb-3">Quick Links</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Home</a></li>
                <li><a href="#products" class="hover:underline">Products</a></li>
                <li><a href="{{ route('seller.register') }}" class="hover:underline">Become a Seller</a></li>
            </ul>
        </div>

        <!-- Contact -->
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

    <!-- Bottom Bar -->
    <div class="bg-green-800 text-center py-4 text-sm">
        © 2026 FarmFresh Finds. All rights reserved.
    </div>

</footer>

</body>
</html>