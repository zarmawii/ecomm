@extends('layouts.seller')

@section('content')
    <div class="max-w-xl mx-auto p-6 bg-white shadow rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Add Product</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="name" placeholder="Product Name" class="w-full mb-3 border p-2" required>
            <select name="category" class="w-full mb-3 border p-2" required>
                <option value="">Select Category</option>
                <option value="vegetable">Vegetable</option>
                <option value="fruit">Fruit</option>
            </select>
            <input type="number" name="price" step="0.01" placeholder="Price" class="w-full mb-3 border p-2" required>
            <input type="number" name="stock" placeholder="Stock Quantity" class="w-full mb-3 border p-2" required>
            <input type="file" name="image" class="w-full mb-3 border p-2" accept="image/*" required>

            <button class="bg-green-600 text-black px-4 py-2 rounded">Submit for Approval</button>
        </form>
    </div>

@endsection