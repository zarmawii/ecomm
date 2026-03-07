@extends('layouts.seller')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">My Products</h1>

    <<table class="w-full border-collapse border">>
        <thead>
            <tr class="border-b">
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Category</th>
                <th class="p-2 border">Price</th>
                <th class="p-2 border">Stock</th>
                <th class="p-2 border">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="border-b">
                <td class="p-2 border text-center">{{ $product->name }}</td>
                <td class="p-2 border text-center">{{ $product->category }}</td>
                <td class="p-2 border text-center">{{ $product->price }}</td>
                <td class="p-2 border text-center">{{ $product->stock }}</td>
                <td class="p-2 border text-center">
                    @if($product->is_approved)
                        <span class="text-green-600">Approved</span>
                    @else
                        <span class="text-yellow-600">Pending</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection