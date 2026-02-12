<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <h2 class="text-xl font-bold mt-6 mb-4 text-center">
    Available Products
</h2>

<div class="max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

        @foreach($products as $product)
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">

        <!-- Image Container (ONLY image has fixed height) -->
        <div class="w-full h-48 bg-amber-50 overflow-hidden">
            <img 
                src="{{ asset('storage/' . $product->image) }}"
                class="w-full h-full object-cover object-center"
                alt="{{ $product->name }}"
            >
        </div>

        <!-- Product Details -->
        <div class="p-4">

            <!-- Name -->
            <a href="{{ route('products.show', $product->id) }}">
                <h3 class="font-bold text-lg hover:text-green-600">
                    {{ $product->name }}
                </h3>
            </a>

            <!-- Category -->
            <p class="text-sm text-gray-500 capitalize">
                {{ $product->category }}
            </p>

            <!-- Price -->
            <p class="font-bold text-lg mt-1">
                ₹{{ $product->price }}
            </p>

            <!-- Buttons -->
            <div class="mt-4 flex gap-2">
                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-1">
                    @csrf
                    <button class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm">
                        Add to Cart
                    </button>
                </form>

                <form method="POST" action="{{ route('buy.now', $product->id) }}" class="flex-1">
                    @csrf
                    <button class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm">
                        Buy Now
                    </button>
                </form>
            </div>

        </div>
    </div>
@endforeach


    </div>
</div>


</x-app-layout>
