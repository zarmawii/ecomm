<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Only show verified products
        $products = Product::where('is_approved', 1)->get();

        return view('welcome', compact('products'));
    }
    public function show(Product $product)
{
    return view('products.show', compact('product'));
}

}
