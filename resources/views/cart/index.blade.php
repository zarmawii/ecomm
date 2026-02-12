<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛒 Your Cart
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-6">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(empty($cart))
            <p class="text-gray-600">Your cart is empty.</p>
        @else

        @php $total = 0; @endphp

        <div class="space-y-4">

            @foreach($cart as $id => $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp

                <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between">

                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/' . $item['image']) }}"
                             class="w-20 h-20 object-cover rounded">

                        <div>
                            <h3 class="font-bold">{{ $item['name'] }}</h3>
                            <p>₹{{ $item['price'] }}</p>
                            <p class="text-sm text-gray-500">
                                Subtotal: ₹{{ $subtotal }}
                            </p>
                        </div>
                    </div>

                    <!-- Quantity Controls -->
                    <div class="flex items-center gap-2">

                        <form method="POST" action="{{ route('cart.decrease', $id) }}">
                            @csrf
                            <button class="px-3 py-1 bg-gray-200 rounded">-</button>
                        </form>

                        <span class="px-3">{{ $item['quantity'] }}</span>

                        <form method="POST" action="{{ route('cart.increase', $id) }}">
                            @csrf
                            <button class="px-3 py-1 bg-gray-200 rounded">+</button>
                        </form>

                        <form method="POST" action="{{ route('cart.remove', $id) }}">
                            @csrf
                            <button class="ml-4 px-3 py-1 bg-red-500 text-white rounded">
                                Remove
                            </button>
                        </form>

                    </div>
                </div>

            @endforeach

        </div>

        <!-- Total + Payment -->
        <div class="mt-8 text-right">
            <h3 class="text-xl font-bold">Total: ₹{{ $total }}</h3>

            <button class="mt-4 px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700">
                Proceed to Payment
            </button>
        </div>

        @endif

    </div>
</x-app-layout>
