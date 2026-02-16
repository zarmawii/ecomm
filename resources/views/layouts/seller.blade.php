<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-white border-b border-gray-200 p-4">
        <div class="flex justify-between items-center max-w-7xl mx-auto">
            <a href="{{ route('seller.dashboard') }}" class="font-bold text-lg">
                Seller Dashboard
            </a>
            <div class="space-x-4">
                <a href="{{ route('seller.products.create') }}">Add Product</a>
                <form method="POST" action="{{ route('seller.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            @yield('content')
        </div>
    </main>

</body>
</html>
