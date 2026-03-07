@extends('layouts.seller')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Orders</h1>

    <table class="w-full border">
        <thead>
            <tr class="border-b">
                <th class="p-2 border">Order ID</th>
                <th class="p-2  border">Customer Name</th>
                <th class="p-2  border">Product</th>
                <th class="p-2  border">Qty</th>
                <th class="p-2  border">Payment</th>
                <th class="p-2  border">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-b">
                <td class="p-2 border text-center">{{ $order->id }}</td>
                <td class="p-2 border text-center">{{ $order->user->name ?? 'Guest' }}</td>
                <td class="p-2 border text-center">{{ $order->product->name ?? 'Deleted' }}</td>
                <td class="p-2 border text-center">{{ $order->quantity }}</td>
                <td class="p-2 border text-center">{{ $order->payment_status }}</td>
                <td class="p-2 border text-center">
                    @if($order->order_status == 'pending')
                        <span class="text-yellow-600">Pending</span>
                    @elseif($order->order_status == 'confirmed')
                        <span class="text-blue-600">Confirmed</span>
                    @elseif($order->order_status == 'completed')
                        <span class="text-green-600">Completed</span>
                    @elseif($order->order_status == 'cancelled')
                        <span class="text-red-600">Cancelled</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection