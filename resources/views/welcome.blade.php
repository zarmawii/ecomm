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
        <!-- 🔔 Flash Messages -->
<div class="max-w-7xl mx-auto px-6 mt-6">

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

</div>
        <!-- Left side: App Name / Logo -->
        <div>
            <span class="text-xl font-bold text-gray-800 dark:text-gray-200">FarmFresh Finds</span>
        </div>

        <!-- Right side: Login / Register Buttons -->
       <div class="flex space-x-3">
    <!-- Normal User -->
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
    <a href="{{ route('seller.register') }}" 
       class="px-6 py-3 bg-green-600 text-black rounded hover:bg-green-700">
       Want to Sell?
    </a>

</div>
<div class="max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-6">

        @foreach($products as $product)

        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden">

            <!-- Image -->
            <div class="w-full h-40 bg-amber-50">
                <img 
                    src="{{ asset('storage/' . $product->image) }}"
                    class="w-full h-full object-cover"
                    alt="{{ $product->name }}"
                >
            </div>

            <!-- Content -->
            <div class="p-4">

                <a href="{{ route('products.show', $product->id) }}">
                    <h3 class="font-semibold text-lg hover:text-green-600 transition">
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
                        <button class="flex-1 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition">
                            Add to Cart
                        </button>
                    </form>

                    <form method="POST" action="{{ route('buy.now', $product->id) }}">
                        @csrf
                        <button class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm transition">
                            Buy Now
                        </button>
                    </form>

                </div>

            </div>
        </div>

        @endforeach

    </div>
</div>




</body>
</html>
