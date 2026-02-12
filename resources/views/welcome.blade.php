<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-6 mt-6">
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div id="paymentSuccess" class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>

            <script>
                setTimeout(function() {
                    var alert = document.getElementById('paymentSuccess');
                    if(alert) alert.style.display = 'none';
                }, 4000);
            </script>
        @endif
    </div>

    <!-- Navigation Bar -->
    <nav class="bg-white dark:bg-gray-800 shadow px-6 py-4 flex justify-between items-center">
        <div>
            <span class="text-xl font-bold text-gray-800 dark:text-gray-200">FarmFresh Finds</span>
        </div>

        <div class="flex space-x-3">
            @auth
                <a href="{{ route('home') }}" 
                   class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-semibold rounded-md transition">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-semibold rounded-md transition">
                    Login
                </a>
                <a href="{{ route('register') }}" 
                   class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-semibold rounded-md transition">
                    Register
                </a>
            @endauth
        </div>
    </nav>

    <!-- Main Welcome Section -->
    <main class="flex flex-col items-center justify-center mt-20 px-6 text-center">
        <h1 class="text-5xl font-bold text-gray-800 dark:text-gray-100 mb-6">
            Welcome to FarmFresh Finds!
        </h1>

        @guest
        <div class="mt-6 text-center">
            <a href="{{ route('seller.register') }}" 
               class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700">
               Want to Sell?
            </a>
        </div>
        @endguest
    </main>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto px-6 mt-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

            @foreach($products as $product)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden">

                <!-- Product Image -->
                <div class="w-full h-40 bg-amber-50">
                    <img 
                        src="{{ asset('storage/' . $product->image) }}"
                        class="w-full h-full object-cover"
                        alt="{{ $product->name }}"
                    >
                </div>

                <!-- Product Details -->
                <div class="p-4">
                    <a href="{{ route('products.show', $product->id) }}">
                        <h3 class="font-semibold text-lg hover:text-green-600 transition">
                            {{ $product->name }}
                        </h3>
                    </a>
                    <p class="text-sm text-gray-500 capitalize mt-1">{{ $product->category }}</p>
                    <p class="font-bold text-green-700 text-lg mt-2">₹{{ $product->price }}</p>

                    <!-- Buttons -->
                    <div class="mt-4 flex gap-2">

                        <!-- Add to Cart -->
                        <form method="POST" action="{{ route('cart.add', $product->id) }}">
                            @csrf
                            <button class="flex-1 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition">
                                Add to Cart
                            </button>
                        </form>

                        <!-- Buy Now (Direct Payment) -->
                        <form method="POST" action="{{ route('buy.now', $product->id) }}">
                            @csrf
                            <button type="button" 
                                    class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm transition"
                                    onclick="buyNow({{ $product->id }}, '{{ $product->name }}', '{{ $product->price }}')">
                                Buy Now
                            </button>
                        </form>

                    </div>
                </div>

            </div>
            @endforeach

        </div>
    </div>

    <!-- Hidden Razorpay Form -->
    <form name="razorpayForm" action="{{ route('razorpay.success') }}" method="POST">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
        <input type="hidden" name="amount" id="hiddenAmount">
        <input type="hidden" name="name" id="hiddenName">
    </form>

    <script>
        function buyNow(productId, productName, productPrice){
            // Replace with actual amount in rupees
            var amount = productPrice;

            fetch(`/razorpay/payment`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    name: productName,
                    email: "{{ auth()->user()->email ?? '' }}",
                    phone: "{{ auth()->user()->phone ?? '' }}",
                    amount: amount
                })
            })
            .then(res => res.json())
            .then(data => {
                var options = {
                    "key": "{{ env('RAZORPAY_KEY') }}",
                    "amount": data.amount, // in paise
                    "currency": "INR",
                    "name": productName,
                    "description": "Purchase",
                    "order_id": data.order_id,
                    "handler": function(response){
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                        document.getElementById('razorpay_signature').value = response.razorpay_signature;
                        document.forms['razorpayForm'].submit();
                    },
                    "prefill": {
                        "name": "{{ auth()->user()->name ?? '' }}",
                        "email": "{{ auth()->user()->email ?? '' }}",
                        "contact": "{{ auth()->user()->phone ?? '' }}"
                    },
                    "theme": {"color": "#3399cc"}
                };
                var rzp = new Razorpay(options);
                rzp.open();
            })
            .catch(err => alert('Something went wrong: ' + err));
        }
    </script>

</body>
</html>
