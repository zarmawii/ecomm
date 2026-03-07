<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class SellerOrderController extends Controller
{
    public function index()
{
    $orders = Order::where('seller_id', auth('seller')->id())
                  ->with(['user', 'product'])
                  ->get();

    return view('seller.orders.index', compact('orders'));
}
}
