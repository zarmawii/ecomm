<x-guest-layout>
    <div class="max-w-md mx-auto mt-20 p-6 bg-black shadow-md rounded">
        <h2 class="text-2xl font-bold mb-6 text-center">Seller Portal</h2>

        <div class="flex flex-col gap-4">
            <a href="{{ route('seller.login') }}"
               class="px-4 py-2 bg-blue-600 text-black rounded text-center hover:bg-blue-700">
               Seller Login
            </a>

            <a href="{{ route('seller.register') }}"
               class="px-4 py-2 bg-green-600 text-black rounded text-center hover:bg-green-700">
               Seller Register
            </a>
        </div>
    </div>
</x-guest-layout>
