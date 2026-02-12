<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerProductController extends Controller
{
    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required|in:vegetable,fruit',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'seller_id' => Auth::guard('seller')->id(),
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'is_approved' => false,
        ]);

        return redirect()->route('seller.products.create')
                         ->with('success', 'Product submitted for admin approval.');
    }
}
