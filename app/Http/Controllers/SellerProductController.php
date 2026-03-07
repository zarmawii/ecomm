<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SellerProductController extends Controller
{
    public function create()
    {
        return view('seller.products.create');
    }
    public function index()
{
    $products = Product::where('seller_id', auth('seller')->id())
                      ->get();

    return view('seller.products.index', compact('products'));
}

    public function store(Request $request)
    {
        try {

            // ✅ Validate form
            $request->validate([
                'name' => 'required',
                'category' => 'required|in:vegetable,fruit',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            // ✅ Store image in storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');

            // ✅ Create product (AI pending)
            $product = Product::create([
                'seller_id' => Auth::guard('seller')->id(),
                'name' => $request->name,
                'category' => $request->category,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $imagePath,
                'is_approved' => false,
                'ai_status' => 'pending',
                'ai_result' => null,
                'ai_confidence' => null,
            ]);

            // ✅ Send image to Flask AI
            $response = Http::attach(
                'image',
                file_get_contents(storage_path('app/public/' . $product->image)),
                $product->image
            )->post('http://127.0.0.1:5001/predict');

            // If AI server not responding
            if (!$response->successful()) {
                return back()->with('error', 'AI server not responding. Try again later.');
            }

            $ai = $response->json();

            // ✅ Save AI result
            $product->ai_result = $ai['result'] ?? 'unknown';
            $product->ai_confidence = $ai['confidence'] ?? 0;

            // ✅ Decision Logic
            if ($ai['result'] === "fresh") {

                $product->ai_status = 'approved';
                $product->save();

                return back()->with('success',
                    'Product passed AI verification and sent to admin.');

            } else {

                $product->ai_status = 'rejected';
                $product->save();

                return back()->with('error',
                    'AI rejected this product. Only fresh items are allowed.');
            }

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}