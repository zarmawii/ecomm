<x-guest-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">Welcome, {{ Auth::guard('seller')->user()->name }}!</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Seller Info Card -->
            <div class="p-6 bg-white shadow rounded-lg">
                <h2 class="text-xl font-semibold mb-2">Account Info</h2>
                <p><strong>Email:</strong> {{ Auth::guard('seller')->user()->email }}</p>
                <p><strong>Status:</strong> 
                    @if(Auth::guard('seller')->user()->is_verified)
                        <span class="text-green-600 font-semibold">Verified</span>
                    @else
                        <span class="text-yellow-600 font-semibold">Pending Verification</span>
                    @endif
                </p>
            </div>

            <!-- Actions Card -->
            <div class="p-6 bg-white shadow rounded-lg">
                <h2 class="text-xl font-semibold mb-2">Actions</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="text-blue-500 hover:underline">Add Product</a>
                    </li>
                    <li>
                        <a href="#" class="text-blue-500 hover:underline">View My Products</a>
                    </li>
                    <li>
                        <a href="#" class="text-blue-500 hover:underline">Orders</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('seller.logout') }}">
                            @csrf
                            <button type="submit" class="text-red-500 hover:underline">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-guest-layout>
