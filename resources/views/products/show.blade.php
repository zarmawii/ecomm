<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-3xl mx-auto bg-white shadow rounded p-6">

        <img src="{{ asset('storage/' . $product->image) }}"
             class="w-full h-80 object-cover mb-6">

        <h1 class="text-3xl font-bold mb-2">
            {{ $product->name }}
        </h1>

        <p class="text-gray-600 capitalize mb-2">
            Category: {{ $product->category }}
        </p>

        <p class="text-xl font-semibold mb-4">
            ₹{{ $product->price }}
        </p>

        @auth
            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                @csrf
                <button class="px-6 py-2 bg-green-600 text-white rounded">
                    Add to Cart
                </button>
            </form>

            <button class="px-6 py-2 bg-blue-600 text-white rounded mt-2">
                Buy Now
            </button>
        @else
            <a href="{{ route('login') }}"
               class="px-6 py-2 bg-green-600 text-white rounded inline-block">
               Login to Buy
            </a>
        @endauth

    </div>

</body>
</html>
