<x-app-layout>

    <!-- ✅ Payment Success Alert -->
    @if(session('success'))
        <div id="paymentSuccess" 
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function() {
                var alert = document.getElementById('paymentSuccess');
                if(alert) alert.style.display = 'none';
            }, 5000); // hide after 5 seconds
        </script>
    @endif

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

                    <!-- Image -->
                    <div class="w-full h-48 bg-amber-50 overflow-hidden">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                    </div>

                    <!-- Product Details -->
                    <div class="p-4">
                        <a href="{{ route('products.show', $product->id) }}">
                            <h3 class="font-bold text-lg hover:text-green-600">{{ $product->name }}</h3>
                        </a>
                        <p class="text-sm text-gray-500 capitalize">{{ $product->category }}</p>
                        <p class="font-bold text-lg mt-1">₹{{ $product->price }}</p>

                        <div class="mt-4 flex gap-2">
                            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-1">
                                @csrf
                                <button class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded text-sm">Add to Cart</button>
                            </form>

                            <button 
                                class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm"
                                onclick="buyNow({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})">
                                Buy Now
                            </button>
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

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        function buyNow(productId, productName, productPrice){
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
                    amount: productPrice
                })
            })
            .then(res => res.json())
            .then(data => {
                var options = {
                    "key": "{{ env('RAZORPAY_KEY') }}",
                    "amount": data.amount,
                    "currency": "INR",
                    "name": productName,
                    "description": "Purchase",
                    "order_id": data.order_id,
                    "handler": function(response){
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                        document.getElementById('razorpay_signature').value = response.razorpay_signature;
                        document.getElementById('hiddenAmount').value = productPrice;
                        document.getElementById('hiddenName').value = productName;
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

</x-app-layout>
