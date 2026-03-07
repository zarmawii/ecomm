<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Razorpay\Api\Api;
use App\Models\Payment;

class CartController extends Controller
{
    // Show Cart Page
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Only create Razorpay order if cart is not empty
        $orderId = null;
        if (!empty($cart)) {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $order = $api->order->create([
                'receipt' => 'order_' . uniqid(),
                'amount' => $total * 100, // convert rupees to paise
                'currency' => 'INR',
                'payment_capture' => 1
            ]);
            $orderId = $order['id'];

            // Save a pending payment record
            Payment::create([
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone ?? '',
                'amount' => $total,
                'order_id' => $orderId,
                'status' => 0
            ]);
        }

        // Pass all Razorpay variables to Blade
        return view('cart.index', [
            'cart' => $cart,
            'total' => $total,
            'razorpayKey' => env('RAZORPAY_KEY'),
            'amount' => $total,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'phone' => auth()->user()->phone ?? '',
            'orderId' => $orderId
        ]);
    }

    // Add Product
    public function add(Product $product)
    {    
        if (!auth()->check()) {
        return redirect()->route('login')
            ->with('error', 'Please login first to continue.');
    }
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->image,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart!');
    }

    // Increase Quantity
    public function increase($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        }

        return back();
    }

    // Decrease Quantity (remove 1)
    public function decrease($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {

            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]); // remove completely if 1
            }

            session()->put('cart', $cart);
        }

        return back();
    }

    // Remove Completely
    public function remove($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product removed!');
    }

    // Buy Now (direct checkout)
    public function buyNow(Product $product)
    {
         if (!auth()->check()) {
        return redirect()->route('login')
            ->with('error', 'Please login first to continue.');
    }
        session()->put('cart', [
            $product->id => [
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->image,
                "quantity" => 1
            ]
        ]);

        return redirect()->route('cart.index');
    }
}
