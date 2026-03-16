<x-app-layout>

@if (session('success'))
<div class="max-w-7xl mx-auto mt-6 rounded bg-green-100 border border-green-400 text-green-700 px-4 py-3">
    {{ session('success') }}
</div>
@endif

<div class="max-w-7xl mx-auto py-10 px-6">

    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-white mb-8">
        🌾 Seller Dashboard
    </h1>

    <!-- Seller Welcome -->
    <div class="mb-8 bg-green-50 border border-green-200 p-6 rounded-lg">
        <h2 class="text-xl font-semibold">
            Welcome, {{ Auth::guard('seller')->user()->name }} 👋
        </h2>
        <p class="text-gray-600 mt-1">
            Manage your farm products and orders from here.
        </p>
    </div>

    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Account Info -->
        <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-3">Account Info</h3>

            <p class="text-gray-600 mb-2">
                <strong>Email:</strong> {{ Auth::guard('seller')->user()->email }}
            </p>

            <p>
                <strong>Status:</strong>

                @if(Auth::guard('seller')->user()->is_verified)
                    <span class="text-green-600 font-semibold">Verified ✔</span>
                @else
                    <span class="text-yellow-600 font-semibold">Pending Verification</span>
                @endif
            </p>
        </div>


        <!-- Add Product -->
        <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-3">Add Product</h3>

            <p class="text-gray-600 mb-4">
                Add new farm products for customers.
            </p>

            <a href="{{ route('seller.products.create') }}"
               class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
               + Add Product
            </a>
        </div>


        <!-- View Products -->
        <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-3">My Products</h3>

            <p class="text-gray-600 mb-4">
                View and manage your listed products.
            </p>

            <a href="#"
               class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
               View Products
            </a>
        </div>


        <!-- Orders -->
        <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-3">Orders</h3>

            <p class="text-gray-600 mb-4">
                Check customer orders and deliveries.
            </p>

            <a href="#"
               class="inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
               View Orders
            </a>
        </div>


        <!-- Logout -->
        <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-3">Account</h3>

            <p class="text-gray-600 mb-4">
                Logout from your seller account.
            </p>

            <form method="POST" action="{{ route('seller.logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
        </div>

    </div>

</div>

</x-app-layout>
